<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin — <?php echo $__env->yieldContent('title', 'Panel Admin'); ?> | BRMP Aneka Kacang</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body>
    <div class="nv-shell" x-data="{ sidebar: window.innerWidth > 760 ? 'open' : 'closed', drawer: false }"
        :data-sidebar="sidebar" :data-drawer="drawer ? 'open' : undefined"
        x-on:keydown.escape.window="drawer = false">

        
        <aside class="nv-sidebar">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nv-sidebar__brand">
                <div class="nv-wordmark-mark">
                    <i data-lucide="sprout"></i>
                </div>
                <div class="nv-wordmark">
                    <strong>Panel Admin</strong>
                    <span>BRMP Aneka Kacang</span>
                </div>
            </a>

            <nav class="nv-sidebar__nav">
                
                <details open class="nv-nav-group">
                    <summary>
                        <span>Utama</span>
                        <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
                    </summary>
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                        class="nv-nav-link"
                        <?php echo request()->routeIs('admin.dashboard') ? 'aria-current="page"' : ''; ?>>
                        <i data-lucide="layout-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </details>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'Administrator')): ?>
                    <details open class="nv-nav-group">
                        <summary>
                            <span>Master Data</span>
                            <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
                        </summary>
                        <a href="<?php echo e(route('admin.seed-categories.index')); ?>"
                            class="nv-nav-link"
                            <?php echo request()->routeIs('admin.seed-categories*') ? 'aria-current="page"' : ''; ?>>
                            <i data-lucide="layers"></i>
                            <span>Kategori Benih</span>
                        </a>
                        <a href="<?php echo e(route('admin.workers.index')); ?>"
                            class="nv-nav-link"
                            <?php echo request()->routeIs('admin.workers*') ? 'aria-current="page"' : ''; ?>>
                            <i data-lucide="users"></i>
                            <span>Data Pekerja</span>
                        </a>
                    </details>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'Administrator|Petugas Benih|Proses Produksi')): ?>
                    <details open class="nv-nav-group">
                        <summary>
                            <span>Pengolahan Benih</span>
                            <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
                        </summary>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'Administrator|Petugas Benih')): ?>
                            <a href="<?php echo e(route('admin.seeds.index')); ?>"
                                class="nv-nav-link"
                                <?php echo request()->routeIs('admin.seeds*') ? 'aria-current="page"' : ''; ?>>
                                <i data-lucide="sprout"></i>
                                <span>Varietas Benih</span>
                            </a>
                            <a href="<?php echo e(route('admin.seed-lots.index')); ?>"
                                class="nv-nav-link"
                                <?php echo request()->routeIs('admin.seed-lots*') ? 'aria-current="page"' : ''; ?>>
                                <i data-lucide="package"></i>
                                <span>Lot Benih</span>
                            </a>
                            <a href="<?php echo e(route('admin.seed-mutations.index')); ?>"
                                class="nv-nav-link"
                                <?php echo request()->routeIs('admin.seed-mutations*') ? 'aria-current="page"' : ''; ?>>
                                <i data-lucide="arrow-left-right"></i>
                                <span>Mutasi Benih</span>
                            </a>
                            <a href="<?php echo e(route('admin.lab-tests.index')); ?>"
                                class="nv-nav-link"
                                <?php echo request()->routeIs('admin.lab-tests*') ? 'aria-current="page"' : ''; ?>>
                                <i data-lucide="flask-conical"></i>
                                <span>Uji Lab</span>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'Administrator|Proses Produksi')): ?>
                            <a href="<?php echo e(route('admin.production-processes.index')); ?>"
                                class="nv-nav-link"
                                <?php echo request()->routeIs('admin.production-processes*') ? 'aria-current="page"' : ''; ?>>
                                <i data-lucide="cog"></i>
                                <span>Proses Produksi</span>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </details>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'Administrator|Order Processor|Petugas Benih')): ?>
                    <details open class="nv-nav-group">
                        <summary>
                            <span>Persediaan</span>
                            <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
                        </summary>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'Administrator|Order Processor')): ?>
                            <a href="<?php echo e(route('admin.stock-transactions.index')); ?>"
                                class="nv-nav-link"
                                <?php echo request()->routeIs('admin.stock-transactions*') ? 'aria-current="page"' : ''; ?>>
                                <i data-lucide="repeat"></i>
                                <span>Transaksi Stok</span>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <a href="<?php echo e(route('admin.orders.index')); ?>"
                            class="nv-nav-link"
                            <?php echo request()->routeIs('admin.orders*') ? 'aria-current="page"' : ''; ?>>
                            <i data-lucide="shopping-bag"></i>
                            <span>Pesanan</span>
                        </a>
                    </details>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <details open class="nv-nav-group">
                    <summary>
                        <span>Sistem</span>
                        <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
                    </summary>
                    <a href="<?php echo e(route('admin.activity-log.index')); ?>"
                        class="nv-nav-link"
                        <?php echo request()->routeIs('admin.activity-log*') ? 'aria-current="page"' : ''; ?>>
                        <i data-lucide="file-text"></i>
                        <span>Log Aktivitas</span>
                    </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'Administrator')): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>"
                            class="nv-nav-link"
                            <?php echo request()->routeIs('admin.users*') ? 'aria-current="page"' : ''; ?>>
                            <i data-lucide="user-plus"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </details>
            </nav>

            
            <?php
                $currentUser = Auth::user();
                $currentRole = $currentUser?->roles->first()?->name;
                $roleTone = match($currentRole) {
                    'Administrator' => 'nv-status--success',
                    'Petugas Benih', 'Proses Produksi' => 'nv-status--info',
                    'Order Processor' => 'nv-status--warning',
                    default => 'nv-status--neutral',
                };
            ?>
            <div class="nv-sidebar__footer">
                <div class="nv-profile">
                    <div class="nv-avatar">
                        <?php echo e(strtoupper(substr($currentUser?->name ?? 'U', 0, 2))); ?>

                    </div>
                    <div class="nv-profile__meta">
                        <strong><?php echo e($currentUser?->name); ?></strong>
                        <span><?php echo e($currentRole ?? 'Pengguna'); ?></span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentRole): ?>
                        <span class="nv-status <?php echo e($roleTone); ?>" style="font-size: 0.68rem; height: 20px; padding: 0 6px;">
                            <?php echo e($currentRole); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <a href="<?php echo e(route('home')); ?>" class="nv-nav-link" target="_blank" title="Lihat Landing Page">
                    <i data-lucide="home"></i>
                    <span>Lihat Landing Page</span>
                </a>
            </div>
        </aside>

        
        <button class="nv-scrim" @click="drawer = false" aria-label="Tutup menu"></button>

        
        <div class="nv-main">
            
            <header class="nv-topbar">
                <div class="nv-topbar__left">
                    <button type="button" class="nv-btn nv-btn--icon nv-btn--ghost"
                        @click="sidebar = sidebar === 'open' ? 'closed' : 'open'; if(window.innerWidth <= 760) drawer = !drawer"
                        aria-label="Toggle menu">
                        <i data-lucide="panel-left"></i>
                    </button>
                    <nav class="nv-breadcrumb" aria-label="Breadcrumb">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nv-crumb-root">Admin</a>
                        <i data-lucide="chevron-right" class="nv-crumb-sep"></i>
                        <span aria-current="page"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></span>
                    </nav>
                </div>

                <div class="nv-topbar__right">
                    <div style="display: flex; align-items: center; gap: 8px;" class="nv-hide-sm">
                        <span style="font-size: var(--nv-text-sm); font-weight: 500; color: var(--nv-text)"><?php echo e($currentUser?->name); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentRole): ?>
                            <span class="nv-status <?php echo e($roleTone); ?>" style="font-size: 0.7rem; height: 20px; padding: 0 6px;">
                                <?php echo e($currentRole); ?>

                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="nv-divider-v nv-hide-sm"></div>

                    <a href="<?php echo e(route('admin.activity-log.index')); ?>" class="nv-btn nv-btn--icon nv-btn--ghost nv-hide-sm" title="Log Aktivitas">
                        <i data-lucide="bell"></i>
                    </a>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'Administrator')): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="nv-btn nv-btn--icon nv-btn--ghost nv-hide-sm" title="Manajemen Pengguna">
                            <i data-lucide="settings"></i>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <a href="<?php echo e(route('home')); ?>" class="nv-btn nv-btn--icon nv-btn--ghost" title="Lihat Landing Page" target="_blank">
                        <i data-lucide="home"></i>
                    </a>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline-flex; margin: 0;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="nv-btn nv-btn--ghost" title="Keluar">
                            <i data-lucide="log-out"></i>
                            <span class="nv-hide-sm">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            
            <main class="admin-content">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <i data-lucide="check"></i>
                        <span><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                    <div class="alert alert-error">
                        <i data-lucide="x-circle"></i>
                        <span><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>

</html>
<?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/admin/layout.blade.php ENDPATH**/ ?>