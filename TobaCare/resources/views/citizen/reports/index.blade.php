@extends('layouts.citizen')

@section('title', 'Aspirasi Saya — Portal Warga TobaCare')

@section('content')
<div class="space-y-6">

    <!-- Top Bar Navigation: Kembali ke Beranda -->
    <div class="flex items-center justify-between text-xs text-slate-500">
        <a href="/" class="inline-flex items-center text-xs font-semibold text-slate-700 hover:text-rose-600 bg-white hover:bg-slate-50 px-3.5 py-1.5 rounded-xl border border-slate-200/80 shadow-2xs transition">
            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Beranda</span>
        </a>
        <span class="text-slate-400 text-[11px] font-medium hidden sm:inline">Pemerintah Kabupaten Toba &bull; Layanan Aspirasi Terpadu</span>
    </div>

    <!-- Hero Card for Citizen -->
    <div class="bg-linear-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-xl border border-slate-700/50">
        <!-- Subtle civic pattern in background -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-rose-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute right-10 top-1/2 -translate-y-1/2 hidden md:block opacity-15">
            <svg class="w-64 h-64 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>

        <div class="relative z-10 max-w-xl space-y-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                Pemerintah Kabupaten Toba
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white leading-tight">
                Aspirasi & Pengaduan Warga
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Laporkan kerusakan infrastruktur jalan, lampu penerangan padam, atau penumpukan sampah. Setiap laporan dipantau transparan dan ditindaklanjuti oleh dinas terkait.
            </p>
            <div class="pt-2 flex flex-wrap items-center gap-3">
                <a href="/citizen/reports/create"
                   class="inline-flex items-center px-5 py-2.5 rounded-full font-bold text-white text-xs sm:text-sm shadow-lg shadow-orange-500/25 bg-linear-to-r from-[#FF4E20] via-[#FF5F2E] to-[#E92359] hover:from-[#E63F12] hover:to-[#CF1749] transition transform hover:scale-[1.02] cursor-pointer">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Buat Laporan Baru</span>
                </a>
                <button type="button" onclick="loadCitizenReports(1)"
                        class="inline-flex items-center px-4 py-2.5 rounded-full font-semibold text-slate-300 hover:text-white bg-white/10 hover:bg-white/15 text-xs sm:text-sm transition cursor-pointer">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Segarkan Data</span>
                </button>
                <a href="/"
                   class="inline-flex items-center px-4 py-2.5 rounded-full font-semibold text-slate-300 hover:text-white bg-white/10 hover:bg-white/15 text-xs sm:text-sm transition cursor-pointer">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Stats Cards for Citizen -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Pengaduan</span>
            <div id="stat-total" class="text-2xl font-extrabold text-slate-900 mt-1">0</div>
            <span class="text-[11px] text-slate-400">seluruh riwayat</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <span class="text-xs font-semibold text-amber-600 uppercase tracking-wider block">Menunggu Triase</span>
            <div id="stat-pending" class="text-2xl font-extrabold text-amber-600 mt-1">0</div>
            <span class="text-[11px] text-slate-400">tahap verifikasi</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <span class="text-xs font-semibold text-sky-600 uppercase tracking-wider block">Ditangani Petugas</span>
            <div id="stat-progress" class="text-2xl font-extrabold text-sky-600 mt-1">0</div>
            <span class="text-[11px] text-slate-400">pengerjaan fisik</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider block">Selesai Dituntaskan</span>
            <div id="stat-resolved" class="text-2xl font-extrabold text-emerald-600 mt-1">0</div>
            <span class="text-[11px] text-slate-400">solusi tuntas</span>
        </div>
    </div>

    <!-- Filters & Tabs -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs space-y-3">
        <!-- View Toggle: Aspirasi Saya vs Jelajah Publik -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 flex-wrap gap-2">
            <div class="flex items-center space-x-2">
                <button type="button" onclick="switchMode(false)" id="mode-my"
                        class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-900 text-white transition cursor-pointer">
                    Laporan Saya
                </button>
                <button type="button" onclick="switchMode(true)" id="mode-public"
                        class="px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer">
                    Jelajah Publik (Transparansi)
                </button>
            </div>

            <!-- Status Pills -->
            <div class="flex items-center space-x-1.5 overflow-x-auto text-xs">
                <button type="button" onclick="setFilterStatus('')" id="filter-all"
                        class="px-3 py-1 rounded-lg font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                    Semua
                </button>
                <button type="button" onclick="setFilterStatus('submitted')" id="filter-submitted"
                        class="px-3 py-1 rounded-lg font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                    Verifikasi
                </button>
                <button type="button" onclick="setFilterStatus('in_progress')" id="filter-in-progress"
                        class="px-3 py-1 rounded-lg font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                    Dikerjakan
                </button>
                <button type="button" onclick="setFilterStatus('resolved')" id="filter-resolved"
                        class="px-3 py-1 rounded-lg font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                    Selesai
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="relative">
            <input type="text" id="citizen-search" oninput="debounceSearch()"
                   placeholder="Cari laporan berdasarkan judul, lokasi jalan, atau jenis masalah..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Reports Card Feed -->
    <div id="reports-feed" class="space-y-3">
        <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center text-slate-400 space-y-3">
            <svg class="animate-spin h-6 w-6 text-rose-500 mx-auto" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-xs sm:text-sm font-medium">Memuat aspirasi pengaduan warga...</p>
        </div>
    </div>

    <!-- Pagination -->
    <div id="citizen-pagination" class="hidden flex items-center justify-between py-2 text-xs text-slate-500">
        <span id="citizen-page-info">Halaman 1</span>
        <div class="flex space-x-2">
            <button type="button" id="btn-citizen-prev" onclick="changeCitizenPage(-1)"
                    class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 font-semibold disabled:opacity-50 transition cursor-pointer">
                Sebelumnya
            </button>
            <button type="button" id="btn-citizen-next" onclick="changeCitizenPage(1)"
                    class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 font-semibold disabled:opacity-50 transition cursor-pointer">
                Selanjutnya
            </button>
        </div>
    </div>

</div>

<!-- Timeline Tracker Modal (Instant In-App Transparency) -->
<div id="timeline-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[85vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900">Pelacakan Status Penanganan</h3>
                <p id="timeline-modal-subtitle" class="text-xs text-slate-400 mt-0.5">Memuat riwayat...</p>
            </div>
            <button type="button" onclick="closeTimelineModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Stepper Visual -->
        <div id="timeline-stepper" class="space-y-4 py-2">
            <!-- Dynamically populated by renderTimeline() -->
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
            ? 'px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-900 text-white transition cursor-pointer'
            : 'px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer';

        document.getElementById('mode-public').className = publicMode
            ? 'px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-900 text-white transition cursor-pointer'
            : 'px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition cursor-pointer';

        loadCitizenReports(1);
    }

    function setFilterStatus(status) {
        currentStatus = status;
        ['filter-all', 'filter-submitted', 'filter-in-progress', 'filter-resolved'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.className = 'px-3 py-1 rounded-lg font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition';
        });

        const activeId = status === '' ? 'filter-all' : (status === 'submitted' ? 'filter-submitted' : (status === 'in_progress' ? 'filter-in-progress' : 'filter-resolved'));
        const el = document.getElementById(activeId);
        if (el) el.className = 'px-3 py-1 rounded-lg font-semibold bg-slate-900 text-white transition';

        loadCitizenReports(1);
    }

    async function loadCitizenReports(page = 1) {
        currentPage = page;
        const feed = document.getElementById('reports-feed');
        const q = document.getElementById('citizen-search').value.trim();

        feed.innerHTML = `
            <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center text-slate-400 space-y-3">
                <svg class="animate-spin h-6 w-6 text-rose-500 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-xs sm:text-sm font-medium">Memuat data...</p>
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
                    <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center text-slate-400 space-y-3">
                        <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm font-semibold text-slate-600">Belum ada laporan pengaduan ditemukan</p>
                        <p class="text-xs text-slate-400">Gunakan tombol "Buat Laporan Baru" untuk menyampaikan keluhan fasilitas di sekitar Anda.</p>
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
            feed.innerHTML = `
                <div class="bg-rose-50 p-6 rounded-2xl border border-rose-200 text-center text-rose-700 text-xs">
                    Gagal memuat aspirasi: ${err.message}
                </div>
            `;
        }
    }

    function renderReportCard(report) {
        const firstImg = report.thumbnail_url || (report.images && report.images[0] ? (report.images[0].url || `/storage/${report.images[0].storage_key}`) : null);
        const thumb = firstImg
            ? `<img src="${firstImg}" alt="Foto Bukti" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border border-slate-200 shadow-2xs shrink-0">`
            : `<div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-slate-100 border border-slate-200 flex flex-col items-center justify-center text-slate-400 text-[10px] shrink-0">
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
            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>Menunggu Verifikasi</span>';
        } else if (report.status === 'verified') {
            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200"><span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span>Terverifikasi Dinas</span>';
        } else if (report.status === 'assigned' || report.status === 'in_progress') {
            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5 animate-pulse"></span>Sedang Ditangani Petugas</span>';
        } else if (report.status === 'resolved') {
            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Tuntas Diselesaikan</span>';
        } else if (report.status === 'rejected') {
            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">Laporan Ditolak</span>';
        }

        const catName = report.category?.name || 'Infrastruktur & Lingkungan';
        const reporterTag = isPublicMode ? `<span class="text-[11px] text-slate-400 mr-2">Oleh: ${report.reporter_masked || 'Warga Toba'}</span>` : '';

        return `
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-start space-x-4 flex-1 min-w-0">
                    ${thumb}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 flex-wrap gap-1 mb-1">
                            ${statusBadge}
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                ${catName}
                            </span>
                        </div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 truncate">${report.title}</h3>
                        <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">${report.description}</p>
                        
                        <div class="flex items-center text-[11px] text-slate-400 mt-2 space-x-3">
                            ${reporterTag}
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                ${address}
                            </span>
                            <span class="hidden sm:inline">·</span>
                            <span class="hidden sm:inline">${dateStr}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button: Open Timeline Tracker & View Details -->
                <div class="sm:shrink-0 w-full sm:w-auto pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 flex items-center justify-end space-x-2">
                    <button type="button" onclick="openTimelineModal('${report.id}', '${report.title.replace(/'/g, "\\'")}')"
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center px-3 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs transition cursor-pointer" title="Lacak Cepat">
                        <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Lacak</span>
                    </button>
                    <a href="/citizen/reports/${report.id}"
                       class="flex-1 sm:flex-initial inline-flex items-center justify-center px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-2xs transition cursor-pointer">
                        <span>Rincian</span>
                        <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            { level: 2, title: 'Analisis Awal AI', desc: 'Sistem menganalisis foto dan mendeteksi kategori laporan.' },
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
