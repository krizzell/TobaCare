@extends('layouts.app')

@section('title', 'Daftar Akun — TobaCare')

@section('body')
<div class="min-h-screen bg-[#ecebe8] text-slate-800 flex items-center justify-center p-3 sm:p-6 lg:p-10 antialiased selection:bg-rose-500 selection:text-white">
    <div class="w-full max-w-300 bg-white rounded-3xl lg:rounded-[2.5rem] shadow-2xl border border-slate-200/70 overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-180">

        <!-- LEFT PANE: Dark Brand & Visual Hero -->
        <div class="lg:col-span-6 xl:col-span-7 bg-[#171412] text-white p-8 sm:p-12 lg:p-14 flex flex-col justify-between relative overflow-hidden">
            <!-- Concentric Circular Radar/Ripple Lines -->
            <div class="absolute -right-24 top-1/2 -translate-y-1/2 w-120 h-120 rounded-full border border-white/5 pointer-events-none"></div>
            <div class="absolute -right-12 top-1/2 -translate-y-1/2 w-90 h-90 rounded-full border border-white/7 pointer-events-none"></div>
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-60 h-60 rounded-full border border-white/9 pointer-events-none"></div>
            <div class="absolute -left-20 -top-20 w-80 h-80 rounded-full bg-rose-500/5 blur-3xl pointer-events-none"></div>

            <!-- Top Tagline -->
            <div class="relative z-10">
                <p class="text-xs sm:text-sm font-light text-slate-300/80 tracking-wide">
                    Sistem Pelayanan Terpadu & Aspirasi Publik — Kabupaten Toba
                </p>
            </div>

            <!-- Hero Content -->
            <div class="my-auto py-8 sm:py-12 relative z-10 space-y-8">
                <div class="space-y-4">
                    <h1 class="text-3xl sm:text-4xl xl:text-5xl font-extrabold tracking-tight text-white leading-[1.15]">
                        Bergabung bersama<br>
                        <span class="text-transparent bg-clip-text bg-linear-to-r from-amber-400 via-rose-400 to-rose-300">warga peduli Toba</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-sm">
                        Buat akun gratis dan mulai berkontribusi. Setiap laporan yang kamu kirim membantu pemerintah memprioritaskan perbaikan infrastruktur di sekitar kamu.
                    </p>
                </div>

                <!-- Benefits list -->
                <div class="space-y-3">
                    @foreach([
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Laporkan masalah infrastruktur dengan mudah'],
                        ['icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'text' => 'Pantau status laporan secara real-time'],
                        ['icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'text' => 'Lihat peta sebaran masalah di sekitarmu'],
                    ] as $item)
                    <div class="flex items-center space-x-3 text-sm text-slate-300">
                        <div class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                            </svg>
                        </div>
                        <span>{{ $item['text'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Bottom quote -->
            <div class="relative z-10 border-t border-white/10 pt-6">
                <p class="text-xs text-slate-500 italic leading-relaxed">
                    "Setiap laporan adalah langkah nyata menuju kota yang lebih baik."
                </p>
            </div>
        </div>

        <!-- RIGHT PANE: Register Form -->
        <div class="lg:col-span-6 xl:col-span-5 bg-white p-8 sm:p-12 lg:p-14 flex flex-col justify-between">

            <!-- Top Header: Brand Logo + Beranda -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('images/tobacare-logo.png') }}" alt="TobaCare" class="w-20 h-16 object-contain object-center">
                </div>
                <a href="/" class="text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1.5 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Beranda</span>
                </a>
            </div>

            <!-- Center Form Area -->
            <div class="my-auto py-6 sm:py-8 max-w-sm w-full mx-auto">
                <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight text-slate-900 mb-2">
                    Sign Up
                </h2>
                <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                    Isi data di bawah untuk bergabung sebagai warga pelapor.
                </p>

                <!-- Alert: Error -->
                <div id="register-alert" class="hidden mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm items-start space-x-2.5">
                    <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div id="register-alert-text" class="leading-relaxed"></div>
                </div>

                <!-- Alert: Success -->
                <div id="register-success" class="hidden mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm items-start space-x-2.5">
                    <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="leading-relaxed">
                        <strong>Akun berhasil dibuat!</strong> Mengarahkan ke halaman masuk...
                    </div>
                </div>

                <form id="register-form" class="space-y-4" onsubmit="handleRegister(event)">
                    <!-- Full Name -->
                    <div>
                        <input id="name" name="name" type="text" autocomplete="name" required
                               minlength="2" maxlength="100"
                               placeholder="Nama Lengkap"
                               class="w-full px-5 py-3.5 sm:py-4 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-[#FF512F] transition text-sm sm:text-base">
                        <p id="name-error" class="hidden text-xs text-rose-600 mt-1.5 pl-4 leading-relaxed"></p>
                    </div>

                    <!-- Email -->
                    <div>
                        <input id="reg-email" name="email" type="email" autocomplete="email" required
                               placeholder="Alamat Email Aktif"
                               class="w-full px-5 py-3.5 sm:py-4 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-[#FF512F] transition text-sm sm:text-base">
                        <p id="email-error" class="hidden text-xs text-rose-600 mt-1.5 pl-4 leading-relaxed"></p>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="relative">
                            <input id="reg-password" name="password" type="password" autocomplete="new-password" required
                                   minlength="8" maxlength="72"
                                   placeholder="Password (min. 8 karakter)"
                                   class="w-full px-5 py-3.5 sm:py-4 pr-12 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-[#FF512F] transition text-sm sm:text-base">
                            <button type="button" onclick="toggleRegPassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none p-1" title="Tampilkan / Sembunyikan sandi">
                                <svg id="reg-eye-show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="reg-eye-hide" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2.5 px-1">
                            <div class="flex gap-1 mb-1.5">
                                <div id="str-1" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors duration-300"></div>
                                <div id="str-2" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors duration-300"></div>
                                <div id="str-3" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors duration-300"></div>
                                <div id="str-4" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors duration-300"></div>
                            </div>
                            <p id="str-label" class="text-[11px] text-slate-400 leading-none min-h-2.75"></p>
                        </div>
                        <p id="password-error" class="hidden text-xs text-rose-600 mt-1.5 pl-4 leading-relaxed"></p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <input id="reg-password-confirm" name="password_confirm" type="password" autocomplete="new-password" required
                               placeholder="Ulangi Password"
                               class="w-full px-5 py-3.5 sm:py-4 rounded-full border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-[#FF512F] transition text-sm sm:text-base">
                        <p id="confirm-error" class="hidden text-xs text-rose-600 mt-1.5 pl-4 leading-relaxed"></p>
                    </div>

                    <!-- Terms & Privacy checkbox -->
                    <div class="flex items-start space-x-3 px-1 pt-1">
                        <input id="terms" type="checkbox" required
                               class="mt-0.5 w-4 h-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500 cursor-pointer shrink-0">
                        <label for="terms" class="text-xs text-slate-500 leading-relaxed cursor-pointer">
                            Saya menyetujui <a href="#" class="text-[#FF512F] hover:underline font-medium">Syarat & Ketentuan</a> serta <a href="#" class="text-[#FF512F] hover:underline font-medium">Kebijakan Privasi</a> TobaCare. Data saya hanya digunakan untuk keperluan pelaporan masyarakat.
                        </label>
                    </div>

                    <!-- Google OAuth -->
                    <div class="pt-2">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-px flex-1 bg-slate-200"></div>
                            <span class="text-xs font-medium text-slate-400 whitespace-nowrap">Atau Daftar dengan</span>
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

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" id="reg-btn-submit"
                                class="w-full py-3.5 sm:py-4 px-6 rounded-full font-semibold text-white shadow-lg shadow-orange-500/25 bg-linear-to-r from-[#FF4E20] via-[#FF5F2E] to-[#E92359] hover:from-[#E63F12] hover:to-[#CF1749] focus:outline-none focus:ring-4 focus:ring-orange-500/30 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center space-x-2 text-sm sm:text-base cursor-pointer">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span id="reg-btn-text">Buat Akun Sekarang</span>
                            <svg id="reg-btn-spinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Already have account / Back to login -->
                <div class="mt-8 pt-1 text-center">
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Sudah punya akun?
                        <a href="/login" class="font-semibold text-[#FF512F] hover:text-[#E03E1A] transition">Masuk Sekarang →</a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2 pt-4">
                <span>&copy; 2026 TobaCare · Pemkab Toba</span>
                <div class="flex items-center space-x-4">
                    <a href="mailto:kontak@tobacare.test" class="hover:text-slate-600 transition">Contact Us</a>
                    <span class="text-slate-300">·</span>
                    <span class="text-slate-500">Bahasa Indonesia</span>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function toggleRegPassword() {
        const input = document.getElementById('reg-password');
        const show = document.getElementById('reg-eye-show');
        const hide = document.getElementById('reg-eye-hide');
        if (input.type === 'password') {
            input.type = 'text';
            show.classList.add('hidden');
            hide.classList.remove('hidden');
        } else {
            input.type = 'password';
            show.classList.remove('hidden');
            hide.classList.add('hidden');
        }
    }

    // Password strength meter
    document.getElementById('reg-password').addEventListener('input', function () {
        const val = this.value;
        let strength = 0;
        if (val.length >= 8) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;

        const colors = ['bg-rose-500', 'bg-orange-400', 'bg-amber-400', 'bg-emerald-500'];
        const labels = ['', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];

        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById(`str-${i}`);
            bar.className = `h-1 flex-1 rounded-full transition-colors duration-300 ${i <= strength ? colors[strength - 1] : 'bg-slate-200'}`;
        }
        document.getElementById('str-label').textContent = val.length > 0 ? labels[strength] : '';
    });

    function showFieldError(fieldId, msg) {
        const el = document.getElementById(fieldId);
        el.textContent = msg;
        el.classList.remove('hidden');
    }

    function clearFieldErrors() {
        ['name-error', 'email-error', 'password-error', 'confirm-error'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
    }

    function showAlert(msg) {
        document.getElementById('register-alert-text').textContent = msg;
        document.getElementById('register-alert').classList.remove('hidden');
        document.getElementById('register-alert').classList.add('flex');
        document.getElementById('register-success').classList.add('hidden');
        document.getElementById('register-success').classList.remove('flex');
    }

    function showSuccess() {
        document.getElementById('register-success').classList.remove('hidden');
        document.getElementById('register-success').classList.add('flex');
        document.getElementById('register-alert').classList.add('hidden');
        document.getElementById('register-alert').classList.remove('flex');
        document.getElementById('register-form').classList.add('opacity-50', 'pointer-events-none');
    }

    const googleError = new URLSearchParams(window.location.search).get('google_error');
    if (googleError) {
        showAlert(googleError);
    }

    async function handleRegister(e) {
        e.preventDefault();
        clearFieldErrors();
        document.getElementById('register-alert').classList.add('hidden');

        const name     = document.getElementById('name').value.trim();
        const email    = document.getElementById('reg-email').value.trim();
        const password = document.getElementById('reg-password').value;
        const confirm  = document.getElementById('reg-password-confirm').value;
        document.getElementById('register-success').classList.add('hidden');
        document.getElementById('register-success').classList.remove('flex');

        // Client-side validation
        let hasError = false;
        if (name.length < 2) { showFieldError('name-error', 'Nama minimal 2 karakter.'); hasError = true; }
        if (!email) {
            showFieldError('email-error', 'Email tidak boleh kosong.');
            hasError = true;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showFieldError('email-error', 'Format email tidak valid.');
            hasError = true;
        }
        if (password.length < 8) { showFieldError('password-error', 'Password minimal 8 karakter.'); hasError = true; }
        if (password !== confirm) { showFieldError('confirm-error', 'Password dan konfirmasi tidak cocok.'); hasError = true; }
        if (hasError) return;

        const btn     = document.getElementById('reg-btn-submit');
        const btnText = document.getElementById('reg-btn-text');
        const spinner = document.getElementById('reg-btn-spinner');

        btn.disabled = true;
        btnText.textContent = 'Membuat akun...';
        spinner.classList.remove('hidden');

        try {
            const res = await fetch('/api/v1/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, email, password })
            });

            const data = await res.json();

            if (!res.ok) {
                // Handle validation errors from backend
                const fields = data?.errors || data?.error?.fields;
                if (fields) {
                    if (fields.name) {
                        showFieldError('name-error', Array.isArray(fields.name) ? fields.name[0] : fields.name);
                    }
                    if (fields.email) {
                        showFieldError('email-error', Array.isArray(fields.email) ? fields.email[0] : fields.email);
                    }
                    if (fields.password) {
                        showFieldError('password-error', Array.isArray(fields.password) ? fields.password[0] : fields.password);
                    }
                } else {
                    showAlert(data?.error?.message || data?.message || 'Terjadi kesalahan saat mendaftar.');
                }
                btn.disabled = false;
                btnText.textContent = 'Buat Akun Sekarang';
                spinner.classList.add('hidden');
                return;
            }

            // Success
            showSuccess();
            setTimeout(() => {
                window.location.href = '/login?registered=1';
            }, 1800);

        } catch (err) {
            showAlert('Gagal terhubung ke server. Silakan coba lagi.');
            btn.disabled = false;
            btnText.textContent = 'Buat Akun Sekarang';
            spinner.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
