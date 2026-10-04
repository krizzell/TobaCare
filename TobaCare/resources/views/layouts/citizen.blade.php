@extends('layouts.app')

@section('body')
<div class="min-h-screen bg-[#F8FAFC] flex flex-col antialiased text-slate-800 selection:bg-rose-500 selection:text-white">
    
    <!-- Top Civic Header for Citizens -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-40 shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Brand & Portal Name -->
                <div class="flex items-center space-x-3">
                    <a href="/" class="flex items-center space-x-2.5 group" title="Kembali ke Beranda Utama">
                        <img src="{{ asset('images/tobacare-logo.png') }}" alt="TobaCare" class="w-16 h-12 object-contain object-center">
                        <div>
                            <span class="text-lg font-bold tracking-tight text-slate-900 group-hover:text-rose-600 transition">TobaCare</span>
                            <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-[10px] font-semibold tracking-wider uppercase rounded bg-rose-50 text-rose-700 border border-rose-200">Portal Warga</span>
                        </div>
                    </a>

                    <!-- Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-1 ml-6 pl-6 border-l border-slate-200 text-sm font-semibold">
                        <a id="nav-home" href="/" 
                           class="px-3 py-1.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition flex items-center space-x-1">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Beranda</span>
                        </a>
                        <a id="nav-my-reports" href="/citizen/reports" 
                           class="px-3 py-1.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition">
                            Aspirasi Saya
                        </a>
                        <a id="nav-explore" href="/citizen/reports?explore=true" 
                           class="px-3 py-1.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition">
                            Jelajah Publik
                        </a>
                    </nav>
                </div>

                <!-- Right Action Buttons: Lapor Button + User Profile -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <!-- Create Report Button (Vibrant Call to Action) -->
                    <a href="/citizen/reports/create"
                       class="inline-flex items-center px-4 py-2 rounded-full font-semibold text-white text-xs sm:text-sm shadow-md shadow-orange-500/20 bg-linear-to-r from-[#FF4E20] via-[#FF5F2E] to-[#E92359] hover:from-[#E63F12] hover:to-[#CF1749] transition transform hover:scale-[1.02] cursor-pointer">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Lapor Sekarang</span>
                    </a>

                    <!-- Citizen Profile Chip -->
                    <div class="flex items-center space-x-2.5 pl-2 sm:pl-3 border-l border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xs shadow-2xs" id="citizen-user-avatar">
                            WU
                        </div>
                        <div class="hidden lg:flex flex-col text-left text-xs">
                            <span id="citizen-user-name" class="font-bold text-slate-800 leading-tight">Warga Uji</span>
                            <span class="text-[10px] text-slate-400">Masyarakat Pelapor</span>
                        </div>
                        <button type="button" onclick="openPasswordModal()" title="Atur password"
                                class="text-slate-400 hover:text-sky-600 p-1.5 rounded-lg hover:bg-sky-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zm-8 14a8 8 0 0116 0M19 8v6m3-3h-6" />
                            </svg>
                        </button>
                        <button type="button" onclick="TobaCare.logout()" title="Keluar"
                                class="text-slate-400 hover:text-rose-600 p-1.5 rounded-lg hover:bg-rose-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 py-6 sm:py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Civic Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-3">
            <div>
                &copy; 2026 Pemerintah Kabupaten Toba — Layanan Aspirasi & Pengaduan Fasilitas Publik.
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-slate-400">Layanan Darurat / Call Center: <strong class="text-slate-700">112</strong></span>
                <span class="text-slate-300">·</span>
                <a href="mailto:aspirasi@tobacare.test" class="hover:text-slate-700 transition">Bantuan Warga</a>
            </div>
        </div>
    </footer>

</div>

<!-- Password Modal -->
<div id="password-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs items-center justify-center p-4" onclick="closePasswordModal()">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4" onclick="event.stopPropagation()">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Atur Password Manual</h2>
            <p id="password-modal-description" class="text-xs text-slate-500 mt-1 leading-relaxed">
                Buat password agar Anda bisa masuk tanpa Google.
            </p>
        </div>
        <form id="password-form" class="space-y-3" onsubmit="savePassword(event)">
            <div id="current-password-field" class="hidden">
                <label for="current-password" class="block text-xs font-semibold text-slate-700 mb-1">Password saat ini</label>
                <input id="current-password" type="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
            </div>
            <div>
                <label for="new-password" class="block text-xs font-semibold text-slate-700 mb-1">Password baru</label>
                <input id="new-password" type="password" minlength="8" maxlength="72" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
            </div>
            <div>
                <label for="new-password-confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi password baru</label>
                <input id="new-password-confirmation" type="password" minlength="8" maxlength="72" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
            </div>
            <p id="password-error" class="hidden text-xs text-rose-600"></p>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closePasswordModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Batal</button>
                <button type="submit" id="save-password-button" class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-sky-600 hover:bg-sky-700">Simpan Password</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openPasswordModal() {
        const user = TobaCare.getUser();
        const currentField = document.getElementById('current-password-field');
        const modal = document.getElementById('password-modal');
        currentField.classList.toggle('hidden', Boolean(user?.password_login_enabled));
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePasswordModal() {
        const modal = document.getElementById('password-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('password-form').reset();
        document.getElementById('password-error').classList.add('hidden');
    }

    async function savePassword(event) {
        event.preventDefault();
        const button = document.getElementById('save-password-button');
        const error = document.getElementById('password-error');
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmation = document.getElementById('new-password-confirmation').value;

        error.classList.add('hidden');
        if (newPassword !== confirmation) {
            error.textContent = 'Konfirmasi password baru tidak cocok.';
            error.classList.remove('hidden');
            return;
        }

        button.disabled = true;
        try {
            const data = await TobaCare.api('/api/v1/auth/password', {
                method: 'POST',
                body: JSON.stringify({
                    current_password: currentPassword || undefined,
                    password: newPassword,
                    password_confirmation: confirmation
                })
            });
            const user = TobaCare.getUser() || {};
            user.password_login_enabled = true;
            TobaCare.setAuth(TobaCare.getToken(), user);
            closePasswordModal();
            TobaCare.toast(data.message, 'success');
        } catch (err) {
            error.textContent = err.data?.error?.message || err.message || 'Password gagal disimpan.';
            error.classList.remove('hidden');
        } finally {
            button.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const token = TobaCare.getToken();
        const user = TobaCare.getUser();

        if (!token || !user) {
            window.location.href = '/login';
            return;
        }

        const nameEl = document.getElementById('citizen-user-name');
        const avatarEl = document.getElementById('citizen-user-avatar');
        if (nameEl) nameEl.textContent = user.name || 'Warga Toba';
        if (avatarEl) {
            const initials = (user.name || 'W').split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            avatarEl.textContent = initials;
        }

        // Active link highlight
        const currentPath = window.location.pathname;
        const urlParams = new URLSearchParams(window.location.search);
        const isExplore = urlParams.get('explore') === 'true';

        const linkMy = document.getElementById('nav-my-reports');
        const linkExp = document.getElementById('nav-explore');

        if (isExplore) {
            if (linkExp) linkExp.className = 'px-3 py-1.5 rounded-xl bg-slate-900 text-white font-semibold transition';
        } else if (currentPath.startsWith('/citizen/reports')) {
            if (linkMy) linkMy.className = 'px-3 py-1.5 rounded-xl bg-slate-900 text-white font-semibold transition';
        }

        if (urlParams.get('setup_password') === '1' && user.password_login_enabled === false) {
            openPasswordModal();
        }
    });
</script>
@endpush
@endsection
