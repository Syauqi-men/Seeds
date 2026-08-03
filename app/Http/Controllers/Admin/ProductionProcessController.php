<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductionProcess;
use App\Models\SeedLot;
use Illuminate\Http\Request;

class ProductionProcessController extends Controller
{
    public function index()
    {
        $processes = ProductionProcess::with('seedLot.seed')->latest()->paginate(15);
        return view('admin.production-processes.index', compact('processes'));
    }

    public function create()
    {
        $lots = SeedLot::with('seed')->get();
        return view('admin.production-processes.create', compact('lots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seed_lot_id'       => 'required|exists:seed_lots,id',
            'input_quantity'    => 'required|numeric|min:0.01',
            'output_quantity'   => 'required|numeric|min:0',
            'shrinkage_quantity'=> 'nullable|numeric|min:0',
            'waste_quantity'    => 'nullable|numeric|min:0',
            'moisture_start'    => 'nullable|numeric|min:0|max:100',
            'moisture_end'      => 'nullable|numeric|min:0|max:100',
            'processed_at'      => 'nullable|date',
            'notes'             => 'nullable|string|max:500',
        ]);

        // Validasi toleransi: output tidak boleh melebihi input secara signifikan (> 5%)
        $tolerance = $data['input_quantity'] * 1.05;
        if ($data['output_quantity'] > $tolerance) {
            return back()->withErrors(['output_quantity' => 'Output melebihi input melebihi toleransi 5%. Harap periksa data.'])->withInput();
        }

        ProductionProcess::create($data);
        return redirect()->route('admin.production-processes.index')->with('success', 'Proses produksi berhasil dicatat.');
    }

    public function show(ProductionProcess $productionProcess)
    {
        $productionProcess->load('seedLot.seed');
        return view('admin.production-processes.show', compact('productionProcess'));
    }

    public function edit(ProductionProcess $productionProcess)
    {
        $lots = SeedLot::with('seed')->get();
        return view('admin.production-processes.edit', compact('productionProcess', 'lots'));
    }

    public function update(Request $request, ProductionProcess $productionProcess)
    {
        $data = $request->validate([
            'seed_lot_id'       => 'required|exists:seed_lots,id',
            'input_quantity'    => 'required|numeric|min:0.01',
            'output_quantity'   => 'required|numeric|min:0',
            'shrinkage_quantity'=> 'nullable|numeric|min:0',
            'waste_quantity'    => 'nullable|numeric|min:0',
            'moisture_start'    => 'nullable|numeric|min:0|max:100',
            'moisture_end'      => 'nullable|numeric|min:0|max:100',
            'processed_at'      => 'nullable|date',
            'notes'             => 'nullable|string|max:500',
        ]);

        $tolerance = $data['input_quantity'] * 1.05;
        if ($data['output_quantity'] > $tolerance) {
            return back()->withErrors(['output_quantity' => 'Output melebihi input melebihi toleransi 5%.'])->withInput();
        }

        $productionProcess->update($data);
        return redirect()->route('admin.production-processes.index')->with('success', 'Proses produksi berhasil diperbarui.');
    }

    public function destroy(ProductionProcess $productionProcess)
    {
        $productionProcess->delete();
        return redirect()->route('admin.production-processes.index')->with('success', 'Proses produksi berhasil dihapus.');
    }
}
