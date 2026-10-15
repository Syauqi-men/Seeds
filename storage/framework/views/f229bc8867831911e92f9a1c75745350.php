<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="nv-page-head">
    <div>
        <h1>Dashboard</h1>
        <p>Ringkasan data stok benih BRMP Aneka Kacang</p>
    </div>
    <div class="nv-page-head__tools">
        <button class="nv-btn" onclick="window.location.reload()">
            <i data-lucide="refresh-cw"></i> Refresh
        </button>
    </div>
</div>

<div class="nv-dash">
    <!-- Metrics -->
    <div class="nv-dash__metrics">
        <div class="nv-panel nv-metric nv-reveal" style="--i:0">
            <div class="nv-panel__body">
                <div class="nv-metric__head">
                    <span class="nv-metric__name"><i data-lucide="sprout"></i> Total Varietas</span>
                    <span class="nv-metric__icon"><i data-lucide="sprout"></i></span>
                </div>
                <div class="nv-metric__row">
                    <span class="nv-metric__value"><?php echo e(number_format($stats['total_seeds'])); ?><span class="nv-metric__unit">varietas terdaftar</span></span>
                </div>
            </div>
        </div>

        <div class="nv-panel nv-metric nv-reveal" style="--i:1">
            <div class="nv-panel__body">
                <div class="nv-metric__head">
                    <span class="nv-metric__name"><i data-lucide="package"></i> Total Lot</span>
                    <span class="nv-metric__icon"><i data-lucide="package"></i></span>
                </div>
                <div class="nv-metric__row">
                    <span class="nv-metric__value"><?php echo e(number_format($stats['total_lots'])); ?><span class="nv-metric__unit">lot benih</span></span>
                </div>
            </div>
        </div>

        <div class="nv-panel nv-metric nv-reveal" style="--i:2">
            <div class="nv-panel__body">
                <div class="nv-metric__head">
                    <span class="nv-metric__name"><i data-lucide="check-circle"></i> Lot Siap</span>
                    <span class="nv-metric__icon"><i data-lucide="check-circle"></i></span>
                </div>
                <div class="nv-metric__row">
                    <span class="nv-metric__value" style="color: var(--nv-success)"><?php echo e(number_format($stats['lots_ready'])); ?><span class="nv-metric__unit">status Ready</span></span>
                </div>
            </div>
        </div>

        <div class="nv-panel nv-metric nv-reveal" style="--i:3">
            <div class="nv-panel__body">
                <div class="nv-metric__head">
                    <span class="nv-metric__name"><i data-lucide="scale"></i> Stok Bersih</span>
                    <span class="nv-metric__icon"><i data-lucide="scale"></i></span>
                </div>
                <div class="nv-metric__row">
                    <span class="nv-metric__value"><?php echo e(number_format($stats['total_clean'], 0)); ?><span class="nv-metric__unit">kg total</span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart panel -->
    <div class="nv-dash__chart">
        <div class="nv-panel nv-chart nv-reveal" style="--i:4">
            <div class="nv-panel__body">
                <div class="nv-panel__head">
                    <div class="nv-panel__title"><i data-lucide="bar-chart-3"></i> Ringkasan Stok</div>
                </div>
                <div class="nv-chart__summary">
                    <span class="nv-chart__total"><?php echo e(number_format($stats['total_raw'], 0)); ?><span class="nv-metric__unit"> kg mentah</span></span>
                </div>
                <div style="padding: 20px 14px; display: grid; grid-template-columns: 1fr 1fr; gap: var(--nv-gutter);">
                    <div style="padding: 16px; background: var(--nv-surface-muted); border-radius: var(--nv-radius); border: 1px solid var(--nv-border); text-align: center;">
                        <div style="font-size: var(--nv-text-xs); color: var(--nv-text-muted); margin-bottom: 4px;">Stok Mentah Total</div>
                        <div style="font-size: 1.4rem; font-weight: 600;"><?php echo e(number_format($stats['total_raw'], 0)); ?> <span style="font-size: var(--nv-text-sm); font-weight: 400; color: var(--nv-text-muted);">kg</span></div>
                    </div>
                    <div style="padding: 16px; background: var(--nv-success-soft); border-radius: var(--nv-radius); border: 1px solid #C9F0DD; text-align: center;">
                        <div style="font-size: var(--nv-text-xs); color: var(--nv-text-muted); margin-bottom: 4px;">Stok Bersih Total</div>
                        <div style="font-size: 1.4rem; font-weight: 600; color: var(--nv-success);"><?php echo e(number_format($stats['total_clean'], 0)); ?> <span style="font-size: var(--nv-text-sm); font-weight: 400; color: var(--nv-text-muted);">kg</span></div>
                    </div>
                </div>
                <div style="padding: 0 14px 14px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                    <div style="padding: 10px; background: var(--nv-surface-muted); border-radius: var(--nv-radius-sm); border: 1px solid var(--nv-border);">
                        <div style="font-size: .68rem; color: var(--nv-text-muted); margin-bottom: 2px;">Lot Siap</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: var(--nv-success);"><?php echo e(number_format($stats['lots_ready'])); ?></div>
                    </div>
                    <div style="padding: 10px; background: var(--nv-surface-muted); border-radius: var(--nv-radius-sm); border: 1px solid var(--nv-border);">
                        <div style="font-size: .68rem; color: var(--nv-text-muted); margin-bottom: 2px;">Lot Habis</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: var(--nv-danger);"><?php echo e(number_format($stats['lots_depleted'])); ?></div>
                    </div>
                    <div style="padding: 10px; background: var(--nv-surface-muted); border-radius: var(--nv-radius-sm); border: 1px solid var(--nv-border);">
                        <div style="font-size: .68rem; color: var(--nv-text-muted); margin-bottom: 2px;">Total Lot</div>
                        <div style="font-size: 1.1rem; font-weight: 600;"><?php echo e(number_format($stats['total_lots'])); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Updates panel (activity log) -->
    <div class="nv-dash__updates">
        <div class="nv-panel nv-updates nv-reveal" style="--i:5">
            <div class="nv-panel__body">
                <div class="nv-panel__head">
                    <div class="nv-panel__title"><i data-lucide="activity"></i> Aktivitas Terbaru</div>
                    <a href="<?php echo e(route('admin.activity-log.index')); ?>" class="nv-btn nv-btn--ghost" style="font-size: var(--nv-text-xs);">Lihat semua</a>
                </div>
                <div class="nv-updates__list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="nv-activity">
                        <div class="nv-activity__icon" data-tone="info">
                            <i data-lucide="file-text"></i>
                        </div>
                        <div>
                            <div class="nv-activity__head">
                                <span class="nv-activity__title"><?php echo e($activity->description); ?></span>
                                <span class="nv-activity__time"><?php echo e($activity->created_at->diffForHumans()); ?></span>
                            </div>
                            <div class="nv-activity__copy"><?php echo e($activity->causer->name ?? 'Sistem'); ?></div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="nv-empty">
                        <i data-lucide="inbox"></i>
                        <strong>Belum ada aktivitas</strong>
                        <span>Aktivitas akan muncul di sini saat ada perubahan data.</span>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Table (recent transactions) -->
    <div class="nv-dash__table">
        <div class="nv-panel nv-reveal" style="--i:6">
            <div class="nv-panel__body">
                <div class="nv-panel__head">
                    <div class="nv-panel__title"><i data-lucide="repeat"></i> Transaksi Stok Terbaru</div>
                    <a href="<?php echo e(route('admin.stock-transactions.index')); ?>" class="nv-btn nv-btn--ghost" style="font-size: var(--nv-text-xs);">Lihat semua</a>
                </div>
                <div class="nv-table__scroll">
                    <table class="nv-table">
                        <thead><tr>
                            <th>Lot</th><th>Tipe</th><th class="num">Qty</th><th>Waktu</th>
                        </tr></thead>
                        <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="nv-cell-strong"><?php echo e($tx->seedLot->lot_number); ?></td>
                            <td>
                                <span class="nv-status <?php echo e($tx->transaction_type->value === 'IN' ? 'nv-status--success' : ($tx->transaction_type->value === 'OUT' ? 'nv-status--danger' : 'nv-status--info')); ?>">
                                    <i data-lucide="<?php echo e($tx->transaction_type->value === 'IN' ? 'arrow-down' : ($tx->transaction_type->value === 'OUT' ? 'arrow-up' : 'minus')); ?>"></i>
                                    <?php echo e($tx->transaction_type->label()); ?>

                                </span>
                            </td>
                            <td class="num"><?php echo e(number_format($tx->quantity, 1)); ?> kg</td>
                            <td class="nv-cell-muted"><?php echo e($tx->created_at->diffForHumans()); ?></td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="4" class="text-center" style="color: var(--nv-text-muted);">Belum ada transaksi</td></tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>