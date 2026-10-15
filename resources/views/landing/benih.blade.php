@extends('landing.layout')
@section('title', 'Data Benih')

@section('content')
<div class="board">
    {{-- Board Header --}}
    <div class="board-header">
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;margin-right:8px"><circle cx="12" cy="12" r="10"/><path d="M12 8c0 0-2 2-2 4s2 4 2 4"/><path d="M12 8c0 0 2 2 2 4s-2 4-2 4"/><path d="M8 12h8"/></svg>
            Data Varietas Benih
        </h1>
        <p>Informasi varietas benih Kedelai, Kacang Tanah, dan Kacang Hijau yang tersedia di BRMP Aneka Kacang</p>
    </div>

    {{-- Livewire Component untuk Filter + List --}}
    @livewire('benih-list')
</div>
@endsection
