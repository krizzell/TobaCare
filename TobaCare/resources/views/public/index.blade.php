@extends('layouts.app')

@section('title', 'TobaCare — Portal Aspirasi & Transparansi Perbaikan Fasilitas Publik Kab. Toba')

@section('body')
<div class="min-h-screen bg-[#F8FAFC] flex flex-col antialiased text-slate-800 selection:bg-rose-500 selection:text-white">

    <!-- Sticky Civic Navbar -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 transition-all shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Brand Emblem & Logo -->
                <div class="flex items-center space-x-3">
                    <a href="/" class="flex items-center space-x-3">
                        <svg class="w-9 h-9" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="15" stroke="url(#brand-ring-pub)" stroke-width="4.5" />
                            <defs>
                                <linearGradient id="brand-ring-pub" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#FF512F" />
                                    <stop offset="35%" stop-color="#F09819" />
                                    <stop offset="70%" stop-color="#10B981" />
                                    <stop offset="100%" stop-color="#06B6D4" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <div>
                            <span class="text-xl font-extrabold tracking-tight text-slate-900 block leading-tight">TobaCare</span>
                            <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest block">Pemkab Toba</span>
                        </div>
                    </a>

                    <!-- Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-1 ml-8 pl-8 border-l border-slate-200 text-sm font-semibold text-slate-600">
                        <a href="#tujuan" class="px-3 py-1.5 rounded-xl hover:text-slate-900 hover:bg-slate-50 transition">
                            Tujuan Platform
                        </a>
                        <a href="#fasilitas-selesai" class="px-3 py-1.5 rounded-xl hover:text-slate-900 hover:bg-slate-50 transition">
                            Fasilitas Diperbaiki
                        </a>
                        <a href="#cara-lapor" class="px-3 py-1.5 rounded-xl hover:text-slate-900 hover:bg-slate-50 transition">
                            Alur Penanganan
                        </a>
                        <a href="#kontak" class="px-3 py-1.5 rounded-xl hover:text-slate-900 hover:bg-slate-50 transition">
                            Layanan 112
                        </a>
                    </nav>
                </div>

                <!-- Right Action Area: Login / User Profile & "Keluar Aplikasi" button -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    
                    <!-- Guest State: Masuk Portal Button -->
                    <div id="nav-guest-state" class="flex items-center">
                        <a href="/login"
                           class="inline-flex items-center px-4 py-2 rounded-full font-bold text-xs sm:text-sm text-slate-800 hover:text-white bg-slate-100 hover:bg-slate-900 border border-slate-200 transition shadow-2xs">
                            <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Masuk Portal</span>
                        </a>
                    </div>

                    <!-- Authenticated User State: User Chip + Keluar Aplikasi Button -->
                    <div id="nav-logged-state" class="hidden items-center space-x-2.5 sm:space-x-3">
                        <a href="/citizen/reports" class="flex items-center space-x-2 text-xs font-bold text-slate-800 hover:text-rose-600 transition bg-slate-50 hover:bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200 shadow-2xs" title="Buka Portal Aspirasi Saya">
                            <span class="w-7 h-7 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xs" id="nav-user-avatar">WU</span>
                            <span class="hidden sm:inline" id="nav-user-name">Warga Uji</span>
                        </a>

                        <!-- Button "Keluar Aplikasi" (Menggantikan duplikasi tombol lapor) -->
                        <button type="button" onclick="handleLogoutApp()"
                                class="inline-flex items-center px-3.5 sm:px-4 py-2 rounded-full font-bold text-xs sm:text-sm text-rose-700 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200/80 hover:border-rose-600 transition shadow-2xs cursor-pointer"
                                title="Keluar dari akun aplikasi">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Keluar Aplikasi</span>
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1">

        <!-- 1. HERO SECTION & PURPOSE -->
        <section class="relative overflow-hidden bg-gradient-to-b from-white via-slate-50/70 to-[#F8FAFC] pt-12 sm:pt-20 pb-16 sm:pb-24 border-b border-slate-200/80">
            <!-- Background Decorative Blur Rings -->
            <div class="absolute -top-24 right-1/4 w-96 h-96 rounded-full bg-rose-500/10 blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 -left-20 w-80 h-80 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6">
                
                <!-- Institutional Badge -->
                <div class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-rose-50 border border-rose-200/80 text-rose-700 text-xs font-semibold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-rose-500 mr-2 animate-ping"></span>
                    Pemerintah Kabupaten Toba — Portal Pelayanan Aspirasi Terpadu
                </div>

                <!-- Main Hero Headline -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.15] max-w-4xl mx-auto">
                    Wadah Aspirasi Warga & Transparansi Perbaikan Fasilitas Publik
                </h1>

                <!-- Clear Purpose Statement (Tujuan Web Ini) -->
                <p class="text-sm sm:text-base lg:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed font-normal">
                    TobaCare adalah platform terpadu untuk masyarakat Kabupaten Toba. Sampaikan keluhan jalan berlubang, lampu penerangan padam, dan masalah kebersihan. Pantau penanganannya dan saksikan bukti nyata perbaikan yang telah dituntaskan oleh dinas terkait.
                </p>

                <!-- Dual Action CTAs -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                    <!-- Laporkan Keluhanmu Button -->
                    <button type="button" onclick="handleReportComplaintClick()"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-3.5 rounded-full font-extrabold text-white text-sm sm:text-base shadow-lg shadow-orange-500/30 bg-gradient-to-r from-[#FF4E20] via-[#FF5F2E] to-[#E92359] hover:from-[#E63F12] hover:to-[#CF1749] transition transform hover:scale-[1.02] cursor-pointer">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Laporkan Keluhanmu</span>
                    </button>

                    <!-- Lihat Fasilitas yang Sudah Diperbaiki Button -->
                    <a href="#fasilitas-selesai"
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 rounded-full font-bold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-300 shadow-2xs text-sm sm:text-base transition cursor-pointer">
                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Lihat Fasilitas Selesai Diperbaiki</span>
                        <svg class="w-4 h-4 ml-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>

                <!-- 4 Quick Stats / Impact Highlights -->
                <div class="pt-8 sm:pt-12 grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 max-w-4xl mx-auto text-left">
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 block">Fasilitas Diperbaiki</span>
                        <div id="stat-hero-resolved" class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">280+</div>
                        <span class="text-[11px] text-slate-400">tuntas ditangani</span>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-sky-700 block">Kecamatan Terlayani</span>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">16</div>
                        <span class="text-[11px] text-slate-400">seluruh Kab. Toba</span>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 block">Rata-rata Respon</span>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">2.4 Hari</div>
                        <span class="text-[11px] text-slate-400">kecepatan triase</span>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-purple-700 block">Transparansi Publik</span>
                        <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">100%</div>
                        <span class="text-[11px] text-slate-400">terbuka untuk warga</span>
                    </div>
                </div>

            </div>
        </section>


        <!-- 2. TUJUAN & NILAI PLATFORM (3 Pillars) -->
        <section id="tujuan" class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-xs font-bold uppercase tracking-widest text-rose-600 block">Tujuan & Nilai Utama</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Mengapa TobaCare Dihadirkan untuk Anda?
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Kami membangun saluran terpadu agar setiap aspirasi fasilitas publik memiliki kepastian penanganan tanpa hambatan birokrasi.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Pillar 1 -->
                    <div class="bg-slate-50/70 p-6 sm:p-8 rounded-3xl border border-slate-200/80 space-y-4 hover:shadow-md transition">
                        <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">1. Pelaporan Cepat & Mudah</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Cukup ambil foto kerusakan melalui ponsel, tentukan lokasi di peta, dan kirimkan aduan Anda dalam hitungan detik. Tanpa perlu surat pengantar fisik.
                        </p>
                    </div>

                    <!-- Pillar 2 -->
                    <div class="bg-slate-50/70 p-6 sm:p-8 rounded-3xl border border-slate-200/80 space-y-4 hover:shadow-md transition">
                        <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">2. Transparansi Linimasa Real-Time</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Ketahui status laporan secara terbuka: kapan diverifikasi oleh dinas, kapan petugas teknis lapangan ditugaskan, hingga tahapan pengerjaan fisik di lapangan.
                        </p>
                    </div>

                    <!-- Pillar 3 -->
                    <div class="bg-slate-50/70 p-6 sm:p-8 rounded-3xl border border-slate-200/80 space-y-4 hover:shadow-md transition">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">3. Aksi Nyata & Akuntabilitas</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Setiap perbaikan yang telah rampung didokumentasikan dengan foto hasil pekerjaan fisik dan dipublikasikan resmi oleh dinas agar masyarakat melihat kinerja nyata pemerintah.
                        </p>
                    </div>
                </div>

            </div>
        </section>


        <!-- 3. SHOWCASE FASILITAS YANG SUDAH DIPERBAIKI OLEH PEMERINTAH (Diupload Admin/Operator) -->
        <section id="fasilitas-selesai" class="py-16 sm:py-20 bg-[#F8FAFC] scroll-mt-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="space-y-2 max-w-xl">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                            Aksi Nyata Pemkab Toba
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Fasilitas yang Selesai Diperbaiki
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Dokumentasi resmi infrastruktur dan sarana publik yang telah tuntas diperbaiki oleh Organisasi Perangkat Daerah (OPD) Pemerintah Kabupaten Toba.
                        </p>
                    </div>

                    <!-- Report Complaint Action Reminder -->
                    <div class="shrink-0">
                        <button type="button" onclick="handleReportComplaintClick()"
                                class="inline-flex items-center px-4 py-2.5 rounded-full font-bold text-white text-xs shadow-xs bg-slate-900 hover:bg-slate-800 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Ada Fasilitas Rusak? Laporkan di Sini</span>
                        </button>
                    </div>
                </div>

                <!-- Filters & Search Controls -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs space-y-3">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <!-- Category Pills -->
                        <div class="flex items-center space-x-1.5 overflow-x-auto text-xs py-1" id="category-filter-pills">
                            <button type="button" onclick="setPublicFilterCategory('')" id="cat-pill-all"
                                    class="px-3.5 py-1.5 rounded-xl font-bold bg-slate-900 text-white transition cursor-pointer">
                                Semua Fasilitas
                            </button>
                            <button type="button" onclick="setPublicFilterCategory('jalan_rusak')" id="cat-pill-jalan"
                                    class="px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer">
                                Jalan & Jembatan
                            </button>
                            <button type="button" onclick="setPublicFilterCategory('lampu_jalan_rusak')" id="cat-pill-lampu"
                                    class="px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer">
                                Lampu Jalan (PJU)
                            </button>
                            <button type="button" onclick="setPublicFilterCategory('sampah')" id="cat-pill-sampah"
                                    class="px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer">
                                Sampah & Kebersihan
                            </button>
                            <button type="button" onclick="setPublicFilterCategory('drainase_rusak')" id="cat-pill-drainase"
                                    class="px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer">
                                Drainase & Saluran
                            </button>
                        </div>
                    </div>

                    <!-- Search Input -->
                    <div class="relative">
                        <input type="text" id="facility-search-input" oninput="debouncePublicSearch()"
                               placeholder="Cari fasilitas selesai (misal: Balige, Porsea, Laguboti, Jalan Sisingamangaraja)..."
                               class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Facilities Grid Container -->
                <div id="facilities-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Loading Skeleton -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 text-center text-slate-400 space-y-3 col-span-full py-16">
                        <svg class="animate-spin h-8 w-8 text-emerald-600 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-sm font-semibold text-slate-600">Memuat katalog fasilitas yang selesai diperbaiki...</p>
                    </div>
                </div>

                <!-- Pagination for Facilities -->
                <div id="facilities-pagination" class="hidden flex items-center justify-between py-4 text-xs text-slate-500 border-t border-slate-200">
                    <span id="facilities-page-info">Halaman 1</span>
                    <div class="flex space-x-2">
                        <button type="button" id="btn-fac-prev" onclick="changeFacilityPage(-1)"
                                class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 font-semibold disabled:opacity-40 transition cursor-pointer">
                            &larr; Sebelumnya
                        </button>
                        <button type="button" id="btn-fac-next" onclick="changeFacilityPage(1)"
                                class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 font-semibold disabled:opacity-40 transition cursor-pointer">
                            Selanjutnya &rarr;
                        </button>
                    </div>
                </div>

            </div>
        </section>


        <!-- 4. ALUR KERJA (CARA KERJA TOBACARE) -->
        <section id="cara-lapor" class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-xs font-bold uppercase tracking-widest text-sky-600 block">Alur Penanganan</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Bagaimana Pengaduan Anda Ditindaklanjuti?
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Proses terstandar dan transparan dari saat Anda mengirimkan foto kerusakan hingga fasilitas siap digunakan kembali.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Step 1 -->
                    <div class="relative bg-slate-50/70 p-6 rounded-3xl border border-slate-200/80 space-y-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white font-extrabold text-sm flex items-center justify-center">
                            1
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Laporkan dengan Foto</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Masyarakat mengambil foto bukti di lokasi kejadian, memilih kategori kerusakan, dan memastikan koordinat GPS akurat.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative bg-slate-50/70 p-6 rounded-3xl border border-slate-200/80 space-y-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white font-extrabold text-sm flex items-center justify-center">
                            2
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Verifikasi Dinas</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Admin dinas memeriksa validitas laporan dengan bantuan rekomendasi AI, lalu menerbitkan surat tugas penanganan.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative bg-slate-50/70 p-6 rounded-3xl border border-slate-200/80 space-y-3">
                        <div class="w-10 h-10 rounded-2xl bg-sky-600 text-white font-extrabold text-sm flex items-center justify-center">
                            3
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Pengerjaan Fisik</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Operator teknis dari dinas terkait turun ke lapangan untuk melakukan perbaikan fisik infrastruktur yang rusak.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative bg-slate-50/70 p-6 rounded-3xl border border-slate-200/80 space-y-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-extrabold text-sm flex items-center justify-center">
                            4
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Publikasi Hasil Tuntas</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Bukti foto hasil pengerjaan diunggah ke sistem dan dipublikasikan di galeri publik agar seluruh warga dapat melihatnya.
                        </p>
                    </div>
                </div>

                <div class="text-center pt-4">
                    <button type="button" onclick="handleReportComplaintClick()"
                            class="inline-flex items-center px-6 py-3 rounded-full font-bold text-white text-xs sm:text-sm shadow-md shadow-orange-500/20 bg-gradient-to-r from-[#FF4E20] via-[#FF5F2E] to-[#E92359] hover:from-[#E63F12] hover:to-[#CF1749] transition transform hover:scale-[1.02] cursor-pointer">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Mulai Laporkan Sekarang</span>
                    </button>
                </div>

            </div>
        </section>


        <!-- 5. EMERGENCY CONTACT & CALL CENTER 112 -->
        <section id="kontak" class="py-12 bg-slate-900 text-white relative overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                        Keadaan Darurat / Bahaya
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold tracking-tight">Kejadian Mengancam Keselamatan Jiwa?</h3>
                    <p class="text-xs sm:text-sm text-slate-400 max-w-xl">
                        Jika ada jembatan putus, tiang listrik roboh, atau longsor darurat, segera hubungi Call Center Bebas Pulsa Pemkab Toba.
                    </p>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="tel:112"
                       class="inline-flex items-center px-6 py-3 rounded-full font-bold text-white bg-rose-600 hover:bg-rose-500 text-sm shadow-lg shadow-rose-600/30 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>Hubungi 112 (Bebas Pulsa)</span>
                    </a>
                </div>
            </div>
        </section>

    </main>


    <!-- Civic Footer -->
    <footer class="bg-white border-t border-slate-200 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-6">
                <div class="flex items-center space-x-3">
                    <svg class="w-7 h-7" viewBox="0 0 40 40" fill="none">
                        <circle cx="20" cy="20" r="15" stroke="url(#footer-brand-ring)" stroke-width="4.5" />
                        <defs>
                            <linearGradient id="footer-brand-ring" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#FF512F" />
                                <stop offset="100%" stop-color="#06B6D4" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="text-base font-bold text-slate-800">TobaCare — Transparansi Fasilitas Publik</span>
                </div>
                <div class="flex items-center space-x-4 text-xs font-semibold text-slate-500">
                    <a href="/login" class="hover:text-slate-900 transition">Login Petugas / Admin</a>
                    <span>·</span>
                    <a href="#tujuan" class="hover:text-slate-900 transition">Tentang Kami</a>
                    <span>·</span>
                    <a href="#fasilitas-selesai" class="hover:text-slate-900 transition">Galeri Perbaikan</a>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 gap-2">
                <p>&copy; 2026 Pemerintah Kabupaten Toba, Provinsi Sumatera Utara. Seluruh hak cipta dilindungi.</p>
                <p>Didukung oleh Diskominfo, Dinas PUTR, dan Dinas Lingkungan Hidup Kab. Toba.</p>
            </div>
        </div>
    </footer>

</div>


<!-- Facility Detail Modal (Public Transparency Modal) -->
<div id="facility-detail-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4" onclick="closeFacilityModal()">
    <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-slate-200 p-6 sm:p-8 space-y-6" onclick="event.stopPropagation()">
        
        <!-- Header -->
        <div class="flex items-start justify-between">
            <div class="space-y-1">
                <div class="flex items-center space-x-2">
                    <span id="fac-modal-category" class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Kategori
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                        Selesai Diperbaiki
                    </span>
                </div>
                <h3 id="fac-modal-title" class="text-xl font-bold text-slate-900 leading-tight pt-1">
                    Judul Fasilitas
                </h3>
            </div>
            <button type="button" onclick="closeFacilityModal()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold p-1 cursor-pointer">
                &times;
            </button>
        </div>

        <!-- Photo Evidence -->
        <div class="rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 aspect-16/9 relative group">
            <img id="fac-modal-img" src="" alt="Bukti Perbaikan" class="w-full h-full object-cover">
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px]">Lokasi / Kecamatan</span>
                <span id="fac-modal-location" class="font-semibold text-slate-800 text-sm block mt-0.5">-</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px]">Dinas Pelaksana</span>
                <span id="fac-modal-agency" class="font-semibold text-slate-800 text-sm block mt-0.5">Pemkab Toba</span>
            </div>
        </div>

        <!-- Official Resolution Note -->
        <div class="bg-emerald-50/60 p-4 sm:p-5 rounded-2xl border border-emerald-200/80 space-y-1">
            <span class="text-emerald-800 font-bold text-xs uppercase tracking-wider flex items-center">
                <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Dokumentasi & Catatan Resmi Penanganan
            </span>
            <p id="fac-modal-note" class="text-xs sm:text-sm text-slate-700 leading-relaxed pt-1">
                -
            </p>
            <div class="text-[11px] text-slate-400 pt-2 font-mono" id="fac-modal-date"></div>
        </div>

        <div class="flex justify-end pt-2 border-t border-slate-100">
            <button type="button" onclick="closeFacilityModal()"
                    class="px-5 py-2 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition cursor-pointer">
                Tutup
            </button>
        </div>

    </div>
</div>


@push('scripts')
<script>
    let currentCategoryFilter = '';
    let currentSearchQuery = '';
    let currentPage = 1;
    let totalPages = 1;
    let searchDebounceTimeout = null;

    document.addEventListener('DOMContentLoaded', () => {
        checkNavAuthStatus();
        loadResolvedFacilities(1);
    });

    // Check user auth for header avatar / login / logout button
    function checkNavAuthStatus() {
        const token = TobaCare.getToken();
        const user = TobaCare.getUser();

        const guestState = document.getElementById('nav-guest-state');
        const loggedState = document.getElementById('nav-logged-state');

        if (token && user) {
            if (guestState) guestState.classList.add('hidden');
            if (loggedState) {
                loggedState.classList.remove('hidden');
                loggedState.classList.add('flex');
            }

            const nameEl = document.getElementById('nav-user-name');
            const avatarEl = document.getElementById('nav-user-avatar');
            if (nameEl) nameEl.textContent = user.name || 'Warga';
            if (avatarEl) {
                const initials = (user.name || 'W').split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                avatarEl.textContent = initials;
            }
        } else {
            if (guestState) guestState.classList.remove('hidden');
            if (loggedState) {
                loggedState.classList.add('hidden');
                loggedState.classList.remove('flex');
            }
        }
    }

    function handleLogoutApp() {
        TobaCare.confirm({
            title: 'Keluar Aplikasi',
            message: 'Apakah Anda yakin ingin keluar dari akun aplikasi TobaCare?',
            confirmText: 'Ya, Keluar',
            confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
            onConfirm: () => {
                const token = TobaCare.getToken();
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
                        TobaCare.toast('Berhasil keluar dari aplikasi.', 'success');
                        setTimeout(() => window.location.href = '/', 400);
                    });
                } else {
                    localStorage.removeItem('tobacare_token');
                    localStorage.removeItem('tobacare_user');
                    window.location.href = '/';
                }
            }
        });
    }

    /**
     * CORE REQUIREMENT:
     * "tapi di halaman utama juga ada tombol 'laporkan keluhanmu', nah jika masyarakat menekan tombol ini,
     * nanti akan diarahkan ke login terlebih dahulu baru bisa mengisi laporan"
     */
    function handleReportComplaintClick() {
        try {
            const token = window.TobaCare ? window.TobaCare.getToken() : localStorage.getItem('tobacare_token');
            const userStr = localStorage.getItem('tobacare_user');
            const user = userStr ? JSON.parse(userStr) : (window.TobaCare ? window.TobaCare.getUser() : null);

            // If user is already logged in as citizen/user: go straight to report form
            if (token && user && user.role?.name === 'user') {
                window.location.href = '/citizen/reports/create';
                return;
            }
        } catch (e) {
            console.warn('Auth check in handleReportComplaintClick:', e);
        }

        // If not logged in: redirect to login page with callback redirect parameter
        window.location.href = '/login?redirect=' + encodeURIComponent('/citizen/reports/create');
    }

    async function loadResolvedFacilities(page = 1) {
        currentPage = page;
        const grid = document.getElementById('facilities-grid');

        let url = `/api/v1/public/resolved-facilities?page=${page}&per_page=6`;
        if (currentCategoryFilter) url += `&category_code=${encodeURIComponent(currentCategoryFilter)}`;
        if (currentSearchQuery) url += `&q=${encodeURIComponent(currentSearchQuery)}`;

        try {
            const res = await fetch(url);
            if (!res.ok) throw new Error('Gagal mengambil data fasilitas.');

            const data = await res.json();
            const items = data.data || [];
            totalPages = data.meta?.last_page || 1;

            // Update hero stat if available
            if (data.stats && data.stats.total_resolved !== undefined) {
                const heroStat = document.getElementById('stat-hero-resolved');
                if (heroStat) heroStat.textContent = `${data.stats.total_resolved}+`;
            }

            if (items.length === 0) {
                grid.innerHTML = `
                    <div class="bg-white rounded-3xl p-12 border border-slate-200 text-center text-slate-400 space-y-3 col-span-full">
                        <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-sm font-semibold text-slate-700">Belum ada dokumentasi fasilitas perbaikan yang sesuai</p>
                        <p class="text-xs text-slate-400">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                    </div>
                `;
                document.getElementById('facilities-pagination').classList.add('hidden');
                return;
            }

            grid.innerHTML = items.map(fac => renderFacilityCard(fac)).join('');

            // Pagination Controls
            document.getElementById('facilities-pagination').classList.remove('hidden');
            document.getElementById('facilities-page-info').textContent = `Halaman ${data.meta.current_page} dari ${totalPages} (Total ${data.meta.total} Fasilitas)`;
            document.getElementById('btn-fac-prev').disabled = currentPage <= 1;
            document.getElementById('btn-fac-next').disabled = currentPage >= totalPages;

        } catch (err) {
            grid.innerHTML = `
                <div class="bg-rose-50 rounded-2xl p-6 border border-rose-200 text-center text-rose-700 text-xs col-span-full">
                    Gagal memuat fasilitas selesai: ${err.message}
                </div>
            `;
        }
    }

    function renderFacilityCard(fac) {
        const thumb = fac.thumbnail_url
            ? `<img src="${fac.thumbnail_url}" alt="${fac.title}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">`
            : `<div class="w-full h-48 bg-slate-100 flex flex-col items-center justify-center text-slate-400 text-xs">
                 <svg class="w-8 h-8 mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                 <span>Dokumentasi Pemkab</span>
               </div>`;

        const catName = fac.category ? fac.category.name : 'Infrastruktur';
        const address = fac.location ? fac.location.address : 'Kabupaten Toba';
        const dateStr = fac.resolved_at ? new Date(fac.resolved_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : 'Terverifikasi';

        return `
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xs hover:shadow-lg transition flex flex-col overflow-hidden group">
                <!-- Image Header -->
                <div class="relative overflow-hidden bg-slate-100">
                    ${thumb}
                    <div class="absolute top-3 left-3 flex items-center space-x-1.5">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 backdrop-blur-xs text-slate-800 shadow-2xs">
                            ${catName}
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500 text-white shadow-xs">
                            <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Selesai Diperbaiki
                        </span>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center text-[11px] text-slate-400 space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="truncate">${address}</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-emerald-700 transition">
                            ${fac.title}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            ${fac.resolution_note || fac.description}
                        </p>
                    </div>

                    <!-- Card Footer -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <div class="text-[11px] text-slate-400">
                            <span>Selesai: </span><strong class="text-slate-600 font-semibold">${dateStr}</strong>
                        </div>
                        <button type="button" onclick="openFacilityModal('${fac.id}')"
                                class="inline-flex items-center text-xs font-bold text-emerald-600 hover:text-emerald-800 transition cursor-pointer">
                            <span>Lihat Rincian</span>
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    async function openFacilityModal(id) {
        try {
            const res = await fetch(`/api/v1/public/resolved-facilities/${id}`);
            if (!res.ok) throw new Error('Data fasilitas tidak ditemukan.');
            const data = await res.json();
            const fac = data.facility;

            document.getElementById('fac-modal-title').textContent = fac.title;
            document.getElementById('fac-modal-category').textContent = fac.category ? fac.category.name : 'Infrastruktur';
            document.getElementById('fac-modal-location').textContent = fac.location ? fac.location.address_text : 'Kabupaten Toba';
            document.getElementById('fac-modal-agency').textContent = fac.managing_agency || 'Pemerintah Kabupaten Toba';
            document.getElementById('fac-modal-note').textContent = fac.resolution_note || fac.description;

            const dateStr = fac.resolved_at ? new Date(fac.resolved_at).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'long', year: 'numeric'
            }) : '-';
            document.getElementById('fac-modal-date').textContent = `Diverifikasi tuntas: ${dateStr}`;

            const imgEl = document.getElementById('fac-modal-img');
            imgEl.src = fac.thumbnail_url || (fac.images && fac.images[0] ? fac.images[0].url : '');

            document.getElementById('facility-detail-modal').classList.remove('hidden');
        } catch (err) {
            TobaCare.toast('Gagal memuat rincian fasilitas.', 'error');
        }
    }

    function closeFacilityModal() {
        document.getElementById('facility-detail-modal').classList.add('hidden');
    }

    function setPublicFilterCategory(catCode) {
        currentCategoryFilter = catCode;
        
        // Update active pill styling
        const pills = ['all', 'jalan', 'lampu', 'sampah', 'drainase'];
        pills.forEach(p => {
            const btn = document.getElementById(`cat-pill-${p}`);
            if (btn) {
                btn.className = 'px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer';
            }
        });

        let activeId = 'cat-pill-all';
        if (catCode === 'jalan_rusak') activeId = 'cat-pill-jalan';
        else if (catCode === 'lampu_jalan_rusak') activeId = 'cat-pill-lampu';
        else if (catCode === 'sampah') activeId = 'cat-pill-sampah';
        else if (catCode === 'drainase_rusak') activeId = 'cat-pill-drainase';

        const activeBtn = document.getElementById(activeId);
        if (activeBtn) {
            activeBtn.className = 'px-3.5 py-1.5 rounded-xl font-bold bg-slate-900 text-white transition cursor-pointer';
        }

        loadResolvedFacilities(1);
    }

    function debouncePublicSearch() {
        clearTimeout(searchDebounceTimeout);
        searchDebounceTimeout = setTimeout(() => {
            currentSearchQuery = document.getElementById('facility-search-input').value.trim();
            loadResolvedFacilities(1);
        }, 350);
    }

    function changeFacilityPage(delta) {
        const next = currentPage + delta;
        if (next >= 1 && next <= totalPages) {
            loadResolvedFacilities(next);
        }
    }
</script>
@endpush
@endsection
