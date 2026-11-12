@extends('admin.layout')
@section('title', 'Export Benih')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Export Benih</h1>
        <p class="page-subtitle">Rekapitulasi ketersediaan stok dan hasil proses produksi lot benih siap salur</p>
    </div>

    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <a href="{{ route('admin.reports.stock-availability.xlsx') }}" class="btn btn-primary" title="Unduh rekapitulasi data dalam format Excel">
            <i data-lucide="file-spreadsheet" style="width: 16px; height: 16px;"></i>
            <span>Unduh Excel (.xlsx)</span>
        </a>
        <a href="{{ route('admin.reports.stock-availability') }}" class="btn btn-ghost" style="border: 1px solid var(--nv-border); background: var(--nv-surface); color: var(--nv-text);" title="Unduh data dalam format CSV">
            <i data-lucide="file-text" style="width: 16px; height: 16px;"></i>
            <span>Unduh CSV</span>
        </a>
    </div>
</div>

{{-- KPI Summary Cards --}}
<div class="stats-grid">
    {{-- Card 1: Total Lot --}}
    <div class="stat-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
            <span class="stat-card-label" style="margin: 0; text-transform: uppercase; letter-spacing: 0.04em;">
                Total Lot Terproses
            </span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(59, 130, 246, 0.1); display: grid; place-items: center; color: #2563eb;">
                <i data-lucide="boxes" style="width: 16px; height: 16px;"></i>
            </div>
        </div>
        <div class="stat-card-value">
            {{ number_format($summary['total_lots'] ?? 0, 0, ',', '.') }}
        </div>
        <div class="stat-card-unit">
            Lot siap disalurkan / diekspor
        </div>
    </div>

    {{-- Card 2: Total Berat Awal --}}
    <div class="stat-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
            <span class="stat-card-label" style="margin: 0; text-transform: uppercase; letter-spacing: 0.04em;">
                Total Berat Awal
            </span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(100, 116, 139, 0.1); display: grid; place-items: center; color: #475569;">
                <i data-lucide="scale" style="width: 16px; height: 16px;"></i>
            </div>
        </div>
        <div class="stat-card-value">
            {{ number_format($summary['total_arrival'] ?? 0, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: 500; color: var(--nv-text-muted);">kg</span>
        </div>
        <div class="stat-card-unit">
            Akumulasi bahan baku tiba
        </div>
    </div>

    {{-- Card 3: Stok Bersih Siap Salur --}}
    <div class="stat-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
            <span class="stat-card-label" style="margin: 0; text-transform: uppercase; letter-spacing: 0.04em;">
                Stok Bersih Siap Salur
            </span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(34, 197, 94, 0.12); display: grid; place-items: center; color: #16a34a;">
                <i data-lucide="sprout" style="width: 16px; height: 16px;"></i>
            </div>
        </div>
        <div class="stat-card-value" style="color: #15803d;">
            {{ number_format($summary['total_clean'] ?? 0, 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: 500; color: var(--nv-text-muted);">kg</span>
        </div>
        <div class="stat-card-unit">
            Rendemen rata-rata: <strong style="color: #15803d;">{{ $summary['recovery_rate'] ?? 0 }}%</strong>
        </div>
    </div>

    {{-- Card 4: Total Sortir & Limbah --}}
    <div class="stat-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
            <span class="stat-card-label" style="margin: 0; text-transform: uppercase; letter-spacing: 0.04em;">
                Total Sortasi & Limbah
            </span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); display: grid; place-items: center; color: #d97706;">
                <i data-lucide="recycle" style="width: 16px; height: 16px;"></i>
            </div>
        </div>
        <div class="stat-card-value">
            {{ number_format(($summary['total_sortir'] ?? 0) + ($summary['total_waste'] ?? 0), 2, ',', '.') }} <span style="font-size: 0.85rem; font-weight: 500; color: var(--nv-text-muted);">kg</span>
        </div>
        <div class="stat-card-unit">
            Sortir: {{ number_format($summary['total_sortir'] ?? 0, 1, ',', '.') }} kg · Limbah: {{ number_format($summary['total_waste'] ?? 0, 1, ',', '.') }} kg
        </div>
    </div>
</div>

{{-- Data Table Section --}}
<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 48px; text-align: center;">#</th>
                <th style="min-width: 150px;">Nomor Lot</th>
                <th style="min-width: 200px;">Varietas & Komoditas</th>
                <th style="min-width: 110px;">Kelas Benih</th>
                <th style="text-align: right; min-width: 120px;">Berat Awal</th>
                <th style="text-align: right; min-width: 120px;">Stok Bersih</th>
                <th style="text-align: right; min-width: 110px;">Sortasi</th>
                <th style="text-align: right; min-width: 110px;">Limbah</th>
                <th style="text-align: right; min-width: 100px;">Rendemen</th>
                <th style="text-align: center; width: 64px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lots as $lot)
            @php
                $sortir   = (float) ($lot->sortir_total ?? 0);
                $limbah   = (float) ($lot->waste_total ?? 0);
                $rendemen = ($lot->arrival_weight > 0)
                    ? round(($lot->clean_stock / $lot->arrival_weight) * 100, 1)
                    : 0;
            @endphp
            <tr>
                <td style="text-align: center; color: var(--nv-text-muted); font-size: var(--nv-text-xs);">
                    {{ $lots->firstItem() + $loop->index }}
                </td>
                <td>
                    <div style="font-weight: 600; color: var(--nv-text); font-size: var(--nv-text-sm);">
                        {{ $lot->lot_number }}
                    </div>
                    <div class="text-small text-muted" style="margin-top: 2px;">
                        {{ $lot->harvest_date ? 'Panen: ' . $lot->harvest_date->translatedFormat('d M Y') : 'Diperbarui: ' . $lot->updated_at->translatedFormat('d M Y') }}
                    </div>
                </td>
                <td>
                    <div style="font-weight: 500; color: var(--nv-text); margin-bottom: 3px;">
                        {{ $lot->seed->var_name ?? '-' }}
                    </div>
                    <div>
                        <span class="badge {{ \App\Models\SeedCategory::badgeClassFor($lot->seed->category?->name) }}" style="font-size: 0.68rem; padding: 1px 7px;">
                            {{ $lot->seed->category?->name ?? '-' }}
                        </span>
                    </div>
                </td>
                <td>
                    @if($lot->seed->var_class)
                        <span class="badge {{ $lot->seed->var_class->badgeClass() }}" style="font-size: 0.72rem; padding: 2px 8px; font-weight: 600;">
                            {{ $lot->seed->var_class->value }}
                        </span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <span style="font-weight: 500;">{{ number_format($lot->arrival_weight ?? 0, 2, ',', '.') }}</span>
                    <span class="text-small text-muted">kg</span>
                </td>
                <td style="text-align: right;">
                    <span style="font-weight: 700; color: #15803d;">{{ number_format($lot->clean_stock, 2, ',', '.') }}</span>
                    <span class="text-small text-muted">kg</span>
                </td>
                <td style="text-align: right;">
                    <span>{{ number_format($sortir, 2, ',', '.') }}</span>
                    <span class="text-small text-muted">kg</span>
                </td>
                <td style="text-align: right;">
                    <span style="color: #b91c1c;">{{ number_format($limbah, 2, ',', '.') }}</span>
                    <span class="text-small text-muted">kg</span>
                </td>
                <td style="text-align: right;">
                    <span class="badge" style="background: rgba(34, 197, 94, 0.1); color: #166534; border: 1px solid rgba(34, 197, 94, 0.25); font-weight: 600; font-size: 0.72rem; padding: 2px 7px;">
                        {{ $rendemen }}%
                    </span>
                </td>
                <td style="text-align: center;">
                    <a href="{{ route('admin.seed-lots.show', $lot) }}" class="btn btn-ghost btn-sm" title="Lihat detail lot {{ $lot->lot_number }}" style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                        <i data-lucide="eye" style="width: 14px; height: 14px;"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 48px 20px;">
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; color: var(--nv-text-muted);">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--nv-surface-muted); display: grid; place-items: center; border: 1px solid var(--nv-border);">
                            <i data-lucide="package-open" style="width: 24px; height: 24px; color: var(--nv-text-subtle);"></i>
                        </div>
                        <strong style="color: var(--nv-text); font-size: var(--nv-text-md);">Belum Ada Data Lot Benih Terproses</strong>
                        <p style="margin: 0; font-size: var(--nv-text-sm); max-width: 420px; line-height: 1.5;">
                            Data lot akan muncul di sini setelah melalui tahapan proses sortasi atau grading pada modul Proses Produksi.
                        </p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($lots->count() > 0)
        @php
            $pageArrival  = (float) $lots->sum('arrival_weight');
            $pageClean    = (float) $lots->sum('clean_stock');
            $pageSortir   = (float) $lots->sum('sortir_total');
            $pageWaste    = (float) $lots->sum('waste_total');
            $pageRendemen = ($pageArrival > 0) ? round(($pageClean / $pageArrival) * 100, 1) : 0;
        @endphp
        <tfoot>
            <tr style="background: var(--nv-surface-muted); font-weight: 600; border-top: 2px solid var(--nv-border);">
                <td colspan="4" style="text-align: right; color: var(--nv-text-muted); font-size: var(--nv-text-xs); text-transform: uppercase; letter-spacing: 0.04em; padding: 12px 14px;">
                    Subtotal Halaman Ini ({{ $lots->count() }} Lot) :
                </td>
                <td style="text-align: right; font-variant-numeric: tabular-nums;">
                    {{ number_format($pageArrival, 2, ',', '.') }} <span class="text-small text-muted">kg</span>
                </td>
                <td style="text-align: right; font-variant-numeric: tabular-nums; color: #15803d;">
                    {{ number_format($pageClean, 2, ',', '.') }} <span class="text-small text-muted">kg</span>
                </td>
                <td style="text-align: right; font-variant-numeric: tabular-nums;">
                    {{ number_format($pageSortir, 2, ',', '.') }} <span class="text-small text-muted">kg</span>
                </td>
                <td style="text-align: right; font-variant-numeric: tabular-nums; color: #b91c1c;">
                    {{ number_format($pageWaste, 2, ',', '.') }} <span class="text-small text-muted">kg</span>
                </td>
                <td style="text-align: right;">
                    <span class="badge" style="background: rgba(34, 197, 94, 0.15); color: #166534; font-weight: 700; font-size: 0.72rem; padding: 2px 7px;">
                        {{ $pageRendemen }}%
                    </span>
                </td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    @if($lots->hasPages())
    <div style="padding: var(--space-md) var(--space-lg); border-top: 1px solid var(--nv-border);">
        {{ $lots->links() }}
    </div>
    @endif
</div>
@endsection
