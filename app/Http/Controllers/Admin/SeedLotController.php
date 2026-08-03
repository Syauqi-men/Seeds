<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeedLot;
use Illuminate\Http\Request;

class SeedLotController extends Controller
{
    public function index()
    {
        $lots = SeedLot::with('seed')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);
        return view('admin.seed-lots.index', compact('lots'));
    }

    public function create()
    {
        return view('admin.seed-lots.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.seed-lots.index');
    }

    public function show(SeedLot $seedLot)
    {
        $seedLot->load(['seed', 'productionProcesses', 'labTests', 'stockTransactions']);
        return view('admin.seed-lots.show', compact('seedLot'));
    }

    public function edit(SeedLot $seedLot)
    {
        return view('admin.seed-lots.edit', compact('seedLot'));
    }

    public function update(Request $request, SeedLot $seedLot)
    {
        return redirect()->route('admin.seed-lots.index');
    }

    public function destroy(SeedLot $seedLot)
    {
        $seedLot->delete();
        return redirect()->route('admin.seed-lots.index')->with('success', 'Lot benih berhasil dihapus.');
    }
}
