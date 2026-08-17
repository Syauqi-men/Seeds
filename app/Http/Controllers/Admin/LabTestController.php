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
        ], [
            'seed_lot_id.required'     => 'Lot benih wajib dipilih.',
            'seed_lot_id.exists'       => 'Lot benih yang dipilih tidak ditemukan.',
            'germination_rate.required'=> 'Daya kecambah wajib diisi.',
            'germination_rate.numeric' => 'Daya kecambah harus berupa angka.',
            'germination_rate.min'     => 'Daya kecambah minimal 0%.',
            'germination_rate.max'     => 'Daya kecambah maksimal 100%.',
            'moisture_content.numeric' => 'Kadar air harus berupa angka.',
            'moisture_content.min'     => 'Kadar air minimal 0%.',
            'moisture_content.max'     => 'Kadar air maksimal 100%.',
            'test_result.required'     => 'Hasil uji wajib dipilih.',
            'test_result.in'           => 'Hasil uji tidak valid, pilih PASSED atau FAILED.',
            'tested_at.date'           => 'Tanggal uji tidak valid.',
            'notes.max'                => 'Catatan maksimal 500 karakter.',
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
        ], [
            'seed_lot_id.required'     => 'Lot benih wajib dipilih.',
            'seed_lot_id.exists'       => 'Lot benih yang dipilih tidak ditemukan.',
            'germination_rate.required'=> 'Daya kecambah wajib diisi.',
            'germination_rate.numeric' => 'Daya kecambah harus berupa angka.',
            'germination_rate.min'     => 'Daya kecambah minimal 0%.',
            'germination_rate.max'     => 'Daya kecambah maksimal 100%.',
            'moisture_content.numeric' => 'Kadar air harus berupa angka.',
            'moisture_content.min'     => 'Kadar air minimal 0%.',
            'moisture_content.max'     => 'Kadar air maksimal 100%.',
            'test_result.required'     => 'Hasil uji wajib dipilih.',
            'test_result.in'           => 'Hasil uji tidak valid, pilih PASSED atau FAILED.',
            'tested_at.date'           => 'Tanggal uji tidak valid.',
            'notes.max'                => 'Catatan maksimal 500 karakter.',
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
