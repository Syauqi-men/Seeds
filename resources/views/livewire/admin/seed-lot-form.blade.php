<form wire:submit="save">
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-md)">
        <div class="form-group">
            <label class="form-label required" for="seed_id">Varietas Benih</label>
            <select id="seed_id" wire:model.live="seed_id" class="form-control @error('seed_id') is-invalid @enderror">
                <option value="">-- Pilih Varietas --</option>
                @foreach($seeds as $seed)
                <option value="{{ $seed->id }}">{{ $seed->var_name }} ({{ $seed->category->value }} - {{ $seed->var_class->value }})</option>
                @endforeach
            </select>
            @error('seed_id') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label required" for="status">Status</label>
            <select id="status" wire:model="status" class="form-control">
                @foreach($statuses as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Lokasi & Kode Prefix --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md)">
        <div class="form-group">
            <label class="form-label" for="location">Lokasi</label>
            <select id="location" wire:model.live="location" class="form-control">
                <option value="">-- Pilih Lokasi --</option>
                @foreach($locationOptions as $alias => $label)
                <option value="{{ $alias }}">{{ $label }}</option>
                @endforeach
            </select>
            <span class="form-hint">Alias lokasi untuk format nomor lot</span>
        </div>
        <div class="form-group">
            <label class="form-label" for="lot_code_prefix">Kode Prefix Lot</label>
            <input type="text" id="lot_code_prefix" wire:model.live="lot_code_prefix"
                class="form-control" placeholder="KD-DP-NS" maxlength="20">
            <span class="form-hint">Kode program/instansi, dapat diubah sesuai kebutuhan</span>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label required" for="lot_number">Nomor Lot</label>
        <div style="display:flex;gap:var(--space-sm);align-items:center">
            <input type="text" id="lot_number" wire:model="lot_number"
                class="form-control @error('lot_number') is-invalid @enderror"
                placeholder="Contoh: 001-KD-DP-NS-KP-26">
            <label style="display:flex;align-items:center;gap:4px;font-size:0.8rem;color:var(--color-text-muted);white-space:nowrap">
                <input type="checkbox" wire:model.live="autoLotNumber"> Auto
            </label>
        </div>
        @error('lot_number') <span class="form-error">{{ $message }}</span> @enderror
        <span class="form-hint">Format: NNN-[KODE PREFIX]-[ALIAS LOKASI]-[TH]. Centang "Auto" untuk generate otomatis.</span>
    </div>

    <div class="form-group">
        <label class="form-label" for="harvest_date">Tanggal Panen</label>
        <input type="date" id="harvest_date" wire:model="harvest_date" class="form-control">
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-md)">
        <div class="form-group">
            <label class="form-label">Berat Asal (kg)</label>
            <input type="number" step="0.01" wire:model="origin_weight" class="form-control" placeholder="0.00">
        </div>
        <div class="form-group">
            <label class="form-label">Kadar Air Asal (%)</label>
            <input type="number" step="0.01" min="0" max="100" wire:model="origin_moisture" class="form-control" placeholder="0.00">
        </div>
        <div class="form-group">
            <label class="form-label">Berat Tiba (kg)</label>
            <input type="number" step="0.01" wire:model="arrival_weight" class="form-control" placeholder="0.00">
        </div>
        <div class="form-group">
            <label class="form-label">Kadar Air Tiba (%)</label>
            <input type="number" step="0.01" min="0" max="100" wire:model="arrival_moisture" class="form-control" placeholder="0.00">
        </div>
    </div>

    {{-- Read-only stock info --}}
    @if($seedLot && $seedLot->exists)
    <div class="form-group">
        <label class="form-label">Stok (Dikelola Otomatis)</label>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md)">
            <div class="readonly-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Stok Mentah: <strong>{{ number_format($seedLot->raw_stock, 2) }} kg</strong>
            </div>
            <div class="readonly-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Stok Bersih: <strong>{{ number_format($seedLot->clean_stock, 2) }} kg</strong>
            </div>
        </div>
        <span class="form-hint">Stok dihitung otomatis dari transaksi dan proses produksi. Tidak dapat diubah manual.</span>
    </div>
    @endif

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm);margin-top:var(--space-md)">
        <a href="{{ route('admin.seed-lots.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan
            </span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </div>
</form>
