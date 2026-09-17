<?php $__env->startSection('title', 'Proses Produksi'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Proses Produksi</h1>
        <p class="page-subtitle">Data proses sortasi & grading benih (entri terakhir per lot)</p>
    </div>
    <a href="<?php echo e(route('admin.production-processes.create')); ?>" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Proses
    </a>
</div>
<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Lot</th>
                <th>Jenis Proses</th>
                <th>Pekerja</th>
                <th>Input (kg)</th>
                <th>Output (kg)</th>
                <th>Susut (kg)</th>
                <th>Tanggal Proses</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $processes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td>
                    <div style="font-weight:600"><?php echo e($proc->seedLot->lot_number); ?></div>
                    <div class="text-small text-muted"><?php echo e($proc->seedLot->seed->var_name); ?></div>
                </td>
                <td>
                    <span class="badge <?php echo e($proc->process_type->badgeClass()); ?>">
                        <?php echo e($proc->process_type->label()); ?>

                    </span>
                </td>
                <td>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proc->worker): ?>
                        <div style="font-weight:500"><?php echo e($proc->worker->name); ?></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proc->worker->code): ?>
                        <div class="text-small text-muted"><?php echo e($proc->worker->code); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td><?php echo e(number_format($proc->input_quantity, 2)); ?></td>
                <td><?php echo e(number_format($proc->output_quantity, 2)); ?></td>
                <td><?php echo e(number_format($proc->sortir_quantity, 2)); ?></td>
                <td class="text-small text-muted"><?php echo e($proc->processed_at?->translatedFormat('d M Y') ?? '-'); ?></td>
                <td style="text-align:right">
                    <div style="display:flex;gap:4px;justify-content:flex-end" x-data="{ del: false }">
                        <a href="<?php echo e(route('admin.production-processes.edit', $proc)); ?>" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <button @click="del=true" class="btn btn-danger btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                        </button>
                        <div x-show="del" class="modal-backdrop" @click.self="del=false" x-transition style="display:none">
                            <div class="modal-box">
                                <h3 class="modal-title">Hapus Proses Produksi?</h3>
                                <p style="font-size:0.9rem;color:var(--color-text-muted);margin-bottom:var(--space-lg)">Data proses ini akan dihapus dan stok bersih lot terkait akan dihitung ulang otomatis.</p>
                                <div style="display:flex;gap:var(--space-sm);justify-content:flex-end">
                                    <button @click="del=false" class="btn btn-ghost">Batal</button>
                                    <form method="POST" action="<?php echo e(route('admin.production-processes.destroy', $proc)); ?>">
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
            <tr><td colspan="8" class="text-center text-muted" style="padding:var(--space-xl)">Belum ada proses produksi.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
    <div style="padding:var(--space-md) var(--space-lg)"><?php echo e($processes->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/production-processes/index.blade.php ENDPATH**/ ?>