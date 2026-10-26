@extends('admin.layout')
@section('title', 'Kategori Benih')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Kategori Benih</h1>
        <p class="page-subtitle">Kelola kategori komoditas benih (Kedelai, Kacang Tanah, dll.)</p>
    </div>
    <a href="{{ route('admin.seed-categories.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Kategori
    </a>
</div>

<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Singkatan</th>
                <th>Keterangan</th>
                <th>Jumlah Varietas</th>
                <th>Diperbarui</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td style="font-weight:600">{{ $cat->name }}</td>
                <td>
                    @if($cat->abbr)
                    <span class="badge badge-raw">{{ $cat->abbr }}</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td class="text-small text-muted">{{ $cat->description ?? '-' }}</td>
                <td>
                    <span style="font-weight:600;color:var(--color-primary-700)">{{ $cat->seeds_count }}</span>
                    <span class="text-small text-muted"> varietas</span>
                </td>
                <td class="text-muted text-small">{{ $cat->updated_at->translatedFormat('d M Y') }}</td>
                <td style="text-align:right">
                    <div style="display:flex;gap:4px;justify-content:flex-end" x-data="{ del: false }">
                        <a href="{{ route('admin.seed-categories.edit', $cat) }}" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <button @click="del=true" class="btn btn-danger btn-sm"
                            {{ $cat->seeds_count > 0 ? 'disabled title=Tidak dapat dihapus karena masih digunakan' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                        </button>

                        {{-- Modal Konfirmasi Hapus --}}
                        <div x-show="del" class="modal-backdrop" @click.self="del=false" x-transition style="display:none">
                            <div class="modal-box">
                                <h3 class="modal-title">Hapus Kategori?</h3>
                                <p style="font-size:0.9rem;color:var(--color-text-muted);margin-bottom:var(--space-lg)">
                                    Kategori <strong>{{ $cat->name }}</strong> akan dihapus permanen.
                                    Tindakan ini tidak dapat dibatalkan.
                                </p>
                                <div style="display:flex;gap:var(--space-sm);justify-content:flex-end">
                                    <button @click="del=false" class="btn btn-ghost">Batal</button>
                                    <form method="POST" action="{{ route('admin.seed-categories.destroy', $cat) }}">
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
            <tr><td colspan="6" class="text-center text-muted" style="padding:var(--space-xl)">
                Belum ada kategori benih. <a href="{{ route('admin.seed-categories.create') }}">Tambah sekarang</a>
            </td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:var(--space-md) var(--space-lg)">{{ $categories->links() }}</div>
</div>
@endsection
