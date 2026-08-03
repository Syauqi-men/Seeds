<form wire:submit="save">
    <div class="form-group">
        <label class="form-label required" for="var_name">Nama Varietas</label>
        <input type="text" id="var_name" wire:model="var_name" class="form-control @error('var_name') is-invalid @enderror" placeholder="Contoh: Anjasmoro">
        @error('var_name') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md)">
        <div class="form-group">
            <label class="form-label required" for="category">Kategori</label>
            <select id="category" wire:model="category" class="form-control @error('category') is-invalid @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->value }}">{{ $cat->label() }}</option>
                @endforeach
            </select>
            @error('category') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label required" for="var_class">Kelas Benih</label>
            <select id="var_class" wire:model="var_class" class="form-control @error('var_class') is-invalid @enderror">
                <option value="">-- Pilih Kelas --</option>
                @foreach($varClasses as $vc)
                <option value="{{ $vc->value }}">{{ $vc->label() }}</option>
                @endforeach
            </select>
            @error('var_class') <span class="form-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="form-label" for="description">Deskripsi</label>
        <textarea id="description" wire:model="description" class="form-control" rows="3" placeholder="Deskripsi singkat varietas (opsional)"></textarea>
        @error('description') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm);margin-top:var(--space-md)">
        <a href="{{ route('admin.seeds.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan
            </span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </div>
</form>
