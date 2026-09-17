<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProcessType;
use App\Http\Controllers\Controller;
use App\Models\ProductionProcess;
use App\Models\SeedLot;
use App\Models\Worker;
use App\Observers\SeedLotObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionProcessController extends Controller
{
    public function index()
    {
        $processes = ProductionProcess::with('seedLot.seed', 'worker')
            ->latest()
            ->paginate(15);

        return view('admin.production-processes.index', compact('processes'));
    }

    public function create()
    {
        $lots    = SeedLot::with('seed')->get();
        $workers = Worker::active()->orderBy('name')->get();
        $types   = ProcessType::cases();
        return view('admin.production-processes.create', compact('lots', 'workers', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seed_lot_id'  => 'required|exists:seed_lots,id',
            'process_type' => 'required|in:Sorting,Grading',
            'processed_at' => 'nullable|date',
            'notes'        => 'nullable|string|max:500',
            'rows'                     => 'required|array|min:1',
            'rows.*.worker_id'         => 'nullable|exists:workers,id',
            'rows.*.input_quantity'    => 'required|numeric|min:0.01',
            'rows.*.output_quantity'   => 'required|numeric|min:0',
            'rows.*.sortir_quantity'   => 'nullable|numeric|min:0',
            'rows.*.waste_quantity'    => 'nullable|numeric|min:0',
        ], [
            'seed_lot_id.required'           => 'Lot benih wajib dipilih.',
            'seed_lot_id.exists'             => 'Lot benih yang dipilih tidak ditemukan.',
            'process_type.required'          => 'Jenis proses wajib dipilih.',
            'process_type.in'                => 'Jenis proses tidak valid, pilih Sorting atau Grading.',
            'rows.required'                  => 'Minimal harus ada satu baris pekerja.',
            'rows.*.worker_id.exists'        => 'Pekerja yang dipilih tidak ditemukan.',
            'rows.*.input_quantity.required' => 'Jumlah input (kg) wajib diisi di setiap baris.',
            'rows.*.input_quantity.numeric'  => 'Jumlah input (kg) harus berupa angka.',
            'rows.*.input_quantity.min'      => 'Jumlah input (kg) minimal 0.01.',
            'rows.*.output_quantity.required'=> 'Jumlah output (kg) wajib diisi di setiap baris.',
            'rows.*.output_quantity.numeric' => 'Jumlah output (kg) harus berupa angka.',
            'rows.*.output_quantity.min'     => 'Jumlah output (kg) tidak boleh negatif.',
            'rows.*.sortir_quantity.numeric' => 'Jumlah sortir (kg) harus berupa angka.',
            'rows.*.sortir_quantity.min'     => 'Jumlah sortir (kg) tidak boleh negatif.',
            'rows.*.waste_quantity.numeric'  => 'Jumlah limbah (kg) harus berupa angka.',
            'rows.*.waste_quantity.min'      => 'Jumlah limbah (kg) tidak boleh negatif.',
        ]);

        $lotId       = $request->seed_lot_id;
        $processType = $request->process_type;
        $processedAt = $request->processed_at ?: null;
        $notes       = $request->notes ?? null;

        // Validate balance & stock availability 
        $runningStock = [];
        if (!isset($runningStock[$lotId])) {
            $lot = SeedLot::find($lotId);
            $runningStock[$lotId] = [
                'raw'     => (float) $lot->raw_stock,
                'graded'  => (float) $lot->graded_stock,
                'lot_num' => $lot->lot_number,
            ];
        }

        foreach ($request->rows as $i => $row) {
            $rowNum  = $i + 1;
            $input   = (float) $row['input_quantity'];
            $output  = (float) $row['output_quantity'];
            $sortir  = (float) ($row['sortir_quantity'] ?? 0);
            $waste   = (float) ($row['waste_quantity'] ?? 0);
            $balance = $output + $sortir + $waste;

            // Balance check
            if (abs($balance - $input) > 0.01) {
                return back()->withErrors([
                    "rows.{$i}.output_quantity" =>
                        "Baris #{$rowNum}: Output ({$output}) + Sortir ({$sortir}) + Limbah ({$waste}) = " .
                        number_format($balance, 2) . " kg — harus sama dengan Input ({$input} kg).",
                ])->withInput();
            }

            // Stock based process type
            if ($processType === ProcessType::Grading->value) {
                if ($input > $runningStock[$lotId]['raw']) {
                    return back()->withErrors([
                        "rows.{$i}.input_quantity" =>
                            "Baris #{$rowNum}: Input Grading ({$input} kg) melebihi sisa stok mentah lot {$runningStock[$lotId]['lot_num']} " .
                            "(" . number_format($runningStock[$lotId]['raw'], 2) . " kg).",
                    ])->withInput();
                }
                $runningStock[$lotId]['raw']    -= $input;
                $runningStock[$lotId]['graded'] += $output;
            } else {
                if ($input > $runningStock[$lotId]['graded']) {
                    return back()->withErrors([
                        "rows.{$i}.input_quantity" =>
                            "Baris #{$rowNum}: Input Sorting ({$input} kg) melebihi sisa stok grading lot {$runningStock[$lotId]['lot_num']} " .
                            "(" . number_format($runningStock[$lotId]['graded'], 2) . " kg).",
                    ])->withInput();
                }
                $runningStock[$lotId]['graded'] -= $input;
            }
        }

        // Save process
        DB::transaction(function () use ($request, $lotId, $processType, $processedAt, $notes) {
            foreach ($request->rows as $row) {
                $process = new ProductionProcess([
                    'seed_lot_id'     => $lotId,
                    'process_type'    => $processType,
                    'worker_id'       => $row['worker_id'] ?: null,
                    'input_quantity'  => $row['input_quantity'],
                    'output_quantity' => $row['output_quantity'],
                    'sortir_quantity' => $row['sortir_quantity'] ?? 0,
                    'waste_quantity'  => $row['waste_quantity'] ?? 0,
                    'processed_at'    => $processedAt,
                    'notes'           => $notes,
                ]);
                $process->saveQuietly(); 
            }

            $lot = SeedLot::find($lotId);
            SeedLotObserver::recalculate($lot);
        });

        return redirect()->route('admin.production-processes.index')
                         ->with('success', count($request->rows) . ' proses produksi berhasil dicatat.');
    }

    public function show(ProductionProcess $productionProcess)
    {
        $productionProcess->load('seedLot.seed', 'worker');
        return view('admin.production-processes.show', compact('productionProcess'));
    }

    public function edit(ProductionProcess $productionProcess)
    {
        $lots    = SeedLot::with('seed')->get();
        $workers = Worker::active()->orderBy('name')->get();
        $types   = ProcessType::cases();
        return view('admin.production-processes.edit', compact('productionProcess', 'lots', 'workers', 'types'));
    }

    public function update(Request $request, ProductionProcess $productionProcess)
    {
        $data = $request->validate([
            'seed_lot_id'     => 'required|exists:seed_lots,id',
            'process_type'    => 'required|in:Sorting,Grading',
            'worker_id'       => 'nullable|exists:workers,id',
            'input_quantity'  => 'required|numeric|min:0.01',
            'output_quantity' => 'required|numeric|min:0',
            'sortir_quantity' => 'nullable|numeric|min:0',
            'waste_quantity'  => 'nullable|numeric|min:0',
            'processed_at'    => 'nullable|date',
            'notes'           => 'nullable|string|max:500',
        ], [
            'seed_lot_id.required'     => 'Lot benih wajib dipilih.',
            'seed_lot_id.exists'       => 'Lot benih yang dipilih tidak ditemukan.',
            'process_type.required'    => 'Jenis proses wajib dipilih.',
            'process_type.in'          => 'Jenis proses tidak valid.',
            'input_quantity.required'  => 'Jumlah input (kg) wajib diisi.',
            'input_quantity.numeric'   => 'Jumlah input (kg) harus berupa angka.',
            'input_quantity.min'       => 'Jumlah input (kg) minimal 0.01.',
            'output_quantity.required' => 'Jumlah output (kg) wajib diisi.',
            'output_quantity.numeric'  => 'Jumlah output (kg) harus berupa angka.',
            'output_quantity.min'      => 'Jumlah output (kg) tidak boleh negatif.',
            'sortir_quantity.numeric'  => 'Jumlah sortir (kg) harus berupa angka.',
            'sortir_quantity.min'      => 'Jumlah sortir (kg) tidak boleh negatif.',
            'waste_quantity.numeric'   => 'Jumlah limbah (kg) harus berupa angka.',
            'waste_quantity.min'       => 'Jumlah limbah (kg) tidak boleh negatif.',
        ]);

        // Balance Validate
        $input   = (float) $data['input_quantity'];
        $output  = (float) $data['output_quantity'];
        $sortir  = (float) ($data['sortir_quantity'] ?? 0);
        $waste   = (float) ($data['waste_quantity'] ?? 0);
        $balance = $output + $sortir + $waste;

        if (abs($balance - $input) > 0.01) {
            return back()->withErrors([
                'output_quantity' =>
                    "Output ({$output}) + Sortir ({$sortir}) + Limbah ({$waste}) = " .
                    number_format($balance, 2) . " kg — harus sama dengan Input ({$input} kg).",
            ])->withInput();
        }

        $productionProcess->update($data);

        return redirect()->route('admin.production-processes.index')
                         ->with('success', 'Proses produksi berhasil diperbarui.');
    }

    public function destroy(ProductionProcess $productionProcess)
    {
        $productionProcess->delete();

        return redirect()->route('admin.production-processes.index')
                         ->with('success', 'Proses produksi berhasil dihapus.');
    }
}
