@extends('admin.layout')
@section('title', 'Detail Lot Benih')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $seedLot->lot_number }}</h1>
        <p class="page-subtitle">{{ $seedLot->seed->var_name }} &bull; {{ $seedLot->seed->category->label() }} &bull; {{ $seedLot->seed->var_class->value }}</p>
    </div>
    <div style="display:flex;gap:var(--space-sm)">
        <a href="{{ route('admin.seed-lots.edit', $seedLot) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('admin.seed-lots.index') }}" class="btn btn-ghost">Kembali</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-xl)">
    <div class="form-card">
        <h3 style="margin-bottom:var(--space-md);font-size:1rem">Informasi Lot</h3>
        <dl style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-sm)">
            <dt class="text-muted text-small">Status</dt>
            <dd><span class="badge badge-{{ strtolower($seedLot->status->value) }}">{{ $seedLot->status->label() }}</span></dd>
            <dt class="text-muted text-small">Tanggal Panen</dt>
            <dd>{{ $seedLot->harvest_date?->translatedFormat('d M Y') ?? '-' }}</dd>
            <dt class="text-muted text-small">Stok Mentah</dt>
            <dd style="font-weight:700;color:var(--color-primary-700)">{{ number_format($seedLot->raw_stock, 2) }} kg</dd>
            <dt class="text-muted text-small">Stok Bersih</dt>
            <dd style="font-weight:700;color:var(--color-primary-700)">{{ number_format($seedLot->clean_stock, 2) }} kg</dd>
            <dt class="text-muted text-small">Berat Asal</dt>
            <dd>{{ $seedLot->origin_weight ? number_format($seedLot->origin_weight, 2).' kg' : '-' }}</dd>
            <dt class="text-muted text-small">KA Asal</dt>
            <dd>{{ $seedLot->origin_moisture ? $seedLot->origin_moisture.'%' : '-' }}</dd>
            <dt class="text-muted text-small">Berat Tiba</dt>
            <dd>{{ $seedLot->arrival_weight ? number_format($seedLot->arrival_weight, 2).' kg' : '-' }}</dd>
            <dt class="text-muted text-small">KA Tiba</dt>
            <dd>{{ $seedLot->arrival_moisture ? $seedLot->arrival_moisture.'%' : '-' }}</dd>
        </dl>
    </div>

    <div class="form-card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
            <h3 style="font-size:1rem">Uji Lab ({{ $seedLot->labTests->count() }})</h3>
            <a href="{{ route('admin.lab-tests.create') }}" class="btn btn-secondary btn-sm">+ Tambah Uji</a>
        </div>
        @forelse($seedLot->labTests as $test)
        <div style="border:1px solid var(--color-border);border-radius:var(--radius-sm);padding:var(--space-sm);margin-bottom:var(--space-xs)">
            <div style="display:flex;justify-content:space-between">
                <span class="badge {{ $test->test_result->value === 'PASSED' ? 'badge-ready' : 'badge-depleted' }}">{{ $test->test_result->label() }}</span>
                <span class="text-small text-muted">{{ $test->tested_at?->translatedFormat('d M Y') ?? '-' }}</span>
            </div>
            <div class="text-small" style="margin-top:4px">
                Daya Kecambah: <strong>{{ $test->germination_rate }}%</strong> &bull; Kadar Air: {{ $test->moisture_content ?? '-' }}%
            </div>
        </div>
        @empty
        <p class="text-muted text-small">Belum ada uji lab.</p>
        @endforelse
    </div>
</div>

<div class="form-card mt-lg">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem">Proses Produksi ({{ $seedLot->productionProcesses->count() }})</h3>
        <a href="{{ route('admin.production-processes.create') }}" class="btn btn-secondary btn-sm">+ Tambah Proses</a>
    </div>
    <table class="data-table">
        <thead><tr>
            <th>Jenis Proses</th>
            <th>Pekerja</th>
            <th>Input (kg)</th>
            <th>Output (kg)</th>
            <th>Susut (kg)</th>
            <th>Limbah (kg)</th>
            <th>Tanggal</th>
        </tr></thead>
        <tbody>
            @forelse($seedLot->productionProcesses as $proc)
            <tr>
                <td>
                    <span class="badge {{ $proc->process_type->badgeClass() }}">
                        {{ $proc->process_type->label() }}
                    </span>
                </td>
                <td>
                    @if($proc->worker)
                        <div style="font-weight:500">{{ $proc->worker->name }}</div>
                        @if($proc->worker->code)
                        <div class="text-small text-muted">{{ $proc->worker->code }}</div>
                        @endif
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ number_format($proc->input_quantity, 2) }} kg</td>
                <td>{{ number_format($proc->output_quantity, 2) }} kg</td>
                <td>{{ number_format($proc->shrinkage_quantity, 2) }} kg</td>
                <td>{{ number_format($proc->waste_quantity, 2) }} kg</td>
                <td class="text-small text-muted">{{ $proc->processed_at?->translatedFormat('d M Y') ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted">Belum ada proses produksi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="form-card mt-lg">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem">Transaksi Stok ({{ $seedLot->stockTransactions->count() }})</h3>
        <a href="{{ route('admin.stock-transactions.create') }}" class="btn btn-secondary btn-sm">+ Tambah Transaksi</a>
    </div>
    <table class="data-table">
        <thead><tr><th>Tipe</th><th>Quantity</th><th>Referensi</th><th>Catatan</th><th>Tanggal</th></tr></thead>
        <tbody>
            @forelse($seedLot->stockTransactions as $tx)
            <tr>
                <td>
                    <span class="badge {{ $tx->transaction_type->value === 'IN' ? 'badge-ready' : ($tx->transaction_type->value === 'OUT' ? 'badge-depleted' : 'badge-processing') }}">
                        {{ $tx->transaction_type->label() }}
                    </span>
                </td>
                <td style="font-weight:600">{{ number_format($tx->quantity, 2) }} kg</td>
                <td class="text-small">{{ $tx->reference_no ?? '-' }}</td>
                <td class="text-small text-muted">{{ Str::limit($tx->notes, 40) ?? '-' }}</td>
                <td class="text-small text-muted">{{ $tx->transacted_at?->translatedFormat('d M Y') ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi stok.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
