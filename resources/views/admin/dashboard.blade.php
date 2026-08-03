@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Ringkasan data stok benih BRMP Aneka Kacang</p>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-label">Total Varietas</div>
        <div class="stat-card-value">{{ number_format($stats['total_seeds']) }}</div>
        <div class="stat-card-unit">varietas terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Total Lot</div>
        <div class="stat-card-value">{{ number_format($stats['total_lots']) }}</div>
        <div class="stat-card-unit">lot benih</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Lot Siap</div>
        <div class="stat-card-value" style="color:var(--color-ready)">{{ number_format($stats['lots_ready']) }}</div>
        <div class="stat-card-unit">status Ready</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Mentah</div>
        <div class="stat-card-value">{{ number_format($stats['total_raw'], 0) }}</div>
        <div class="stat-card-unit">kg total</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Bersih</div>
        <div class="stat-card-value">{{ number_format($stats['total_clean'], 0) }}</div>
        <div class="stat-card-unit">kg total</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Lot Habis</div>
        <div class="stat-card-value" style="color:var(--color-depleted)">{{ number_format($stats['lots_depleted']) }}</div>
        <div class="stat-card-unit">status Depleted</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-xl)">
    {{-- Transaksi Terbaru --}}
    <div class="data-table-wrapper">
        <div style="padding:var(--space-md) var(--space-lg);border-bottom:1px solid var(--color-border);">
            <h3 style="font-size:0.95rem;font-weight:700">Transaksi Stok Terbaru</h3>
        </div>
        <table class="data-table">
            <thead><tr>
                <th>Lot</th><th>Tipe</th><th>Qty</th><th>Waktu</th>
            </tr></thead>
            <tbody>
            @forelse($recentTransactions as $tx)
            <tr>
                <td>{{ $tx->seedLot->lot_number }}</td>
                <td>
                    <span class="badge {{ $tx->transaction_type->value === 'IN' ? 'badge-ready' : ($tx->transaction_type->value === 'OUT' ? 'badge-depleted' : 'badge-processing') }}">
                        {{ $tx->transaction_type->label() }}
                    </span>
                </td>
                <td>{{ number_format($tx->quantity, 1) }} kg</td>
                <td class="text-muted text-small">{{ $tx->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted">Belum ada transaksi</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Log Aktivitas Terbaru --}}
    <div class="data-table-wrapper">
        <div style="padding:var(--space-md) var(--space-lg);border-bottom:1px solid var(--color-border);">
            <h3 style="font-size:0.95rem;font-weight:700">Aktivitas Terbaru</h3>
        </div>
        <div style="padding:var(--space-md)">
            <div class="activity-feed">
                @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div>
                        <div class="activity-text">{{ $activity->description }}</div>
                        <div class="activity-time">
                            {{ $activity->causer->name ?? 'Sistem' }} &bull; {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-small">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
