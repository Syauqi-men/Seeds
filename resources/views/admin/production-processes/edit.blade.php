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
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:var(--space-md)">
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
            <div class="form-group">
                <label class="form-label required">Jenis Proses</label>
                <select name="process_type" class="form-control @error('process_type') is-invalid @enderror">
                    @foreach($types as $type)
                    <option value="{{ $type->value }}"
                        {{ old('process_type', $productionProcess->process_type->value) === $type->value ? 'selected' : '' }}>
                        {{ $type->label() }}
                    </option>
                    @endforeach
                </select>
                @error('process_type') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Pekerja</label>
                <select name="worker_id" class="form-control">
                    <option value="">-- Pilih Pekerja --</option>
                    @foreach($workers as $w)
                    <option value="{{ $w->id }}"
                        {{ old('worker_id', $productionProcess->worker_id) == $w->id ? 'selected' : '' }}>
                        {{ $w->name }}{{ $w->code ? ' ('.$w->code.')' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required">Input (kg)</label>
                <input type="number" name="input_quantity" step="0.01"
                    value="{{ old('input_quantity', $productionProcess->input_quantity) }}"
                    class="form-control @error('input_quantity') is-invalid @enderror">
                @error('input_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label required">Output (kg)</label>
                <input type="number" name="output_quantity" step="0.01"
                    value="{{ old('output_quantity', $productionProcess->output_quantity) }}"
                    class="form-control @error('output_quantity') is-invalid @enderror">
                @error('output_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Sortir (kg)</label>
                <input type="number" name="sortir_quantity" step="0.01"
                    value="{{ old('sortir_quantity', $productionProcess->sortir_quantity) }}"
                    class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Limbah (kg)</label>
                <input type="number" name="waste_quantity" step="0.01"
                    value="{{ old('waste_quantity', $productionProcess->waste_quantity) }}"
                    class="form-control">
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label">Tanggal Proses</label>
                <input type="datetime-local" name="processed_at"
                    value="{{ old('processed_at', $productionProcess->processed_at?->format('Y-m-d\TH:i')) }}"
                    class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Catatan</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $productionProcess->notes) }}</textarea>
            </div>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <a href="{{ route('admin.production-processes.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
</div>
@endsection
