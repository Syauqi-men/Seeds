@extends('admin.layout')
@section('title', 'Tambah Mutasi Benih')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Tambah Mutasi Benih</h1></div>
    <a href="{{ route('admin.seed-mutations.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-error" style="margin-bottom:var(--space-md)">
    <ul style="margin:0;padding-left:1.5rem">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-card" style="max-width:540px">

    {{-- Info box --}}
    {{-- <div style="background:var(--color-bg-subtle,#f8f9fa);border:1px solid var(--color-border);border-left:4px solid var(--color-warning,#e6a817);border-radius:6px;padding:12px 16px;margin-bottom:var(--space-lg);font-size:0.9rem;">
        <strong>Informasi:</strong> Setiap mutasi akan <strong>mengurangi 2 kg stok bersih</strong> dari lot benih yang dipilih secara otomatis. Hanya lot dengan stok bersih ≥ 2 kg yang dapat dipilih.
    </div> --}}

    <form method="POST" action="{{ route('admin.seed-mutations.store') }}">
        @csrf

        <div class="form-group">
            <label class="form-label required">Lot Benih</label>
            @if($lots->isEmpty())
                <div style="padding:12px;background:#fff3cd;border:1px solid #ffc107;border-radius:6px;font-size:0.9rem;color:#856404;">
                    <strong>Tidak ada lot yang tersedia.</strong> Pastikan ada lot benih dengan stok bersih ≥ 2 kg sebelum melakukan mutasi.
                </div>
            @else
                <select name="seed_lot_id" class="form-control @error('seed_lot_id') is-invalid @enderror">
                    <op value="">-- Pilih Lot Benih --</op  tion>
                    @foreach($lots as $lot)
                    <option value="{{ $lot->id }}" {{ old('seed_lot_id') == $lot->id ? 'selected' : '' }}>
                        {{ $lot->lot_number }} — {{ $lot->seed->var_name }}
                        (stok bersih: {{ number_format($lot->clean_stock, 2) }} kg)
                    </option>
                    @endforeach
                </select>
                @error('seed_lot_id') <span class="form-error">{{ $message }}</span> @enderror
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal Mutasi</label>
            <input type="date" name="mutated_at" class="form-control"
                   value="{{ old('mutated_at', now()->format('Y-m-d')) }}">
        </div>

        <div class="form-group">
            <label class="form-label">Catatan <span style="font-weight:400;color:var(--color-text-muted)">(opsional)</span></label>
            <input type="text" name="notes" class="form-control"
                   placeholder="Catatan tambahan (opsional)"
                   value="{{ old('notes') }}">
        </div>

        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm);margin-top:var(--space-lg)">
            <a href="{{ route('admin.seed-mutations.index') }}" class="btn btn-ghost">Batal</a>
            @if(!$lots->isEmpty())
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                OK
            </button>
            @endif
        </div>
    </form>
</div>
@endsection
