<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Stok Benih BRMP Aneka Kacang - Informasi ketersediaan benih Kedelai, Kacang Tanah, dan Kacang Hijau.">
    <title>@yield('title', 'BRMP Aneka Kacang') — Informasi Stok Benih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
<div class="page-wrapper">

    {{-- Navbar --}}
    <nav class="navbar" x-data="{ mobileOpen: false }">
        <div class="navbar-inner">
            <a href="{{ route('home') }}" class="navbar-brand">
                @if(file_exists(public_path('images/logo-brmp.png')))
                    <img src="{{ asset('images/logo-brmp.png') }}" alt="Logo BRMP" style="height:40px;width:auto">
                @else
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="14" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                        <path d="M16 8C12 8 9 12 9 16C9 20 12 24 16 24C20 24 23 20 23 16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="16" cy="16" r="3" fill="white"/>
                    </svg>
                @endif
                <div class="navbar-logo-text">
                    <span>BRMP Aneka Kacang</span>
                    <span class="subtitle">Balai Riset dan Modernisasi Pertanian</span>
                </div>
            </a>

            <div class="navbar-menu">
                <a href="{{ route('benih.index') }}" class="nav-link {{ request()->routeIs('benih*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8c0 0-2 2-2 4s2 4 2 4"/><path d="M12 8c0 0 2 2 2 4s-2 4-2 4"/><path d="M8 12h8"/></svg>
                    Benih
                </a>
                <a href="{{ route('lot-benih.index') }}" class="nav-link {{ request()->routeIs('lot-benih*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Lot Benih
                </a>
                @auth
                <a href="{{ route('admin.dashboard') }}" class="nav-icon-btn" title="Panel Admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
                @else
                <a href="{{ route('login') }}" class="nav-icon-btn" title="Login Admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
                @endauth
            </div>

            <button class="navbar-toggle" @click="mobileOpen = !mobileOpen" aria-label="Toggle menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div class="navbar-mobile" :class="{ 'open': mobileOpen }">
            <a href="{{ route('benih.index') }}" class="nav-link">Benih</a>
            <a href="{{ route('lot-benih.index') }}" class="nav-link">Lot Benih</a>
            @auth
            <a href="{{ route('admin.dashboard') }}" class="nav-link">Panel Admin</a>
            @else
            <a href="{{ route('login') }}" class="nav-link">Login Admin</a>
            @endauth
        </div>
    </nav>

    {{-- Main content --}}
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <p>&copy; {{ date('Y') }} BRMP Aneka Kacang. Data stok benih diperbarui secara berkala.</p>
    </footer>

</div>
@livewireScripts
</body>
</html>
