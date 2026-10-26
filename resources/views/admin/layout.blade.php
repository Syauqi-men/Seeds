<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin: @yield('title', 'Panel Sistem') | BRMP Aneka Kacang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="nv-shell" x-data="{ sidebar: window.innerWidth > 760 ? 'open' : 'closed', drawer: false }"
        :data-sidebar="sidebar" :data-drawer="drawer ? 'open' : undefined"
        x-on:keydown.escape.window="drawer = false">

        <aside class="nv-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="nv-sidebar__brand">
                <div class="nv-wordmark-mark">
                    <i data-lucide="sprout"></i>
                </div>
                <div class="nv-wordmark">
                    <strong>Panel Sistem</strong>
                    <span>BRMP Aneka Kacang</span>
                </div>
            </a>

            <nav class="nv-sidebar__nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="nv-nav-link"
                    {!! request()->routeIs('admin.dashboard') ? 'aria-current="page"' : '' !!}>
                    <i data-lucide="layout-dashboard"></i>
                    <span>Beranda</span>
                </a>

                {{-- Master Data: Administrator saja --}}
                @role('Administrator')
                    <details open class="nv-nav-group">
                        <summary>
                            <span>Master Data</span>
                            <i data-lucide="chevron-down" style="width: 12px; height: 12px;"></i>
                        </summary>
                        <a href="{{ route('admin.seed-categories.index') }}"
                            class="nv-nav-link"
                            {!! request()->routeIs('admin.seed-categories*') ? 'aria-current="page"' : '' !!}>
                            <i data-lucide="layers"></i>
                            <span>Kategori Benih</span>
                        </a>
                        <a href="{{ route('admin.workers.index') }}"
                            class="nv-nav-link"
                            {!! request()->routeIs('admin.workers*') ? 'aria-current="page"' : '' !!}>
                            <i data-lucide="users"></i>
                            <span>Data Pekerja</span>
                        </a>
                    </details>
                @endrole

                {{-- Pengolahan Benih: Administrator, Petugas Benih, Proses Produksi --}}
                @role('Administrator|Petugas Benih|Proses Produksi')
                    <details open class="nv-nav-group">
                        <summary>
                            <span>Pengolahan Benih</span>
                            <i data-lucide="chevron-down" style="width: 12px; height: 12px;"></i>
                        </summary>
                        @role('Administrator|Petugas Benih')
                            <a href="{{ route('admin.seeds.index') }}"
                                class="nv-nav-link"
                                {!! request()->routeIs('admin.seeds*') ? 'aria-current="page"' : '' !!}>
                                <i data-lucide="sprout"></i>
                                <span>Varietas Benih</span>
                            </a>
                            <a href="{{ route('admin.seed-lots.index') }}"
                                class="nv-nav-link"
                                {!! request()->routeIs('admin.seed-lots*') ? 'aria-current="page"' : '' !!}>
                                <i data-lucide="package"></i>
                                <span>Lot Benih</span>
                            </a>
                            <a href="{{ route('admin.seed-mutations.index') }}"
                                class="nv-nav-link"
                                {!! request()->routeIs('admin.seed-mutations*') ? 'aria-current="page"' : '' !!}>
                                <i data-lucide="arrow-left-right"></i>
                                <span>Mutasi Benih</span>
                            </a>
                            <a href="{{ route('admin.lab-tests.index') }}"
                                class="nv-nav-link"
                                {!! request()->routeIs('admin.lab-tests*') ? 'aria-current="page"' : '' !!}>
                                <i data-lucide="flask-conical"></i>
                                <span>Uji Lab</span>
                            </a>
                        @endrole
                        @role('Administrator|Proses Produksi')
                            <a href="{{ route('admin.production-processes.index') }}"
                                class="nv-nav-link"
                                {!! request()->routeIs('admin.production-processes*') ? 'aria-current="page"' : '' !!}>
                                <i data-lucide="cog"></i>
                                <span>Proses Produksi</span>
                            </a>
                        @endrole
                    </details>
                @endrole

                {{-- Persediaan: Administrator, Order Processor, Petugas Benih --}}
                @role('Administrator|Order Processor|Petugas Benih')
                    <details open class="nv-nav-group">
                        <summary>
                            <span>Persediaan</span>
                            <i data-lucide="chevron-down" style="width: 12px; height: 12px;"></i>
                        </summary>
                        @role('Administrator|Order Processor')
                            <a href="{{ route('admin.stock-transactions.index') }}"
                                class="nv-nav-link"
                                {!! request()->routeIs('admin.stock-transactions*') ? 'aria-current="page"' : '' !!}>
                                <i data-lucide="repeat"></i>
                                <span>Transaksi Stok</span>
                            </a>
                        @endrole
                        <a href="{{ route('admin.orders.index') }}"
                            class="nv-nav-link"
                            {!! request()->routeIs('admin.orders*') ? 'aria-current="page"' : '' !!}>
                            <i data-lucide="shopping-bag"></i>
                            <span>Pesanan</span>
                        </a>
                    </details>
                @endrole

                {{-- Sistem: semua role --}}
                <details open class="nv-nav-group">
                    <summary>
                        <span>Sistem</span>
                        <i data-lucide="chevron-down" style="width: 12px; height: 12px;"></i>
                    </summary>
                    <a href="{{ route('admin.activity-log.index') }}"
                        class="nv-nav-link"
                        {!! request()->routeIs('admin.activity-log*') ? 'aria-current="page"' : '' !!}>
                        <i data-lucide="file-text"></i>
                        <span>Log Aktivitas</span>
                    </a>
                    @role('Administrator')
                        <a href="{{ route('admin.users.index') }}"
                            class="nv-nav-link"
                            {!! request()->routeIs('admin.users*') ? 'aria-current="page"' : '' !!}>
                            <i data-lucide="user-plus"></i>
                            <span>Kelola Pengguna</span>
                        </a>
                    @endrole
                </details>
            </nav>
        </aside>

        <button class="nv-scrim" id="nv-scrim-btn" @click="drawer = false" aria-label="Tutup menu"></button>

        <div class="nv-main">
            @php
                $currentUser = Auth::user();
                $currentRole = $currentUser?->roles->first()?->name ?? 'Pengguna';
            @endphp
            <header class="nv-topbar">
                <div class="nv-topbar__left">
                    <button type="button" id="nv-sidebar-toggle" class="nv-btn nv-btn--icon nv-btn--ghost"
                        @click="sidebar = sidebar === 'open' ? 'closed' : 'open'; if(window.innerWidth <= 760) drawer = !drawer"
                        aria-label="Toggle menu">
                        <i data-lucide="panel-left"></i>
                    </button>
                    <nav class="nv-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('admin.dashboard') }}" class="nv-crumb-root">Sistem</a>
                        <i data-lucide="chevron-right" class="nv-crumb-sep"></i>
                        <span aria-current="page">@yield('title', 'Dashboard')</span>
                    </nav>
                </div>

                <div class="nv-topbar__right">
                    <div class="nv-user-menu" id="nv-export-menu">
                        <button type="button"
                            class="nv-btn"
                            id="nv-export-menu-btn"
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="nv-export-dropdown">
                            <i data-lucide="download"></i>
                            <span>Export</span>
                            <i data-lucide="chevron-down"></i>
                        </button>

                        <div class="nv-user-dropdown" id="nv-export-dropdown" role="menu" hidden>
                            <div class="nv-user-dropdown__header">
                                <strong class="nv-user-dropdown__name">Laporan Ketersediaan Benih</strong>
                                <span class="nv-user-dropdown__role">Rekap per varietas dan kelas</span>
                            </div>
                            <a href="{{ route('admin.reports.stock-availability.xlsx') }}" class="nv-user-dropdown__item" role="menuitem">
                                <i data-lucide="file-spreadsheet"></i>
                                <span>Excel (.xlsx)</span>
                            </a>
                            <a href="{{ route('admin.reports.stock-availability') }}" class="nv-user-dropdown__item" role="menuitem">
                                <i data-lucide="file-text"></i>
                                <span>CSV (.csv)</span>
                            </a>
                        </div>
                    </div>

                    <div class="nv-user-menu" id="nv-user-menu">
                        <button type="button"
                            class="nv-user-circle"
                            id="nv-user-menu-btn"
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-label="Menu Pengguna"
                            title="{{ $currentUser?->name }} ({{ $currentRole }})">
                            <i data-lucide="user"></i>
                        </button>

                        <div class="nv-user-dropdown" id="nv-user-dropdown" role="menu" hidden>
                            <div class="nv-user-dropdown__header">
                                <strong class="nv-user-dropdown__name">{{ $currentUser?->name ?? 'Pengguna' }}</strong>
                                <span class="nv-user-dropdown__role">{{ $currentRole }}</span>
                            </div>

                            <a href="{{ route('home') }}" class="nv-user-dropdown__item" role="menuitem">
                                <i data-lucide="home"></i>
                                <span>Lihat Landing Page</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="nv-user-dropdown__item nv-user-dropdown__item--danger" role="menuitem">
                                    <i data-lucide="log-out"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="admin-content">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i data-lucide="check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error">
                        <i data-lucide="x-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @livewireScripts
    <script>
        (function () {
            var menus = [
                { wrap: 'nv-export-menu', btn: 'nv-export-menu-btn', panel: 'nv-export-dropdown' },
                { wrap: 'nv-user-menu', btn: 'nv-user-menu-btn', panel: 'nv-user-dropdown' }
            ].map(function (m) {
                return {
                    wrap: document.getElementById(m.wrap),
                    btn: document.getElementById(m.btn),
                    panel: document.getElementById(m.panel)
                };
            }).filter(function (m) { return m.wrap && m.btn && m.panel; });

            function closeMenu(m) {
                m.panel.setAttribute('hidden', '');
                m.btn.setAttribute('aria-expanded', 'false');
            }

            menus.forEach(function (m) {
                m.btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var wasHidden = m.panel.hasAttribute('hidden');
                    menus.forEach(closeMenu);
                    if (wasHidden) {
                        m.panel.removeAttribute('hidden');
                        m.btn.setAttribute('aria-expanded', 'true');
                    }
                });
            });

            document.addEventListener('click', function (e) {
                menus.forEach(function (m) {
                    if (!m.wrap.contains(e.target)) closeMenu(m);
                });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') menus.forEach(closeMenu);
            });

            // Fallback toggle sidebar untuk halaman tanpa Livewire/Alpine
            var shell = document.querySelector('.nv-shell');
            var toggleBtn = document.getElementById('nv-sidebar-toggle');
            var scrimBtn = document.getElementById('nv-scrim-btn');
            if (shell && toggleBtn) {
                if (!shell.hasAttribute('data-sidebar')) {
                    shell.setAttribute('data-sidebar', window.innerWidth > 760 ? 'open' : 'closed');
                }
                toggleBtn.addEventListener('click', function () {
                    if (window.Alpine) return;
                    var current = shell.getAttribute('data-sidebar') || 'open';
                    shell.setAttribute('data-sidebar', current === 'open' ? 'closed' : 'open');
                    if (window.innerWidth <= 760) {
                        var isDrawer = shell.getAttribute('data-drawer') === 'open';
                        if (isDrawer) shell.removeAttribute('data-drawer');
                        else shell.setAttribute('data-drawer', 'open');
                    }
                });
                if (scrimBtn) {
                    scrimBtn.addEventListener('click', function () {
                        if (window.Alpine) return;
                        shell.removeAttribute('data-drawer');
                    });
                }
            }
        })();
    </script>
</body>

</html>
