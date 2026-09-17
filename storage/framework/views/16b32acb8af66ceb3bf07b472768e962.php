<?php $__env->startSection('title', 'Lot Benih'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Lot Benih</h1>
        <p class="page-subtitle">Kelola data lot benih dan stok</p>
    </div>
    <a href="<?php echo e(route('admin.seed-lots.create')); ?>" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Lot
    </a>
</div>

<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nomor Lot</th>
                <th>Varietas</th>
                <th>Status</th>
                <th>Stok Mentah</th>
                <th>Stok Bersih</th>
                <th>Diperbarui</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td><span style="font-weight:600"><?php echo e($lot->lot_number); ?></span></td>
                <td>
                    <div><?php echo e($lot->seed->var_name); ?></div>
                    <div class="text-small text-muted"><?php echo e($lot->seed->category?->name ?? '—'); ?> &bull; <?php echo e($lot->seed->var_class->value); ?></div>
                </td>
                <td><span class="badge badge-<?php echo e(strtolower($lot->status->value)); ?>"><?php echo e($lot->status->label()); ?></span></td>
                <td><?php echo e(number_format($lot->raw_stock, 2)); ?> kg</td>
                <td><?php echo e(number_format($lot->clean_stock, 2)); ?> kg</td>
                <td class="text-muted text-small"><?php echo e($lot->updated_at->translatedFormat('d M Y')); ?></td>
                <td style="text-align:right">
                    <div style="display:flex;gap:4px;justify-content:flex-end" x-data="{ showDelete: false }">
                        <a href="<?php echo e(route('admin.seed-lots.show', $lot)); ?>" class="btn btn-ghost btn-sm" title="Detail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <a href="<?php echo e(route('admin.seed-lots.edit', $lot)); ?>" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <button @click="showDelete = true" class="btn btn-danger btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                        <div x-show="showDelete" class="modal-backdrop" @click.self="showDelete=false" x-transition style="display:none">
                            <div class="modal-box">
                                <h3 class="modal-title">Hapus Lot Benih?</h3>
                                <p style="font-size:0.9rem;color:var(--color-text-muted);margin-bottom:var(--space-lg)">Lot <strong><?php echo e($lot->lot_number); ?></strong> beserta semua transaksi dan data terkait akan dihapus permanen.</p>
                                <div style="display:flex;gap:var(--space-sm);justify-content:flex-end">
                                    <button @click="showDelete=false" class="btn btn-ghost">Batal</button>
                                    <form method="POST" action="<?php echo e(route('admin.seed-lots.destroy', $lot)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr><td colspan="7" class="text-center text-muted" style="padding:var(--space-xl)">Belum ada lot benih.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
    <div style="padding:var(--space-md) var(--space-lg)"><?php echo e($lots->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/seed-lots/index.blade.php ENDPATH**/ ?>