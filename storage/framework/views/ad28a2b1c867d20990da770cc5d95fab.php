<?php $__env->startSection('title', 'Detail Pesanan'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Pesanan</h1>
        <p class="page-subtitle"><?php echo e($order->reference_num ?? 'Tanpa Referensi'); ?> — <?php echo e($order->cust_name); ?></p>
    </div>
    <div style="display:flex;gap:var(--space-sm)">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>
</div>


<div class="form-card" style="margin-bottom:var(--space-md)">
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:var(--space-md);color:var(--color-text)">Informasi Pesanan</h3>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--space-md) var(--space-lg)">
        <div>
            <span class="text-small text-muted" style="display:block">Pemesan</span>
            <strong><?php echo e($order->cust_name); ?></strong>
        </div>
        <div>
            <span class="text-small text-muted" style="display:block">Tipe Pesanan</span>
            <?php
                $typeLabels = [
                    'commercial'        => 'Komersial',
                    'seed_aid'          => 'Bantuan Benih',
                    'internal_transfer' => 'Transfer Internal',
                    'lab_sample'        => 'Sampel Lab',
                ];
            ?>
            <span class="badge badge-processing"><?php echo e($typeLabels[$order->order_type] ?? $order->order_type); ?></span>
        </div>
        <div>
            <span class="text-small text-muted" style="display:block">Status</span>
            <?php
                $statusBadge = match($order->status) {
                    'pending'   => 'badge-quarantine',
                    'preparing' => 'badge-processing',
                    'ready', 'completed' => 'badge-ready',
                    'cancelled' => 'badge-depleted',
                    default     => '',
                };
                $statusLabel = match($order->status) {
                    'pending'   => 'Pending',
                    'preparing' => 'Diproses',
                    'ready'     => 'Siap',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default     => $order->status,
                };
            ?>
            <span class="badge <?php echo e($statusBadge); ?>"><?php echo e($statusLabel); ?></span>
        </div>
        <div>
            <span class="text-small text-muted" style="display:block">Status Pembayaran</span>
            <?php
                $payBadge = match($order->payment_status) {
                    'paid'   => 'badge-ready',
                    'unpaid' => 'badge-depleted',
                    'exempt' => 'badge-quarantine',
                    default  => '',
                };
                $payLabel = match($order->payment_status) {
                    'paid'   => 'Lunas',
                    'unpaid' => 'Belum Bayar',
                    'exempt' => 'Bebas Biaya',
                    default  => $order->payment_status,
                };
            ?>
            <span class="badge <?php echo e($payBadge); ?>"><?php echo e($payLabel); ?></span>
        </div>
        <div>
            <span class="text-small text-muted" style="display:block">No. Referensi</span>
            <?php echo e($order->reference_num ?? '—'); ?>

        </div>
        <div>
            <span class="text-small text-muted" style="display:block">Tanggal Dibuat</span>
            <?php echo e($order->created_at->format('d M Y, H:i')); ?>

        </div>
        <div>
            <span class="text-small text-muted" style="display:block">Dicatat oleh</span>
            <?php echo e($order->user->name ?? '—'); ?>

        </div>
        <div>
            <span class="text-small text-muted" style="display:block">Diproses oleh</span>
            <?php echo e($order->petugasBenih->name ?? '— (belum diproses)'); ?>

        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->notes): ?>
        <div style="grid-column: span 3">
            <span class="text-small text-muted" style="display:block">Catatan</span>
            <?php echo e($order->notes); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<div class="data-table-wrapper">
    <h3 style="font-size:1rem;font-weight:700;padding:var(--space-md) var(--space-lg) 0;color:var(--color-text)">
        Item Pesanan (<?php echo e($order->items->count()); ?> varietas)
    </h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Varietas Benih</th>
                <th>Kelas</th>
                <th style="text-align:right">Jumlah (kg)</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td class="text-muted"><?php echo e($i + 1); ?></td>
                <td style="font-weight:600"><?php echo e($item->seed->var_name ?? '—'); ?></td>
                <td><span class="badge badge-processing"><?php echo e($item->seed_class->value ?? $item->seed_class); ?></span></td>
                <td style="text-align:right;font-weight:600"><?php echo e(number_format($item->quantity, 2)); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr style="background:var(--color-bg-alt);font-weight:700">
                <td colspan="3" style="text-align:right">Total</td>
                <td style="text-align:right"><?php echo e(number_format($order->items->sum('quantity'), 2)); ?> kg</td>
            </tr>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>