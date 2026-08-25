@extends('admin.layout')
@section('title', 'Edit Kategori Benih')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Kategori Benih</h1>
        <p class="page-subtitle">Perbarui data kategori <strong>{{ $seedCategory->name }}</strong></p>
    </div>
    <a href="{{ route('admin.seed-categories.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>

<div class="form-card" style="max-width:560px">
    <form method="POST" action="{{ route('admin.seed-categories.update', $seedCategory) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label class="form-label required" for="name">Nama Kategori</label>
            <input type="text" id="name" name="name" value="{{ old('name', $seedCategory->name) }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Contoh: Kedelai" maxlength="100">
            @error('name') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="abbr">Singkatan</label>
            <input type="text" id="abbr" name="abbr" value="{{ old('abbr', $seedCategory->abbr) }}"
                class="form-control @error('abbr') is-invalid @enderror"
                placeholder="Contoh: KDL" maxlength="10" style="max-width:120px">
            @error('abbr') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Keterangan</label>
            <textarea id="description" name="description" rows="3"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Keterangan singkat (opsional)">{{ old('description', $seedCategory->description) }}</textarea>
            @error('description') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        {{-- Info varietas yang menggunakan kategori ini --}}
        @if($seedCategory->seeds_count ?? $seedCategory->seeds()->count())
        <div class="alert alert-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Kategori ini digunakan oleh <strong>{{ $seedCategory->seeds()->count() }} varietas benih</strong>.
            Perubahan nama akan berdampak pada semua varietas tersebut.
        </div>
        @endif

        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm);margin-top:var(--space-lg)">
            <a href="{{ route('admin.seed-categories.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Perbarui
            </button>
        </div>
    </form>
</div>
@endsection
