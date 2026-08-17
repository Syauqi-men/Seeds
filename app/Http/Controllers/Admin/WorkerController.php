<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WorkerRole;
use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::orderBy('name')->paginate(20);
        return view('admin.workers.index', compact('workers'));
    }

    public function create()
    {
        $roles = WorkerRole::cases();
        return view('admin.workers.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'code'      => 'nullable|string|max:20',
            'role'      => 'required|in:Sorting,Grading,Both',
            'is_active' => 'boolean',
            'notes'     => 'nullable|string|max:500',
        ], [
            'name.required'  => 'Nama pekerja wajib diisi.',
            'name.max'       => 'Nama pekerja maksimal 100 karakter.',
            'role.required'  => 'Peran pekerja wajib dipilih.',
            'role.in'        => 'Peran pekerja tidak valid, pilih Sorting, Grading, atau Both.',
            'notes.max'      => 'Catatan maksimal 500 karakter.',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        Worker::create($data);
        return redirect()->route('admin.workers.index')
                         ->with('success', 'Data pekerja berhasil ditambahkan.');
    }

    public function edit(Worker $worker)
    {
        $roles = WorkerRole::cases();
        return view('admin.workers.edit', compact('worker', 'roles'));
    }

    public function update(Request $request, Worker $worker)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'code'      => 'nullable|string|max:20',
            'role'      => 'required|in:Sorting,Grading,Both',
            'is_active' => 'boolean',
            'notes'     => 'nullable|string|max:500',
        ], [
            'name.required'  => 'Nama pekerja wajib diisi.',
            'name.max'       => 'Nama pekerja maksimal 100 karakter.',
            'role.required'  => 'Peran pekerja wajib dipilih.',
            'role.in'        => 'Peran pekerja tidak valid, pilih Sorting, Grading, atau Both.',
            'notes.max'      => 'Catatan maksimal 500 karakter.',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $worker->update($data);
        return redirect()->route('admin.workers.index')
                         ->with('success', 'Data pekerja berhasil diperbarui.');
    }

    public function destroy(Worker $worker)
    {
        $worker->delete();
        return redirect()->route('admin.workers.index')
                         ->with('success', 'Data pekerja berhasil dihapus.');
    }
}
