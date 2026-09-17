<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeedLot;
use App\Models\SeedMutation;
use Illuminate\Http\Request;

class SeedMutationController extends Controller
{
    public function index()
    {
        $mutations = SeedMutation::with('seedLot.seed')
            ->latest()
            ->paginate(20);

        return view('admin.seed-mutations.index', compact('mutations'));
    }

    public function create()
    {
        $lots = SeedLot::with('seed')
            ->where('clean_stock', '>=', 2)
            ->orderBy('lot_number')
            ->get();

        return view('admin.seed-mutations.create', compact('lots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seed_lot_id' => 'required|exists:seed_lots,id',
            'mutated_at'  => 'nullable|date',
            'notes'       => 'nullable|string|max:500',
        ], [
            'seed_lot_id.required' => 'Lot benih wajib dipilih.',
            'seed_lot_id.exists'   => 'Lot benih yang dipilih tidak ditemukan.',
            'mutated_at.date'      => 'Tanggal mutasi tidak valid.',
            'notes.max'            => 'Catatan maksimal 500 karakter.',
        ]);

        $lot = SeedLot::findOrFail($request->seed_lot_id);

        if ($lot->clean_stock < 2) {
            return back()->withErrors([
                'seed_lot_id' => "Stok bersih lot {$lot->lot_number} tidak mencukupi untuk mutasi (tersedia: {$lot->clean_stock} kg, dibutuhkan: 2 kg).",
            ])->withInput();
        }

        // Save mutation
        SeedMutation::create([
            'seed_lot_id' => $lot->id,
            'mutated_at'  => $request->mutated_at ?: now()->toDateString(),
            'notes'       => $request->notes,
        ]);

        $lot->decrement('clean_stock', 2);

        return redirect()
            ->route('admin.seed-mutations.index')
            ->with('success', "Mutasi benih lot {$lot->lot_number} berhasil dicatat. Stok bersih dikurangi 2 kg.");
    }

    public function destroy(SeedMutation $seedMutation)
    {
        // Delete note only 
        $lotNumber = $seedMutation->seedLot->lot_number ?? '-';
        $seedMutation->delete();

        return redirect()
            ->route('admin.seed-mutations.index')
            ->with('success', "Catatan mutasi lot {$lotNumber} berhasil dihapus.");
    }
}
