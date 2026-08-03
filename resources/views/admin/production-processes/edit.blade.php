@extends('admin.layout')
@section('title', 'Edit Proses Produksi')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit Proses Produksi</h1></div>
    <a href="{{ route('admin.production-processes.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>
<div class="form-card">
    <form method="POST" action="{{ route('admin.production-processes.update', $productionProcess) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label required">Lot Benih</label>
            <select name="seed_lot_id" class="form-control">
                @foreach($lots as $lot)
                <option value="{{ $lot->id }}" {{ $productionProcess->seed_lot_id == $lot->id ? 'selected' : '' }}>
                    {{ $lot->lot_number }} &mdash; {{ $lot->seed->var_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required">Input (kg)</label>
                <input type="number" name="input_quantity" step="0.01" value="{{ old('input_quantity', $productionProcess->input_quantity) }}" class="form-control @error('input_quantity') is-invalid @enderror">
                @error('input_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label required">Output (kg)</label>
                <input type="number" name="output_quantity" step="0.01" value="{{ old('output_quantity', $productionProcess->output_quantity) }}" class="form-control @error('output_quantity') is-invalid @enderror">
                @error('output_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Susut (kg)</label>
                <input type="number" name="shrinkage_quantity" step="0.01" value="{{ old('shrinkage_quantity', $productionProcess->shrinkage_quantity) }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Limbah (kg)</label>
                <input type="number" name="waste_quantity" step="0.01" value="{{ old('waste_quantity', $productionProcess->waste_quantity) }}" class="form-control">
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label">KA Awal (%)</label>
                <input type="number" name="moisture_start" step="0.01" value="{{ old('moisture_start', $productionProcess->moisture_start) }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">KA Akhir (%)</label>
                <input type="number" name="moisture_end" step="0.01" value="{{ old('moisture_end', $productionProcess->moisture_end) }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Proses</label>
                <input type="datetime-local" name="processed_at" value="{{ old('processed_at', $productionProcess->processed_at?->format('Y-m-d\TH:i')) }}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $productionProcess->notes) }}</textarea>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <a href="{{ route('admin.production-processes.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
</div>
@endsection
