@extends('admin.layout')
@section('title', 'Edit Pesanan')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Pesanan</h1>
        <p class="page-subtitle">{{ $order->reference_num ?? 'Tanpa Referensi' }} — {{ $order->cust_name }}</p>
    </div>
    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>

@php
    $user = auth()->user();
    $canEditDetails = $user->hasAnyRole(['Administrator', 'Order Processor']);
    $canEditStatus = $user->hasAnyRole(['Administrator', 'Petugas Benih']);
@endphp

<form method="POST" action="{{ route('admin.orders.update', $order) }}">
    @csrf @method('PUT')

    {{-- Info Pemesan --}}
    <div class="form-card" style="margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:var(--space-md);color:var(--color-text)">
            Informasi Pemesan
        </h3>
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label {{ $canEditDetails ? 'required' : '' }}" for="cust_name">Nama Pemesan</label>
                <input type="text" id="cust_name" name="cust_name"
                    value="{{ old('cust_name', $order->cust_name) }}"
                    class="form-control @error('cust_name') is-invalid @enderror"
                    {{ $canEditDetails ? '' : 'disabled' }}>
                @error('cust_name') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label {{ $canEditDetails ? 'required' : '' }}" for="order_type">Tipe Pesanan</label>
                <select id="order_type" name="order_type" class="form-control @error('order_type') is-invalid @enderror"
                    {{ $canEditDetails ? '' : 'disabled' }}>
                    @php $ot = old('order_type', $order->order_type); @endphp
                    <option value="commercial" {{ $ot === 'commercial' ? 'selected' : '' }}>Komersial</option>
                    <option value="seed_aid" {{ $ot === 'seed_aid' ? 'selected' : '' }}>Bantuan Benih</option>
                    <option value="internal_transfer" {{ $ot === 'internal_transfer' ? 'selected' : '' }}>Transfer Internal</option>
                    <option value="lab_sample" {{ $ot === 'lab_sample' ? 'selected' : '' }}>Sampel Lab</option>
                </select>
                @error('order_type') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label" for="reference_num">No. Referensi / Surat</label>
                <input type="text" id="reference_num" name="reference_num"
                    value="{{ old('reference_num', $order->reference_num) }}"
                    class="form-control" placeholder="SPP-001/IX/2026"
                    {{ $canEditDetails ? '' : 'disabled' }}>
            </div>
            <div class="form-group">
                <label class="form-label" for="notes">Catatan</label>
                <input type="text" id="notes" name="notes"
                    value="{{ old('notes', $order->notes) }}"
                    class="form-control" placeholder="Keterangan tambahan (opsional)"
                    {{ $canEditDetails ? '' : 'disabled' }}>
            </div>
        </div>
    </div>

    {{-- Status Pesanan --}}
    <div class="form-card" style="margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:var(--space-md);color:var(--color-text)">
            Status Pesanan
        </h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label {{ $canEditStatus ? 'required' : '' }}" for="status">Status Pesanan</label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror"
                    {{ $canEditStatus ? '' : 'disabled' }}>
                    @php $st = old('status', $order->status); @endphp
                    <option value="pending" {{ $st === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="preparing" {{ $st === 'preparing' ? 'selected' : '' }}>Diproses</option>
                    <option value="ready" {{ $st === 'ready' ? 'selected' : '' }}>Siap</option>
                    <option value="completed" {{ $st === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $st === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status') <span class="form-error">{{ $message }}</span> @enderror
                @if(!$canEditStatus)
                    <small class="text-muted" style="display:block;margin-top:4px">Hanya Petugas Benih yang dapat mengubah status.</small>
                @endif
            </div>
            <div class="form-group">
                <label class="form-label {{ $canEditDetails ? 'required' : '' }}" for="payment_status">Status Pembayaran</label>
                <select id="payment_status" name="payment_status" class="form-control @error('payment_status') is-invalid @enderror"
                    {{ $canEditDetails ? '' : 'disabled' }}>
                    @php $ps = old('payment_status', $order->payment_status); @endphp
                    <option value="unpaid" {{ $ps === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="paid" {{ $ps === 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="exempt" {{ $ps === 'exempt' ? 'selected' : '' }}>Bebas Biaya</option>
                </select>
                @error('payment_status') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- Ringkasan Item (read-only) --}}
    <div class="data-table-wrapper" style="margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem;font-weight:700;padding:var(--space-md) var(--space-lg) 0;color:var(--color-text)">
            Item Pesanan (tidak dapat diubah)
        </h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Varietas</th>
                    <th>Kelas</th>
                    <th style="text-align:right">Jumlah (kg)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $i => $item)
                <tr>
                    <td class="text-muted">{{ $i + 1 }}</td>
                    <td>{{ $item->seed->var_name ?? '—' }}</td>
                    <td><span class="badge badge-processing">{{ $item->seed_class->value ?? $item->seed_class }}</span></td>
                    <td style="text-align:right">{{ number_format($item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
@endsection
