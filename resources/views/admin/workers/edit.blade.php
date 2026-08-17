@extends('admin.layout')
@section('title', 'Edit Pekerja')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit Pekerja</h1></div>
    <a href="{{ route('admin.workers.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>
<div class="form-card">
    <form method="POST" action="{{ route('admin.workers.update', $worker) }}">
        @csrf @method('PUT')
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required" for="w_name">Nama Pekerja</label>
                <input type="text" id="w_name" name="name" value="{{ old('name', $worker->name) }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="w_code">Kode / Inisial</label>
                <input type="text" id="w_code" name="code" value="{{ old('code', $worker->code) }}"
                    class="form-control" maxlength="20">
            </div>
            <div class="form-group">
                <label class="form-label required" for="w_role">Peran</label>
                <select id="w_role" name="role" class="form-control @error('role') is-invalid @enderror">
                    @foreach($roles as $role)
                    <option value="{{ $role->value }}" {{ old('role', $worker->role->value) === $role->value ? 'selected' : '' }}>
                        {{ $role->label() }}
                    </option>
                    @endforeach
                </select>
                @error('role') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $worker->notes) }}</textarea>
        </div>
        <div class="form-group" style="display:flex;align-items:center;gap:var(--space-sm)">
            <input type="checkbox" id="w_active" name="is_active" value="1"
                {{ old('is_active', $worker->is_active) ? 'checked' : '' }} style="width:16px;height:16px">
            <label for="w_active" class="form-label" style="margin:0;cursor:pointer">Pekerja aktif</label>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <a href="{{ route('admin.workers.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
</div>
@endsection
