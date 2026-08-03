@extends('admin.layout')
@section('title', 'Tambah Transaksi Stok')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Tambah Transaksi Stok</h1></div>
    <a href="{{ route('admin.stock-transactions.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>
<div class="form-card">
    <form method="POST" action="{{ route('admin.stock-transactions.store') }}">
        @csrf
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required">Lot Benih</label>
                <select name="seed_lot_id" class="form-control @error('seed_lot_id') is-invalid @enderror">
                    <option value="">-- Pilih Lot --</option>
                    @foreach($lots as $lot)
                    <option value="{{ $lot->id }}" {{ old('seed_lot_id') == $lot->id ? 'selected' : '' }}>
                        {{ $lot->lot_number }} &mdash; {{ $lot->seed->var_name }}
                    </option>
                    @endforeach
                </select>
                @error('seed_lot_id') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label required">Tipe Transaksi</label>
                <select name="transaction_type" class="form-control @error('transaction_type') is-invalid @enderror">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="IN"         {{ old('transaction_type') === 'IN' ? 'selected' : '' }}>Masuk (IN)</option>
                    <option value="OUT"        {{ old('transaction_type') === 'OUT' ? 'selected' : '' }}>Keluar (OUT)</option>
                    <option value="ADJUSTMENT" {{ old('transaction_type') === 'ADJUSTMENT' ? 'selected' : '' }}>Penyesuaian (ADJUSTMENT)</option>
                </select>
                @error('transaction_type') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required">Jumlah (kg)</label>
                <input type="number" name="quantity" step="0.01" value="{{ old('quantity') }}" class="form-control @error('quantity') is-invalid @enderror" placeholder="0.00">
                @error('quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">No. Referensi</label>
                <input type="text" name="reference_no" value="{{ old('reference_no') }}" class="form-control" placeholder="INV-XXX-001">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="datetime-local" name="transacted_at" value="{{ old('transacted_at') }}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2" placeholder="Keterangan transaksi">{{ old('notes') }}</textarea>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <a href="{{ route('admin.stock-transactions.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
