<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | BRMP Aneka Kacang</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    :root {
      /* Core Palette */
      --lichen-canvas: #DCE3DC;
      --specimen-sheet: #EFF3EE;
      --chlorophyll-ink: #192820;
      --herbarium-slate: #4A5E52;
      --canopy-pine: #234B36;

      /* Supporting Tones */
      --input-surface: #F7FAF6;
      --border-hairline: #B8C6BA;
      --border-strong: #7A9080;
      --canopy-pine-hover: #1A3A29;
      --error-ink: #8C2D25;
      --error-surface: #F9ECEA;

      /* Typography */
      --font-display: 'Newsreader', Georgia, serif;
      --font-body: 'Instrument Sans', -apple-system, BlinkMacSystemFont, sans-serif;

      /* Type Scale */
      --size-sm: 0.875rem;
      --size-base: 1rem;
      --size-lg: 1.25rem;
      --size-xl: 1.75rem;
    }

    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100dvh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      background-color: var(--lichen-canvas);
      background-image:
        radial-gradient(circle at 18% 15%, rgba(239, 243, 238, 0.78) 0%, transparent 48%),
        radial-gradient(circle at 85% 82%, rgba(184, 198, 186, 0.45) 0%, transparent 52%);
      color: var(--chlorophyll-ink);
      font-family: var(--font-body);
      font-size: var(--size-base);
      line-height: 1.5;
      position: relative;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    /* Background */
    .topography-backdrop {
      position: fixed;
      inset: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
      opacity: 0.42;
    }

    /* Container */
    .seed-ledger-sheet {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 780px;
      background-color: var(--specimen-sheet);
      border: 1px solid var(--border-strong);
      padding: 0.375rem;
      box-shadow: 0 20px 45px -18px rgba(25, 40, 32, 0.14);
      animation: sheet-settle 420ms cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    @keyframes sheet-settle {
      from {
        opacity: 0;
        transform: translateY(8px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .sheet-inner-frame {
      border: 1px solid var(--border-hairline);
      display: grid;
      grid-template-columns: 1fr;
    }

    @media (min-width: 700px) {
      .sheet-inner-frame {
        grid-template-columns: 11fr 13fr;
      }
    }

    /* Kolom Kiri */
    .institution-aside {
      padding: 2rem;
      border-bottom: 1px solid var(--border-hairline);
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      text-align: center;
      background-color: rgba(220, 227, 220, 0.28);
    }

    @media (min-width: 700px) {
      .institution-aside {
        padding: 2.5rem 2.5rem 2.75rem;
        border-bottom: none;
        border-right: 1px solid var(--border-hairline);
      }
    }

    .institution-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.2rem;
      margin-bottom: 2.25rem;
    }

    .institution-title {
      font-family: var(--font-body);
      font-size: 2rem;
      font-weight: 700;
      color: var(--chlorophyll-ink);
      line-height: 1.05;
      letter-spacing: -0.02em;
    }

    .institution-subtitle {
      font-family: var(--font-body);
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--chlorophyll-ink);
      line-height: 1.2;
      letter-spacing: -0.015em;
    }

    /* Logo */
    .botanical-plate {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .botanical-plate img {
      width: 148px;
      height: auto;
      object-fit: contain;
    }

    /* Kolom Kanan */
    .auth-column {
      padding: 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    @media (min-width: 700px) {
      .auth-column {
        padding: 2.75rem 2.5rem;
      }
    }

    .auth-heading {
      font-family: var(--font-heading);
      font-size: var(--size-l);
      font-weight: 700;
      line-height: 1.2;
      letter-spacing: -0.015em;
      color: var(--chlorophyll-ink);
      margin-bottom: 1.5rem;
    }

    /* Status Banner */
    .status-banner {
      display: none;
      padding: 0.75rem 0.875rem;
      margin-bottom: 1.25rem;
      background-color: var(--error-surface);
      border-left: 3px solid var(--error-ink);
      color: var(--error-ink);
      font-size: var(--size-sm);
    }

    .status-banner[data-active="true"] {
      display: block;
    }

    .status-banner--success {
      background-color: #E1ECE4;
      border-left-color: var(--canopy-pine);
      color: var(--chlorophyll-ink);
    }

    /* Form */
    .field-item {
      margin-bottom: 1.25rem;
    }

    .field-label {
      display: block;
      font-size: var(--size-sm);
      font-weight: 500;
      color: var(--chlorophyll-ink);
      margin-bottom: 0.375rem;
    }

    .field-control-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }

    .text-input {
      width: 100%;
      height: 2.75rem;
      padding: 0 0.875rem;
      background-color: var(--input-surface);
      border: 1px solid var(--border-strong);
      border-radius: 3px;
      font-family: var(--font-body);
      font-size: var(--size-base);
      color: var(--chlorophyll-ink);
      transition: border-color 140ms ease, background-color 140ms ease;
    }

    .text-input--with-toggle {
      padding-right: 3rem;
    }

    .text-input::placeholder {
      color: #788B7E;
    }

    .text-input:focus-visible {
      outline: 2px solid var(--canopy-pine);
      outline-offset: 1px;
      border-color: var(--canopy-pine);
      background-color: #FFFFFF;
    }

    .text-input[aria-invalid="true"] {
      border-color: var(--error-ink);
      background-color: var(--error-surface);
    }

    .password-toggle {
      position: absolute;
      right: 0.125rem;
      top: 50%;
      transform: translateY(-50%);
      width: 2.5rem;
      height: 2.5rem;
      display: grid;
      place-items: center;
      background: transparent;
      border: 1px solid transparent;
      border-radius: 2px;
      cursor: pointer;
      color: var(--herbarium-slate);
      transition: color 140ms ease, background-color 140ms ease;
    }

    .password-toggle:hover {
      color: var(--chlorophyll-ink);
      background-color: rgba(74, 94, 82, 0.08);
    }

    .password-toggle:focus-visible {
      outline: 2px solid var(--canopy-pine);
      outline-offset: 1px;
    }

    .password-toggle .lucide,
    .password-toggle svg {
      width: 18px;
      height: 18px;
    }

    .field-feedback {
      display: none;
      margin-top: 0.375rem;
      font-size: var(--size-sm);
      color: var(--error-ink);
    }

    .field-feedback[data-active="true"] {
      display: block;
    }

    .primary-action {
      width: 100%;
      height: 2.875rem;
      margin-top: 0.5rem;
      padding: 0 1.25rem;
      background-color: var(--canopy-pine);
      color: var(--specimen-sheet);
      border: 1px solid var(--canopy-pine);
      border-radius: 3px;
      font-family: var(--font-body);
      font-size: var(--size-base);
      font-weight: 500;
      cursor: pointer;
      transition: background-color 140ms ease;
    }

    .primary-action:hover:not(:disabled) {
      background-color: var(--canopy-pine-hover);
    }

    .primary-action:focus-visible {
      outline: 2px solid var(--chlorophyll-ink);
      outline-offset: 2px;
    }

    .primary-action:disabled {
      opacity: 0.65;
      cursor: wait;
    }

    /* Navigasi */
    .back-nav {
      margin-top: 1.5rem;
      padding-top: 1rem;
      border-top: 1px solid var(--border-hairline);
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      min-height: 2.75rem;
      font-size: var(--size-sm);
      font-weight: 500;
      color: var(--herbarium-slate);
      text-decoration: none;
      padding: 0.25rem 0;
      border-radius: 2px;
      transition: color 140ms ease;
    }

    .back-link:hover {
      color: var(--chlorophyll-ink);
    }

    .back-link:focus-visible {
      outline: 2px solid var(--canopy-pine);
      outline-offset: 4px;
    }

    .back-link .lucide,
    .back-link svg {
      width: 16px;
      height: 16px;
      flex-shrink: 0;
    }

    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation: none !important;
        transition: none !important;
      }
    }
  </style>
</head>
<body>

  <svg class="topography-backdrop" viewBox="0 0 1440 900" fill="none" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
    <path d="M-120 180 C 240 90, 520 290, 890 140 C 1150 40, 1340 190, 1560 110" stroke="#4A5E52" stroke-opacity="0.12" stroke-width="1.2"/>
    <path d="M-120 340 C 310 210, 610 420, 980 260 C 1210 160, 1390 310, 1560 240" stroke="#4A5E52" stroke-opacity="0.10" stroke-width="1.2"/>
    <path d="M-120 520 C 190 430, 580 640, 940 470 C 1180 350, 1360 490, 1560 430" stroke="#4A5E52" stroke-opacity="0.12" stroke-width="1.2"/>
    <path d="M-120 710 C 280 610, 670 790, 1060 630 C 1260 540, 1410 670, 1560 610" stroke="#4A5E52" stroke-opacity="0.09" stroke-width="1.2"/>
  </svg>

  <main class="seed-ledger-sheet">
    <div class="sheet-inner-frame">

      <aside class="institution-aside" aria-label="Informasi instansi">
        <div class="institution-header">
          <span class="institution-title">BRMP</span>
          <span class="institution-subtitle">Aneka Kacang</span>
        </div>

        <div class="botanical-plate">
          @if(file_exists(public_path('images/logo-brmp.png')))
            <img src="{{ asset('images/logo-brmp.png') }}" alt="Logo BRMP Aneka Kacang">
          @else
            <i data-lucide="layers" style="width:64px;height:64px;color:var(--canopy-pine);"></i>
          @endif
        </div>
      </aside>

      <section class="auth-column" aria-labelledby="login-title">
        <h1 id="login-title" class="auth-heading">Masuk ke Panel Sistem</h1>

        @if (session('status'))
          <div id="status-banner" class="status-banner status-banner--success" role="status" aria-live="polite" data-active="true">
            {{ session('status') }}
          </div>
        @endif

        @if (session('error'))
          <div id="status-error-banner" class="status-banner" role="alert" aria-live="polite" data-active="true">
            {{ session('error') }}
          </div>
        @endif

        <form id="brmp-login-form" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="field-item">
            <label for="email" class="field-label">Email</label>
            <div class="field-control-wrap">
              <input
                type="email"
                id="email"
                name="email"
                class="text-input"
                value="{{ old('email') }}"
                placeholder="admin@brmp.go.id"
                autocomplete="username"
                required
                autofocus
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                aria-describedby="email-feedback"
              />
            </div>
            <p id="email-feedback" class="field-feedback" data-active="{{ $errors->has('email') ? 'true' : 'false' }}">
              {{ $errors->first('email') }}
            </p>
          </div>

          <div class="field-item">
            <label for="password" class="field-label">Password</label>
            <div class="field-control-wrap">
              <input
                type="password"
                id="password"
                name="password"
                class="text-input text-input--with-toggle"
                placeholder="••••••••"
                autocomplete="current-password"
                required
                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                aria-describedby="password-feedback"
              />
              <button
                type="button"
                class="password-toggle"
                aria-label="Lihat atau sembunyikan password"
                onclick="toggleLoginPassword()"
              >
                <i data-lucide="eye" id="login-eye-open"></i>
                <i data-lucide="eye-off" id="login-eye-slash" style="display:none"></i>
              </button>
            </div>
            <p id="password-feedback" class="field-feedback" data-active="{{ $errors->has('password') ? 'true' : 'false' }}">
              {{ $errors->first('password') }}
            </p>
          </div>

          <button type="submit" id="submit-action" class="primary-action">
            Masuk
          </button>
        </form>

        <nav class="back-nav" aria-label="Navigasi halaman publik">
          <a href="{{ route('benih.index') }}" class="back-link">
            <i data-lucide="arrow-left" aria-hidden="true"></i>
            <span>Kembali ke halaman publik</span>
          </a>
        </nav>
      </section>

    </div>
  </main>

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
