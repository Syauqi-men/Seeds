<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Stok Benih BRMP Aneka Kacang - Informasi ketersediaan benih Kedelai, Kacang Tanah, dan Kacang Hijau.">
    <title><?php echo $__env->yieldContent('title', 'BRMP Aneka Kacang'); ?> — Informasi Stok Benih</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body>
<div class="page-wrapper">

    
    <nav class="navbar" x-data="{ mobileOpen: false }">
        <div class="navbar-inner">
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(file_exists(public_path('images/logo-brmp.png'))): ?>
                    <img src="<?php echo e(asset('images/logo-brmp.png')); ?>" alt="Logo BRMP" style="height:40px;width:auto">
                <?php else: ?>
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="14" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                        <path d="M16 8C12 8 9 12 9 16C9 20 12 24 16 24C20 24 23 20 23 16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="16" cy="16" r="3" fill="white"/>
                    </svg>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="navbar-logo-text">
                    <span>BRMP Aneka Kacang</span>
                    <span class="subtitle">Balai Riset dan Modernisasi Pertanian</span>
                </div>
            </a>

            <div class="navbar-menu">
                <a href="<?php echo e(route('benih.index')); ?>" class="nav-link <?php echo e(request()->routeIs('benih*') ? 'active' : ''); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8c0 0-2 2-2 4s2 4 2 4"/><path d="M12 8c0 0 2 2 2 4s-2 4-2 4"/><path d="M8 12h8"/></svg>
                    Benih
                </a>
                <a href="<?php echo e(route('lot-benih.index')); ?>" class="nav-link <?php echo e(request()->routeIs('lot-benih*') ? 'active' : ''); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Lot Benih
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-icon-btn" title="Panel Admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
                <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="nav-icon-btn" title="Login Admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <button class="navbar-toggle" @click="mobileOpen = !mobileOpen" aria-label="Toggle menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>

        
        <div class="navbar-mobile" :class="{ 'open': mobileOpen }">
            <a href="<?php echo e(route('benih.index')); ?>" class="nav-link">Benih</a>
            <a href="<?php echo e(route('lot-benih.index')); ?>" class="nav-link">Lot Benih</a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">Panel Admin</a>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="nav-link">Login Admin</a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </nav>

    
    <main class="main-content">
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    
    <footer class="footer">
        <p>&copy; <?php echo e(date('Y')); ?> BRMP Aneka Kacang. Data stok benih diperbarui secara berkala.</p>
    </footer>

</div>
<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/landing/layout.blade.php ENDPATH**/ ?>