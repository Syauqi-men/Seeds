@extends('landing.layout')
@section('title', 'Lot Benih')

@section('content')
<div class="board">
    <div class="board-header">
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;margin-right:8px"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Data Lot Benih
        </h1>
        <p>Informasi lot benih beserta status dan stok masing-masing lot yang tercatat di BRMP Aneka Kacang</p>
    </div>
    @livewire('lot-benih-list')
</div>
@endsection
