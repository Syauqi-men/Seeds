<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Panel Admin') | BRMP Aneka Kacang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="admin-wrapper">

        {{-- Sidebar --}}
        <aside class="sidebar">
            <div class="sidebar-brand">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                    stroke="rgba(255,255,255,0.7)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" />
                    <path d="M2 17l10 5 10-5" />
                    <path d="M2 12l10 5 10-5" />
                </svg>
                <div class="sidebar-brand-text">
                    Panel Admin<br>
                    <span class="sidebar-brand-sub">BRMP Aneka Kacang</span>
                </div>
            </div>

            <nav class="sidebar-nav">

                <div class="sidebar-section">Utama</div>
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                    Dashboard
                </a>

                {{-- Master Data — Administrator saja --}}
                @role('Administrator')
                <div class="sidebar-section">Master Data</div>
                <a href="{{ route('admin.seed-categories.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.seed-categories*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 3h18v4H3z" />
                        <path d="M3 10h18v4H3z" />
                        <path d="M3 17h18v4H3z" />
                    </svg>
                    Kategori Benih
                </a>

                <a href="{{ route('admin.workers.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.workers*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Data Pekerja
                </a>
                @endrole

                {{-- Pengolahan Benih — Administrator & Petugas Benih --}}
                @role('Administrator|Petugas Benih')
                <div class="sidebar-section">Pengolahan Benih</div>
                <a href="{{ route('admin.seeds.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.seeds*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8c0 0-2 2-2 4s2 4 2 4" />
                        <path d="M12 8c0 0 2 2 2 4s-2 4-2 4" />
                        <path d="M8 12h8" />
                    </svg>
                    Varietas Benih
                </a>

                <a href="{{ route('admin.seed-lots.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.seed-lots*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    </svg>
                    Lot Benih
                </a>

                <a href="{{ route('admin.production-processes.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.production-processes*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="16 3 21 3 21 8" />
                        <line x1="4" y1="20" x2="21" y2="3" />
                        <polyline points="21 16 21 21 16 21" />
                        <line x1="15" y1="15" x2="21" y2="21" />
                    </svg>
                    Proses Produksi
                </a>

                <a href="{{ route('admin.seed-mutations.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.seed-mutations*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v11m0 0H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4m0 0H5a2 2 0 0 0-2-2v0" />
                    </svg>
                    Mutasi Benih
                </a>

                <a href="{{ route('admin.lab-tests.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.lab-tests*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 3h6v6l4 10a2 2 0 0 1-1.9 2.7H6.9A2 2 0 0 1 5 19L9 9V3z" />
                        <line x1="9" y1="3" x2="15" y2="3" />
                        <line x1="7.5" y1="14" x2="16.5" y2="14" />
                    </svg>
                    Uji Lab
                </a>
                @endrole

                {{-- Persediaan — Administrator & Order Processor --}}
                @role('Administrator|Order Processor')
                <div class="sidebar-section">Persediaan</div>
                <a href="{{ route('admin.stock-transactions.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.stock-transactions*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="17 1 21 5 17 9" />
                        <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                        <polyline points="7 23 3 19 7 15" />
                        <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                    </svg>
                    Transaksi Stok
                </a>
                @endrole

                {{-- Pesanan - Semua Role Bisa Akses --}}
                @role('Administrator|Order Processor|Petugas Benih')
                <a href="{{ route('admin.orders.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                    Pesanan
                </a>
                @endrole

                {{-- Sistem — semua role --}}
                <div class="sidebar-section">Sistem</div>
                <a href="{{ route('admin.activity-log.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.activity-log*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Log Aktivitas
                </a>

                {{-- Manajemen Pengguna — Administrator saja --}}
                @role('Administrator')
                <a href="{{ route('admin.users.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        <line x1="19" y1="8" x2="23" y2="8"/>
                        <line x1="21" y1="6" x2="21" y2="10"/>
                    </svg>
                    Manajemen Pengguna
                </a>
                @endrole

            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}"
                    style="font-size:0.8rem;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:4px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Lihat Landing Page
                </a>
            </div>
        </aside>

        {{-- Main --}}
        <div class="admin-main">
            {{-- Topbar --}}
            <div class="admin-topbar">
                <div>
                    <span style="font-weight:600;color:var(--color-text)">@yield('title', 'Dashboard')</span>
                </div>
                <div style="display:flex;align-items:center;gap:var(--space-md)">
                    {{-- Nama + Badge Role --}}
                    <div style="display:flex;align-items:center;gap:6px">
                        <span style="font-size:0.85rem;color:var(--color-text-muted)">{{ Auth::user()->name }}</span>
                        @php $roleName = Auth::user()->roles->first()?->name; @endphp
                        @if($roleName)
                            <span class="badge {{ $roleName === 'Administrator' ? 'badge-ready' : ($roleName === 'Petugas Benih' ? 'badge-processing' : 'badge-quarantine') }}"
                                style="font-size:0.7rem">
                                {{ $roleName }}
                            </span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            {{-- Content --}}
            <div class="admin-content">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="15" y1="9" x2="9" y2="15" />
                            <line x1="9" y1="9" x2="15" y2="15" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>
