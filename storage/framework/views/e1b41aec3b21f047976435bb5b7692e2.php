<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — BRMP Aneka Kacang</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body {
            background: var(--nv-surface-muted);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .auth-card {
            background: var(--nv-surface);
            width: 100%;
            max-width: 420px;
            border: 1px solid var(--nv-border);
            border-radius: var(--nv-radius-lg);
            box-shadow: var(--nv-shadow-lg);
            padding: 2.5rem;
            animation: nv-reveal var(--nv-dur-panel) var(--nv-ease) both;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-logo {
            width: 52px; height: 52px;
            margin: 0 auto 1rem;
            border-radius: var(--nv-radius);
            background: var(--nv-surface-dark);
            display: grid; place-items: center;
            color: #fff;
        }
        .auth-logo img {
            width: 100%; height: 100%; object-fit: contain;
            border-radius: var(--nv-radius); background: #fff;
        }
        .auth-title {
            font-family: var(--nv-font);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--nv-text);
            margin-bottom: 0.25rem;
        }
        .auth-subtitle {
            font-size: var(--nv-text-sm);
            color: var(--nv-text-muted);
            line-height: 1.5;
        }
        .auth-divider {
            display: flex; align-items: center; gap: 10px;
            margin: 1.5rem 0;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; height: 1px; background: var(--nv-border);
        }
        .auth-divider span {
            font-size: var(--nv-text-xs); color: var(--nv-text-subtle);
            white-space: nowrap;
        }
        .auth-form .form-group { margin-bottom: 1rem; }
        .auth-form .form-label {
            display: block;
            font-size: var(--nv-text-sm);
            font-weight: 500;
            color: var(--nv-text);
            margin-bottom: 0.35rem;
        }
        .auth-form .form-control {
            width: 100%; height: 40px;
            padding: 0 12px;
            border: 1px solid var(--nv-border);
            border-radius: var(--nv-radius-sm);
            font: inherit; font-size: var(--nv-text-md);
            color: var(--nv-text);
            box-shadow: var(--nv-shadow-sm);
            transition: border-color var(--nv-dur-feedback) var(--nv-ease), box-shadow var(--nv-dur-feedback) var(--nv-ease);
        }
        .auth-form .form-control:hover { border-color: var(--nv-border-strong); }
        .auth-form .form-control:focus { outline: none; border-color: var(--nv-accent); box-shadow: var(--nv-focus); }
        .auth-form .form-control.is-invalid { border-color: var(--nv-danger); box-shadow: 0 0 0 3px rgba(220,38,38,.12); }
        .form-error { font-size: var(--nv-text-xs); color: var(--nv-danger); margin-top: 4px; }
        .password-wrapper { position: relative; }
        .password-wrapper .form-control { padding-right: 40px; }
        .password-toggle {
            position: absolute; right: 2px; top: 50%; transform: translateY(-50%);
            width: 36px; height: 36px;
            display: grid; place-items: center;
            background: none; border: 0; cursor: pointer;
            color: var(--nv-text-subtle);
            border-radius: var(--nv-radius-sm);
            transition: color var(--nv-dur-feedback) var(--nv-ease);
        }
        .password-toggle:hover { color: var(--nv-text-muted); }
        .password-toggle .lucide { width: 16px; height: 16px; }
        .btn-login {
            width: 100%; height: 40px;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            background: var(--nv-surface-dark); color: #fff;
            border: 1px solid var(--nv-surface-dark); border-radius: var(--nv-radius-sm);
            font: inherit; font-size: var(--nv-text-md); font-weight: 600;
            cursor: pointer;
            box-shadow: var(--nv-shadow-sm);
            transition: background var(--nv-dur-feedback) var(--nv-ease), transform var(--nv-dur-feedback) var(--nv-ease);
            margin-top: 0.5rem;
        }
        .btn-login:hover { background: #000; }
        .btn-login:active { transform: translateY(1px); }
        .session-status {
            padding: 10px 14px; margin-bottom: 1rem;
            background: var(--nv-success-soft); color: #065F46;
            border: 1px solid #C9F0DD; border-radius: var(--nv-radius-sm);
            font-size: var(--nv-text-sm);
        }
        .auth-footer {
            margin-top: 1.5rem; text-align: center;
        }
        .auth-footer a {
            font-size: var(--nv-text-sm); color: var(--nv-text-muted);
            display: inline-flex; align-items: center; gap: 4px;
            font-weight: 500;
            transition: color var(--nv-dur-feedback) var(--nv-ease);
        }
        .auth-footer a:hover { color: var(--nv-text); }
        .auth-footer a .lucide { width: 14px; height: 14px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(file_exists(public_path('images/logo-brmp.png'))): ?>
                    <img src="<?php echo e(asset('images/logo-brmp.png')); ?>" alt="Logo BRMP">
                <?php else: ?>
                    <i data-lucide="layers" style="width:24px;height:24px;"></i>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <h1 class="auth-title">BRMP Aneka Kacang</h1>
            <p class="auth-subtitle">Sistem Informasi Manajemen Stok Benih<br>Balai Riset dan Pengujian Tanaman</p>
        </div>

        <div class="auth-divider"><span>Masuk ke panel admin</span></div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
            <div class="session-status"><?php echo e(session('status')); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="auth-form">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label" for="email"><i data-lucide="mail" style="width:14px;height:14px;vertical-align:-2px;margin-right:4px;"></i>Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('email')); ?>" placeholder="admin@brmp.go.id" required autofocus autocomplete="username">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('email')): ?>
                    <div class="form-error"><?php echo e($errors->first('email')); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="password"><i data-lucide="lock" style="width:14px;height:14px;vertical-align:-2px;margin-right:4px;"></i>Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>" placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="password-toggle" tabindex="-1" onclick="toggleLoginPassword()">
                        <i data-lucide="eye" id="login-eye-open"></i>
                        <i data-lucide="eye-off" id="login-eye-slash" style="display:none"></i>
                    </button>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('password')): ?>
                    <div class="form-error"><?php echo e($errors->first('password')); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <button type="submit" class="btn-login">
                <i data-lucide="log-in" style="width:16px;height:16px;"></i>
                Masuk
            </button>
        </form>

        <div class="auth-footer">
            <a href="<?php echo e(route('benih.index')); ?>">
                <i data-lucide="chevron-left"></i>
                Kembali ke halaman publik
            </a>
        </div>
    </div>

    <script>
        function toggleLoginPassword() {
            var input = document.getElementById('password');
            var eyeOpen = document.getElementById('login-eye-open');
            var eyeSlash = document.getElementById('login-eye-slash');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeSlash.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeSlash.style.display = 'none';
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/auth/login.blade.php ENDPATH**/ ?>