<?php $__env->startSection('title', 'Edit Pesanan'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Pesanan</h1>
        <p class="page-subtitle"><?php echo e($order->reference_num ?? 'Tanpa Referensi'); ?> — <?php echo e($order->cust_name); ?></p>
    </div>
    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>

<?php
    $user = auth()->user();
    $canEditDetails = $user->hasAnyRole(['Administrator', 'Order Processor']);
    $canEditStatus = $user->hasAnyRole(['Administrator', 'Petugas Benih']);
?>

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
                    <option value="pending" <?php echo e($st === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="preparing" <?php echo e($st === 'preparing' ? 'selected' : ''); ?>>Diproses</option>
                    <option value="ready" <?php echo e($st === 'ready' ? 'selected' : ''); ?>>Siap</option>
                    <option value="completed" <?php echo e($st === 'completed' ? 'selected' : ''); ?>>Selesai</option>
                    <option value="cancelled" <?php echo e($st === 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
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
                    <option value="paid" <?php echo e($ps === 'paid' ? 'selected' : ''); ?>>Lunas</option>
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
        <h3 style="font-size:1rem;font-weight:700;padding:var(--space-md) var(--space-lg) 0;color:var(--color-text)">
            Item Pesanan (tidak dapat diubah)
        </h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Varietas</th>
                    <th>Kelas</th>
                    <th style="text-align:right">Jumlah (kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td class="text-muted"><?php echo e($i + 1); ?></td>
                    <td><?php echo e($item->seed->var_name ?? '—'); ?></td>
                    <td><span class="badge badge-processing"><?php echo e($item->seed_class->value ?? $item->seed_class); ?></span></td>
                    <td style="text-align:right"><?php echo e(number_format($item->quantity, 2)); ?></td>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/orders/edit.blade.php ENDPATH**/ ?>