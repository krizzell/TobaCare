@extends('layouts.citizen')

@section('title', 'Detail Aspirasi & Progres — TobaCare')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between text-xs text-slate-500">
        <div class="flex items-center space-x-2">
            <a href="/" class="hover:text-slate-900 transition flex items-center">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <span>/</span>
            <a href="/citizen/reports" class="hover:text-slate-900 transition flex items-center font-medium">
                Aspirasi Saya
            </a>
            <span>/</span>
            <span class="text-slate-700 font-semibold" id="breadcrumb-id">Detail Laporan</span>
        </div>

        <div class="flex items-center space-x-2">
            <button type="button" onclick="copyReportLink()" 
                    class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs transition cursor-pointer">
                <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                Bagikan
            </button>
            <button type="button" onclick="window.print()" 
                    class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs transition cursor-pointer">
                <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Tanda Terima
            </button>
        </div>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-2xs space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center space-x-2">
                <span id="detail-code-badge" class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    Memuat...
                </span>
                <span id="detail-category-badge" class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                    -
                </span>
            </div>
            <div id="detail-status-badge" class="px-3.5 py-1.5 rounded-full text-xs font-bold inline-flex items-center">
                Memuat status...
            </div>
        </div>

        <div>
            <h1 id="detail-title" class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">
                Memuat rincian laporan pengaduan...
            </h1>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 mt-2">
                <span class="flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Dilaporkan: <strong id="detail-created-at" class="ml-1 text-slate-700 font-semibold">-</strong>
                </span>
                <span class="text-slate-300">·</span>
                <span class="flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Lokasi: <span id="detail-district" class="ml-1 text-slate-700 font-semibold">-</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Photos & Details (2 spans) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Resolution Banner (Shown only when resolved) -->
            <div id="resolution-banner" class="hidden bg-gradient-to-r from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-md">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-base font-bold">Laporan Telah Selesai Dituntaskan</h2>
                        <p class="text-xs text-emerald-100 leading-relaxed" id="resolution-note-text">
                            Pengerjaan perbaikan fisik di lapangan telah rampung dan diverifikasi tuntas oleh tim teknis dinas terkait.
                        </p>
                        <div class="text-[11px] text-emerald-200 pt-1 font-medium" id="resolution-timestamp"></div>
                    </div>
                </div>

                <!-- Resolution Evidence Container -->
                <div id="citizen-evidence-box" class="hidden mt-4 pt-4 border-t border-white/20">
                    <span class="text-xs font-bold text-white block mb-2">Foto Bukti Hasil Perbaikan Fisik Petugas:</span>
                    <div id="citizen-evidence-gallery" class="grid grid-cols-1 sm:grid-cols-2 gap-3"></div>
                </div>
            </div>

            <!-- Photo Evidence Gallery -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Foto Bukti Pengaduan Warga
                    </h2>
                    <span class="text-[11px] text-slate-400">Klik foto untuk memperbesar</span>
                </div>

                <div id="photos-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="h-44 rounded-2xl bg-slate-100 animate-pulse flex items-center justify-center text-slate-400 text-xs">
                        Memuat foto bukti...
                    </div>
                </div>
            </div>

            <!-- Description & Context -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center border-b border-slate-100 pb-3">
                    <svg class="w-4 h-4 mr-2 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Uraian Masalah
                </h2>

                <div class="space-y-3">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Deskripsi Kejadian</span>
                        <div id="detail-desc" class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line font-normal">
                            Memuat deskripsi...
                        </div>
                    </div>

                    <div id="detail-add-info-box" class="hidden">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Informasi Tambahan / Patokan Khusus</span>
                        <div id="detail-add-info" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 leading-relaxed">
                            -
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center border-b border-slate-100 pb-3">
                    <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Lokasi Titik Masalah
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Alamat / Patokan</span>
                        <p id="detail-address-text" class="font-semibold text-slate-800">Memuat lokasi...</p>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Koordinat GPS</span>
                            <p id="detail-coords-text" class="font-mono text-xs text-slate-700">0.000000, 0.000000</p>
                        </div>
                        <a id="detail-maps-btn" href="#" target="_blank"
                           class="inline-flex items-center text-xs font-bold text-sky-600 hover:text-sky-800 mt-3">
                            <span>Buka di Google Maps</span>
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Timeline & Civic Transparency (1 span) -->
        <div class="space-y-6">

            <!-- Civic Timeline Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Alur Transparansi Penanganan
                    </h2>
                </div>

                <!-- Stepper Progress Bar -->
                <div class="py-2">
                    <div class="flex items-center justify-between text-[11px] font-semibold text-slate-400 mb-2" id="stepper-labels">
                        <span id="st-step-1">1. Lapor</span>
                        <span id="st-step-2">2. Verifikasi</span>
                        <span id="st-step-3">3. Dikerjakan</span>
                        <span id="st-step-4">4. Tuntas</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden flex">
                        <div id="stepper-progress-bar" class="bg-gradient-to-r from-orange-500 via-sky-500 to-emerald-500 h-full w-1/4 transition-all duration-500"></div>
                    </div>
                </div>

                <!-- Vertical Detailed Timeline -->
                <div id="vertical-timeline" class="space-y-4 pt-2">
                    <div class="text-center py-6 text-slate-400 text-xs">Memuat linimasa...</div>
                </div>
            </div>

            <!-- Assigned Department / Operator Card (Civic friendly) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-2xs space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Dinas Penanggung Jawab
                </h3>

                <div class="space-y-2 text-xs">
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">OPD / Instansi Terkait</span>
                        <span id="dept-name" class="font-bold text-slate-800 text-sm block mt-0.5">Dinas PUTR Kab. Toba</span>
                    </div>

                    <div id="operator-info-box" class="hidden p-3 rounded-2xl bg-sky-50/70 border border-sky-200/60">
                        <span class="text-sky-600 block text-[10px] uppercase font-bold">Tim Penanganan Lapangan</span>
                        <span id="operator-name" class="font-bold text-slate-800 block mt-0.5">-</span>
                        <span id="operator-due-date" class="text-slate-500 text-[11px] block mt-0.5">Target: -</span>
                    </div>
                </div>
            </div>

            <!-- Help & Hotline Box -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white shadow-md space-y-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/10 text-rose-300">
                    Bantuan Terpadu
                </span>
                <h3 class="text-sm font-bold">Butuh Penanganan Cepat Darurat?</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Jika kejadian berpotensi membahayakan keselamatan jiwa (seperti jembatan ambruk atau pohon tumbang melintang), segera hubungi Call Center Siaga Toba.
                </p>
                <div class="pt-1 flex items-center space-x-3">
                    <a href="tel:112" class="px-4 py-2 rounded-full bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs transition">
                        Telepon 112 (Bebas Pulsa)
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Photo Lightbox Modal -->
<div id="photo-modal" class="hidden fixed inset-0 z-50 bg-black/85 backdrop-blur-xs flex items-center justify-center p-4" onclick="closePhotoModal()">
    <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col items-center" onclick="event.stopPropagation()">
        <button type="button" onclick="closePhotoModal()" class="absolute -top-10 right-0 text-white/80 hover:text-white p-2 text-xl font-bold cursor-pointer">
            &times; Tutup
        </button>
        <img id="photo-modal-img" src="" alt="Perbesar Foto" class="max-h-[80vh] w-auto max-w-full rounded-2xl shadow-2xl object-contain border border-white/10">
        <p id="photo-modal-caption" class="text-white text-xs mt-3 text-center"></p>
    </div>
</div>

@push('scripts')
<script>
    const reportId = @json($id);
    let currentReport = @json($initialReport ?? null);

    document.addEventListener('DOMContentLoaded', () => {
        if (currentReport) {
            renderReport(currentReport);
        }
        loadReportDetail();
    });

    async function loadReportDetail() {
        try {
            const data = await TobaCare.api(`/api/v1/reports/${reportId}`);
            if (data && data.report) {
                currentReport = data.report;
                renderReport(currentReport);
            }
        } catch (err) {
            console.warn('Live refresh detail failed or token absent:', err);
            // Only toast error if we have no rendered report at all
            if (!currentReport) {
                if (err.status === 403) {
                    TobaCare.toast('Laporan ini bersifat privat atau Anda tidak memiliki akses.', 'error');
                } else if (err.status === 404) {
                    TobaCare.toast('Laporan tidak ditemukan.', 'error');
                } else {
                    TobaCare.toast(err.message || 'Gagal memuat rincian laporan.', 'error');
                }
                setTimeout(() => window.location.href = '/citizen/reports', 2500);
            }
        }
    }

    function renderReport(r) {
        // Code & Category
        const shortId = r.id ? r.id.substring(0, 8).toUpperCase() : 'TBC';
        document.getElementById('breadcrumb-id').textContent = `#${shortId}`;
        document.getElementById('detail-code-badge').textContent = `#${shortId}`;
        document.getElementById('detail-category-badge').textContent = r.category ? r.category.name : 'Umum';
        
        // Department Name based on category
        const deptEl = document.getElementById('dept-name');
        if (r.category && r.category.name.toLowerCase().includes('jalan')) {
            deptEl.textContent = 'Dinas Pekerjaan Umum & Tata Ruang (PUTR)';
        } else if (r.category && r.category.name.toLowerCase().includes('sampah')) {
            deptEl.textContent = 'Dinas Lingkungan Hidup Kab. Toba';
        } else if (r.category && r.category.name.toLowerCase().includes('lampu')) {
            deptEl.textContent = 'Dinas Perhubungan Kab. Toba';
        } else {
            deptEl.textContent = 'Pemerintah Kabupaten Toba';
        }

        // Title & Date
        document.getElementById('detail-title').textContent = r.title;
        document.getElementById('detail-created-at').textContent = formatDateTime(r.created_at);
        document.getElementById('detail-desc').textContent = r.description;

        // Additional Info
        if (r.additional_info && r.additional_info.trim() !== '') {
            document.getElementById('detail-add-info-box').classList.remove('hidden');
            document.getElementById('detail-add-info').textContent = r.additional_info;
        }

        // Status Badge
        const statusEl = document.getElementById('detail-status-badge');
        statusEl.className = `px-3.5 py-1.5 rounded-full text-xs font-bold inline-flex items-center ${getStatusBadgeClass(r.status)}`;
        statusEl.innerHTML = getStatusLabel(r.status);

        // Location
        if (r.location) {
            document.getElementById('detail-district').textContent = r.location.address_text || 'Kabupaten Toba';
            document.getElementById('detail-address-text').textContent = r.location.address_text || 'Alamat tidak dicantumkan';
            document.getElementById('detail-coords-text').textContent = `${Number(r.location.latitude).toFixed(6)}, ${Number(r.location.longitude).toFixed(6)}`;
            document.getElementById('detail-maps-btn').href = `https://www.google.com/maps?q=${r.location.latitude},${r.location.longitude}`;
        }

        // Photos Gallery
        const photosGrid = document.getElementById('photos-grid');
        photosGrid.innerHTML = '';
        if (r.images && r.images.length > 0) {
            r.images.forEach((img, idx) => {
                let imgUrl = img.url || (img.storage_key ? `/storage/${img.storage_key}` : '');
                if (imgUrl && imgUrl.includes('/storage/')) {
                    imgUrl = '/storage/' + imgUrl.split('/storage/')[1];
                }
                const imgCard = document.createElement('div');
                imgCard.className = 'group relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 aspect-4/3 cursor-pointer shadow-2xs hover:shadow-md transition';
                imgCard.onclick = () => openPhotoModal(imgUrl, `Foto Bukti #${idx + 1} — ${r.title}`);
                imgCard.innerHTML = `
                    <img src="${imgUrl}" alt="Foto Bukti" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                        <span class="text-[11px] text-white font-medium flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                            Klik untuk perbesar
                        </span>
                    </div>
                `;
                photosGrid.appendChild(imgCard);
            });
        } else {
            photosGrid.innerHTML = `
                <div class="sm:col-span-2 py-8 text-center text-slate-400 text-xs bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    Tidak ada lampiran foto.
                </div>
            `;
        }

        // Operator assignment (if any)
        const assignment = r.active_assignment || r.activeAssignment;
        if (assignment && assignment.operator) {
            const opBox = document.getElementById('operator-info-box');
            if (opBox) opBox.classList.remove('hidden');
            const opNameEl = document.getElementById('operator-name');
            if (opNameEl) opNameEl.textContent = assignment.operator.name || 'Petugas Lapangan';
            if (assignment.due_date) {
                const opDueEl = document.getElementById('operator-due-date');
                if (opDueEl) opDueEl.textContent = `Target: ${formatDate(assignment.due_date)}`;
            }
        }

        // Resolution Banner (if resolved)
        if (r.status === 'resolved') {
            const resBanner = document.getElementById('resolution-banner');
            if (resBanner) resBanner.classList.remove('hidden');
            
            // Check status history for resolution note
            const historyList = r.status_history || r.statusHistory || [];
            const resolvedEntry = historyList.find(h => h.to_status === 'resolved');
            if (resolvedEntry && resolvedEntry.note) {
                const noteEl = document.getElementById('resolution-note-text');
                if (noteEl) noteEl.textContent = resolvedEntry.note;
            }
            if (resolvedEntry && resolvedEntry.created_at) {
                const tsEl = document.getElementById('resolution-timestamp');
                if (tsEl) tsEl.textContent = `Dituntaskan pada: ${formatDateTime(resolvedEntry.created_at)}`;
            }

            // Display resolution evidences if available
            const evidences = r.resolution_evidences || r.resolutionEvidences || [];
            const evBox = document.getElementById('citizen-evidence-box');
            const evGallery = document.getElementById('citizen-evidence-gallery');
            if (evBox && evGallery && evidences.length > 0) {
                evBox.classList.remove('hidden');
                evGallery.innerHTML = evidences.map(ev => `
                    <div class="rounded-2xl overflow-hidden bg-white/10 p-1.5 border border-white/20">
                        <img src="${ev.url}" alt="Foto Bukti Perbaikan" class="w-full h-36 object-cover rounded-xl cursor-pointer" onclick="openLightbox('${ev.url}', 'Foto Hasil Perbaikan Fisik Petugas')">
                        ${ev.note ? `<p class="text-[11px] text-emerald-100 p-1.5 italic font-medium">"${ev.note}"</p>` : ''}
                    </div>
                `).join('');
            }
        }

        // Stepper & Vertical Timeline
        renderTimeline(r);
    }

    function renderTimeline(r) {
        const statuses = ['submitted', 'verified', 'in_progress', 'resolved'];
        const currentIdx = statuses.indexOf(r.status);

        // Progress bar width
        const bar = document.getElementById('stepper-progress-bar');
        const st1 = document.getElementById('st-step-1');
        const st2 = document.getElementById('st-step-2');
        const st3 = document.getElementById('st-step-3');
        const st4 = document.getElementById('st-step-4');

        if (r.status === 'submitted' || r.status === 'ai_analysis' || r.status === 'pending_verification') {
            bar.style.width = '25%';
            st1.className = 'text-rose-600 font-bold';
        } else if (r.status === 'verified' || r.status === 'assigned') {
            bar.style.width = '50%';
            st1.className = 'text-emerald-600 font-semibold';
            st2.className = 'text-sky-600 font-bold';
        } else if (r.status === 'in_progress') {
            bar.style.width = '75%';
            st1.className = 'text-emerald-600 font-semibold';
            st2.className = 'text-emerald-600 font-semibold';
            st3.className = 'text-sky-600 font-bold';
        } else if (r.status === 'resolved') {
            bar.style.width = '100%';
            st1.className = 'text-emerald-600 font-semibold';
            st2.className = 'text-emerald-600 font-semibold';
            st3.className = 'text-emerald-600 font-semibold';
            st4.className = 'text-emerald-600 font-bold';
        } else if (r.status === 'rejected') {
            bar.style.width = '50%';
            bar.className = 'bg-rose-500 h-full w-1/2';
        }

        // Render vertical timeline history
        const vTimeline = document.getElementById('vertical-timeline');
        vTimeline.innerHTML = '';

        const history = (r.status_history || r.statusHistory || []).slice().reverse();

        if (history.length === 0) {
            vTimeline.innerHTML = `
                <div class="p-3 rounded-2xl bg-slate-50 text-xs text-slate-500">
                    Laporan baru saja dikirim dan menunggu antrean verifikasi dinas.
                </div>
            `;
            return;
        }

        history.forEach((h, idx) => {
            const item = document.createElement('div');
            item.className = 'relative pl-6 pb-4 border-l-2 border-slate-200 last:border-transparent last:pb-0';
            
            // Dot color
            let dotColor = 'bg-slate-400';
            if (h.to_status === 'resolved') dotColor = 'bg-emerald-500 ring-4 ring-emerald-100';
            else if (h.to_status === 'rejected') dotColor = 'bg-rose-500 ring-4 ring-rose-100';
            else if (h.to_status === 'in_progress') dotColor = 'bg-sky-500 ring-4 ring-sky-100';
            else if (h.to_status === 'verified' || h.to_status === 'assigned') dotColor = 'bg-indigo-500 ring-4 ring-indigo-100';
            else if (idx === 0) dotColor = 'bg-rose-500 ring-4 ring-rose-100';

            item.innerHTML = `
                <span class="absolute -left-[7px] top-1 w-3 h-3 rounded-full ${dotColor}"></span>
                <div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-800">${getCivicTimelineTitle(h.to_status)}</span>
                        <span class="text-[10px] text-slate-400 font-mono">${formatDateTime(h.created_at)}</span>
                    </div>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-200/60">
                        ${h.note || getCivicTimelineDesc(h.to_status)}
                    </p>
                </div>
            `;
            vTimeline.appendChild(item);
        });
    }

    function getCivicTimelineTitle(status) {
        switch (status) {
            case 'submitted': return 'Laporan Diterima Sistem';
            case 'ai_analysis': return 'Analisis Awal Citra';
            case 'pending_verification': return 'Antrean Verifikasi Dinas';
            case 'verified': return 'Laporan Disetujui / Diverifikasi';
            case 'assigned': return 'Petugas Lapangan Ditugaskan';
            case 'in_progress': return 'Pengerjaan Perbaikan Berlangsung';
            case 'resolved': return 'Penanganan Tuntas Selesai';
            case 'rejected': return 'Laporan Tidak Dapat Diproses';
            default: return 'Pembaruan Status';
        }
    }

    function getCivicTimelineDesc(status) {
        switch (status) {
            case 'submitted': return 'Aspirasi warga telah tercatat di basis data terpadu.';
            case 'verified': return 'Admin dinas telah memverifikasi kesesuaian lokasi dan kelayakan pengaduan.';
            case 'assigned': return 'Surat tugas penanganan telah diteruskan ke tim pelaksana lapangan.';
            case 'in_progress': return 'Petugas berada di lokasi melakukan pengerjaan fisik atau perbaikan teknis.';
            case 'resolved': return 'Pekerjaan telah rampung dan fasilitas dapat digunakan kembali secara layak.';
            case 'rejected': return 'Laporan belum memenuhi kriteria atau merupakan duplikasi pengaduan aktif.';
            default: return 'Informasi status diperbarui.';
        }
    }

    function getStatusLabel(s) {
        switch (s) {
            case 'submitted': return '<span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Menunggu Verifikasi';
            case 'verified': return '<span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> Diverifikasi Dinas';
            case 'assigned': return '<span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5"></span> Petugas Ditugaskan';
            case 'in_progress': return '<span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span> Sedang Dikerjakan';
            case 'resolved': return '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Selesai Dituntaskan';
            case 'rejected': return '<span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Laporan Ditolak';
            default: return s;
        }
    }

    function getStatusBadgeClass(s) {
        switch (s) {
            case 'submitted': return 'bg-amber-50 text-amber-700 border border-amber-200';
            case 'verified': return 'bg-blue-50 text-blue-700 border border-blue-200';
            case 'assigned': return 'bg-indigo-50 text-indigo-700 border border-indigo-200';
            case 'in_progress': return 'bg-sky-50 text-sky-700 border border-sky-200';
            case 'resolved': return 'bg-emerald-50 text-emerald-700 border border-emerald-200';
            case 'rejected': return 'bg-rose-50 text-rose-700 border border-rose-200';
            default: return 'bg-slate-100 text-slate-700 border border-slate-200';
        }
    }

    function formatDateTime(str) {
        if (!str) return '-';
        const d = new Date(str);
        return d.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    }

    function formatDate(str) {
        if (!str) return '-';
        const d = new Date(str);
        return d.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        });
    }

    function copyReportLink() {
        navigator.clipboard.writeText(window.location.href);
        TobaCare.toast('Tautan pengaduan berhasil disalin ke papan klip!', 'success');
    }

    function openPhotoModal(url, caption) {
        const modal = document.getElementById('photo-modal');
        document.getElementById('photo-modal-img').src = url;
        document.getElementById('photo-modal-caption').textContent = caption || '';
        modal.classList.remove('hidden');
    }

    function closePhotoModal() {
        document.getElementById('photo-modal').classList.add('hidden');
    }
</script>
@endpush
@endsection
