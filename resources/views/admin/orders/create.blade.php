@extends('admin.layout')
@section('title', 'Buat Pesanan Baru')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Buat Pesanan Baru</h1></div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>




<form method="POST" action="{{ route('admin.orders.store') }}" id="orderForm">
    @csrf

    {{-- ── Info Pemesan ──────────────────────────────────────────── --}}
    <div class="form-card" style="margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:var(--space-md);color:var(--color-text)">
            Informasi Pemesan
        </h3>
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required" for="cust_name">Nama Pemesan</label>
                <input type="text" id="cust_name" name="cust_name" value="{{ old('cust_name') }}"
                    class="form-control @error('cust_name') is-invalid @enderror"
                    placeholder="Nama petani/mitra/instansi">
                @error('cust_name') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label required" for="order_type">Tipe Pesanan</label>
                <select id="order_type" name="order_type" class="form-control @error('order_type') is-invalid @enderror">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="commercial" {{ old('order_type') === 'commercial' ? 'selected' : '' }}>Komersial</option>
                    <option value="seed_aid" {{ old('order_type') === 'seed_aid' ? 'selected' : '' }}>Bantuan Benih</option>
                    <option value="internal_transfer" {{ old('order_type') === 'internal_transfer' ? 'selected' : '' }}>Transfer Internal</option>
                    <option value="lab_sample" {{ old('order_type') === 'lab_sample' ? 'selected' : '' }}>Sampel Lab</option>
                </select>
                @error('order_type') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label required" for="payment_status">Status Pembayaran</label>
                <select id="payment_status" name="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
                    <option value="unpaid" {{ old('payment_status', 'unpaid') === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="paid" {{ old('payment_status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="exempt" {{ old('payment_status') === 'exempt' ? 'selected' : '' }}>Bebas Biaya</option>
                </select>
                @error('payment_status') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label" for="reference_num">No. Referensi / Surat</label>
                <input type="text" id="reference_num" name="reference_num" value="{{ old('reference_num') }}"
                    class="form-control" placeholder="SPP-001/IX/2026">
            </div>
            <div class="form-group">
                <label class="form-label" for="notes">Catatan</label>
                <input type="text" id="notes" name="notes" value="{{ old('notes') }}"
                    class="form-control" placeholder="Keterangan tambahan (opsional)">
            </div>
        </div>
    </div>

    {{-- ── Item Pesanan (Multi-row) ─────────────────────────────── --}}
    <div style="margin-bottom:var(--space-sm)">
        <h3 style="font-size:1rem;font-weight:700;color:var(--color-text)">
            Item Pesanan
        </h3>
        <p style="font-size:0.85rem;color:var(--color-text-muted);margin-bottom:var(--space-md)">
            Tambahkan varietas dan kelas benih yang dipesan. Klik "+ Tambah Item" untuk menambah baris.
        </p>
    </div>

    <div id="order-items">
        {{-- Baris pertama --}}
        <div class="form-card order-item-row" style="margin-bottom:var(--space-md)">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
                <span class="row-label" style="font-weight:600;font-size:0.9rem;color:var(--color-text-muted)">Item #1</span>
                <button type="button" class="btn btn-danger btn-sm btn-remove-item" style="display:none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Hapus
                </button>
            </div>
            <div style="display:grid;grid-template-columns:1fr 2fr 1fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label">Kategori Benih</label>
                    <select class="form-control seed-category-filter" data-row="0">
                        <option value="">-- Semua --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Varietas Benih</label>
                    <select name="items[0][seed_id]" class="form-control seed-select">
                        <option value="">-- Pilih Varietas --</option>
                        @foreach($seeds as $seed)
                        <option value="{{ $seed->id }}" data-category="{{ $seed->category_id }}">{{ $seed->var_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Kelas Benih</label>
                    <select name="items[0][seed_class]" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="NS">Nucleus Seed (NS)</option>
                        <option value="BS">Breeder Seed (BS)</option>
                        <option value="FS">Foundation Seed (FS)</option>
                        <option value="SS">Stock Seed (SS)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Jumlah (kg)</label>
                    <input type="number" name="items[0][quantity]" step="0.01" min="0.01"
                        class="form-control" placeholder="0.00">
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah Item --}}
    <div style="margin-bottom:var(--space-md)">
        <button type="button" id="btn-add-item" class="btn btn-ghost"
            style="width:100%;border:2px dashed var(--color-border);display:flex;align-items:center;justify-content:center;gap:var(--space-sm)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Item Pesanan
        </button>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
    </div>
</form>

<script>
(function () {
    // Data untuk dropdown dinamis
    const categoryOptions = `{!! $categories->map(fn($c) => '<option value="'.$c->id.'">'.$c->name.'</option>')->implode('') !!}`;
    const seedData = [
        @foreach($seeds as $seed)
        { id: {{ $seed->id }}, name: '{!! addslashes($seed->var_name) !!}', categoryId: {{ $seed->category_id ?? 'null' }} },
        @endforeach
    ];
    const classOptions = `
        <option value="">-- Pilih Kelas --</option>
        <option value="NS">Nucleus Seed (NS)</option>
        <option value="BS">Breeder Seed (BS)</option>
        <option value="FS">Foundation Seed (FS)</option>
        <option value="SS">Stock Seed (SS)</option>
    `;

    function buildSeedOptions(categoryId) {
        let opts = '<option value="">-- Pilih Varietas --</option>';
        seedData.forEach(s => {
            if (!categoryId || s.categoryId == categoryId) {
                opts += `<option value="${s.id}" data-category="${s.categoryId}">${s.name}</option>`;
            }
        });
        return opts;
    }

    // Filter kategori → varietas (delegasi event)
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('seed-category-filter')) {
            const row = e.target.closest('.order-item-row');
            const seedSelect = row.querySelector('.seed-select');
            seedSelect.innerHTML = buildSeedOptions(e.target.value);
        }
    });

    let itemCount = 1;

    document.getElementById('btn-add-item').addEventListener('click', function () {
        const idx = itemCount++;
        const row = document.createElement('div');
        row.className = 'form-card order-item-row';
        row.style.cssText = 'margin-bottom:var(--space-md)';
        row.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
                <span class="row-label" style="font-weight:600;font-size:0.9rem;color:var(--color-text-muted)">Item #${idx + 1}</span>
                <button type="button" class="btn btn-danger btn-sm btn-remove-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Hapus
                </button>
            </div>
            <div style="display:grid;grid-template-columns:1fr 2fr 1fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label">Kategori Benih</label>
                    <select class="form-control seed-category-filter" data-row="${idx}">
                        <option value="">-- Semua --</option>${categoryOptions}
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Varietas Benih</label>
                    <select name="items[${idx}][seed_id]" class="form-control seed-select">
                        ${buildSeedOptions('')}
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Kelas Benih</label>
                    <select name="items[${idx}][seed_class]" class="form-control">${classOptions}</select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Jumlah (kg)</label>
                    <input type="number" name="items[${idx}][quantity]" step="0.01" min="0.01"
                        class="form-control" placeholder="0.00">
                </div>
            </div>
        `;
        row.querySelector('.btn-remove-item').addEventListener('click', function () {
            row.remove();
            updateItemLabels();
        });
        document.getElementById('order-items').appendChild(row);
        updateItemLabels();
    });

    function updateItemLabels() {
        const rows = document.querySelectorAll('.order-item-row');
        rows.forEach((r, i) => {
            const label = r.querySelector('.row-label');
            if (label) label.textContent = `Item #${i + 1}`;
            const removeBtn = r.querySelector('.btn-remove-item');
            if (removeBtn) removeBtn.style.display = rows.length > 1 ? '' : 'none';
        });
    }
})();
</script>
@endsection
