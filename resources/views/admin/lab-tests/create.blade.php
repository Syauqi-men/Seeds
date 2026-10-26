@extends('admin.layout')
@section('title', 'Tambah Uji Lab')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Tambah Uji Lab</h1></div>
    <a href="{{ route('admin.lab-tests.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>
<div class="form-card">
    <form method="POST" action="{{ route('admin.lab-tests.store') }}">
        @csrf
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
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required">Daya Kecambah (%)</label>
                <input type="number" name="germination_rate" step="0.1" min="0" max="100" value="{{ old('germination_rate') }}" class="form-control @error('germination_rate') is-invalid @enderror" placeholder="0 - 100">
                @error('germination_rate') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Kadar Air (%)</label>
                <input type="number" name="moisture_content" step="0.1" min="0" max="100" value="{{ old('moisture_content') }}" class="form-control" placeholder="0 - 100">
            </div>
            <div class="form-group">
                <label class="form-label required">Hasil Uji</label>
                <select name="test_result" class="form-control @error('test_result') is-invalid @enderror">
                    <option value="">-- Pilih Hasil --</option>
                    <option value="PASSED" {{ old('test_result') === 'PASSED' ? 'selected' : '' }}>Lulus (PASSED)</option>
                    <option value="FAILED" {{ old('test_result') === 'FAILED' ? 'selected' : '' }}>Tidak Lulus (FAILED)</option>
                </select>
                @error('test_result') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Uji</label>
                <input type="date" name="tested_at" value="{{ old('tested_at') }}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2" placeholder="Catatan hasil uji (opsional)">{{ old('notes') }}</textarea>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <a href="{{ route('admin.lab-tests.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
