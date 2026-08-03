<div>
    {{-- Filter Bar --}}
    <div class="filter-bar">
        <input
            wire:model.live.debounce.400ms="search"
            type="text"
            class="filter-input"
            placeholder="Cari nama varietas..."
            id="search-benih"
        >
        <select wire:model.live="filterCategory" class="filter-select" id="filter-category">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->value }}">{{ $cat->label() }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterVarClass" class="filter-select" id="filter-varclass">
            <option value="">Semua Kelas</option>
            @foreach($varClasses as $vc)
            <option value="{{ $vc->value }}">{{ $vc->value }}</option>
            @endforeach
        </select>
    </div>

    <div class="board-body">
        @forelse($seeds as $seed)
        {{-- Seed Group --}}
        <div class="seed-group">
            <div class="seed-group-header">
                <div>
                    <span class="seed-group-title">{{ $seed->var_name }}</span>
                    <span class="badge badge-category-{{ str_replace(' ', '-', strtolower($seed->category->value)) }}" style="margin-left:8px">
                        {{ $seed->category->label() }}
                    </span>
                    <span class="badge badge-raw" style="margin-left:4px">{{ $seed->var_class->value }}</span>
                </div>
                <span class="seed-group-meta">{{ $seed->seedLots->count() }} lot</span>
            </div>

            @if($seed->seedLots->isEmpty())
                <p class="text-muted text-small" style="padding:var(--space-md)">Belum ada lot benih untuk varietas ini.</p>
            @else
            <div class="cards-grid">
                @foreach($seed->seedLots->take(10) as $lot)
                <div class="card">
                    <div class="card-title">{{ $lot->lot_number }}</div>
                    <div class="card-subtitle">
                        @if($lot->harvest_date)
                            Panen: {{ $lot->harvest_date->translatedFormat('d M Y') }}
                        @else
                            Tanggal panen belum dicatat
                        @endif
                    </div>

                    <div class="card-stats">
                        <div class="stat-item">
                            <div class="stat-label">Stok Mentah</div>
                            <div class="stat-value">{{ number_format($lot->raw_stock, 1) }}<span style="font-size:0.65rem;color:var(--color-text-muted)"> kg</span></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Stok Bersih</div>
                            <div class="stat-value">{{ number_format($lot->clean_stock, 1) }}<span style="font-size:0.65rem;color:var(--color-text-muted)"> kg</span></div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <span class="badge badge-{{ strtolower($lot->status->value) }}">{{ $lot->status->label() }}</span>
                        <span class="card-timestamp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $lot->updated_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>

            @if($seed->seedLots->count() > 10)
            <div class="text-center mt-md">
                <span class="text-small text-muted">+{{ $seed->seedLots->count() - 10 }} lot lainnya</span>
            </div>
            @endif
            @endif
        </div>
        @empty
        <div class="text-center" style="padding:var(--space-2xl)">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--color-text-light);margin-bottom:var(--space-md)"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <p class="text-muted">Tidak ada varietas benih yang sesuai filter.</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-lg">
            {{ $seeds->links() }}
        </div>
    </div>
</div>
