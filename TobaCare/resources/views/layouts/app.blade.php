<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/tobacare-logo.png') }}">
    <title>@yield('title', 'TobaCare') Ã¢â‚¬â€ Sistem Pengaduan Lingkungan & Fasum</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="min-h-full flex flex-col font-sans">

    @yield('body')

    <!-- Global Confirmation Modal (Replacing ugly browser confirm) -->
    <div id="global-confirm-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 transform transition-all space-y-4">
            <div class="flex items-start space-x-3.5">
                <div id="global-confirm-icon-wrapper" class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 id="global-confirm-title" class="text-base font-bold text-slate-900 leading-tight">Konfirmasi Tindakan</h3>
                    <p id="global-confirm-message" class="text-xs text-slate-500 mt-1 leading-relaxed">Apakah Anda yakin ingin melanjutkan tindakan ini?</p>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-2.5 pt-2 border-t border-slate-100">
                <button type="button" id="global-confirm-btn-cancel"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="global-confirm-btn-action"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-white shadow-xs transition cursor-pointer bg-slate-900 hover:bg-slate-800">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>

    <!-- Global Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col space-y-3 pointer-events-none max-w-sm w-full"></div>

    <script>
        // Global Auth & API Helper
        window.TobaCare = {
            confirmCallback: null,
            confirm(options = {}) {
                const modal = document.getElementById('global-confirm-modal');
                const title = document.getElementById('global-confirm-title');
                const message = document.getElementById('global-confirm-message');
                const btnAction = document.getElementById('global-confirm-btn-action');
                const btnCancel = document.getElementById('global-confirm-btn-cancel');

                title.textContent = options.title || 'Konfirmasi Tindakan';
                message.textContent = options.message || 'Apakah Anda yakin ingin melanjutkan?';
                btnAction.textContent = options.confirmText || 'Konfirmasi';
                btnAction.className = `px-4 py-2 rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer ${options.confirmClass || 'bg-slate-900 hover:bg-slate-800 text-white'}`;

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                const cleanup = () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    btnAction.onclick = null;
                    btnCancel.onclick = null;
                };

                btnCancel.onclick = cleanup;
                btnAction.onclick = async () => {
                    cleanup();
                    if (typeof options.onConfirm === 'function') {
                        await options.onConfirm();
                    }
                };
            },
            getToken() {
                return localStorage.getItem('tobacare_token');
            },
            getUser() {
                const user = localStorage.getItem('tobacare_user');
                return user ? JSON.parse(user) : null;
            },
            setAuth(token, user) {
                localStorage.setItem('tobacare_token', token);
                localStorage.setItem('tobacare_user', JSON.stringify(user));
            },
            logout() {
                const token = this.getToken();
                if (token) {
                    fetch('/api/v1/auth/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    }).finally(() => {
                        localStorage.removeItem('tobacare_token');
                        localStorage.removeItem('tobacare_user');
                        window.location.href = '/login';
                    });
                } else {
                    localStorage.removeItem('tobacare_token');
                    localStorage.removeItem('tobacare_user');
                    window.location.href = '/login';
                }
            },
            fetch(path, options = {}) {
                const token = this.getToken();
                const headers = {
                    'Accept': 'application/json',
                    ...(options.headers || {})
                };
                if (token) {
                    headers['Authorization'] = 'Bearer ' + token;
                }
                return fetch(path, { ...options, headers });
            },
            async api(path, options = {}) {
                const token = this.getToken();
                const headers = {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    ...(options.headers || {})
                };
                if (token) {
                    headers['Authorization'] = 'Bearer ' + token;
                }

                const response = await fetch(path, { ...options, headers });
                if (response.status === 401) {
                    this.logout();
                    throw new Error('Sesi telah berakhir. Silakan login kembali.');
                }
                const data = await response.json().catch(() => ({}));
                if (!response.ok) {
                    const err = new Error(data?.error?.message || 'Terjadi kesalahan sistem.');
                    err.data = data;
                    err.status = response.status;
                    throw err;
                }
                return data;
            },
            toast(message, type = 'success') {
                const container = document.getElementById('toast-container');
                if (!container) return;

                const toast = document.createElement('div');
                toast.className = `pointer-events-auto flex items-start p-4 rounded-lg shadow-lg border text-sm transition-all transform duration-300 translate-y-2 opacity-0 ${
                    type === 'error'
                        ? 'bg-rose-50 border-rose-200 text-rose-800'
                        : type === 'warning'
                        ? 'bg-amber-50 border-amber-200 text-amber-800'
                        : 'bg-emerald-50 border-emerald-200 text-emerald-800'
                }`;

                const icon = type === 'error'
                    ? '<svg class="w-5 h-5 mr-3 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                    : '<svg class="w-5 h-5 mr-3 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';

                toast.innerHTML = `
                    ${icon}
                    <div class="flex-1 leading-snug">${message}</div>
                    <button type="button" class="ml-3 text-slate-400 hover:text-slate-600 focus:outline-none" onclick="this.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                `;

                container.appendChild(toast);
                requestAnimationFrame(() => {
                    toast.classList.remove('translate-y-2', 'opacity-0');
                });

                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            }
        };
    </script>
    @stack('scripts')
</body>
</html>
