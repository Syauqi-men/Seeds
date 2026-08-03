@extends('admin.layout')
@section('title', 'Uji Lab')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Uji Laboratorium</h1>
        <p class="page-subtitle">Hasil pengujian daya kecambah dan kadar air benih</p>
    </div>
    <a href="{{ route('admin.lab-tests.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Uji Lab
    </a>
</div>
<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Lot</th><th>Daya Kecambah</th><th>Kadar Air</th><th>Hasil</th><th>Tanggal Uji</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tests as $test)
            <tr>
                <td>
                    <div style="font-weight:600">{{ $test->seedLot->lot_number }}</div>
                    <div class="text-small text-muted">{{ $test->seedLot->seed->var_name }}</div>
                </td>
                <td style="font-weight:600">{{ $test->germination_rate }}%</td>
                <td>{{ $test->moisture_content ?? '-' }}%</td>
                <td>
                    <span class="badge {{ $test->test_result->value === 'PASSED' ? 'badge-ready' : 'badge-depleted' }}">
                        {{ $test->test_result->label() }}
                    </span>
                </td>
                <td class="text-small text-muted">{{ $test->tested_at?->translatedFormat('d M Y') ?? '-' }}</td>
                <td style="text-align:right">
                    <div style="display:flex;gap:4px;justify-content:flex-end" x-data="{ del: false }">
                        <a href="{{ route('admin.lab-tests.edit', $test) }}" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <button @click="del=true" class="btn btn-danger btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                        </button>
                        <div x-show="del" class="modal-backdrop" @click.self="del=false" x-transition style="display:none">
                            <div class="modal-box">
                                <h3 class="modal-title">Hapus Data Uji Lab?</h3>
                                <p style="font-size:0.9rem;color:var(--color-text-muted);margin-bottom:var(--space-lg)">Data uji lab ini akan dihapus permanen.</p>
                                <div style="display:flex;gap:var(--space-sm);justify-content:flex-end">
                                    <button @click="del=false" class="btn btn-ghost">Batal</button>
                                    <form method="POST" action="{{ route('admin.lab-tests.destroy', $test) }}">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Hapus</button></form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted" style="padding:var(--space-xl)">Belum ada data uji lab.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:var(--space-md) var(--space-lg)">{{ $tests->links() }}</div>
</div>
@endsection
