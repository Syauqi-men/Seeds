@extends('admin.layout')
@section('title', 'Edit Pengguna')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit Pengguna</h1></div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>
<div class="form-card">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required" for="u_name">Nama Lengkap</label>
                <input type="text" id="u_name" name="name" value="{{ old('name', $user->name) }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label required" for="u_role">Peran (Role)</label>
                <select id="u_role" name="role" class="form-control @error('role') is-invalid @enderror">
                    <option value="">-- Pilih Peran --</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role', $userRole) === $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
                @error('role') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="form-label required" for="u_email">Email</label>
            <input type="email" id="u_email" name="email" value="{{ old('email', $user->email) }}"
                class="form-control @error('email') is-invalid @enderror">
            @error('email') <span class="form-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="u_password">Password Baru</label>
            <div style="position:relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" id="u_password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Kosongkan jika tidak ingin mengubah password"
                    style="padding-right:2.5rem">
                <button type="button" @click="show=!show" tabindex="-1"
                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;padding:0;line-height:1;display:flex;align-items:center">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        style="display:none">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                        <path d="M10.73 14.73a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            @error('password') <span class="form-error">{{ $message }}</span> @enderror
        </div>
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
</div>
@endsection
