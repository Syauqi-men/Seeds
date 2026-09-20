<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Ringkasan data stok benih BRMP Aneka Kacang</p>
    </div>
</div>


<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-label">Total Varietas</div>
        <div class="stat-card-value"><?php echo e(number_format($stats['total_seeds'])); ?></div>
        <div class="stat-card-unit">varietas terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Total Lot</div>
        <div class="stat-card-value"><?php echo e(number_format($stats['total_lots'])); ?></div>
        <div class="stat-card-unit">lot benih</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Lot Siap</div>
        <div class="stat-card-value" style="color:var(--color-ready)"><?php echo e(number_format($stats['lots_ready'])); ?></div>
        <div class="stat-card-unit">status Ready</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Mentah</div>
        <div class="stat-card-value"><?php echo e(number_format($stats['total_raw'], 0)); ?></div>
        <div class="stat-card-unit">kg total</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Bersih</div>
        <div class="stat-card-value"><?php echo e(number_format($stats['total_clean'], 0)); ?></div>
        <div class="stat-card-unit">kg total</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Lot Habis</div>
        <div class="stat-card-value" style="color:var(--color-depleted)"><?php echo e(number_format($stats['lots_depleted'])); ?></div>
        <div class="stat-card-unit">status Depleted</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-xl)">
    
    <div class="data-table-wrapper">
        <div style="padding:var(--space-md) var(--space-lg);border-bottom:1px solid var(--color-border);">
            <h3 style="font-size:0.95rem;font-weight:700">Transaksi Stok Terbaru</h3>
        </div>
        <table class="data-table">
            <thead><tr>
                <th>Lot</th><th>Tipe</th><th>Qty</th><th>Waktu</th>
            </tr></thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td><?php echo e($tx->seedLot->lot_number); ?></td>
                <td>
                    <span class="badge <?php echo e($tx->transaction_type->value === 'IN' ? 'badge-ready' : ($tx->transaction_type->value === 'OUT' ? 'badge-depleted' : 'badge-processing')); ?>">
                        <?php echo e($tx->transaction_type->label()); ?>

                    </span>
                </td>
                <td><?php echo e(number_format($tx->quantity, 1)); ?> kg</td>
                <td class="text-muted text-small"><?php echo e($tx->created_at->diffForHumans()); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr><td colspan="4" class="text-center text-muted">Belum ada transaksi</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="data-table-wrapper">
        <div style="padding:var(--space-md) var(--space-lg);border-bottom:1px solid var(--color-border);">
            <h3 style="font-size:0.95rem;font-weight:700">Aktivitas Terbaru</h3>
        </div>
        <div style="padding:var(--space-md)">
            <div class="activity-feed">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div>
                        <div class="activity-text"><?php echo e($activity->description); ?></div>
                        <div class="activity-time">
                            <?php echo e($activity->causer->name ?? 'Sistem'); ?> &bull; <?php echo e($activity->created_at->diffForHumans()); ?>

                        </div>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p class="text-muted text-small">Belum ada aktivitas tercatat.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>