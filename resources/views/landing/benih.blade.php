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

{{-- Aktivitas Terbaru --}}
{{-- @if($recentActivities->isNotEmpty())
<div class="board mt-lg">
    <div class="board-body">
        <h2 style="font-size:1rem;margin-bottom:var(--space-md);color:var(--color-primary-800)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;margin-right:6px"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Aktivitas Terbaru
        </h2>
        <div class="activity-feed">
            @foreach($recentActivities as $activity)
            <div class="activity-item">
                <div class="activity-dot"></div>
                <div>
                    <div class="activity-text">{{ $activity->description }}</div>
                    <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif --}}
@endsection
