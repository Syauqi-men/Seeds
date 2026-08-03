<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — BRMP Aneka Kacang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Auth page specific styles ── */
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: #064E3B;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Background blobs */
        body::before {
            content: '';
            position: fixed;
            top: -20%;
            right: -15%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            left: -15%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6,95,70,0.4) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-card {
            background: white;
            width: 100%;
            max-width: 440px;
            padding: 2.5rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.35);
            position: relative;
            z-index: 1;
            animation: cardIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Accent strip at top */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 5px;
            background: linear-gradient(90deg, #047857, #10B981, #34D399);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo {
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
        }

        .auth-logo img {
            height: 56px;
            width: auto;
        }

        .auth-logo-placeholder {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #047857, #10B981);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .auth-title {
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: #064E3B;
            margin-bottom: 0.3rem;
        }

        .auth-subtitle {
            font-size: 0.82rem;
            color: #6B7280;
            line-height: 1.4;
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E8E3D8;
        }
        .auth-divider span {
            font-size: 0.72rem;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .form-group {
            margin-bottom: 1.1rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.35rem;
        }

        .form-control {
            width: 100%;
            padding: 0.65rem 0.875rem;
            border: 1.5px solid #D1D5DB;
            border-radius: 0;
            font-family: inherit;
            font-size: 0.9rem;
            color: #111827;
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-control:focus {
            border-color: #10B981;
            box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
        }

        .form-control.is-invalid {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
        }

        .form-error {
            font-size: 0.78rem;
            color: #EF4444;
            margin-top: 0.3rem;
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            margin-top: 0.25rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.82rem;
            color: #6B7280;
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #10B981;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.82rem;
            color: #059669;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #047857; }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            border: none;
            border-radius: 0;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(4,120,87,0.4);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #047857, #065F46);
            box-shadow: 0 6px 20px rgba(4,120,87,0.5);
            transform: translateY(-1px);
        }
        .btn-login:active {
            transform: translateY(0);
        }

        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
        }

        .auth-footer a {
            font-size: 0.82rem;
            color: #059669;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .auth-footer a:hover { color: #047857; }

        .session-status {
            padding: 0.7rem 1rem;
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        /* Decorative circles */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            opacity: 0.06;
        }
        .deco-1 { width: 180px; height: 180px; background: #10B981; top: -60px; right: -60px; }
        .deco-2 { width: 100px; height: 100px; background: #10B981; bottom: -30px; left: -30px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="deco-circle deco-1"></div>
        <div class="deco-circle deco-2"></div>

        {{-- Header / Logo --}}
        <div class="auth-header">
            <div class="auth-logo">
                @if(file_exists(public_path('images/logo-brmp.png')))
                    <img src="{{ asset('images/logo-brmp.png') }}" alt="Logo BRMP">
                @else
                    <div class="auth-logo-placeholder">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    </div>
                @endif
            </div>
            <h1 class="auth-title">BRMP Aneka Kacang</h1>
            <p class="auth-subtitle">Sistem Informasi Manajemen Stok Benih<br>Balai Riset dan Mekanisasi Pertanian</p>
        </div>

        <div class="auth-divider"><span>Login Administrator</span></div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email') }}"
                    placeholder="admin@brmp.go.id"
                    required
                    autofocus
                    autocomplete="username"
                >
                @if($errors->has('email'))
                    <div class="form-error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
                @if($errors->has('password'))
                    <div class="form-error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember_me">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                Masuk ke Panel Admin
            </button>
        </form>

        <div class="auth-footer">
            <a href="{{ route('benih.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke halaman publik
            </a>
        </div>
    </div>
</body>
</html>
