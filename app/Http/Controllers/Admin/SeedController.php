<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seed;
use Illuminate\Http\Request;

class SeedController extends Controller
{
    public function index()
    {
        $seeds = Seed::withCount('seedLots')
            ->join('seed_categories', 'seeds.category_id', '=', 'seed_categories.id')
            ->orderBy('seed_categories.name')
            ->orderBy('seeds.var_name')
            ->select('seeds.*')
            ->paginate(15);
        return view('admin.seeds.index', compact('seeds'));
    }

    public function create()
    {
        return view('admin.seeds.create');
    }

    public function store()
    {
        // Handled by Livewire SeedForm component
        return redirect()->route('admin.seeds.index');
    }

    public function show(Seed $seed)
    {
        $seed->load(['seedLots' => fn($q) => $q->latest()->with('labTests')]);
        return view('admin.seeds.show', compact('seed'));
    }

    public function edit(Seed $seed)
    {
        return view('admin.seeds.edit', compact('seed'));
    }

    public function update(Request $request, Seed $seed)
    {
        return redirect()->route('admin.seeds.index');
    }

    public function destroy(Seed $seed)
    {
        $seed->delete();
        return redirect()->route('admin.seeds.index')->with('success', 'Varietas benih berhasil dihapus.');
    }
}
