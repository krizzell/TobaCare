@extends('layouts.app')

@section('body')
<div class="min-h-screen bg-[#F8FAFC] flex antialiased text-slate-800 selection:bg-emerald-500 selection:text-white">
    
    <!-- Left Navigation Sidebar (ECOBASE Style) -->
    <aside id="admin-sidebar" 
           class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200/80 p-5 flex flex-col justify-between transition-transform duration-200 ease-in-out lg:translate-x-0 -translate-x-full shadow-lg lg:shadow-none">
        
        <div class="space-y-6">
            <!-- Brand Logo Header -->
            <div class="flex items-center justify-between px-2">
                <a href="/admin/dashboard" class="flex items-center space-x-2.5">
                    <img src="{{ asset('images/tobacare-logo.png') }}" alt="TobaCare" class="w-16 h-12 object-contain object-center">
                    <div>
                        <span class="text-base font-extrabold tracking-tight text-slate-900">TobaCare</span>
                        <span class="text-[10px] block font-semibold text-emerald-600 tracking-wider uppercase -mt-0.5">CIVIC PORTAL</span>
                    </div>
                </a>
                <!-- Close mobile drawer button -->
                <button type="button" onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Menu Tree -->
            <nav class="space-y-6 text-xs font-semibold">
                <!-- Group 1: Layanan & Triase -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Layanan & Triase</span>
                        <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    
                    <a id="side-link-overview" href="/admin/dashboard" 
                       class="side-item flex items-center px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 transition group">
                        <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-emerald-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Overview & Monitoring</span>
                    </a>

                    <a id="side-link-queue" href="/admin/reports" 
                       class="side-item flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 transition group">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-emerald-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>Antrean Verifikasi</span>
                        </div>
                        <span id="side-badge-queue" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Triase</span>
                    </a>

                    <a id="side-link-operator-tasks" href="/operator/reports" 
                       class="side-item hidden flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 transition group">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-amber-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Tugas Lapangan</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-700">Tugas</span>
                    </a>
                </div>

                <!-- Group 2: Monitoring & Operasional -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Operasional & Petugas</span>
                        <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <a href="javascript:void(0)" onclick="TobaCare.toast('Peta GIS sebaran wilayah siap dihubungkan.', 'info')"
                       class="side-item flex items-center px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 transition group">
                        <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-emerald-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Peta Sebaran Laporan</span>
                    </a>

                    <a href="javascript:void(0)" onclick="TobaCare.toast('Daftar operator aktif terintegrasi dengan form penugasan admin.', 'info')"
                       class="side-item flex items-center px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 transition group">
                        <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-emerald-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Petugas & Instansi</span>
                    </a>
                </div>

                <!-- Group 3: Sistem -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Konfigurasi</span>
                    </div>

                    <a href="javascript:void(0)" onclick="TobaCare.toast('Modul audit log keamanan aktif mencatat seluruh verifikasi.', 'info')"
                       class="side-item flex items-center px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 transition group">
                        <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-emerald-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Audit Log Sistem</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Sidebar Footer: Light/Dark Mode Switcher Pill (Matching ECOBASE Reference) -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <span class="text-xs font-semibold text-slate-600">Mode Tampilan</span>
            <div class="flex items-center p-1 rounded-xl bg-slate-100 border border-slate-200/80">
                <button type="button" class="p-1 rounded-lg bg-emerald-600 text-white shadow-2xs" title="Mode Terang">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <button type="button" onclick="TobaCare.toast('Mode gelap sedang disiapkan untuk rilis berikutnya.', 'info')" class="p-1 rounded-lg text-slate-400 hover:text-slate-600" title="Mode Gelap">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </div>
    </aside>

    <!-- Mobile Drawer Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs hidden lg:hidden"></div>

    <!-- Main Content Wrapper (With left margin for sidebar on desktop) -->
    <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
        
        <!-- Top App Bar (ECOBASE Header Style) -->
        <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <!-- Hamburger Menu on Mobile -->
                <button type="button" onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-slate-700 p-2 rounded-lg border border-slate-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <div>
                    <h2 id="topbar-title" class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                        TobaCare Civic Intelligence
                    </h2>
                </div>
            </div>

            <!-- Right Controls: Notification Bell + User Profile Chip (Like Reference) -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <!-- Notification Bell with Alert Dot -->
                <button type="button" onclick="TobaCare.toast('Tidak ada notifikasi darurat baru.', 'info')"
                        class="relative p-2 rounded-xl border border-slate-200 text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                </button>

                <!-- User Profile Chip (Matching ECOBASE Top-Right) -->
                <div class="flex items-center space-x-3 pl-2 sm:pl-3 border-l border-slate-200">
                    <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs shadow-2xs" id="nav-user-avatar">
                        AD
                    </div>
                    <div class="hidden sm:flex flex-col text-left text-xs">
                        <span id="nav-user-name" class="font-bold text-slate-800 leading-tight">Admin TobaCare</span>
                        <span id="nav-user-email" class="text-[11px] text-slate-400">admin@tobacare.test</span>
                    </div>
                    <button type="button" onclick="TobaCare.logout()" title="Keluar dari akun"
                            class="text-slate-400 hover:text-rose-600 p-1.5 rounded-lg hover:bg-rose-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-3.5 px-4 sm:px-6 lg:px-8 text-xs text-slate-400 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div>
                &copy; 2026 TobaCare Ã¢â‚¬â€ Sistem Informasi & Pengaduan Pelayanan Publik Terpadu Kab. Toba
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-slate-600 font-medium">Sistem Berjalan Normal</span>
            </div>
        </footer>

    </div>

</div>

@push('scripts')
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const isOpen = !sidebar.classList.contains('-translate-x-full');

        if (isOpen) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        } else {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }
    }

    // Role-based navigation and profile display
    document.addEventListener('DOMContentLoaded', () => {
        const token = TobaCare.getToken();
        const user = TobaCare.getUser();

        if (!token || !user) {
            window.location.href = '/login';
            return;
        }

        const nameEl = document.getElementById('nav-user-name');
        const emailEl = document.getElementById('nav-user-email');
        const avatarEl = document.getElementById('nav-user-avatar');
        const role = user.role?.name;

        if (nameEl) nameEl.textContent = user.name || 'Petugas';
        if (emailEl) emailEl.textContent = user.email || '';
        if (avatarEl) {
            const initials = (user.name || 'TC').split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            avatarEl.textContent = initials;
        }

        const currentPath = window.location.pathname;
        const linkOverview = document.getElementById('side-link-overview');
        const linkQueue = document.getElementById('side-link-queue');
        const linkOperator = document.getElementById('side-link-operator-tasks');

        // Style active links matching ECOBASE pill style (bg-emerald-50 text-emerald-700)
        const activeClass = 'side-item flex items-center px-3.5 py-2.5 rounded-xl bg-emerald-50 text-emerald-700 font-bold transition';

        if (role === 'admin') {
            if (linkOperator) linkOperator.remove();

            if (currentPath.includes('/admin/dashboard') || currentPath === '/admin') {
                if (linkOverview) linkOverview.className = activeClass;
            } else if (currentPath.includes('/admin/reports')) {
                if (linkQueue) linkQueue.className = activeClass;
            }
        } else if (role === 'operator') {
            if (linkOverview) linkOverview.remove();
            if (linkQueue) linkQueue.remove();
            if (linkOperator) {
                linkOperator.classList.remove('hidden');
                linkOperator.className = activeClass;
            }
        } else {
            TobaCare.toast('Akses khusus administrator dan petugas operasional.', 'error');
            setTimeout(() => TobaCare.logout(), 800);
        }
    });
</script>
@endpush
@endsection
