<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeedCategory;
use Illuminate\Http\Request;

class SeedCategoryController extends Controller
{
    public function index()
    {
        $categories = SeedCategory::withCount('seeds')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.seed-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.seed-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:seed_categories,name',
            'abbr'        => 'nullable|string|max:10',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max'      => 'Nama kategori maksimal 100 karakter.',
            'name.unique'   => 'Nama kategori ini sudah ada.',
            'abbr.max'      => 'Singkatan maksimal 10 karakter.',
            'description.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        SeedCategory::create($data);

        return redirect()->route('admin.seed-categories.index')
                         ->with('success', 'Kategori benih berhasil ditambahkan.');
    }

    public function edit(SeedCategory $seedCategory)
    {
        return view('admin.seed-categories.edit', compact('seedCategory'));
    }

    public function update(Request $request, SeedCategory $seedCategory)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:seed_categories,name,' . $seedCategory->id,
            'abbr'        => 'nullable|string|max:10',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max'      => 'Nama kategori maksimal 100 karakter.',
            'name.unique'   => 'Nama kategori ini sudah digunakan, gunakan nama lain.',
            'abbr.max'      => 'Singkatan maksimal 10 karakter.',
            'description.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        $seedCategory->update($data);

        return redirect()->route('admin.seed-categories.index')
                         ->with('success', 'Kategori benih berhasil diperbarui.');
    }

    public function destroy(SeedCategory $seedCategory)
    {
        $hasOrders = \App\Models\OrderItem::whereIn(
            'seed_id',
            $seedCategory->seeds()->pluck('id')
        )->exists();

        if ($hasOrders) {
            return redirect()->route('admin.seed-categories.index')
                             ->with('error', "Kategori \"{$seedCategory->name}\" tidak dapat dihapus karena varietas di dalamnya memiliki riwayat transaksi pesanan.");
        }

        try {
            $seedCategory->delete();

            return redirect()->route('admin.seed-categories.index')
                             ->with('success', 'Kategori benih berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('admin.seed-categories.index')
                             ->with('error', 'Gagal menghapus kategori benih: ' . $e->getMessage());
        }
    }
}
