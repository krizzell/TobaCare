@extends('layouts.app')

@section('title', 'Sign In Ã¢â‚¬â€ TobaCare')

@section('body')
<div class="min-h-screen bg-[#ecebe8] text-slate-800 flex items-center justify-center p-3 sm:p-6 lg:p-10 antialiased selection:bg-rose-500 selection:text-white">
    <!-- Main Card Container matching reference layout -->
    <div class="w-full max-w-300 bg-white rounded-3xl lg:rounded-[2.5rem] shadow-2xl border border-slate-200/70 overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-170">
        
        <!-- LEFT PANE: Dark Brand & Visual Hero (Like Reference) -->
        <div class="lg:col-span-6 xl:col-span-7 bg-[#171412] text-white p-8 sm:p-12 lg:p-14 flex flex-col justify-between relative overflow-hidden">
            <!-- Concentric Circular Radar/Ripple Lines (Exact reference detail) -->
            <div class="absolute -right-24 top-1/2 -translate-y-1/2 w-120 h-120 rounded-full border border-white/5 pointer-events-none"></div>
            <div class="absolute -right-12 top-1/2 -translate-y-1/2 w-90 h-90 rounded-full border border-white/7 pointer-events-none"></div>
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-60 h-60 rounded-full border border-white/9 pointer-events-none"></div>
            <div class="absolute -left-20 -top-20 w-80 h-80 rounded-full bg-rose-500/5 blur-3xl pointer-events-none"></div>

            <!-- Top Tagline -->
            <div class="relative z-10">
                <p class="text-xs sm:text-sm font-light text-slate-300/80 tracking-wide">
                    Sistem Pelayanan Terpadu & Aspirasi Publik Ã¢â‚¬â€ Kabupaten Toba
                </p>
            </div>

            <!-- Hero Headline & Phone Mockup Visual -->
            <div class="my-auto py-8 sm:py-12 relative z-10 grid grid-cols-1 xl:grid-cols-12 gap-8 items-center">
                <!-- Left Title -->
                <div class="xl:col-span-6 space-y-4">
                    <h1 class="text-3xl sm:text-4xl xl:text-5xl font-extrabold tracking-tight text-white leading-[1.15]">
                        Aspirasi warga,<br>
                        <span class="text-transparent bg-clip-text bg-linear-to-r from-amber-400 via-rose-400 to-rose-300">nyata aksinya</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-sm">
                        Platform pelaporan kerusakan infrastruktur, kebersihan, dan ketertiban umum dengan verifikasi akurat dan tindak lanjut terukur.
                    </p>
                </div>

                <!-- Right / Center Phone Mockup (Pixel-perfect recreation of reference visual) -->
                <div class="xl:col-span-6 flex justify-center relative">
                    <div class="w-65 sm:w-68.75 bg-[#0c0d0f] rounded-[2.2rem] p-2.5 border-4 border-[#2c2d33] shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] transform -rotate-1 hover:rotate-0 transition-transform duration-500 select-none">
                        <!-- Screen -->
                        <div class="bg-[#141519] rounded-[1.7rem] p-3.5 text-white overflow-hidden relative border border-white/10 font-sans">
                            <!-- Dynamic Island Notch -->
                            <div class="w-16 h-3.5 bg-black rounded-full mx-auto mb-3 flex items-center justify-center">
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-800"></div>
                            </div>

                            <!-- Screen Header -->
                            <div class="flex items-center justify-between text-[11px] text-slate-400 font-medium mb-1">
                                <span>Minggu 1-7 Okt</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </div>

                            <!-- Big Number Metric -->
                            <div class="text-2xl font-bold tracking-tight text-white flex items-baseline space-x-1">
                                <span>897</span>
                                <span class="text-[10px] text-slate-400 font-normal">laporan tuntas</span>
                            </div>

                            <!-- Mini Bar Chart (Matches Payoneer reference chart) -->
                            <div class="mt-3.5 mb-3 bg-white/5 rounded-xl p-2.5 border border-white/5">
                                <div class="h-16 flex items-end justify-between gap-1.5 px-1 pb-1">
                                    <div class="w-full bg-white/80 rounded-t h-[45%]"></div>
                                    <div class="w-full bg-white/80 rounded-t h-[65%]"></div>
                                    <div class="w-full bg-white/80 rounded-t h-[50%]"></div>
                                    <div class="w-full bg-white/80 rounded-t h-[80%]"></div>
                                    <!-- Highlighted active bar with pill badge -->
                                    <div class="w-full relative flex flex-col items-center">
                                        <span class="absolute -top-4 text-[9px] bg-rose-500 text-white px-1 rounded font-bold shadow">120</span>
                                        <div class="w-full bg-linear-to-t from-orange-500 to-rose-500 rounded-t h-14"></div>
                                    </div>
                                    <div class="w-full bg-white/80 rounded-t h-[70%]"></div>
                                    <div class="w-full bg-white/80 rounded-t h-[40%]"></div>
                                </div>
                                <div class="flex justify-between text-[8px] text-slate-400 font-mono mt-1 px-1">
                                    <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span class="text-rose-400 font-bold">Kam</span><span>Jum</span><span>Sab</span>
                                </div>
                            </div>

                            <!-- Quick Categories -->
                            <div class="space-y-1.5 text-[10px]">
                                <div class="p-2 rounded-lg bg-white/5 border border-white/5 flex items-center justify-between">
                                    <span class="text-slate-300">Jalan & Jembatan</span>
                                    <span class="font-semibold text-emerald-400">412 Selesai</span>
                                </div>
                                <div class="p-2 rounded-lg bg-white/5 border border-white/5 flex items-center justify-between">
                                    <span class="text-slate-300">Penerangan Jalan</span>
                                    <span class="font-semibold text-sky-400">285 Selesai</span>
                                </div>
                            </div>

                            <!-- Phone Bottom Bar with Center Ring Icon -->
                            <div class="mt-3 pt-2 border-t border-white/10 flex items-center justify-around text-slate-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <!-- Center multi-color ring -->
                                <div class="w-4 h-4 rounded-full p-0.5 bg-linear-to-tr from-amber-400 via-rose-500 to-sky-400">
                                    <div class="w-full h-full bg-[#141519] rounded-full"></div>
                                </div>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Left Badge (Like the small circle badge in reference) -->
            <div class="relative z-10 flex items-center space-x-2 text-xs text-slate-400">
                <div class="w-6 h-6 rounded-full border border-white/20 flex items-center justify-center text-[10px] text-amber-400 font-bold">
                    Ã¢Å“â€œ
                </div>
                <span>Pemerintah Kabupaten Toba Ã¢â‚¬â€ Layanan Aspirasi Terpadu</span>
            </div>
        </div>

        <!-- RIGHT PANE: Crisp Modern Sign In Surface (Like Reference) -->
        <div class="lg:col-span-6 xl:col-span-5 bg-white p-8 sm:p-12 lg:p-14 flex flex-col justify-between">
            
            <!-- Top Header: Brand Logo + Sign Up link -->
            <div class="flex items-center justify-between">
                <!-- Primary brand logo -->
                <div class="flex items-center">
                    <img src="{{ asset('images/tobacare-logo.png') }}" alt="TobaCare" class="w-20 h-16 object-contain object-center">
                </div>

                <!-- Home & Bantuan Links -->
                <div class="flex items-center space-x-3">
                    <a href="/" class="text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1.5 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <span class="text-slate-300">|</span>
                    <a href="#bantuan" onclick="TobaCare.toast('Layanan pendaftaran akun warga dapat menghubungi administrator dinas terkait.', 'warning')"
                       class="text-xs sm:text-sm font-medium text-slate-600 hover:text-slate-900 flex items-center space-x-1.5 transition">
                        <span>Bantuan</span>
                    </a>
                </div>
            </div>

            <!-- Center Form Area -->
            <div class="my-auto py-6 sm:py-8 max-w-sm w-full mx-auto">
                <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight text-slate-900 mb-6">
                    Log In
                </h2>

                <!-- Notice banner when redirected from "Laporkan Keluhanmu" -->
                <div id="redirect-banner" class="hidden mb-6 p-3.5 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-900 text-xs sm:text-sm items-start space-x-2.5 shadow-2xs">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="leading-relaxed font-medium">
                        Silakan masuk terlebih dahulu untuk mengisi formulir pengaduan. Setelah masuk, Anda akan langsung diarahkan ke form pelaporan.
                    </div>
                </div>

                <!-- Success banner when just registered -->
                <div id="registered-banner" class="hidden mb-6 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-900 text-xs sm:text-sm items-start space-x-2.5 shadow-2xs">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="leading-relaxed font-medium">
                        Akun berhasil dibuat! Silakan masuk menggunakan email dan password yang telah kamu buat.
                    </div>
                </div>

                <!-- Alert Container for errors -->
                <div id="login-alert" class="hidden mb-6 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm items-start space-x-2.5">
                    <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div id="login-alert-text" class="leading-relaxed"></div>
                </div>

                <form id="login-form" class="space-y-4" onsubmit="handleLogin(event)">
                    <!-- Email / Username Input (Pill Shaped) -->
                    <div>
                        <div class="relative">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   placeholder="Email or Username"
                                   class="w-full px-5 py-3.5 sm:py-4 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-[#FF512F] transition text-sm sm:text-base">
                        </div>
                    </div>

                    <!-- Password Input (Pill Shaped with Show/Hide Eye) -->
                    <div>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                   placeholder="Password"
                                   class="w-full px-5 py-3.5 sm:py-4 pr-12 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-[#FF512F] transition text-sm sm:text-base">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none p-1" title="Tampilkan / Sembunyikan sandi">
                                <svg id="eye-show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-hide" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Forgot Password Link (Orange Accent like reference) -->
                    <div class="pt-1 text-center sm:text-left">
                        <a href="javascript:void(0)" onclick="TobaCare.toast('Silakan hubungi Superadmin Diskominfo Toba untuk reset kata sandi akun kedinasan.', 'warning')"
                           class="text-xs sm:text-sm font-medium text-[#FF512F] hover:text-[#E03E1A] transition">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button (Vibrant gradient pill like reference) -->
                    <div class="pt-2">
                        <button type="submit" id="btn-submit"
                                class="w-full py-3.5 sm:py-4 px-6 rounded-full font-semibold text-white shadow-lg shadow-orange-500/25 bg-linear-to-r from-[#FF4E20] via-[#FF5F2E] to-[#E92359] hover:from-[#E63F12] hover:to-[#CF1749] focus:outline-none focus:ring-4 focus:ring-orange-500/30 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center space-x-2 text-sm sm:text-base cursor-pointer">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span id="btn-text">Sign In</span>
                            <svg id="btn-spinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-px flex-1 bg-slate-200"></div>
                        <span class="text-xs font-medium text-slate-400 whitespace-nowrap">atau masuk dengan</span>
                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>
                    <a href="{{ route('google.redirect') }}"
                       class="w-full py-3.5 px-6 rounded-full border border-slate-200 bg-white text-slate-800 font-semibold shadow-sm hover:bg-slate-50 hover:border-slate-300 focus:outline-none focus:ring-4 focus:ring-slate-200/70 transition flex items-center justify-center gap-3 text-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="#4285F4" d="M21.35 12.23c0-.79-.07-1.55-.22-2.27H12v4.3h5.24a4.48 4.48 0 0 1-1.94 2.94v2.45h3.14c1.84-1.69 2.91-4.18 2.91-7.42Z"/>
                            <path fill="#34A853" d="M12 21.99c2.63 0 4.84-.87 6.45-2.34l-3.14-2.45c-.87.58-1.98.92-3.31.92-2.54 0-4.69-1.72-5.46-4.03H3.3v2.53A9.74 9.74 0 0 0 12 21.99Z"/>
                            <path fill="#FBBC05" d="M6.54 14.09a5.86 5.86 0 0 1 0-3.78V7.78H3.3a9.73 9.73 0 0 0 0 8.84l3.24-2.53Z"/>
                            <path fill="#EA4335" d="M12 6.28c1.43 0 2.71.49 3.72 1.46l2.79-2.79C16.84 3.37 14.63 2.5 12 2.5a9.74 9.74 0 0 0-8.7 5.28l3.24 2.53C7.31 8 9.46 6.28 12 6.28Z"/>
                        </svg>
                        <span>Lanjutkan dengan Google</span>
                    </a>
                </div>

                <!-- Register link -->
                <div class="mt-8 pt-1 text-center">
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Belum punya akun?
                        <a href="/register" class="font-semibold text-[#FF512F] hover:text-[#E03E1A] transition">Daftar Sekarang Ã¢â€ â€™</a>
                    </p>
                </div>

                <!-- Subtle Demo Account Switcher for Evaluator/Reviewer -->
                <div class="mt-5 pt-5 border-t border-slate-100 text-center">
                    <p class="text-[11px] font-medium uppercase tracking-wider text-slate-400 mb-2.5">
                        Pilih Kredensial Uji Coba:
                    </p>
                    <div class="flex items-center justify-center gap-1.5 flex-wrap">
                        <button type="button" onclick="fillCredentials('admin@tobacare.test', 'password123')"
                                class="px-3 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900 border border-slate-200 transition">
                            Admin
                        </button>
                        <button type="button" onclick="fillCredentials('operator@tobacare.test', 'password123')"
                                class="px-3 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900 border border-slate-200 transition">
                            Operator
                        </button>
                        <button type="button" onclick="fillCredentials('warga@tobacare.test', 'password123')"
                                class="px-3 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900 border border-slate-200 transition">
                            Warga
                        </button>
                    </div>
                </div>

            </div>

            <!-- Footer: Copyright & Contact Links (Matching reference) -->
            <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2 pt-4">
                <span>&copy; 2026 TobaCare Ã‚Â· Pemkab Toba</span>
                <div class="flex items-center space-x-4">
                    <a href="mailto:kontak@tobacare.test" class="hover:text-slate-600 transition">Contact Us</a>
                    <span class="text-slate-300">Ã‚Â·</span>
                    <span class="hover:text-slate-600 cursor-pointer flex items-center">
                        Bahasa Indonesia
                        <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passInput = document.getElementById('password');
        const eyeShow = document.getElementById('eye-show');
        const eyeHide = document.getElementById('eye-hide');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            eyeShow.classList.add('hidden');
            eyeHide.classList.remove('hidden');
        } else {
            passInput.type = 'password';
            eyeShow.classList.remove('hidden');
            eyeHide.classList.add('hidden');
        }
    }

    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        hideAlert();
        TobaCare.toast('Kredensial ' + email + ' diisi.', 'success');
    }

    function showAlert(message) {
        const alertBox = document.getElementById('login-alert');
        const alertText = document.getElementById('login-alert-text');
        alertText.textContent = message;
        alertBox.classList.remove('hidden');
        alertBox.classList.add('flex');
    }

    function hideAlert() {
        const alertBox = document.getElementById('login-alert');
        alertBox.classList.add('hidden');
        alertBox.classList.remove('flex');
    }

    async function handleLogin(e) {
        e.preventDefault();
        hideAlert();

        const btn = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        btn.disabled = true;
        btnText.textContent = 'Signing in...';
        btnSpinner.classList.remove('hidden');

        try {
            let data;
            if (window.TobaCare && typeof window.TobaCare.api === 'function') {
                data = await window.TobaCare.api('/api/v1/auth/login', {
                    method: 'POST',
                    body: JSON.stringify({ email, password })
                });
            } else {
                const res = await fetch('/api/v1/auth/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                data = await res.json();
                if (!res.ok) {
                    throw new Error(data?.message || data?.error?.message || 'Kredensial tidak valid.');
                }
            }

            if (window.TobaCare && typeof window.TobaCare.setAuth === 'function') {
                window.TobaCare.setAuth(data.token, data.user);
                window.TobaCare.toast('Berhasil masuk! Mengarahkan ke sistem...', 'success');
            } else {
                localStorage.setItem('tobacare_token', data.token);
                localStorage.setItem('tobacare_user', JSON.stringify(data.user));
            }

            setTimeout(() => {
                const urlParams = new URLSearchParams(window.location.search);
                const redirectParam = urlParams.get('redirect');
                const role = data.user?.role?.name;

                if (role === 'admin') {
                    window.location.href = '/admin/dashboard';
                } else if (role === 'operator') {
                    window.location.href = '/operator/reports';
                } else {
                    window.location.href = (redirectParam && redirectParam.startsWith('/')) ? redirectParam : '/citizen/reports';
                }
            }, 500);

        } catch (err) {
            showAlert(err.message || 'Kredensial tidak valid. Silakan periksa kembali email & password.');
            btn.disabled = false;
            btnText.textContent = 'Sign In';
            btnSpinner.classList.add('hidden');
        }
    }

    // Auto-redirect if already authenticated & handle redirect notice banner
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const redirectParam = urlParams.get('redirect');

        const googleCode = urlParams.get('google_code');
        if (googleCode) {
            fetch('/api/v1/auth/google/exchange', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code: googleCode })
            })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) throw new Error(data?.error?.message || 'Login Google gagal.');
                    return data;
                })
                .then(data => {
                    window.TobaCare.setAuth(data.token, data.user);
                    const target = urlParams.get('redirect') || '/citizen/reports';
                    window.location.replace(target);
                })
                .catch(error => {
                    showAlert(error.message);
                });
        }

        // Show notice banner if redirected from reporting CTA
        if (redirectParam) {
            const banner = document.getElementById('redirect-banner');
            if (banner) {
                banner.classList.remove('hidden');
                banner.classList.add('flex');
            }
        }

        // Show success banner if just registered
        if (urlParams.get('registered') === '1') {
            const banner = document.getElementById('registered-banner');
            if (banner) {
                banner.classList.remove('hidden');
                banner.classList.add('flex');
            }
        }

        const token = window.TobaCare ? window.TobaCare.getToken() : localStorage.getItem('tobacare_token');
        const userStr = localStorage.getItem('tobacare_user');
        const user = userStr ? JSON.parse(userStr) : (window.TobaCare ? window.TobaCare.getUser() : null);
        if (token && user) {
            if (user?.role?.name === 'admin') {
                window.location.href = '/admin/dashboard';
            } else if (user?.role?.name === 'operator') {
                window.location.href = '/operator/reports';
            } else if (user?.role?.name === 'user') {
                window.location.href = (redirectParam && redirectParam.startsWith('/')) ? redirectParam : '/citizen/reports';
            }
        }
    });
</script>
@endpush
@endsection
