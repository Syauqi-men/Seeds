<form wire:submit="save">
    
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-md)">
        <div class="form-group">
            <label class="form-label required" for="seed_id">Varietas Benih</label>
            <select id="seed_id" wire:model.live="seed_id" class="form-control <?php $__errorArgs = ['seed_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <option value="">-- Pilih Varietas --</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $seeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <option value="<?php echo e($seed->id); ?>"><?php echo e($seed->var_name); ?> (<?php echo e($seed->category?->name ?? '—'); ?> - <?php echo e($seed->var_class->value); ?>)</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['seed_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="form-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="location">Lokasi</label>
            <select id="location" wire:model.live="location" class="form-control">
                <option value="">-- Pilih Lokasi --</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $locationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alias => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <option value="<?php echo e($alias); ?>"><?php echo e($label); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <span class="form-hint">Alias lokasi untuk format nomor lot</span>
        </div>
    </div>

    
    <div class="form-group">
        <label class="form-label required" for="lot_number">Nomor Lot</label>
        <div style="display:flex;gap:var(--space-sm);align-items:center">
            <input type="text" id="lot_number" wire:model="lot_number"
                class="form-control <?php $__errorArgs = ['lot_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                placeholder="Contoh: 001-KDL-XX-BS-KP-26">
            <label style="display:flex;align-items:center;gap:4px;font-size:0.8rem;color:var(--color-text-muted);white-space:nowrap">
                <input type="checkbox" wire:model.live="autoLotNumber"> Auto
            </label>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['lot_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="form-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <span class="form-hint">
            Format: <code>NNN-[KATEGORI]-XX-[KELAS]-[LOKASI]-[TH]</code>
            &nbsp;·&nbsp; Centang "Auto" untuk generate otomatis dari pilihan di atas.
        </span>
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

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($seedLot && $seedLot->exists): ?>
    <div class="form-group">
        <label class="form-label">Stok (Dikelola Otomatis)</label>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--space-md)">
            <div class="readonly-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Stok Mentah: <strong><?php echo e(number_format($seedLot->raw_stock, 2)); ?> kg</strong>
            </div>
            <div class="readonly-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Stok Bersih: <strong><?php echo e(number_format($seedLot->clean_stock, 2)); ?> kg</strong>
            </div>
            <div class="readonly-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Stok Grading: <strong><?php echo e(number_format($seedLot->graded_stock, 2)); ?> kg</strong>
            </div>
        </div>
        <span class="form-hint">Stok dihitung otomatis dari transaksi dan proses produksi. Tidak dapat diubah manual.</span>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm);margin-top:var(--space-md)">
        <a href="<?php echo e(route('admin.seed-lots.index')); ?>" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan
            </span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </div>
</form>
<?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/livewire/admin/seed-lot-form.blade.php ENDPATH**/ ?>