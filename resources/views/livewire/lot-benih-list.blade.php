<div>
    {{-- Filter Bar --}}
    <div class="filter-bar">
        <input
            wire:model.live.debounce.400ms="search"
            type="text"
            class="filter-input"
            placeholder="Cari nomor lot atau nama varietas..."
            id="search-lot"
        >
        <select wire:model.live="filterCategory" class="filter-select" id="lot-filter-category">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterStatus" class="filter-select" id="lot-filter-status">
            <option value="">Semua Status</option>
            @foreach($statuses as $status)
            <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>

    <div class="board-body">
        @forelse($lots as $lot)
        <div class="card" style="margin-bottom:var(--space-sm)">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:var(--space-md)">
                <div>
                    <div class="card-title">{{ $lot->lot_number }}</div>
                    <div class="card-subtitle">{{ $lot->seed->var_name }} &bull; {{ $lot->seed->category?->name ?? '—' }} &bull; {{ $lot->seed->var_class->value }}</div>
                </div>
                <span class="badge badge-{{ strtolower($lot->status->value) }}">{{ $lot->status->label() }}</span>
            </div>

            <div class="card-stats" style="margin-top:var(--space-sm)">
                <div class="stat-item">
                    <div class="stat-label">Stok Mentah</div>
                    <div class="stat-value">{{ number_format($lot->raw_stock, 1) }} <span style="font-size:0.65rem;color:var(--color-text-muted)">kg</span></div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Stok Bersih</div>
                    <div class="stat-value">{{ number_format($lot->clean_stock, 1) }} <span style="font-size:0.65rem;color:var(--color-text-muted)">kg</span></div>
                </div>
                @if($lot->harvest_date)
                <div class="stat-item">
                    <div class="stat-label">Panen</div>
                    <div style="font-size:0.85rem;font-weight:600">{{ $lot->harvest_date->translatedFormat('d M Y') }}</div>
                </div>
                @endif
            </div>

            <div class="card-footer">
                <span class="card-timestamp">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Terakhir diupdate {{ $lot->updated_at->diffForHumans() }}
                </span>
            </div>
        </div>
        @empty
        <div class="text-center" style="padding:var(--space-2xl)">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--color-text-light);margin-bottom:var(--space-md)"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <p class="text-muted">Tidak ada lot benih yang sesuai filter.</p>
        </div>
        @endforelse

        <div class="mt-lg">
            {{ $lots->links() }}
        </div>
    </div>
</div>
