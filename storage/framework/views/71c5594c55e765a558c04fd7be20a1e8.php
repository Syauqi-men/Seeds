<?php $__env->startSection('title', 'Buat Pesanan Baru'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><h1 class="page-title">Buat Pesanan Baru</h1></div>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>




<form method="POST" action="<?php echo e(route('admin.orders.store')); ?>" id="orderForm">
    <?php echo csrf_field(); ?>

    
    <div class="form-card" style="margin-bottom:var(--space-md)">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:var(--space-md);color:var(--color-text)">
            Informasi Pemesan
        </h3>
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label required" for="cust_name">Nama Pemesan</label>
                <input type="text" id="cust_name" name="cust_name" value="<?php echo e(old('cust_name')); ?>"
                    class="form-control <?php $__errorArgs = ['cust_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    placeholder="Nama petani/mitra/instansi">
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
                <label class="form-label required" for="order_type">Tipe Pesanan</label>
                <select id="order_type" name="order_type" class="form-control <?php $__errorArgs = ['order_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="commercial" <?php echo e(old('order_type') === 'commercial' ? 'selected' : ''); ?>>Komersial</option>
                    <option value="seed_aid" <?php echo e(old('order_type') === 'seed_aid' ? 'selected' : ''); ?>>Bantuan Benih</option>
                    <option value="internal_transfer" <?php echo e(old('order_type') === 'internal_transfer' ? 'selected' : ''); ?>>Transfer Internal</option>
                    <option value="lab_sample" <?php echo e(old('order_type') === 'lab_sample' ? 'selected' : ''); ?>>Sampel Lab</option>
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
            <div class="form-group">
                <label class="form-label required" for="payment_status">Status Pembayaran</label>
                <select id="payment_status" name="payment_status" class="form-control <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="unpaid" <?php echo e(old('payment_status', 'unpaid') === 'unpaid' ? 'selected' : ''); ?>>Belum Bayar</option>
                    <option value="paid" <?php echo e(old('payment_status') === 'paid' ? 'selected' : ''); ?>>Lunas</option>
                    <option value="exempt" <?php echo e(old('payment_status') === 'exempt' ? 'selected' : ''); ?>>Bebas Biaya</option>
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
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:var(--space-md)">
            <div class="form-group">
                <label class="form-label" for="reference_num">No. Referensi / Surat</label>
                <input type="text" id="reference_num" name="reference_num" value="<?php echo e(old('reference_num')); ?>"
                    class="form-control" placeholder="SPP-001/IX/2026">
            </div>
            <div class="form-group">
                <label class="form-label" for="notes">Catatan</label>
                <input type="text" id="notes" name="notes" value="<?php echo e(old('notes')); ?>"
                    class="form-control" placeholder="Keterangan tambahan (opsional)">
            </div>
        </div>
    </div>

    
    <div style="margin-bottom:var(--space-sm)">
        <h3 style="font-size:1rem;font-weight:700;color:var(--color-text)">
            Item Pesanan
        </h3>
        <p style="font-size:0.85rem;color:var(--color-text-muted);margin-bottom:var(--space-md)">
            Tambahkan varietas dan kelas benih yang dipesan. Klik "+ Tambah Item" untuk menambah baris.
        </p>
    </div>

    <div id="order-items">
        
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Varietas Benih</label>
                    <select name="items[0][seed_id]" class="form-control seed-select">
                        <option value="">-- Pilih Varietas --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $seeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($seed->id); ?>" data-category="<?php echo e($seed->category_id); ?>"><?php echo e($seed->var_name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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

    
    <div style="margin-bottom:var(--space-md)">
        <button type="button" id="btn-add-item" class="btn btn-ghost"
            style="width:100%;border:2px dashed var(--color-border);display:flex;align-items:center;justify-content:center;gap:var(--space-sm)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Item Pesanan
        </button>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
    </div>
</form>

<script>
(function () {
    // Data untuk dropdown dinamis
    const categoryOptions = `<?php echo $categories->map(fn($c) => '<option value="'.$c->id.'">'.$c->name.'</option>')->implode(''); ?>`;
    const seedData = [
        <?php $__currentLoopData = $seeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        { id: <?php echo e($seed->id); ?>, name: '<?php echo addslashes($seed->var_name); ?>', categoryId: <?php echo e($seed->category_id ?? 'null'); ?> },
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/orders/create.blade.php ENDPATH**/ ?>