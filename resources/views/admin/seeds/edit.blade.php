@extends('admin.layout')
@section('title', 'Edit Varietas Benih')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Varietas: {{ $seed->var_name }}</h1>
    </div>
    <a href="{{ route('admin.seeds.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>
<div class="form-card">
    @livewire('admin.seed-form', ['seed' => $seed])
</div>
@endsection
