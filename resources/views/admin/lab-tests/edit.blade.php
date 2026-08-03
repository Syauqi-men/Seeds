@extends('admin.layout')
@section('title', 'Edit Uji Lab')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit Uji Lab</h1></div>
    <a href="{{ route('admin.lab-tests.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>
<div class="form-card">
    <form method="POST" action="{{ route('admin.lab-tests.update', $labTest) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label required">Lot Benih</label>
            <select name="seed_lot_id" class="form-control">
                @foreach($lots as $lot)
                <option value="{{ $lot->id }}" {{ $labTest->seed_lot_id == $lot->id ? 'selected' : '' }}>
                    {{ $lot->lot_number }} &mdash; {{ $lot->seed->var_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required">Daya Kecambah (%)</label>
                <input type="number" name="germination_rate" step="0.1" min="0" max="100" value="{{ old('germination_rate', $labTest->germination_rate) }}" class="form-control @error('germination_rate') is-invalid @enderror">
                @error('germination_rate') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Kadar Air (%)</label>
                <input type="number" name="moisture_content" step="0.1" min="0" max="100" value="{{ old('moisture_content', $labTest->moisture_content) }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label required">Hasil Uji</label>
                <select name="test_result" class="form-control">
                    <option value="PASSED" {{ $labTest->test_result->value === 'PASSED' ? 'selected' : '' }}>Lulus (PASSED)</option>
                    <option value="FAILED" {{ $labTest->test_result->value === 'FAILED' ? 'selected' : '' }}>Tidak Lulus (FAILED)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Uji</label>
                <input type="date" name="tested_at" value="{{ old('tested_at', $labTest->tested_at?->format('Y-m-d')) }}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $labTest->notes) }}</textarea>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <a href="{{ route('admin.lab-tests.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
</div>
@endsection
