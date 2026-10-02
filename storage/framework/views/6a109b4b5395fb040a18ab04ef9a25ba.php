<?php $__env->startSection('title', 'Edit Pesanan'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Pesanan</h1>
        <p class="page-subtitle"><?php echo e($order->reference_num ?? 'Tanpa Referensi'); ?> — <?php echo e($order->cust_name); ?></p>
    </div>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>

<?php
    $user = auth()->user();
    $canEditDetails = $user->hasAnyRole(['Administrator', 'Order Processor']);
    $canEditStatus  = $user->hasAnyRole(['Administrator', 'Petugas Benih']);
    $canAllocate    = $user->hasAnyRole(['Administrator', 'Petugas Benih']);
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
<div style="background:#fed7d7;color:#9b2c2c;padding:12px 16px;border-radius:8px;margin-bottom:var(--space-md);font-size:0.9rem;border-left:4px solid #e53e3e">
    <strong>⚠ Gagal:</strong> <?php echo e(session('error')); ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
<div style="background:#c6f6d5;color:#276749;padding:12px 16px;border-radius:8px;margin-bottom:var(--space-md);font-size:0.9rem;border-left:4px solid #38a169">
    ✓ <?php echo e(session('success')); ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.orders.update', $order)); ?>">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

    
    <div class="form-card" style="margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:var(--space-md);color:var(--color-text)">
            Informasi Pemesan
        </h3>
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label <?php echo e($canEditDetails ? 'required' : ''); ?>" for="cust_name">Nama Pemesan</label>
                <input type="text" id="cust_name" name="cust_name"
                    value="<?php echo e(old('cust_name', $order->cust_name)); ?>"
                    class="form-control <?php $__errorArgs = ['cust_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    <?php echo e($canEditDetails ? '' : 'disabled'); ?>>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['cust_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="form-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label <?php echo e($canEditDetails ? 'required' : ''); ?>" for="order_type">Tipe Pesanan</label>
                <select id="order_type" name="order_type" class="form-control <?php $__errorArgs = ['order_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    <?php echo e($canEditDetails ? '' : 'disabled'); ?>>
                    <?php $ot = old('order_type', $order->order_type); ?>
                    <option value="commercial" <?php echo e($ot === 'commercial' ? 'selected' : ''); ?>>Komersial</option>
                    <option value="seed_aid" <?php echo e($ot === 'seed_aid' ? 'selected' : ''); ?>>Bantuan Benih</option>
                    <option value="internal_transfer" <?php echo e($ot === 'internal_transfer' ? 'selected' : ''); ?>>Transfer Internal</option>
                    <option value="lab_sample" <?php echo e($ot === 'lab_sample' ? 'selected' : ''); ?>>Sampel Lab</option>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['order_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="form-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label" for="reference_num">No. Referensi / Surat</label>
                <input type="text" id="reference_num" name="reference_num"
                    value="<?php echo e(old('reference_num', $order->reference_num)); ?>"
                    class="form-control" placeholder="SPP-001/IX/2026"
                    <?php echo e($canEditDetails ? '' : 'disabled'); ?>>
            </div>
            <div class="form-group">
                <label class="form-label" for="notes">Catatan</label>
                <input type="text" id="notes" name="notes"
                    value="<?php echo e(old('notes', $order->notes)); ?>"
                    class="form-control" placeholder="Keterangan tambahan (opsional)"
                    <?php echo e($canEditDetails ? '' : 'disabled'); ?>>
            </div>
        </div>
    </div>

    
    <div class="form-card" style="margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:var(--space-md);color:var(--color-text)">
            Status Pesanan
        </h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label <?php echo e($canEditStatus ? 'required' : ''); ?>" for="status">Status Pesanan</label>
                <select id="status" name="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    <?php echo e($canEditStatus ? '' : 'disabled'); ?>>
                    <?php $st = old('status', $order->status); ?>
                    <option value="pending"    <?php echo e($st === 'pending'    ? 'selected' : ''); ?>>Pending</option>
                    <option value="preparing"  <?php echo e($st === 'preparing'  ? 'selected' : ''); ?>>Diproses</option>
                    <option value="ready"      <?php echo e($st === 'ready'      ? 'selected' : ''); ?>>Siap</option>
                    <option value="completed"  <?php echo e($st === 'completed'  ? 'selected' : ''); ?>>Selesai</option>
                    <option value="cancelled"  <?php echo e($st === 'cancelled'  ? 'selected' : ''); ?>>Dibatalkan</option>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="form-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$canEditStatus): ?>
                    <small class="text-muted" style="display:block;margin-top:4px">Hanya Petugas Benih yang dapat mengubah status.</small>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label <?php echo e($canEditDetails ? 'required' : ''); ?>" for="payment_status">Status Pembayaran</label>
                <select id="payment_status" name="payment_status" class="form-control <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    <?php echo e($canEditDetails ? '' : 'disabled'); ?>>
                    <?php $ps = old('payment_status', $order->payment_status); ?>
                    <option value="unpaid" <?php echo e($ps === 'unpaid' ? 'selected' : ''); ?>>Belum Bayar</option>
                    <option value="paid"   <?php echo e($ps === 'paid'   ? 'selected' : ''); ?>>Lunas</option>
                    <option value="exempt" <?php echo e($ps === 'exempt' ? 'selected' : ''); ?>>Bebas Biaya</option>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="form-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="data-table-wrapper" style="margin-bottom:var(--space-md)">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:var(--space-md) var(--space-lg) 0">
            <h3 style="font-size:1rem;font-weight:700;color:var(--color-text)">Item Pesanan</h3>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAllocate): ?>
            <small class="text-muted">Klik "Alokasi Karung" untuk memilih stok lot benih per item</small>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Varietas</th>
                    <th>Kelas</th>
                    <th style="text-align:right">Dipesan (kg)</th>
                    <th style="text-align:right">Dialokasikan (kg)</th>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAllocate): ?><th style="text-align:center">Aksi</th><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $allocated = $item->allocations->sum('alloc_quantity');
                    $isFull    = $allocated >= $item->quantity;
                ?>
                <tr>
                    <td class="text-muted"><?php echo e($i + 1); ?></td>
                    <td><?php echo e($item->seed->var_name ?? '—'); ?></td>
                    <td><span class="badge badge-processing"><?php echo e($item->seed_class->value ?? $item->seed_class); ?></span></td>
                    <td style="text-align:right"><?php echo e(number_format($item->quantity, 2)); ?></td>
                    <td style="text-align:right">
                        <span class="<?php echo e($isFull ? 'badge badge-ready' : 'badge badge-quarantine'); ?>">
                            <?php echo e(number_format($allocated, 2)); ?> kg
                        </span>
                    </td>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAllocate): ?>
                    <td style="text-align:center">
                        <button type="button"
                            class="btn btn-ghost btn-sm"
                            onclick="bukaModalAlokasi(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->seed->var_name ?? '')); ?>', '<?php echo e($item->seed_class->value ?? $item->seed_class); ?>', <?php echo e($item->quantity); ?>)"
                            title="Alokasi Karung Benih">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Alokasi Karung
                        </button>
                    </td>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAllocate): ?>
<div id="modalAlokasi" class="modal-backdrop" style="display:none" onclick="if(event.target===this)tutupModal()">
    <div class="modal-box" style="max-width:680px;width:95%">

        
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:var(--space-md)">
            <div>
                <h3 class="modal-title" id="modalJudul">Alokasi Karung Benih</h3>
                <p id="modalSubjudul" class="text-muted" style="font-size:0.85rem;margin:2px 0 0"></p>
            </div>
            <button type="button" onclick="tutupModal()" class="btn btn-ghost btn-sm">✕</button>
        </div>

        
        <div id="modalPesan" style="display:none;margin-bottom:var(--space-sm);padding:10px 14px;border-radius:6px;font-size:0.875rem"></div>

        
        <div style="margin-bottom:var(--space-md)">
            <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px">Stok Lot Tersedia</label>
            <div id="daftarLot" style="max-height:220px;overflow-y:auto;border:1px solid var(--color-border);border-radius:8px">
                <table class="data-table" style="margin:0">
                    <thead>
                        <tr>
                            <th>No. Lot</th>
                            <th>Panen</th>
                            <th>Lokasi</th>
                            <th style="text-align:right">Stok (kg)</th>
                            <th style="text-align:center">Tambah</th>
                        </tr>
                    </thead>
                    <tbody id="barisDaftarLot">
                        <tr><td colspan="5" class="text-center text-muted" style="padding:20px">Memuat...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div style="margin-bottom:var(--space-md)">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                <label style="font-weight:600;font-size:0.875rem">Alokasi yang Dipilih</label>
                <span id="ringkasanAlokasi" style="font-size:0.8rem;color:var(--color-text-muted)"></span>
            </div>
            <div id="daftarAlokasi" style="border:1px solid var(--color-border);border-radius:8px;min-height:60px;padding:8px">
                <p id="kosongAlokasi" class="text-muted" style="font-size:0.85rem;text-align:center;padding:12px 0">Belum ada alokasi. Klik "Tambah" pada lot di atas.</p>
            </div>
        </div>

        
        <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
            <button type="button" onclick="tutupModal()" class="btn btn-ghost">Batal</button>
            <button type="button" onclick="simpanAlokasi()" class="btn btn-primary" id="btnSimpanAlokasi">
                Simpan Alokasi
            </button>
        </div>
    </div>
</div>

<script>
// ── State Modal ──────────────────────────────────────────────────────────────
let modalItemId    = null;
let modalItemQty   = 0;
let alokasi        = [];  // [{seed_lot_id, lot_number, alloc_quantity}]
const orderId      = <?php echo e($order->id); ?>;

// ── Buka Modal ───────────────────────────────────────────────────────────────
function bukaModalAlokasi(itemId, namaBenih, kelas, qty) {
    modalItemId  = itemId;
    modalItemQty = parseFloat(qty);
    alokasi      = [];

    document.getElementById('modalJudul').textContent   = 'Alokasi Karung: ' + namaBenih;
    document.getElementById('modalSubjudul').textContent = 'Kelas ' + kelas + ' — Dipesan: ' + qty.toFixed ? qty.toFixed(2) : qty + ' kg';
    sembunyikanPesan();
    document.getElementById('modalAlokasi').style.display = 'flex';
    document.getElementById('modalAlokasi').style.alignItems = 'center';
    document.getElementById('modalAlokasi').style.justifyContent = 'center';

    muatLot(itemId);
}

// ── Tutup Modal ──────────────────────────────────────────────────────────────
function tutupModal() {
    document.getElementById('modalAlokasi').style.display = 'none';
    modalItemId = null;
    alokasi     = [];
}

// ── Muat Daftar Lot via AJAX ─────────────────────────────────────────────────
function muatLot(itemId) {
    document.getElementById('barisDaftarLot').innerHTML =
        '<tr><td colspan="5" class="text-center text-muted" style="padding:20px">Memuat...</td></tr>';

    fetch(`/admin/orders/${orderId}/items/${itemId}/lots`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        // Isi alokasi existing jika ada
        if (data.existing_allocations && data.existing_allocations.length > 0) {
            alokasi = data.existing_allocations.map(a => ({
                seed_lot_id:    a.seed_lot_id,
                lot_number:     a.lot_number,
                alloc_quantity: a.alloc_quantity,
            }));
        }
        renderDaftarLot(data.lots);
        renderAlokasi();
    })
    .catch(() => {
        document.getElementById('barisDaftarLot').innerHTML =
            '<tr><td colspan="5" class="text-center text-muted" style="padding:20px">Gagal memuat data lot.</td></tr>';
    });
}

// ── Render Tabel Lot ─────────────────────────────────────────────────────────
function renderDaftarLot(lots) {
    const tbody = document.getElementById('barisDaftarLot');
    if (!lots || lots.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted" style="padding:20px">Tidak ada stok lot yang tersedia untuk varietas ini.</td></tr>';
        return;
    }
    tbody.innerHTML = lots.map(lot => `
        <tr>
            <td style="font-weight:600">${lot.lot_number}</td>
            <td>${lot.harvest_date ?? '-'}</td>
            <td>${lot.location ?? '-'}</td>
            <td style="text-align:right">${parseFloat(lot.clean_stock).toFixed(2)}</td>
            <td style="text-align:center">
                <button type="button" class="btn btn-ghost btn-sm"
                    onclick="tambahAlokasi(${lot.id}, '${lot.lot_number}', ${lot.clean_stock})">
                    + Tambah
                </button>
            </td>
        </tr>
    `).join('');
}

// ── Tambah Baris Alokasi ─────────────────────────────────────────────────────
function tambahAlokasi(lotId, lotNumber, maxStok) {
    // Cek apakah lot ini sudah ada di daftar alokasi
    const existing = alokasi.find(a => a.seed_lot_id === lotId);
    if (existing) {
        tampilkanPesan('Lot ' + lotNumber + ' sudah ada dalam daftar alokasi.', 'warning');
        return;
    }
    alokasi.push({ seed_lot_id: lotId, lot_number: lotNumber, alloc_quantity: 0, max: maxStok });
    renderAlokasi();
}

// ── Hapus Baris Alokasi ──────────────────────────────────────────────────────
function hapusAlokasi(index) {
    alokasi.splice(index, 1);
    renderAlokasi();
}

// ── Render Daftar Alokasi Terpilih ───────────────────────────────────────────
function renderAlokasi() {
    const container = document.getElementById('daftarAlokasi');
    const kosong    = document.getElementById('kosongAlokasi');

    if (alokasi.length === 0) {
        container.innerHTML = '<p id="kosongAlokasi" class="text-muted" style="font-size:0.85rem;text-align:center;padding:12px 0">Belum ada alokasi. Klik "Tambah" pada lot di atas.</p>';
        hitungTotal();
        return;
    }

    container.innerHTML = alokasi.map((a, i) => `
        <div style="display:flex;align-items:center;gap:8px;padding:6px 4px;border-bottom:1px solid var(--color-border)">
            <span style="flex:1;font-size:0.875rem;font-weight:600">${a.lot_number}</span>
            <div style="display:flex;align-items:center;gap:4px">
                <input type="number" step="0.01" min="0.01" max="${a.max}"
                    value="${a.alloc_quantity > 0 ? a.alloc_quantity : ''}"
                    placeholder="Jumlah kg"
                    class="form-control" style="width:130px;padding:4px 8px;font-size:0.875rem"
                    onchange="updateJumlah(${i}, this.value)"
                    oninput="updateJumlah(${i}, this.value)">
                <span style="font-size:0.8rem;color:var(--color-text-muted)">/ ${parseFloat(a.max).toFixed(2)} kg</span>
            </div>
            <button type="button" onclick="hapusAlokasi(${i})"
                class="btn btn-danger btn-sm" style="padding:3px 8px">✕</button>
        </div>
    `).join('');

    hitungTotal();
}

// ── Update Jumlah Alokasi ────────────────────────────────────────────────────
function updateJumlah(index, value) {
    alokasi[index].alloc_quantity = parseFloat(value) || 0;
    hitungTotal();
}

// ── Hitung & Tampilkan Ringkasan Total ───────────────────────────────────────
function hitungTotal() {
    const total   = alokasi.reduce((sum, a) => sum + (parseFloat(a.alloc_quantity) || 0), 0);
    const sisa    = modalItemQty - total;
    const el      = document.getElementById('ringkasanAlokasi');
    const warna   = sisa < 0 ? '#e53e3e' : sisa === 0 ? '#38a169' : '#d69e2e';
    el.innerHTML  = `<span style="color:${warna}">Total: ${total.toFixed(2)} kg / ${modalItemQty.toFixed(2)} kg (sisa: ${sisa.toFixed(2)} kg)</span>`;
}

// ── Simpan Alokasi via AJAX ──────────────────────────────────────────────────
function simpanAlokasi() {
    sembunyikanPesan();

    const btn = document.getElementById('btnSimpanAlokasi');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const payload = { allocations: alokasi.map(a => ({
        seed_lot_id:    a.seed_lot_id,
        alloc_quantity: a.alloc_quantity,
    }))};

    fetch(`/admin/orders/${orderId}/items/${modalItemId}/allocations`, {
        method: 'POST',
        headers: {
            'Content-Type':     'application/json',
            'Accept':           'application/json',
            'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(payload),
    })
    .then(async r => {
        const body = await r.json();
        if (!r.ok) throw new Error(body.message ?? 'Terjadi kesalahan.');
        tampilkanPesan(body.message, 'success');
        // Reload halaman setelah 1 detik agar kolom "Dialokasikan" ter-update
        setTimeout(() => { window.location.reload(); }, 1000);
    })
    .catch(err => {
        tampilkanPesan(err.message, 'error');
        btn.disabled    = false;
        btn.textContent = 'Simpan Alokasi';
    });
}

// ── Tampilkan Pesan di dalam Modal ───────────────────────────────────────────
function tampilkanPesan(teks, tipe) {
    const el = document.getElementById('modalPesan');
    const warna = tipe === 'success' ? '#c6f6d5' : tipe === 'warning' ? '#fefcbf' : '#fed7d7';
    const warnaTeks = tipe === 'success' ? '#276749' : tipe === 'warning' ? '#744210' : '#9b2c2c';
    el.style.display    = 'block';
    el.style.background = warna;
    el.style.color      = warnaTeks;
    el.textContent      = teks;
}

function sembunyikanPesan() {
    document.getElementById('modalPesan').style.display = 'none';
}
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/orders/edit.blade.php ENDPATH**/ ?>