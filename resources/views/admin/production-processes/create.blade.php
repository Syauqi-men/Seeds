@extends('admin.layout')
@section('title', 'Tambah Proses Produksi')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Tambah Proses Produksi</h1></div>
    <a href="{{ route('admin.production-processes.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>
<div class="form-card">
    <form method="POST" action="{{ route('admin.production-processes.store') }}">
        @csrf
        <div class="form-group">
            <label class="form-label required" for="pp_seed_lot_id">Lot Benih</label>
            <select id="pp_seed_lot_id" name="seed_lot_id" class="form-control @error('seed_lot_id') is-invalid @enderror">
                <option value="">-- Pilih Lot --</option>
                @foreach($lots as $lot)
                <option value="{{ $lot->id }}" {{ old('seed_lot_id') == $lot->id ? 'selected' : '' }}>
                    {{ $lot->lot_number }} &mdash; {{ $lot->seed->var_name }}
                </option>
                @endforeach
            </select>
            @error('seed_lot_id') <span class="form-error">{{ $message }}</span> @enderror
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required">Input (kg)</label>
                <input type="number" name="input_quantity" step="0.01" min="0.01" value="{{ old('input_quantity') }}" class="form-control @error('input_quantity') is-invalid @enderror" placeholder="0.00">
                @error('input_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label required">Output (kg)</label>
                <input type="number" name="output_quantity" step="0.01" min="0" value="{{ old('output_quantity') }}" class="form-control @error('output_quantity') is-invalid @enderror" placeholder="0.00">
                @error('output_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Susut (kg)</label>
                <input type="number" name="shrinkage_quantity" step="0.01" min="0" value="{{ old('shrinkage_quantity', 0) }}" class="form-control" placeholder="0.00">
            </div>
            <div class="form-group">
                <label class="form-label">Limbah (kg)</label>
                <input type="number" name="waste_quantity" step="0.01" min="0" value="{{ old('waste_quantity', 0) }}" class="form-control" placeholder="0.00">
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label">KA Awal (%)</label>
                <input type="number" name="moisture_start" step="0.01" min="0" max="100" value="{{ old('moisture_start') }}" class="form-control" placeholder="0.00">
            </div>
            <div class="form-group">
                <label class="form-label">KA Akhir (%)</label>
                <input type="number" name="moisture_end" step="0.01" min="0" max="100" value="{{ old('moisture_end') }}" class="form-control" placeholder="0.00">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Proses</label>
                <input type="datetime-local" name="processed_at" value="{{ old('processed_at') }}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2" placeholder="Catatan proses (opsional)">{{ old('notes') }}</textarea>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <a href="{{ route('admin.production-processes.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
