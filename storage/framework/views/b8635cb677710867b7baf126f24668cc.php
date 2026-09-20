<?php $__env->startSection('title', 'Tambah Transaksi Stok'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><h1 class="page-title">Tambah Transaksi Stok</h1></div>
    <a href="<?php echo e(route('admin.stock-transactions.index')); ?>" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('rows')): ?>
<div class="alert alert-error" style="margin-bottom:var(--space-md)"><?php echo e($errors->first('rows')); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.stock-transactions.store')); ?>" id="txForm">
    <?php echo csrf_field(); ?>
    <div id="tx-rows">
        
        <div class="form-card tx-row" style="margin-bottom:var(--space-md)">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
                <span style="font-weight:600;font-size:0.9rem;color:var(--color-text-muted)">Baris #1</span>
                <button type="button" class="btn btn-danger btn-sm btn-remove-row" style="display:none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Hapus Baris
                </button>
            </div>
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label required">Lot Benih</label>
                    <select name="rows[0][seed_lot_id]" class="form-control">
                        <option value="">-- Pilih Lot --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($lot->id); ?>"><?php echo e($lot->lot_number); ?> &mdash; <?php echo e($lot->seed->var_name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Tipe Transaksi</label>
                    <select name="rows[0][transaction_type]" class="form-control">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="IN">Masuk (IN)</option>
                        <option value="OUT">Keluar (OUT)</option>
                        <option value="ADJUSTMENT">Penyesuaian</option>
                        <option value="GRADING">Grading</option>
                        <option value="SORTING">Sortasi (Sorting)</option>
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label required">Jumlah (kg)</label>
                    <input type="number" name="rows[0][quantity]" step="0.01" class="form-control" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">No. Referensi</label>
                    <input type="text" name="rows[0][reference_no]" class="form-control" placeholder="INV-XXX-001">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Transaksi</label>
                    <input type="datetime-local" name="rows[0][transacted_at]" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan</label>
                <input type="text" name="rows[0][notes]" class="form-control" placeholder="Keterangan transaksi">
            </div>
        </div>
    </div>

    
    <div style="margin-bottom:var(--space-md)">
        <button type="button" id="btn-add-tx-row" class="btn btn-ghost" style="width:100%;border:2px dashed var(--color-border);display:flex;align-items:center;justify-content:center;gap:var(--space-sm)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Baris Transaksi Lain
        </button>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
        <a href="<?php echo e(route('admin.stock-transactions.index')); ?>" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Semua</button>
    </div>
</form>

<script>
(function () {
    const lotsOptions = `<?php echo $lots->map(fn($l) => '<option value="'.$l->id.'">'.$l->lot_number.' &mdash; '.$l->seed->var_name.'</option>')->implode(''); ?>`;
    const typeOptions = `
        <option value="">-- Pilih Tipe --</option>
        <option value="IN">Masuk (IN)</option>
        <option value="OUT">Keluar (OUT)</option>
        <option value="ADJUSTMENT">Penyesuaian</option>
        <option value="GRADING">Grading</option>
        <option value="SORTING">Sortasi (Sorting)</option>
    `;

    let rowCount = 1;

    document.getElementById('btn-add-tx-row').addEventListener('click', function () {
        const idx = rowCount++;
        const row = document.createElement('div');
        row.className = 'form-card tx-row';
        row.style.cssText = 'margin-bottom:var(--space-md)';
        row.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
                <span style="font-weight:600;font-size:0.9rem;color:var(--color-text-muted)">Baris #${idx + 1}</span>
                <button type="button" class="btn btn-danger btn-sm btn-remove-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Hapus Baris
                </button>
            </div>
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label required">Lot Benih</label>
                    <select name="rows[${idx}][seed_lot_id]" class="form-control">
                        <option value="">-- Pilih Lot --</option>${lotsOptions}
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Tipe Transaksi</label>
                    <select name="rows[${idx}][transaction_type]" class="form-control">${typeOptions}</select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label required">Jumlah (kg)</label>
                    <input type="number" name="rows[${idx}][quantity]" step="0.01" class="form-control" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">No. Referensi</label>
                    <input type="text" name="rows[${idx}][reference_no]" class="form-control" placeholder="INV-XXX-001">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Transaksi</label>
                    <input type="datetime-local" name="rows[${idx}][transacted_at]" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan</label>
                <input type="text" name="rows[${idx}][notes]" class="form-control" placeholder="Keterangan transaksi">
            </div>
        `;
        row.querySelector('.btn-remove-row').addEventListener('click', function () {
            row.remove();
            updateRowLabels();
        });
        document.getElementById('tx-rows').appendChild(row);
        updateRowLabels();
    });

    function updateRowLabels() {
        const rows = document.querySelectorAll('.tx-row');
        rows.forEach((r, i) => {
            const label = r.querySelector('span');
            if (label) label.textContent = `Baris #${i + 1}`;
            const removeBtn = r.querySelector('.btn-remove-row');
            if (removeBtn) removeBtn.style.display = rows.length > 1 ? '' : 'none';
        });
    }
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/stock-transactions/create.blade.php ENDPATH**/ ?>