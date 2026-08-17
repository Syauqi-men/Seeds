<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProcessType;
use App\Http\Controllers\Controller;
use App\Models\ProductionProcess;
use App\Models\SeedLot;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionProcessController extends Controller
{
    public function index()
    {
        // Tampilkan hanya entri terakhir per seed_lot_id
        $latestIds = ProductionProcess::select(DB::raw('MAX(id) as id'))
            ->groupBy('seed_lot_id')
            ->pluck('id');

        $processes = ProductionProcess::with('seedLot.seed', 'worker')
            ->whereIn('id', $latestIds)
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
        // Support multi-row: rows[] array
        $request->validate([
            'rows'                       => 'required|array|min:1',
            'rows.*.seed_lot_id'         => 'required|exists:seed_lots,id',
            'rows.*.process_type'        => 'required|in:Sorting,Grading',
            'rows.*.worker_id'           => 'nullable|exists:workers,id',
            'rows.*.input_quantity'      => 'required|numeric|min:0.01',
            'rows.*.output_quantity'     => 'required|numeric|min:0',
            'rows.*.shrinkage_quantity'  => 'nullable|numeric|min:0',
            'rows.*.waste_quantity'      => 'nullable|numeric|min:0',
            'rows.*.processed_at'        => 'nullable|date',
            'rows.*.notes'               => 'nullable|string|max:500',
        ], [
            'rows.required'                       => 'Minimal harus ada satu baris proses produksi.',
            'rows.*.seed_lot_id.required'         => 'Lot benih wajib dipilih di setiap baris.',
            'rows.*.seed_lot_id.exists'           => 'Lot benih yang dipilih tidak ditemukan.',
            'rows.*.process_type.required'        => 'Jenis proses wajib dipilih di setiap baris.',
            'rows.*.process_type.in'              => 'Jenis proses tidak valid, pilih Sorting atau Grading.',
            'rows.*.worker_id.exists'             => 'Pekerja yang dipilih tidak ditemukan.',
            'rows.*.input_quantity.required'      => 'Jumlah input (kg) wajib diisi di setiap baris.',
            'rows.*.input_quantity.numeric'       => 'Jumlah input (kg) harus berupa angka.',
            'rows.*.input_quantity.min'           => 'Jumlah input (kg) minimal 0.01.',
            'rows.*.output_quantity.required'     => 'Jumlah output (kg) wajib diisi di setiap baris.',
            'rows.*.output_quantity.numeric'      => 'Jumlah output (kg) harus berupa angka.',
            'rows.*.output_quantity.min'          => 'Jumlah output (kg) tidak boleh negatif.',
            'rows.*.shrinkage_quantity.numeric'   => 'Jumlah susut (kg) harus berupa angka.',
            'rows.*.shrinkage_quantity.min'       => 'Jumlah susut (kg) tidak boleh negatif.',
            'rows.*.waste_quantity.numeric'       => 'Jumlah limbah (kg) harus berupa angka.',
            'rows.*.waste_quantity.min'           => 'Jumlah limbah (kg) tidak boleh negatif.',
            'rows.*.processed_at.date'            => 'Tanggal proses tidak valid.',
            'rows.*.notes.max'                    => 'Catatan maksimal 500 karakter.',
        ]);

        foreach ($request->rows as $row) {
            // Validasi toleransi output per baris
            $tolerance = $row['input_quantity'] * 1.05;
            if ($row['output_quantity'] > $tolerance) {
                return back()
                    ->withErrors(['rows' => 'Salah satu baris: output melebihi input melebihi toleransi 5%.'])
                    ->withInput();
            }

            ProductionProcess::create([
                'seed_lot_id'        => $row['seed_lot_id'],
                'process_type'       => $row['process_type'],
                'worker_id'          => $row['worker_id'] ?: null,
                'input_quantity'     => $row['input_quantity'],
                'output_quantity'    => $row['output_quantity'],
                'shrinkage_quantity' => $row['shrinkage_quantity'] ?? 0,
                'waste_quantity'     => $row['waste_quantity'] ?? 0,
                'processed_at'       => $row['processed_at'] ?: null,
                'notes'              => $row['notes'] ?? null,
            ]);
        }

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
            'seed_lot_id'        => 'required|exists:seed_lots,id',
            'process_type'       => 'required|in:Sorting,Grading',
            'worker_id'          => 'nullable|exists:workers,id',
            'input_quantity'     => 'required|numeric|min:0.01',
            'output_quantity'    => 'required|numeric|min:0',
            'shrinkage_quantity' => 'nullable|numeric|min:0',
            'waste_quantity'     => 'nullable|numeric|min:0',
            'processed_at'       => 'nullable|date',
            'notes'              => 'nullable|string|max:500',
        ], [
            'seed_lot_id.required'        => 'Lot benih wajib dipilih.',
            'seed_lot_id.exists'          => 'Lot benih yang dipilih tidak ditemukan.',
            'process_type.required'       => 'Jenis proses wajib dipilih.',
            'process_type.in'             => 'Jenis proses tidak valid, pilih Sorting atau Grading.',
            'worker_id.exists'            => 'Pekerja yang dipilih tidak ditemukan.',
            'input_quantity.required'     => 'Jumlah input (kg) wajib diisi.',
            'input_quantity.numeric'      => 'Jumlah input (kg) harus berupa angka.',
            'input_quantity.min'          => 'Jumlah input (kg) minimal 0.01.',
            'output_quantity.required'    => 'Jumlah output (kg) wajib diisi.',
            'output_quantity.numeric'     => 'Jumlah output (kg) harus berupa angka.',
            'output_quantity.min'         => 'Jumlah output (kg) tidak boleh negatif.',
            'shrinkage_quantity.numeric'  => 'Jumlah susut (kg) harus berupa angka.',
            'shrinkage_quantity.min'      => 'Jumlah susut (kg) tidak boleh negatif.',
            'waste_quantity.numeric'      => 'Jumlah limbah (kg) harus berupa angka.',
            'waste_quantity.min'          => 'Jumlah limbah (kg) tidak boleh negatif.',
            'processed_at.date'           => 'Tanggal proses tidak valid.',
            'notes.max'                   => 'Catatan maksimal 500 karakter.',
        ]);

        $tolerance = $data['input_quantity'] * 1.05;
        if ($data['output_quantity'] > $tolerance) {
            return back()
                ->withErrors(['output_quantity' => 'Output melebihi input melebihi toleransi 5%.'])
                ->withInput();
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
