@extends('admin.layout')
@section('title', 'Data Pekerja')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Data Pekerja</h1>
        <p class="page-subtitle">Daftar pekerja yang melakukan sortasi & grading benih</p>
    </div>
    <a href="{{ route('admin.workers.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Pekerja
    </a>
</div>
<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama</th><th>Kode</th><th>Peran</th><th>Status</th><th>Catatan</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($workers as $worker)
            <tr>
                <td style="font-weight:600">{{ $worker->name }}</td>
                <td>{{ $worker->code ?? '-' }}</td>
                <td>
                    <span class="badge {{ $worker->role->value === 'Grading' ? 'badge-ready' : ($worker->role->value === 'Sorting' ? 'badge-processing' : 'badge-quarantine') }}">
                        {{ $worker->role->label() }}
                    </span>
                </td>
                <td>
                    @if($worker->is_active)
                        <span class="badge badge-ready">Aktif</span>
                    @else
                        <span class="badge badge-depleted">Nonaktif</span>
                    @endif
                </td>
                <td class="text-small text-muted">{{ $worker->notes ?? '-' }}</td>
                <td style="text-align:right">
                    <div style="display:flex;gap:4px;justify-content:flex-end" x-data="{ del: false }">
                        <a href="{{ route('admin.workers.edit', $worker) }}" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <button @click="del=true" class="btn btn-danger btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                        </button>
                        <div x-show="del" class="modal-backdrop" @click.self="del=false" x-transition style="display:none">
                            <div class="modal-box">
                                <h3 class="modal-title">Hapus Pekerja?</h3>
                                <p style="font-size:0.9rem;color:var(--color-text-muted);margin-bottom:var(--space-lg)">
                                    Data pekerja <strong>{{ $worker->name }}</strong> akan dihapus permanen.
                                </p>
                                <div style="display:flex;gap:var(--space-sm);justify-content:flex-end">
                                    <button @click="del=false" class="btn btn-ghost">Batal</button>
                                    <form method="POST" action="{{ route('admin.workers.destroy', $worker) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted" style="padding:var(--space-xl)">Belum ada data pekerja.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:var(--space-md) var(--space-lg)">{{ $workers->links() }}</div>
</div>
@endsection
