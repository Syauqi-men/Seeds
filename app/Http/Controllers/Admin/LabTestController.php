<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use App\Models\SeedLot;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    public function index()
    {
        $tests = LabTest::with('seedLot.seed')->latest()->paginate(15);
        return view('admin.lab-tests.index', compact('tests'));
    }

    public function create()
    {
        $lots = SeedLot::with('seed')->get();
        return view('admin.lab-tests.create', compact('lots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seed_lot_id'     => 'required|exists:seed_lots,id',
            'germination_rate'=> 'required|numeric|min:0|max:100',
            'moisture_content'=> 'nullable|numeric|min:0|max:100',
            'test_result'     => 'required|in:PASSED,FAILED',
            'tested_at'       => 'nullable|date',
            'notes'           => 'nullable|string|max:500',
        ]);

        LabTest::create($data);
        return redirect()->route('admin.lab-tests.index')->with('success', 'Uji lab berhasil dicatat.');
    }

    public function show(LabTest $labTest)
    {
        $labTest->load('seedLot.seed');
        return view('admin.lab-tests.show', compact('labTest'));
    }

    public function edit(LabTest $labTest)
    {
        $lots = SeedLot::with('seed')->get();
        return view('admin.lab-tests.edit', compact('labTest', 'lots'));
    }

    public function update(Request $request, LabTest $labTest)
    {
        $data = $request->validate([
            'seed_lot_id'     => 'required|exists:seed_lots,id',
            'germination_rate'=> 'required|numeric|min:0|max:100',
            'moisture_content'=> 'nullable|numeric|min:0|max:100',
            'test_result'     => 'required|in:PASSED,FAILED',
            'tested_at'       => 'nullable|date',
            'notes'           => 'nullable|string|max:500',
        ]);

        $labTest->update($data);
        return redirect()->route('admin.lab-tests.index')->with('success', 'Uji lab berhasil diperbarui.');
    }

    public function destroy(LabTest $labTest)
    {
        $labTest->delete();
        return redirect()->route('admin.lab-tests.index')->with('success', 'Uji lab berhasil dihapus.');
    }
}
