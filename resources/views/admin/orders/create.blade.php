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

    {{-- Card Ketersediaan Stok Benih (Real-time Clean Stock) --}}
    <div class="form-card" x-data="{ expanded: true }" style="margin-bottom:var(--space-md);padding:18px 20px;">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:var(--nv-radius-sm);background:var(--nv-success-soft);border:1px solid #C9F0DD;display:grid;place-items:center;color:var(--nv-success);flex-shrink:0;">
                    <i data-lucide="package-check" style="width:18px;height:18px;"></i>
                </div>
                <div>
                    <h3 style="font-size:0.98rem;font-weight:700;color:var(--color-text);margin:0;line-height:1.2;">
                        Stok Benih 
                    </h3>
                    <p style="font-size:0.78rem;color:var(--color-text-muted);margin:2px 0 0 0;">
                        Ketersedian stok benih dari gudang
                    </p>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <button type="button" @click="expanded = !expanded" class="btn btn-ghost btn-sm" style="font-size:0.75rem;padding:2px 8px;height:26px;">
                    <span x-show="expanded">Sembunyikan</span>
                    <span x-show="!expanded" x-cloak>Tampilkan</span>
                    <i data-lucide="chevron-down" style="width:13px;height:13px;margin-left:2px;transition:transform 0.2s;" :style="expanded ? 'transform:rotate(180deg)' : ''"></i>
                </button>
            </div>
        </div>

        <div x-show="expanded" x-transition.opacity.duration.200ms style="margin-top:var(--space-md);">
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($stockSummary as $catData)
                <div style="border:1px solid var(--nv-border);border-radius:var(--nv-radius-sm);overflow:hidden;background:var(--nv-surface);">
                    {{-- Header Kategori --}}
                    <div style="background:var(--nv-surface-muted);padding:8px 12px;border-bottom:1px solid var(--nv-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;">
                        <span style="font-weight:700;font-size:0.86rem;color:var(--nv-text);display:flex;align-items:center;gap:6px;">
                            <i data-lucide="sprout" style="width:14px;height:14px;color:var(--nv-accent);"></i>
                            {{ $catData['category_name'] }}
                        </span>
                        <span style="font-size:0.75rem;color:var(--nv-text-muted);">
                            Total Stok : <strong style="color:var(--nv-text);font-variant-numeric:tabular-nums;">{{ number_format($catData['total_clean_stock'], 1) }} kg</strong>
                        </span>
                    </div>

                    {{-- Grid Kolom Kelas: BS | FS | SS (serta NS bila ada) --}}
                    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:1px;background:var(--nv-border);">
                        @foreach($catData['classes'] as $clsName => $items)
                        <div style="background:var(--nv-surface);padding:8px 10px;min-width:0;">
                            <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:6px;margin-bottom:6px;border-bottom:1px dashed var(--nv-border);">
                                <span class="badge {{ $clsName === 'BS' ? 'badge-processing' : ($clsName === 'FS' ? 'badge-ready' : ($clsName === 'SS' ? 'badge-quarantine' : 'badge-raw')) }}" style="font-size:0.68rem;padding:2px 7px;">
                                    Kelas {{ $clsName }}
                                </span>
                                <span style="font-size:0.7rem;color:var(--nv-text-subtle);">
                                    {{ $items->count() }} varietas
                                </span>
                            </div>

                            <div style="display:flex;flex-direction:column;gap:4px;">
                                @forelse($items as $item)
                                <div class="stock-item-row"
                                     title="Klik untuk memasukkan varietas {{ $item['name'] }} ({{ $item['class'] }}) ke pesanan"
                                     onclick="quickSelectSeed({{ $catData['category_id'] }}, {{ $item['id'] }}, '{{ $item['class'] }}')"
                                     style="display:flex;justify-content:space-between;align-items:center;padding:4px 6px;border-radius:var(--nv-radius-sm);background:{{ $item['stock'] > 0 ? 'var(--nv-surface-muted)' : 'transparent' }};font-size:0.8rem;cursor:pointer;transition:background 0.15s;">
                                    <span style="font-weight:500;color:var(--nv-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;padding-right:6px;" title="{{ $item['name'] }}">
                                        {{ $item['name'] }}
                                    </span>
                                    <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                                        @if($item['stock'] > 0)
                                            <span style="font-weight:700;color:var(--nv-success);font-variant-numeric:tabular-nums;font-size:0.82rem;">
                                                {{ number_format($item['stock'], 1) }} <span style="font-size:0.68rem;font-weight:400;color:var(--nv-text-muted);">kg</span>
                                            </span>
                                        @else
                                            <span style="color:var(--nv-text-subtle);font-size:0.72rem;font-style:italic;">
                                                0 kg
                                            </span>
                                        @endif
                                        {{-- <span class="btn btn-ghost btn-sm" style="height:20px;width:20px;padding:0;display:inline-grid;place-items:center;border-radius:3px;color:var(--nv-accent);" title="Pilih ke form">
                                            <i data-lucide="plus" style="width:12px;height:12px;"></i>
                                        </span> --}}
                                    </div>
                                </div>
                                @empty
                                <div style="text-align:center;font-size:0.72rem;color:var(--nv-text-subtle);padding:6px 0;font-style:italic;">
                                    Belum ada varietas
                                </div>
                                @endforelse
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Info Pemesan  --}}
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

    {{-- Item Pesanan (Multi-row) --}}
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

    // Filter kategori ke varietas (delegasi event)
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

    // Helper untuk memilih varietas langsung dari tabel ketersediaan stok
    window.quickSelectSeed = function (categoryId, seedId, seedClass) {
        // Cari baris item yang masih kosong (belum pilih varietas dan belum ada kuantiti)
        const rows = document.querySelectorAll('.order-item-row');
        let targetRow = null;
        for (let i = 0; i < rows.length; i++) {
            const seedSelect = rows[i].querySelector('.seed-select');
            const qtyInput = rows[i].querySelector('input[type="number"]');
            if (!seedSelect.value && (!qtyInput.value || parseFloat(qtyInput.value) <= 0)) {
                targetRow = rows[i];
                break;
            }
        }

        // Jika tidak ada baris yang kosong, klik tombol tambah item
        if (!targetRow) {
            document.getElementById('btn-add-item').click();
            const updatedRows = document.querySelectorAll('.order-item-row');
            targetRow = updatedRows[updatedRows.length - 1];
        }

        if (targetRow) {
            const catFilter = targetRow.querySelector('.seed-category-filter');
            const seedSelect = targetRow.querySelector('.seed-select');
            const classSelect = targetRow.querySelector('select[name$="[seed_class]"]');
            const qtyInput = targetRow.querySelector('input[type="number"]');

            if (catFilter) catFilter.value = categoryId;
            if (seedSelect) {
                seedSelect.innerHTML = buildSeedOptions(categoryId);
                seedSelect.value = seedId;
            }
            if (classSelect) classSelect.value = seedClass;
            if (qtyInput) {
                qtyInput.focus();
                qtyInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    };
})();
</script>

<style>
    .stock-item-row:hover {
        background: var(--nv-surface-hover) !important;
        box-shadow: 0 0 0 1px var(--nv-border);
    }
</style>
@endsection
