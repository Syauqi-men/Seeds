@extends('admin.layout')
@section('title', 'Daftar Pesanan')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Pesanan</h1>
        <p class="page-subtitle">Pesanan benih dari klien/mitra (dicatat secara offline)</p>
    </div>
    @role('Administrator|Order Processor')
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat Pesanan
    </a>
    @endrole
</div>

@php
    $totalOrders = $groupedOrders->flatten(1)->count();
@endphp

@if($totalOrders === 0)
    <div class="data-table-wrapper">
        <div class="text-center text-muted" style="padding:var(--space-xl)">Belum ada data pesanan.</div>
    </div>
@else
    @foreach($statusOrder as $status)
        @php $orders = $groupedOrders[$status]; @endphp
        @if($orders->count() > 0)
        <div class="data-table-wrapper" style="margin-bottom: var(--space-lg);" x-data="{ open: true }">
            {{-- Section Header --}}
            <div style="display:flex; align-items:center; justify-content:space-between; padding: var(--space-sm) var(--space-lg); border-bottom: 1px solid var(--color-border); cursor:pointer;" @click="open = !open">
                <div style="display:flex; align-items:center; gap: var(--space-sm);">
                    <span class="badge {{ $statusBadges[$status] }}" style="font-size:0.8rem;">
                        {{ $statusLabels[$status] }}
                    </span>
                    <span style="font-size:0.85rem; color:var(--color-text-muted);">
                        {{ $orders->count() }} pesanan
                    </span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="var(--color-text-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    :style="open ? '' : 'transform:rotate(-90deg)'" style="transition:transform 0.2s">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </div>

            {{-- Table Content --}}
            <div x-show="open" x-transition>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Ref</th>
                            <th>Pemesan</th>
                            <th>Tipe</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Dibuat</th>
                            <th style="text-align:right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td style="font-weight:600">{{ $order->reference_num ?? '-' }}</td>
                            <td>{{ $order->cust_name }}</td>
                            <td>
                                @php
                                    $typeLabels = [
                                        'commercial'        => 'Komersial',
                                        'seed_aid'          => 'Bantuan Benih',
                                        'internal_transfer' => 'Transfer Internal',
                                        'lab_sample'        => 'Sampel Lab',
                                    ];
                                @endphp
                                <span class="badge badge-processing">{{ $typeLabels[$order->order_type] ?? $order->order_type }}</span>
                            </td>
                            <td>{{ $order->items->count() }} Varietas</td>
                            <td>
                                <span class="badge {{ $statusBadges[$order->status] }}">{{ $statusLabels[$order->status] }}</span>
                            </td>
                            <td>
                                @php
                                    $payBadge = match($order->payment_status) {
                                        'paid'   => 'badge-ready',
                                        'unpaid' => 'badge-depleted',
                                        'exempt' => 'badge-quarantine',
                                        default  => '',
                                    };
                                    $payLabel = match($order->payment_status) {
                                        'paid'   => 'Lunas',
                                        'unpaid' => 'Belum Bayar',
                                        'exempt' => 'Bebas Biaya',
                                        default  => $order->payment_status,
                                    };
                                @endphp
                                <span class="badge {{ $payBadge }}">{{ $payLabel }}</span>
                            </td>
                            <td class="text-small text-muted">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td style="text-align:right">
                                <div style="display:flex;gap:4px;justify-content:flex-end" x-data="{ del: false }">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-sm" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-ghost btn-sm" title="Edit Pesanan">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    @role('Administrator|Order Processor')
                                    @if(in_array($order->status, ['pending', 'cancelled']))
                                    <button @click="del=true" class="btn btn-danger btn-sm" title="Hapus Permanen">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                                    </button>
                                    <div x-show="del" class="modal-backdrop" @click.self="del=false" x-transition style="display:none">
                                        <div class="modal-box">
                                            <h3 class="modal-title">Hapus Pesanan?</h3>
                                            <p style="font-size:0.9rem;color:var(--color-text-muted);margin-bottom:var(--space-lg)">
                                                Pesanan dari <strong>{{ $order->cust_name }}</strong> akan dihapus permanen.
                                            </p>
                                            <div style="display:flex;gap:var(--space-sm);justify-content:flex-end">
                                                <button @click="del=false" class="btn btn-ghost">Batal</button>
                                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endrole
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    @endforeach
@endif
@endsection
