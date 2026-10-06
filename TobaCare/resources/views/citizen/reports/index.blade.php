@extends('layouts.citizen')

@section('title', 'Aspirasi Saya — Portal Warga TobaCare')

@section('content')
<div class="space-y-6">

    <!-- Top Welcome Header Card (Clean & Consistent with Admin Dashboard) -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-2xs">
        <div class="space-y-1.5">
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-200/70">
                    Kabupaten Toba
                </span>
                <span class="text-slate-300">•</span>
                <span class="text-xs font-medium text-slate-400">Layanan Aspirasi & Pengaduan Terpadu</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                Aspirasi & Pengaduan Warga
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-2xl leading-relaxed">
                Pantau status perbaikan infrastruktur jalan, kebersihan, dan lampu penerangan secara transparan dari verifikasi dinas hingga pengerjaan tuntas di lapangan.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 shrink-0">
            <button type="button" onclick="loadCitizenReports(1)"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold shadow-2xs transition hover:border-slate-300 cursor-pointer">
                <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Segarkan Data</span>
            </button>

            <a href="/citizen/reports/create"
               class="inline-flex items-center px-5 py-2.5 rounded-xl font-bold text-white text-xs sm:text-sm shadow-md shadow-rose-500/20 bg-rose-600 hover:bg-rose-700 transition transform hover:scale-[1.02] cursor-pointer">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Lapor Sekarang</span>
            </a>
        </div>
    </div>

    <!-- 4 KPI Summary Cards (Matching Dashboard Grid & Aesthetic) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Pengaduan -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs shadow-2xs">
                    <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-slate-500 bg-slate-50 border border-slate-200/60 px-2.5 py-0.5 rounded-full">
                    Semua
                </span>
            </div>
            <div class="mt-3">
                <div id="stat-total" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">0</div>
                <div class="text-xs font-medium text-slate-500 mt-1">Total Pengaduan Saya</div>
            </div>
        </div>

        <!-- Menunggu Triase -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-2xs">
                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-amber-700 bg-amber-50 border border-amber-200/60 px-2.5 py-0.5 rounded-full flex items-center">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1 animate-pulse"></span>
                    Antrean
                </span>
            </div>
            <div class="mt-3">
                <div id="stat-pending" class="text-2xl sm:text-3xl font-extrabold text-amber-600 tracking-tight">0</div>
                <div class="text-xs font-medium text-slate-500 mt-1">Menunggu Triase & Verifikasi</div>
            </div>
        </div>

        <!-- Ditangani Petugas -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shadow-2xs">
                    <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-sky-700 bg-sky-50 border border-sky-200/60 px-2.5 py-0.5 rounded-full flex items-center">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1 animate-pulse"></span>
                    Proses
                </span>
            </div>
            <div class="mt-3">
                <div id="stat-progress" class="text-2xl sm:text-3xl font-extrabold text-sky-600 tracking-tight">0</div>
                <div class="text-xs font-medium text-slate-500 mt-1">Sedang Ditangani Petugas</div>
            </div>
        </div>

        <!-- Selesai Dituntaskan -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-2xs">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2.5 py-0.5 rounded-full flex items-center">
                    Tuntas
                </span>
            </div>
            <div class="mt-3">
                <div id="stat-resolved" class="text-2xl sm:text-3xl font-extrabold text-emerald-600 tracking-tight">0</div>
                <div class="text-xs font-medium text-slate-500 mt-1">Selesai Dituntaskan</div>
            </div>
        </div>
    </div>

    <!-- Main Content Area: 2-Column Responsive Layout (Feed on Left, Civic Widgets on Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left / Primary Column (8 cols): Filters, Search & Report Cards Feed -->
        <div class="lg:col-span-8 space-y-4">
            
            <!-- Filters, Tabs & Search Toolbar -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-2xs space-y-4">
                <!-- View Toggle & Status Filter Pills -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pb-3 border-b border-slate-100">
                    <!-- Mode Toggle Pill -->
                    <div class="inline-flex p-1 bg-slate-100/90 rounded-2xl space-x-1 self-start">
                        <button type="button" onclick="switchMode(false)" id="mode-my"
                                class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-900 shadow-2xs transition duration-150 cursor-pointer">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Laporan Saya</span>
                        </button>
                        <button type="button" onclick="switchMode(true)" id="mode-public"
                                class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition duration-150 cursor-pointer">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Jelajah Publik (Transparansi)</span>
                        </button>
                    </div>

                    <!-- Status Pills Filter -->
                    <div class="flex items-center space-x-1.5 overflow-x-auto text-xs pb-1 sm:pb-0">
                        <button type="button" onclick="setFilterStatus('')" id="filter-all"
                                class="px-3.5 py-1.5 rounded-xl font-bold bg-slate-900 text-white shadow-2xs transition cursor-pointer">
                            Semua
                        </button>
                        <button type="button" onclick="setFilterStatus('submitted')" id="filter-submitted"
                                class="px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer">
                            Menunggu
                        </button>
                        <button type="button" onclick="setFilterStatus('in_progress')" id="filter-in-progress"
                                class="px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer">
                            Ditangani
                        </button>
                        <button type="button" onclick="setFilterStatus('resolved')" id="filter-resolved"
                                class="px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer">
                            Selesai
                        </button>
                    </div>
                </div>

                <!-- Integrated Search Bar -->
                <div class="relative">
                    <input type="text" id="citizen-search" oninput="debounceSearch()"
                           placeholder="Cari laporan berdasarkan judul, lokasi perbaikan, nama kecamatan, atau kata kunci..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-slate-200/90 text-xs sm:text-sm text-slate-800 placeholder-slate-400 bg-slate-50/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition duration-150">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Reports Card Feed -->
            <div id="reports-feed" class="space-y-3.5">
                <div class="bg-white p-12 rounded-3xl border border-slate-200/80 text-center text-slate-400 space-y-3">
                    <svg class="animate-spin h-6 w-6 text-rose-500 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-xs sm:text-sm font-medium text-slate-500">Memuat aspirasi pengaduan warga...</p>
                </div>
            </div>

            <!-- Pagination -->
            <div id="citizen-pagination" class="hidden flex items-center justify-between py-2 text-xs text-slate-500">
                <span id="citizen-page-info" class="font-medium">Halaman 1</span>
                <div class="flex space-x-2">
                    <button type="button" id="btn-citizen-prev" onclick="changeCitizenPage(-1)"
                            class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 font-semibold disabled:opacity-50 transition cursor-pointer shadow-2xs">
                        Sebelumnya
                    </button>
                    <button type="button" id="btn-citizen-next" onclick="changeCitizenPage(1)"
                            class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 font-semibold disabled:opacity-50 transition cursor-pointer shadow-2xs">
                        Selanjutnya
                    </button>
                </div>
            </div>

        </div>

        <!-- Right / Sidebar Column (4 cols): Information, Guidance & Quick Contacts -->
        <div class="lg:col-span-4 space-y-5 lg:sticky lg:top-24">
            
            <!-- Widget 1: Alur Penanganan Transparan -->
            <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-2xs space-y-4">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900 leading-tight">Alur Penanganan Laporan</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Standar respons cepat Pemkab Toba</p>
                </div>

                <div class="relative pl-7 space-y-4 text-xs before:absolute before:left-2.5 before:top-2 before:bottom-3 before:w-0.5 before:bg-slate-200">
                    <div class="relative">
                        <div class="absolute -left-7 top-0.5 w-5 h-5 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-[10px] ring-4 ring-white">1</div>
                        <div>
                            <strong class="text-slate-800 block text-xs">Lapor dengan Bukti Foto</strong>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Warga memotret kondisi kerusakan fisik & lokasi kejadian di Kab. Toba.</p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-7 top-0.5 w-5 h-5 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-[10px] ring-4 ring-white">2</div>
                        <div>
                            <strong class="text-slate-800 block text-xs">Verifikasi & Triase Sistem</strong>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Pemeriksaan kelengkapan laporan dan penentuan dinas teknis terkait.</p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-7 top-0.5 w-5 h-5 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-[10px] ring-4 ring-white">3</div>
                        <div>
                            <strong class="text-slate-800 block text-xs">Penerbitan Surat Tugas</strong>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Admin dinas menugaskan operator teknis ke lokasi perbaikan.</p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-7 top-0.5 w-5 h-5 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-[10px] ring-4 ring-white">4</div>
                        <div>
                            <strong class="text-slate-800 block text-xs">Pengerjaan & Selesai</strong>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Petugas mengunggah dokumentasi perbaikan tuntas untuk publik.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget 2: Saluran Cepat & Kontak Siaga Kab. Toba -->
            <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-2xs space-y-3.5">
                <div class="pb-2.5 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900 leading-tight">Kontak Dinas & Darurat</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Siaga Kabupaten Toba</p>
                </div>

                <div class="space-y-2.5 text-xs">
                    <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <div>
                            <span class="text-[11px] text-slate-400 block font-medium">Layanan Darurat Siaga</span>
                            <span class="font-bold text-slate-900">Call Center 112</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">Bebas Pulsa</span>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[11px] text-slate-400 block font-medium">Dinas PUTR (Jalan & Drainase)</span>
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-semibold text-slate-800">Sekretariat Balige</span>
                            <span class="text-slate-500 font-mono text-[11px]">(0632) 21xxx</span>
                        </div>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[11px] text-slate-400 block font-medium">Dinas Lingkungan Hidup (Sampah)</span>
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-semibold text-slate-800">Pos Kebersihan</span>
                            <span class="text-slate-500 font-mono text-[11px]">(0632) 32xxx</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget 3: Jelajah Fasilitas Selesai -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-5 rounded-3xl text-white shadow-md space-y-3 relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-emerald-500/20 blur-xl pointer-events-none"></div>
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider">Hasil Nyata Pemerintah</span>
                </div>
                <h4 class="text-sm font-bold text-white leading-snug">
                    Lihat Fasilitas yang Sudah Diperbaiki
                </h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Akses galeri foto sebelum dan sesudah perbaikan infrastruktur di 16 kecamatan se-Kabupaten Toba.
                </p>
                <div class="pt-1">
                    <a href="/#fasilitas-selesai"
                       class="inline-flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/10 transition">
                        <span>Buka Galeri Fasilitas Selesai</span>
                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Timeline Tracker Modal (Instant In-App Transparency) -->
<div id="timeline-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 space-y-4 max-h-[85vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900">Pelacakan Status Penanganan</h3>
                <p id="timeline-modal-subtitle" class="text-xs text-slate-400 mt-0.5">Memuat riwayat...</p>
            </div>
            <button type="button" onclick="closeTimelineModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Stepper Visual -->
        <div id="timeline-stepper" class="space-y-4 py-2">
            <!-- Dynamically populated by renderTimelineSteps() -->
        </div>

        <div class="pt-3 border-t border-slate-100 text-right">
            <button type="button" onclick="closeTimelineModal()"
                    class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition cursor-pointer">
                Tutup Pelacakan
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let isPublicMode = false;
    let currentStatus = '';
    let currentPage = 1;
    let totalPages = 1;
    let searchTimeout = null;

    function debounceSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadCitizenReports(1);
        }, 300);
    }

    function switchMode(publicMode) {
        isPublicMode = publicMode;
        document.getElementById('mode-my').className = !publicMode
            ? 'inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-900 shadow-2xs transition duration-150 cursor-pointer'
            : 'inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition duration-150 cursor-pointer';

        document.getElementById('mode-public').className = publicMode
            ? 'inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-900 shadow-2xs transition duration-150 cursor-pointer'
            : 'inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition duration-150 cursor-pointer';

        loadCitizenReports(1);
    }

    function setFilterStatus(status) {
        currentStatus = status;
        ['filter-all', 'filter-submitted', 'filter-in-progress', 'filter-resolved'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.className = 'px-3.5 py-1.5 rounded-xl font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition cursor-pointer';
        });

        const activeId = status === '' ? 'filter-all' : (status === 'submitted' ? 'filter-submitted' : (status === 'in_progress' ? 'filter-in-progress' : 'filter-resolved'));
        const el = document.getElementById(activeId);
        if (el) el.className = 'px-3.5 py-1.5 rounded-xl font-bold bg-slate-900 text-white shadow-2xs transition cursor-pointer';

        loadCitizenReports(1);
    }

    async function loadCitizenReports(page = 1) {
        currentPage = page;
        const feed = document.getElementById('reports-feed');
        const q = document.getElementById('citizen-search').value.trim();

        feed.innerHTML = `
            <div class="bg-white p-12 rounded-3xl border border-slate-200/80 text-center text-slate-400 space-y-3">
                <svg class="animate-spin h-6 w-6 text-rose-500 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-xs sm:text-sm font-medium text-slate-500">Memuat data...</p>
            </div>
        `;

        try {
            const params = new URLSearchParams({
                page: currentPage,
                per_page: 10,
            });
            if (isPublicMode) params.append('public', '1');
            if (currentStatus) params.append('status', currentStatus);
            if (q) params.append('q', q);

            const res = await TobaCare.api(`/api/v1/citizen/reports?${params.toString()}`);
            const items = res.data || [];
            totalPages = res.meta?.last_page || 1;

            if (res.stats && !isPublicMode) {
                document.getElementById('stat-total').textContent = res.stats.total || 0;
                document.getElementById('stat-pending').textContent = res.stats.pending || 0;
                document.getElementById('stat-progress').textContent = res.stats.in_progress || 0;
                document.getElementById('stat-resolved').textContent = res.stats.resolved || 0;
            }

            if (items.length === 0) {
                feed.innerHTML = `
                    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-200/80 text-center space-y-2.5 max-w-md mx-auto my-6">
                        <h4 class="text-sm sm:text-base font-bold text-slate-800">Belum Ada Aspirasi Ditemukan</h4>
                        <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">
                            ${q ? 'Tidak ada laporan yang sesuai dengan pencarian Anda. Coba kata kunci lain.' : 'Sampaikan pengaduan kerusakan fasilitas di sekitar Anda untuk ditindaklanjuti dinas terkait.'}
                        </p>
                        ${!q && !isPublicMode ? `
                            <div class="pt-2">
                                <a href="/citizen/reports/create" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 transition">
                                    Buat Laporan Baru
                                </a>
                            </div>
                        ` : ''}
                    </div>
                `;
                document.getElementById('citizen-pagination').classList.add('hidden');
                return;
            }

            feed.innerHTML = items.map(r => renderReportCard(r)).join('');

            document.getElementById('citizen-pagination').classList.remove('hidden');
            document.getElementById('citizen-page-info').textContent = `Halaman ${res.meta.current_page} dari ${totalPages} (Total ${res.meta.total} Laporan)`;

            document.getElementById('btn-citizen-prev').disabled = currentPage <= 1;
            document.getElementById('btn-citizen-next').disabled = currentPage >= totalPages;

        } catch (err) {
            console.error(err);
            feed.innerHTML = `
                <div class="bg-rose-50 p-6 rounded-2xl border border-rose-200 text-center text-rose-700 text-xs">
                    Gagal memuat aspirasi: ${err.message}
                </div>
            `;
        }
    }

    function renderReportCard(report) {
        const rawImg = report.thumbnail_url || (report.images && report.images[0] ? (report.images[0].url || `/storage/${report.images[0].storage_key}`) : null);
        const firstImg = (rawImg && rawImg.includes('/storage/')) 
            ? ('/storage/' + rawImg.split('/storage/')[1]) 
            : rawImg;

        const thumb = firstImg
            ? `<img src="${firstImg}" alt="Foto Bukti" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">`
            : `<div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-slate-400 text-[10px]">
                 <svg class="w-6 h-6 mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                 <span>Tanpa Foto</span>
               </div>`;

        // Address
        const address = report.location?.address_text || `Koordinat: ${report.location?.latitude?.toFixed(4)}, ${report.location?.longitude?.toFixed(4)}`;

        // Date
        const dateStr = new Date(report.created_at).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
        });

        // Status Badge
        let statusBadge = '';
        if (report.status === 'submitted' || report.status === 'ai_analysis' || report.status === 'pending_verification') {
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/80"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>Menunggu Verifikasi</span>';
        } else if (report.status === 'verified') {
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200/80"><span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span>Terverifikasi Dinas</span>';
        } else if (report.status === 'assigned' || report.status === 'in_progress') {
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/80"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5 animate-pulse"></span>Sedang Ditangani Petugas</span>';
        } else if (report.status === 'resolved') {
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Tuntas Diselesaikan</span>';
        } else if (report.status === 'rejected') {
            statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/80">Laporan Ditolak</span>';
        }

        const catName = report.category?.name || 'Infrastruktur & Lingkungan';
        const reporterTag = isPublicMode ? `<span class="text-[11px] text-slate-400 mr-2">Oleh: ${report.reporter_masked || 'Warga Toba'}</span>` : '';

        return `
            <div class="group bg-white p-5 rounded-3xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                <div class="flex items-start space-x-4 flex-1 min-w-0 w-full sm:w-auto">
                    <div class="relative shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 aspect-square w-20 h-20 sm:w-24 sm:h-24">
                        ${thumb}
                    </div>
                    <div class="flex-1 min-w-0 space-y-1.5">
                        <div class="flex items-center space-x-2 flex-wrap gap-1.5">
                            ${statusBadge}
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                ${catName}
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-rose-600 transition truncate">${report.title}</h3>
                        <p class="text-xs text-slate-500 line-clamp-1 leading-relaxed">${report.description}</p>
                        
                        <div class="flex items-center text-xs text-slate-400 pt-1 space-x-3 flex-wrap gap-y-1">
                            ${reporterTag}
                            <span class="flex items-center text-slate-500">
                                <svg class="w-3.5 h-3.5 mr-1 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate max-w-[200px] sm:max-w-xs">${address}</span>
                            </span>
                            <span class="text-slate-300">•</span>
                            <span class="flex items-center text-slate-500">
                                <svg class="w-3.5 h-3.5 mr-1 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>${dateStr}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons: Open Timeline Tracker & View Details -->
                <div class="sm:shrink-0 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 flex items-center justify-end space-x-2">
                    <button type="button" onclick="openTimelineModal('${report.id}', '${report.title.replace(/'/g, "\\'")}')"
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs hover:shadow-xs transition duration-150 cursor-pointer" title="Lacak Status">
                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Lacak</span>
                    </button>
                    <a href="/citizen/reports/${report.id}"
                       class="flex-1 sm:flex-initial inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-xs transition duration-150 cursor-pointer">
                        <span>Rincian</span>
                        <svg class="w-3.5 h-3.5 ml-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        `;
    }

    async function openTimelineModal(reportId, title) {
        document.getElementById('timeline-modal-subtitle').textContent = title;
        const stepper = document.getElementById('timeline-stepper');
        stepper.innerHTML = `
            <div class="py-8 text-center text-slate-400 text-xs">
                <svg class="animate-spin h-5 w-5 text-rose-500 mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memuat riwayat tindak lanjut...
            </div>
        `;
        document.getElementById('timeline-modal').classList.remove('hidden');

        try {
            const data = await TobaCare.api(`/api/v1/reports/${reportId}`);
            const report = data.report;
            renderTimelineSteps(report);
        } catch (err) {
            stepper.innerHTML = `<div class="p-4 bg-rose-50 text-rose-700 text-xs rounded-xl">Gagal memuat riwayat: ${err.message}</div>`;
        }
    }

    function renderTimelineSteps(report) {
        const stepper = document.getElementById('timeline-stepper');

        // Level threshold mapping based on report status
        const stageRank = {
            'submitted': 1,
            'ai_analysis': 2,
            'pending_verification': 2,
            'verified': 3,
            'assigned': 4,
            'in_progress': 5,
            'resolved': 6,
            'rejected': 0
        };

        const milestones = [
            { level: 1, title: 'Laporan Dikirim', desc: 'Aspirasi Anda berhasil diterima sistem TobaCare.' },
            { level: 2, title: 'Triase & Verifikasi Awal', desc: 'Sistem memeriksa kelengkapan bukti dan kesesuaian kategori laporan.' },
            { level: 3, title: 'Verifikasi Admin Dinas', desc: 'Dinas terkait memverifikasi kebenaran dan tingkat urgensi laporan.' },
            { level: 4, title: 'Penugasan Petugas', desc: 'Laporan diteruskan ke petugas lapangan untuk pengerjaan fisik.' },
            { level: 5, title: 'Penanganan Lapangan', desc: 'Petugas lapangan melakukan pekerjaan perbaikan di lokasi.' },
            { level: 6, title: 'Selesai Dituntaskan', desc: 'Kerusakan telah diperbaiki dan diverifikasi tuntas.' },
        ];

        const currentRank = stageRank[report.status] !== undefined ? stageRank[report.status] : 1;

        stepper.innerHTML = milestones.map((m, idx) => {
            const isCompleted = currentRank >= m.level;

            const circleClass = isCompleted 
                ? 'bg-emerald-500 text-white shadow-xs' 
                : 'bg-slate-100 text-slate-400 border border-slate-200';

            const lineClass = isCompleted && idx < milestones.length - 1 && currentRank > m.level
                ? 'bg-emerald-500' 
                : 'bg-slate-200';

            return `
                <div class="relative flex items-start space-x-3">
                    ${idx < milestones.length - 1 ? `<div class="absolute left-3.5 top-7 bottom-0 w-0.5 ${lineClass} -z-10"></div>` : ''}
                    <div class="w-7 h-7 rounded-full ${circleClass} flex items-center justify-center text-xs font-bold shrink-0 transition-colors">
                        ${isCompleted 
                            ? `<svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`
                            : `<span class="text-xs font-semibold text-slate-400">${idx + 1}</span>`
                        }
                    </div>
                    <div class="flex-1 pb-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold ${isCompleted ? 'text-slate-900' : 'text-slate-400'}">${m.title}</h4>
                        </div>
                        <p class="text-[11px] ${isCompleted ? 'text-slate-600' : 'text-slate-400'} mt-0.5">${m.desc}</p>
                    </div>
                </div>
            `;
        }).join('');
    }

    function closeTimelineModal() {
        document.getElementById('timeline-modal').classList.add('hidden');
    }

    function changeCitizenPage(delta) {
        const target = currentPage + delta;
        if (target >= 1 && target <= totalPages) {
            loadCitizenReports(target);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('explore') === 'true') {
            switchMode(true);
        } else {
            loadCitizenReports(1);
        }
    });
</script>
@endpush
@endsection
