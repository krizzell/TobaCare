@extends('layouts.admin')

@section('title', 'Detail Tugas Lapangan — Operator TobaCare')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Breadcrumb & Navigation -->
    <div class="flex items-center space-x-2 text-xs text-slate-500">
        <a href="/operator/reports" class="hover:text-slate-900 transition flex items-center">
            <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Tugas
        </a>
        <span>/</span>
        <span class="text-slate-700 font-medium">Penanganan Lapangan</span>
    </div>

    <!-- Header & Action Bar -->
    <div class="bg-white rounded-2xl shadow-2xs border border-slate-200/80 p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <span id="detail-status-badge" class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                    Memuat status...
                </span>
                <span id="detail-priority-badge" class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    -
                </span>
                <span id="detail-date" class="text-xs text-slate-500"></span>
            </div>
            <h1 id="detail-title" class="text-xl sm:text-2xl font-bold text-slate-900 leading-tight">Memuat tugas lapangan...</h1>
            <p id="detail-category-location" class="text-xs text-slate-500 mt-1"></p>
        </div>

        <!-- Action Buttons Container -->
        <div id="detail-actions" class="flex flex-wrap items-center gap-2">
            <!-- Dynamically populated based on status -->
        </div>
    </div>

    <!-- Main Workspace (Grid 2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Photos, Details, Location, & Evidence (Span 2) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Citizen Photo Evidence Gallery -->
            <div class="bg-white rounded-2xl shadow-2xs border border-slate-200/80 p-6">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Foto Bukti Kerusakan dari Warga
                </h2>
                <div id="photo-gallery" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="h-48 rounded-xl bg-slate-100 animate-pulse flex items-center justify-center text-slate-400 text-xs">
                        Memuat foto...
                    </div>
                </div>
            </div>

            <!-- Description & Context -->
            <div class="bg-white rounded-2xl shadow-2xs border border-slate-200/80 p-6 space-y-4">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Deskripsi Masalah dari Pelapor
                </h2>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 text-slate-800 text-sm leading-relaxed whitespace-pre-line" id="detail-description">
                    Memuat deskripsi...
                </div>

                <div id="additional-info-box" class="hidden">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Informasi Tambahan / Patokan Khusus</h3>
                    <p id="detail-additional-info" class="text-sm text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200/70"></p>
                </div>
            </div>

            <!-- Location & Navigation Details -->
            <div class="bg-white rounded-2xl shadow-2xs border border-slate-200/80 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Titik Lokasi & Navigasi Lapangan
                    </h2>
                    <a id="detail-map-btn" href="#" target="_blank"
                       class="inline-flex items-center px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100 text-xs font-semibold transition border border-sky-200">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-slate-50 p-4 rounded-xl border border-slate-200/70">
                    <div>
                        <span class="text-xs text-slate-500 block">Alamat / Patokan Jalan:</span>
                        <span id="detail-address" class="font-medium text-slate-800 block mt-0.5">-</span>
                        <span id="detail-region" class="text-xs text-slate-500 mt-1 block">Wilayah: -</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">Koordinat Geografis:</span>
                        <span id="detail-coordinates" class="font-mono text-xs font-semibold text-slate-700 block mt-0.5">-</span>
                        <span class="text-[11px] text-slate-400 mt-1 block">Dapat langsung dibuka di aplikasi navigasi GPS di ponsel petugas.</span>
                    </div>
                </div>
            </div>

            <!-- Resolution Evidence (FR-23 / Bukti Penyelesaian Lapangan) -->
            <div class="bg-white rounded-2xl shadow-2xs border border-slate-200/80 p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Bukti Fisik Penyelesaian Lapangan (Resolution Evidence)
                    </h2>
                    <span id="evidence-count-badge" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                        0 Foto Bukti
                    </span>
                </div>

                <div id="evidence-list" class="space-y-4">
                    <!-- Populated dynamically -->
                </div>

                <!-- Action to add more evidence if in_progress or resolved -->
                <div id="add-evidence-box" class="hidden pt-3 border-t border-slate-100">
                    <button type="button" onclick="openEvidenceModal()"
                            class="inline-flex items-center px-4 py-2 rounded-xl border border-dashed border-emerald-300 bg-emerald-50/50 hover:bg-emerald-50 text-emerald-700 font-semibold text-xs transition cursor-pointer">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Unggah Foto Bukti Tambahan
                    </button>
                </div>
            </div>

        </div>

        <!-- Right Column: Assignment Details, Action Box, & Status Timeline (Span 1) -->
        <div class="space-y-6">

            <!-- Assignment Info Panel -->
            <div class="bg-white rounded-2xl shadow-2xs border border-slate-200/80 p-6 space-y-4">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 border-b border-slate-100 pb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Informasi Penugasan
                </h2>
                
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium">Ditugaskan Oleh Admin:</span>
                        <span id="assignee-admin" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Instansi / Unit Kerja:</span>
                        <span id="assignee-agency" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Batas Waktu Penanganan (Due Date):</span>
                        <span id="assignee-due-date" class="font-bold text-amber-700">-</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Catatan / Arahan Admin:</span>
                        <p id="assignee-note" class="text-slate-700 italic bg-slate-50 p-2.5 rounded-lg border border-slate-200/60 mt-1">-</p>
                    </div>
                </div>
            </div>

            <!-- Workflow Action Box -->
            <div id="quick-action-card" class="bg-white rounded-2xl shadow-2xs border border-slate-200/80 p-6 space-y-3">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 border-b border-slate-100 pb-2">
                    Aksi Petugas Lapangan
                </h2>
                <div id="quick-action-content" class="space-y-2">
                    <!-- Dynamic button per status -->
                </div>
            </div>

            <!-- Status History Timeline -->
            <div class="bg-white rounded-2xl shadow-2xs border border-slate-200/80 p-6">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-4 border-b border-slate-100 pb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Penanganan
                </h2>
                <div id="status-timeline" class="space-y-4">
                    <!-- Populated dynamically -->
                </div>
            </div>

        </div>

    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. Modal Selesaikan Pengerjaan (Resolve Modal with Evidence Upload) -->
<div id="modal-resolve" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-lg font-bold text-slate-900">Selesaikan Pengerjaan Lapangan</h3>
            <button type="button" onclick="closeResolveModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <p class="text-xs text-slate-500">
            Laporkan hasil penanganan fisik kerusakan dan unggah foto bukti perbaikan. Laporan ini akan dipublikasikan dan diberitahukan langsung ke pelapor.
        </p>

        <!-- Foto Bukti Upload -->
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">
                Foto Bukti Fisik Penyelesaian <span class="text-emerald-600 font-bold">*</span>
            </label>
            <div class="border-2 border-dashed border-slate-200 hover:border-emerald-400 rounded-xl p-4 text-center cursor-pointer transition bg-slate-50/50 hover:bg-emerald-50/30"
                 onclick="document.getElementById('resolve-evidence-input').click()">
                <input type="file" id="resolve-evidence-input" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="handleResolveEvidenceSelect(event)">
                <div id="resolve-evidence-placeholder" class="space-y-1">
                    <svg class="w-8 h-8 mx-auto text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-xs font-semibold text-slate-700 block">Klik untuk Mengambil / Memilih Foto Bukti</span>
                    <span class="text-[10px] text-slate-400 block">JPG, PNG, atau WebP (Maks. 5 MB)</span>
                </div>
                <div id="resolve-evidence-preview" class="hidden flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200">
                    <div class="flex items-center space-x-2.5 min-w-0">
                        <img id="resolve-evidence-img" src="" alt="Bukti" class="w-12 h-12 rounded-lg object-cover border border-slate-200 shrink-0">
                        <span id="resolve-evidence-filename" class="text-xs font-semibold text-slate-800 truncate block">bukti.jpg</span>
                    </div>
                    <button type="button" onclick="event.stopPropagation(); removeResolveEvidence();" class="text-xs text-rose-600 font-bold hover:underline px-2">Hapus</button>
                </div>
            </div>
        </div>

        <div>
            <label for="resolve-note" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Penyelesaian Lapangan <span class="text-rose-500">*</span></label>
            <textarea id="resolve-note" rows="3" required
                      placeholder="Contoh: Aspal berlubang telah ditambal dengan hotmix sedalam 5 cm. Alur jalan kembali mulus dan aman dilewati kendaraan."
                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-2 border-t border-slate-100">
            <button type="button" onclick="closeResolveModal()"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                Batal
            </button>
            <button type="button" id="btn-submit-resolve" onclick="submitResolve()"
                    class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-sm font-semibold text-white shadow-xs transition flex items-center space-x-1.5 cursor-pointer">
                <span>Konfirmasi Selesai</span>
            </button>
        </div>
    </div>
</div>

<!-- 2. Modal Unggah Bukti Tambahan (Standalone Evidence Upload) -->
<div id="modal-evidence-standalone" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-lg font-bold text-slate-900">Unggah Foto Bukti Lapangan</h3>
            <button type="button" onclick="closeEvidenceModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Berkas Foto <span class="text-rose-500">*</span></label>
            <input type="file" id="standalone-evidence-file" accept="image/jpeg,image/png,image/webp"
                   class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
        </div>

        <div>
            <label for="standalone-evidence-note" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Keterangan Foto (Opsional)</label>
            <input type="text" id="standalone-evidence-note" placeholder="Contoh: Kondisi fisik setelah pembersihan material"
                   class="w-full px-3.5 py-2 rounded-lg border border-slate-300 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>

        <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
            <button type="button" onclick="closeEvidenceModal()" class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700">Batal</button>
            <button type="button" id="btn-submit-standalone-evidence" onclick="submitStandaloneEvidence()"
                    class="px-4 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-xs font-semibold text-white">Unggah Bukti</button>
        </div>
    </div>
</div>

<!-- 3. Modal Lightbox Foto -->
<div id="image-lightbox-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/80 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-3xl w-full p-4 shadow-2xl border border-slate-200 space-y-3">
        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
            <h3 id="lightbox-title" class="text-sm font-bold text-slate-900 truncate">Foto Bukti</h3>
            <button type="button" onclick="closeLightbox()" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="rounded-xl overflow-hidden bg-slate-950 flex items-center justify-center max-h-[75vh]">
            <img id="lightbox-img" src="" alt="Foto Bukti" class="max-h-[75vh] w-auto object-contain">
        </div>
        <div class="text-right pt-1">
            <button type="button" onclick="closeLightbox()"
                    class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const reportId = @json($id);
    let currentReport = null;
    let selectedResolveEvidenceFile = null;

    async function loadReportDetail() {
        try {
            const res = await TobaCare.api(`/api/v1/operator/reports/${reportId}`);
            currentReport = res.report;
            renderReport(currentReport);
        } catch (err) {
            TobaCare.toast(err.message || 'Gagal memuat data laporan tugas.', 'error');
        }
    }

    function renderReport(r) {
        if (!r) return;

        // Title and meta
        document.getElementById('detail-title').textContent = r.title || 'Tanpa Judul';
        const dateStr = r.created_at ? new Date(r.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '';
        document.getElementById('detail-date').textContent = dateStr;

        const catName = r.category?.name || 'Kategori Umum';
        const regionStr = r.location?.region ? `di ${r.location.region}` : '';
        document.getElementById('detail-category-location').textContent = `${catName} ${regionStr}`;

        // Status badge
        const statusBadge = document.getElementById('detail-status-badge');
        if (r.status === 'assigned') {
            statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200';
            statusBadge.textContent = 'Ditugaskan (Menunggu Mulai)';
        } else if (r.status === 'in_progress') {
            statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 border border-sky-200';
            statusBadge.textContent = 'Sedang Dikerjakan';
        } else if (r.status === 'resolved') {
            statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200';
            statusBadge.textContent = 'Tuntas Dikerjakan (Resolved)';
        } else {
            statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700';
            statusBadge.textContent = r.status;
        }

        // Priority badge
        const prioBadge = document.getElementById('detail-priority-badge');
        const prio = r.priority_final || 'medium';
        if (prio === 'critical') {
            prioBadge.className = 'px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200';
            prioBadge.textContent = 'Prioritas Kritis';
        } else if (prio === 'high') {
            prioBadge.className = 'px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200';
            prioBadge.textContent = 'Prioritas Tinggi';
        } else if (prio === 'medium') {
            prioBadge.className = 'px-2.5 py-1 rounded-full text-xs font-medium bg-sky-100 text-sky-700 border border-sky-200';
            prioBadge.textContent = 'Prioritas Sedang';
        } else {
            prioBadge.className = 'px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200';
            prioBadge.textContent = 'Prioritas Rendah';
        }

        // Photos gallery
        const photoGallery = document.getElementById('photo-gallery');
        if (r.images && r.images.length > 0) {
            photoGallery.innerHTML = r.images.map(img => `
                <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-slate-100 aspect-video cursor-pointer"
                     onclick="openLightbox('${img.url}', '${r.title.replace(/'/g, "\\'")}')">
                    <img src="${img.url}" alt="Foto Bukti" class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                    <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-semibold">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                        </svg>
                        Perbesar Foto
                    </div>
                </div>
            `).join('');
        } else {
            photoGallery.innerHTML = '<div class="col-span-2 py-8 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">Pelapor tidak menyertakan foto.</div>';
        }

        // Description
        document.getElementById('detail-description').textContent = r.description || '-';
        if (r.additional_info) {
            document.getElementById('detail-additional-info').textContent = r.additional_info;
            document.getElementById('additional-info-box').classList.remove('hidden');
        }

        // Location
        const loc = r.location;
        if (loc) {
            document.getElementById('detail-address').textContent = loc.address_text || 'Patokan tidak ditulis';
            document.getElementById('detail-region').textContent = `Wilayah: ${loc.region || 'Kab. Toba'}`;
            const coords = `${Number(loc.latitude).toFixed(6)}, ${Number(loc.longitude).toFixed(6)}`;
            document.getElementById('detail-coordinates').textContent = coords;
            document.getElementById('detail-map-btn').href = `https://www.google.com/maps/search/?api=1&query=${loc.latitude},${loc.longitude}`;
        }

        // Assignment box
        const assign = r.active_assignment;
        if (assign) {
            document.getElementById('assignee-admin').textContent = assign.assigned_by?.name || 'Administrator';
            document.getElementById('assignee-agency').textContent = assign.agency?.name || 'Dinas Pekerjaan Umum / Lapangan';
            document.getElementById('assignee-due-date').textContent = assign.due_date ? new Date(assign.due_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : 'Tidak ada tenggat waktu';
            document.getElementById('assignee-note').textContent = assign.note || 'Tidak ada catatan tambahan.';
        }

        // Resolution Evidence
        const evidences = r.resolution_evidences || [];
        document.getElementById('evidence-count-badge').textContent = `${evidences.length} Foto Bukti`;
        const evidenceList = document.getElementById('evidence-list');

        if (evidences.length > 0) {
            evidenceList.innerHTML = evidences.map(ev => `
                <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/40 space-y-3">
                    <div class="flex items-start space-x-4">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-xl overflow-hidden border border-emerald-300 bg-white shrink-0 cursor-pointer group relative"
                             onclick="openLightbox('${ev.url}', 'Bukti Penyelesaian Lapangan')">
                            <img src="${ev.url}" alt="Bukti Selesai" class="w-full h-full object-cover group-hover:scale-105 transition">
                            <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-[10px]">
                                Perbesar
                            </div>
                        </div>
                        <div class="flex-1 min-w-0 text-xs space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-600 text-white text-[10px] font-bold">Bukti Fisik Tuntas</span>
                                <span class="text-slate-400 text-[11px]">${ev.created_at ? new Date(ev.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : ''}</span>
                            </div>
                            <p class="text-slate-800 font-semibold text-sm pt-1 leading-relaxed">
                                "${ev.note || 'Pekerjaan perbaikan fisik telah diselesaikan oleh operator.'}"
                            </p>
                            <span class="text-slate-500 text-[11px] block pt-1">
                                Diunggah oleh: <strong>${ev.uploader?.name || 'Operator Lapangan'}</strong>
                            </span>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            evidenceList.innerHTML = `
                <div class="py-6 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    Belum ada foto bukti penyelesaian yang diunggah.
                </div>
            `;
        }

        if (r.status === 'in_progress' || r.status === 'resolved') {
            document.getElementById('add-evidence-box').classList.remove('hidden');
        }

        // Render Action Buttons
        renderActionButtons(r);

        // Status Timeline
        renderTimeline(r.status_history || []);
    }

    function renderActionButtons(r) {
        const topActions = document.getElementById('detail-actions');
        const quickActions = document.getElementById('quick-action-content');
        topActions.innerHTML = '';
        quickActions.innerHTML = '';

        if (r.status === 'assigned') {
            topActions.innerHTML = `
                <button type="button" onclick="startProgress()"
                        class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-xs transition flex items-center cursor-pointer">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    </svg>
                    Mulai Kerjakan di Lapangan
                </button>
            `;
            quickActions.innerHTML = `
                <p class="text-xs text-slate-500 mb-2">Tugas baru telah ditetapkan oleh administrator. Tekan tombol di bawah saat tiba di lokasi untuk mengubah status menjadi sedang dikerjakan.</p>
                <button type="button" onclick="startProgress()"
                        class="w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-xs transition flex items-center justify-center cursor-pointer">
                    Mulai Pengerjaan Fisik
                </button>
            `;
        } else if (r.status === 'in_progress') {
            topActions.innerHTML = `
                <button type="button" onclick="openResolveModal()"
                        class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition flex items-center cursor-pointer">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Tandai Selesai & Unggah Bukti
                </button>
            `;
            quickActions.innerHTML = `
                <p class="text-xs text-slate-500 mb-2">Pekerjaan sedang berlangsung. Bila perbaikan fisik di lokasi sudah tuntas, unggah foto bukti dan konfirmasi penyelesaian.</p>
                <button type="button" onclick="openResolveModal()"
                        class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center cursor-pointer">
                    Selesaikan Pekerjaan
                </button>
            `;
        } else if (r.status === 'resolved') {
            topActions.innerHTML = `
                <span class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">
                    <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    Pekerjaan Tuntas Dilaksanakan
                </span>
            `;
            quickActions.innerHTML = `
                <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-start space-x-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Laporan ini telah ditandai selesai. Terima kasih atas dedikasi dan pelayanan bagi warga Kab. Toba!</span>
                </div>
            `;
        }
    }

    function renderTimeline(history) {
        const container = document.getElementById('status-timeline');
        if (!history || history.length === 0) {
            container.innerHTML = '<p class="text-xs text-slate-400">Belum ada riwayat aktivitas.</p>';
            return;
        }

        container.innerHTML = history.map((item, idx) => {
            const isLast = idx === history.length - 1;
            const time = item.created_at ? new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' }) : '';
            return `
                <div class="relative pl-6 pb-4 ${isLast ? '' : 'border-l-2 border-slate-200'}">
                    <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full ${isLast ? 'bg-emerald-500 ring-4 ring-emerald-100' : 'bg-slate-300'}"></div>
                    <div class="text-xs">
                        <span class="font-bold text-slate-800 uppercase tracking-wider">${item.to_status}</span>
                        <span class="text-slate-400 text-[10px] ml-1.5">${time}</span>
                    </div>
                    ${item.note ? `<p class="text-xs text-slate-600 mt-0.5 italic">"${item.note}"</p>` : ''}
                    ${item.user?.name ? `<span class="text-[10px] text-slate-400 block mt-0.5">Oleh: ${item.user.name}</span>` : ''}
                </div>
            `;
        }).join('');
    }

    function startProgress() {
        TobaCare.confirm({
            title: 'Mulai Penanganan Lapangan',
            message: 'Konfirmasi untuk memulai pekerjaan fisik untuk laporan ini? Status akan diperbarui menjadi "Sedang Dikerjakan" (in_progress) dan notifikasi akan dikirimkan ke pelapor.',
            confirmText: 'Mulai Penanganan',
            confirmClass: 'bg-amber-500 hover:bg-amber-600 text-white',
            onConfirm: async () => {
                try {
                    await TobaCare.api(`/api/v1/operator/reports/${reportId}/start-progress`, {
                        method: 'POST',
                    });
                    TobaCare.toast('Pekerjaan dimulai! Status diubah menjadi sedang dikerjakan.', 'success');
                    loadReportDetail();
                } catch (err) {
                    TobaCare.toast(err.message || 'Gagal memulai pekerjaan.', 'error');
                }
            }
        });
    }

    function openResolveModal() {
        document.getElementById('resolve-note').value = '';
        removeResolveEvidence();
        document.getElementById('modal-resolve').classList.remove('hidden');
    }

    function closeResolveModal() {
        removeResolveEvidence();
        document.getElementById('modal-resolve').classList.add('hidden');
    }

    function handleResolveEvidenceSelect(e) {
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 5 * 1024 * 1024) {
            TobaCare.toast('Ukuran foto bukti melebihi 5 MB.', 'warning');
            e.target.value = '';
            return;
        }
        selectedResolveEvidenceFile = file;
        const reader = new FileReader();
        reader.onload = (evt) => {
            document.getElementById('resolve-evidence-img').src = evt.target.result;
            document.getElementById('resolve-evidence-filename').textContent = file.name;
            document.getElementById('resolve-evidence-placeholder').classList.add('hidden');
            document.getElementById('resolve-evidence-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function removeResolveEvidence() {
        selectedResolveEvidenceFile = null;
        const input = document.getElementById('resolve-evidence-input');
        if (input) input.value = '';
        const img = document.getElementById('resolve-evidence-img');
        if (img) img.src = '';
        const ph = document.getElementById('resolve-evidence-placeholder');
        if (ph) ph.classList.remove('hidden');
        const prev = document.getElementById('resolve-evidence-preview');
        if (prev) prev.classList.add('hidden');
    }

    async function submitResolve() {
        const note = document.getElementById('resolve-note').value.trim();
        if (note.length < 5) {
            TobaCare.toast('Catatan penyelesaian minimal 5 karakter.', 'warning');
            return;
        }

        const btn = document.getElementById('btn-submit-resolve');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        try {
            const formData = new FormData();
            formData.append('note', note);
            if (selectedResolveEvidenceFile) {
                formData.append('evidence_image', selectedResolveEvidenceFile);
            }

            const token = TobaCare.getToken();
            const res = await fetch(`/api/v1/operator/reports/${reportId}/resolve`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const json = await res.json();
            if (!res.ok) {
                throw new Error(json.message || json.error?.message || 'Gagal menyelesaikan laporan.');
            }

            TobaCare.toast('Laporan pengerjaan berhasil diselesaikan!', 'success');
            closeResolveModal();
            loadReportDetail();
        } catch (err) {
            TobaCare.toast(err.message || 'Gagal menyelesaikan laporan.', 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Konfirmasi Selesai';
        }
    }

    function openEvidenceModal() {
        document.getElementById('standalone-evidence-file').value = '';
        document.getElementById('standalone-evidence-note').value = '';
        document.getElementById('modal-evidence-standalone').classList.remove('hidden');
    }

    function closeEvidenceModal() {
        document.getElementById('modal-evidence-standalone').classList.add('hidden');
    }

    async function submitStandaloneEvidence() {
        const fileInput = document.getElementById('standalone-evidence-file');
        const file = fileInput.files[0];
        if (!file) {
            TobaCare.toast('Silakan pilih berkas foto bukti terlebih dahulu.', 'warning');
            return;
        }

        const note = document.getElementById('standalone-evidence-note').value.trim();
        const btn = document.getElementById('btn-submit-standalone-evidence');
        btn.disabled = true;
        btn.textContent = 'Mengunggah...';

        try {
            const formData = new FormData();
            formData.append('file', file);
            if (note) formData.append('note', note);

            const token = TobaCare.getToken();
            const res = await fetch(`/api/v1/operator/reports/${reportId}/evidence`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const json = await res.json();
            if (!res.ok) {
                throw new Error(json.message || json.error?.message || 'Gagal mengunggah foto bukti.');
            }

            TobaCare.toast('Foto bukti berhasil diunggah!', 'success');
            closeEvidenceModal();
            loadReportDetail();
        } catch (err) {
            TobaCare.toast(err.message || 'Gagal mengunggah foto bukti.', 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Unggah Bukti';
        }
    }

    function openLightbox(url, title) {
        document.getElementById('lightbox-img').src = url;
        document.getElementById('lightbox-title').textContent = title || 'Foto Bukti';
        document.getElementById('image-lightbox-modal').classList.remove('hidden');
    }

    function closeLightbox() {
        document.getElementById('image-lightbox-modal').classList.add('hidden');
        document.getElementById('lightbox-img').src = '';
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadReportDetail();
    });
</script>
@endpush
@endsection
