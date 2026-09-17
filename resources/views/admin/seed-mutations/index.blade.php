@extends('admin.layout')
@section('title', 'Mutasi Benih')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Mutasi Benih</h1>
        <p class="page-subtitle">Pencatatan pengambilan sampel benih — setiap mutasi mengurangi 2 kg stok bersih</p>
    </div>
    <a href="{{ route('admin.seed-mutations.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Mutasi
    </a>
</div>

<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Lot Benih</th>
                <th>Varietas</th>
                <th>Tanggal Mutasi</th>
                <th>Pengurangan</th>
                <th>Catatan</th>
                <th>Dicatat Pada</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutations as $i => $mut)
            <tr>
                <td class="text-muted text-small">{{ $mutations->firstItem() + $i }}</td>
                <td>
                    <div style="font-weight:600">{{ $mut->seedLot->lot_number }}</div>
                </td>
                <td class="text-small">{{ $mut->seedLot->seed->var_name ?? '-' }}</td>
                <td class="text-small">{{ $mut->mutated_at?->translatedFormat('d M Y') ?? '-' }}</td>
                <td>
                    <span class="badge badge-depleted">− 2 kg</span>
                </td>
                <td class="text-small text-muted">{{ $mut->notes ?: '—' }}</td>
                <td class="text-small text-muted">{{ $mut->created_at->translatedFormat('d M Y') }}</td>
                <td style="text-align:right">
                    <div x-data="{ del: false }">
                        <button @click="del=true" class="btn btn-danger btn-sm" title="Hapus catatan">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                        </button>
                        <div x-show="del" class="modal-backdrop" @click.self="del=false" x-transition style="display:none">
                            <div class="modal-box">
                                <h3 class="modal-title">Hapus Catatan Mutasi?</h3>
                                <p style="font-size:0.9rem;color:var(--color-text-muted);margin-bottom:var(--space-lg)">
                                    Catatan mutasi ini akan dihapus. <strong>Stok bersih lot tidak akan dikembalikan.</strong>
                                </p>
                                <div style="display:flex;gap:var(--space-sm);justify-content:flex-end">
                                    <button @click="del=false" class="btn btn-ghost">Batal</button>
                                    <form method="POST" action="{{ route('admin.seed-mutations.destroy', $mut) }}">
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
            <tr><td colspan="8" class="text-center text-muted" style="padding:var(--space-xl)">Belum ada catatan mutasi benih.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:var(--space-md) var(--space-lg)">{{ $mutations->links() }}</div>
</div>
@endsection
