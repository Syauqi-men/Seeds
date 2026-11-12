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
                <input type="number" id="germination_rate" name="germination_rate" step="0.1" min="0" max="100" value="{{ old('germination_rate') }}" class="form-control @error('germination_rate') is-invalid @enderror" placeholder="Min. 80%">
                @error('germination_rate') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Kadar Air (%)</label>
                <input type="number" id="moisture_content" name="moisture_content" step="0.1" min="0" max="100" value="{{ old('moisture_content') }}" class="form-control" placeholder="Maks. 12%">
            </div>
            <div class="form-group">
                <label class="form-label">Hasil Uji (Otomatis)</label>
                <input type="text" id="test_result_preview" class="form-control" value="Menunggu input.." readonly style="background:var(--surface-2, #f3f4f6);font-weight:600;cursor:not-allowed">
                <input type="hidden" id="test_result" name="test_result" value="{{ old('test_result', 'FAILED') }}">
                {{-- <small style="display:block;margin-top:4px;font-size:11px;color:var(--text-muted, #6b7280)">Lulus jika Daya Kecambah &ge; 80% &amp; Kadar Air &le; 12%</small> --}}
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const germInput = document.getElementById('germination_rate');
    const moistInput = document.getElementById('moisture_content');
    const preview = document.getElementById('test_result_preview');
    const hidden = document.getElementById('test_result');

    function evaluate() {
        const germVal = germInput.value.trim();
        if (germVal === '') {
            preview.value = 'Menunggu input...';
            preview.style.color = '';
            return;
        }
        const germ = parseFloat(germVal);
        const moistVal = moistInput.value.trim();
        const moistOk = moistVal === '' || parseFloat(moistVal) <= 12;
        const passed = germ >= 80 && moistOk;

        hidden.value = passed ? 'PASSED' : 'FAILED';
        preview.value = passed ? 'Lulus (PASSED)' : 'Tidak Lulus (FAILED)';
        preview.style.color = passed ? '#15803d' : '#b91c1c';
    }

    germInput.addEventListener('input', evaluate);
    moistInput.addEventListener('input', evaluate);
    evaluate();
});
</script>
@endsection
