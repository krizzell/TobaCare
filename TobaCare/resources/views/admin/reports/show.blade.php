@extends('layouts.admin')

@section('title', 'Tinjauan Laporan — TobaCare')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Breadcrumb & Navigation -->
    <div class="flex items-center space-x-2 text-xs text-slate-500">
        <a href="/admin/reports" class="hover:text-slate-900 transition flex items-center">
            <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Antrean
        </a>
        <span>/</span>
        <span class="text-slate-700 font-medium">Detail Verifikasi</span>
    </div>

    <!-- Header & Action Bar -->
    <div class="bg-white rounded-xl shadow-xs border border-slate-200 p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <span id="detail-status-badge" class="px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                    Memuat status...
                </span>
                <span id="detail-date" class="text-xs text-slate-500"></span>
            </div>
            <h1 id="detail-title" class="text-2xl font-bold text-slate-900 leading-tight">Memuat judul laporan...</h1>
            <p id="detail-reporter" class="text-xs text-slate-500 mt-1"></p>
        </div>

        <!-- Action Buttons Container -->
        <div id="detail-actions" class="flex flex-wrap items-center gap-2">
            <!-- Dynamically populated based on status -->
        </div>
    </div>

    <!-- Main Workspace (Grid 2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Photos & Report Details (Span 2) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Photo Evidence Gallery -->
            <div class="bg-white rounded-xl shadow-xs border border-slate-200 p-6">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Foto Bukti Kejadian
                </h2>
                <div id="photo-gallery" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="h-48 rounded-lg bg-slate-100 animate-pulse flex items-center justify-center text-slate-400 text-xs">
                        Memuat foto...
                    </div>
                </div>
            </div>

            <!-- Description & Context -->
            <div class="bg-white rounded-xl shadow-xs border border-slate-200 p-6 space-y-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Deskripsi Permasalahan
                </h2>
                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200/70 text-slate-800 text-sm leading-relaxed whitespace-pre-line" id="detail-description">
                    Memuat deskripsi...
                </div>

                <div id="additional-info-box" class="hidden">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Informasi Tambahan</h3>
                    <p id="detail-additional-info" class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-200/70"></p>
                </div>
            </div>

            <!-- Location Details -->
            <div class="bg-white rounded-xl shadow-xs border border-slate-200 p-6">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Lokasi Permasalahan
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-xs text-slate-500 block">Alamat / Patokan:</span>
                        <span id="detail-address" class="font-medium text-slate-800">-</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">Koordinat Geografis:</span>
                        <span id="detail-coordinates" class="font-mono text-xs text-slate-700">-</span>
                        <a id="detail-map-link" href="#" target="_blank" class="block text-xs text-sky-600 hover:underline mt-1">
                            Buka di Google Maps &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: AI Decision Support, Assignment, & History (Span 1) -->
        <div class="space-y-6">

            <!-- AI / System Decision-Support Box (Professional, NOT futuristic) -->
            <div class="bg-white rounded-xl shadow-xs border border-slate-200 p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Rekomendasi Analisis Sistem
                    </h2>
                    <span id="ai-status-pill" class="text-[11px] font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                        Memeriksa...
                    </span>
                </div>

                <div id="ai-classifications-list" class="space-y-3">
                    <!-- Populated dynamically -->
                </div>

                <div class="p-3 bg-slate-50 rounded-lg border border-slate-200/80 text-[11px] text-slate-500 leading-relaxed">
                    <strong>Catatan Kebijakan:</strong> Hasil analisis model berfungsi sebagai rekomendasi awal. Administrator memegang wewenang penuh untuk menetapkan atau mengoreksi kategori dan prioritas.
                </div>
            </div>

            <!-- Current Assignment Panel -->
            <div id="assignment-panel" class="hidden bg-white rounded-xl shadow-xs border border-slate-200 p-6 space-y-3">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 border-b border-slate-100 pb-2">
                    Penugasan Aktif
                </h2>
                <div class="text-sm space-y-2">
                    <div>
                        <span class="text-xs text-slate-500 block">Operator Lapangan:</span>
                        <span id="assignee-name" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">Tenggat Waktu (Due Date):</span>
                        <span id="assignee-due-date" class="font-medium text-slate-700">-</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">Instruksi / Catatan:</span>
                        <span id="assignee-note" class="text-xs text-slate-600 italic">-</span>
                    </div>
                </div>
            </div>

            <!-- Status & Audit History Timeline -->
            <div class="bg-white rounded-xl shadow-xs border border-slate-200 p-6">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-4 border-b border-slate-100 pb-2">
                    Riwayat Status & Audit
                </h2>
                <div id="status-timeline" class="space-y-4">
                    <!-- Populated dynamically -->
                </div>
            </div>

        </div>

    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. Verify Modal -->
<div id="modal-verify" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 p-6 space-y-4">
        <h3 class="text-lg font-bold text-slate-900">Verifikasi Laporan</h3>
        <p class="text-xs text-slate-500">Tetapkan kategori akhir dan tentukan tingkat prioritas tindak lanjut.</p>
        
        <form onsubmit="submitVerify(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Masalah (Final)</label>
                <select id="verify-category" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tingkat Prioritas Penanganan</label>
                <select id="verify-priority" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <option value="low">Rendah (Low)</option>
                    <option value="medium" selected>Sedang (Medium)</option>
                    <option value="high">Tinggi (High)</option>
                    <option value="critical">Kritis (Critical - Berbahaya)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Verifikasi (Opsional)</label>
                <textarea id="verify-note" rows="3" placeholder="Contoh: Lokasi dekat sekolah, segera tangani..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeModal('modal-verify')" class="px-4 py-2 text-xs font-semibold rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" id="btn-submit-verify" class="px-4 py-2 text-xs font-semibold rounded-lg bg-sky-600 hover:bg-sky-700 text-white cursor-pointer">Verifikasi Sekarang</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Reject Modal -->
<div id="modal-reject" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 p-6 space-y-4">
        <h3 class="text-lg font-bold text-rose-900">Tolak Laporan</h3>
        <p class="text-xs text-slate-500">Berikan alasan penolakan yang jelas. Alasan ini akan tercatat dan dapat dilihat oleh pelapor.</p>
        
        <form onsubmit="submitReject(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alasan Penolakan (Minimal 10 karakter)</label>
                <textarea id="reject-reason" required minlength="10" rows="4" placeholder="Contoh: Foto tidak jelas dan lokasi tidak dapat diidentifikasi..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeModal('modal-reject')" class="px-4 py-2 text-xs font-semibold rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" id="btn-submit-reject" class="px-4 py-2 text-xs font-semibold rounded-lg bg-rose-600 hover:bg-rose-700 text-white cursor-pointer">Tolak Laporan</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Correct AI Modal (Human-in-the-Loop) -->
<div id="modal-correct" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 p-6 space-y-4">
        <h3 class="text-lg font-bold text-slate-900">Koreksi Klasifikasi AI (Human-in-the-Loop)</h3>
        <p class="text-xs text-slate-500">Koreksi ini akan tersimpan sebagai label terverifikasi untuk dataset tanpa menimpa prediksi asli sistem.</p>
        
        <form onsubmit="submitCorrect(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Sebenarnya</label>
                <select id="correct-label" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Subkategori / Tipe (Opsional)</label>
                <input type="text" id="correct-subtype" placeholder="Contoh: lubang, tumpukan, retak..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alasan Koreksi (Opsional)</label>
                <textarea id="correct-reason" rows="2" placeholder="Catatan perbedaan visual..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeModal('modal-correct')" class="px-4 py-2 text-xs font-semibold rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" id="btn-submit-correct" class="px-4 py-2 text-xs font-semibold rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white cursor-pointer">Simpan Koreksi</button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Assign Modal -->
<div id="modal-assign" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 p-6 space-y-4">
        <h3 class="text-lg font-bold text-slate-900">Tugaskan Laporan</h3>
        <p class="text-xs text-slate-500">Pilih operator lapangan atau instansi yang akan menindaklanjuti perbaikan.</p>
        
        <form onsubmit="submitAssign(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Operator Lapangan</label>
                <select id="assign-operator" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <option value="">Pilih operator...</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tenggat Waktu Penyelesaian (Due Date)</label>
                <input type="date" id="assign-due-date" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Penugasan (Opsional)</label>
                <textarea id="assign-note" rows="2" placeholder="Instruksi khusus kepada operator..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeModal('modal-assign')" class="px-4 py-2 text-xs font-semibold rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" id="btn-submit-assign" class="px-4 py-2 text-xs font-semibold rounded-lg bg-slate-900 hover:bg-slate-800 text-white cursor-pointer">Tugaskan Sekarang</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const reportId = window.location.pathname.split('/').pop();
    let currentReport = null;
    let categoriesList = [];
    let operatorsList = [];

    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

    async function loadData() {
        try {
            // Load Categories and Operators in parallel
            const [catRes, opRes] = await Promise.all([
                TobaCare.api('/api/v1/categories'),
                TobaCare.api('/api/v1/admin/operators').catch(() => ({ items: [] }))
            ]);
            categoriesList = catRes.items || [];
            operatorsList = opRes.items || [];

            populateSelects();

            // Load Report Detail
            const data = await TobaCare.api(`/api/v1/admin/reports/${reportId}`);
            currentReport = data;
            renderDetail(data);

        } catch (err) {
            TobaCare.toast('Gagal memuat data laporan: ' + err.message, 'error');
        }
    }

    function populateSelects() {
        const verifyCat = document.getElementById('verify-category');
        const correctLabel = document.getElementById('correct-label');
        const assignOp = document.getElementById('assign-operator');

        verifyCat.innerHTML = categoriesList.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
        correctLabel.innerHTML = categoriesList.map(c => `<option value="${c.code}">${c.name} (${c.code})</option>`).join('');
        assignOp.innerHTML = '<option value="">Pilih operator...</option>' + 
            operatorsList.map(o => `<option value="${o.id}">${o.name} - ${o.email} (${o.agency ? o.agency.name : 'Umum'})</option>`).join('');
    }

    function renderDetail(data) {
        const r = data.report;
        document.getElementById('detail-title').textContent = r.title;
        document.getElementById('detail-description').textContent = r.description;

        if (r.additional_info) {
            document.getElementById('additional-info-box').classList.remove('hidden');
            document.getElementById('detail-additional-info').textContent = r.additional_info;
        }

        const dateStr = new Date(r.created_at).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
        });
        document.getElementById('detail-date').textContent = 'Dilaporkan pada: ' + dateStr;
        document.getElementById('detail-reporter').textContent = 'Pelapor: ' + (data.reporter?.name || 'Warga Anonim') + ' (' + (data.reporter?.email || '-') + ')';

        // Address & Coordinates
        document.getElementById('detail-address').textContent = data.location?.address_text || 'Tidak ada alamat teks.';
        if (data.location?.latitude && data.location?.longitude) {
            const coords = `${data.location.latitude.toFixed(6)}, ${data.location.longitude.toFixed(6)}`;
            document.getElementById('detail-coordinates').textContent = coords;
            document.getElementById('detail-map-link').href = `https://www.google.com/maps?q=${data.location.latitude},${data.location.longitude}`;
        }

        // Status Badge
        const statusMap = {
            'pending_verification': 'bg-amber-50 text-amber-700 border-amber-200',
            'verified': 'bg-sky-50 text-sky-700 border-sky-200',
            'assigned': 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'in_progress': 'bg-purple-50 text-purple-700 border-purple-200',
            'resolved': 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'rejected': 'bg-rose-50 text-rose-700 border-rose-200',
        };
        const statusLabel = {
            'pending_verification': 'Menunggu Verifikasi',
            'verified': 'Diverifikasi',
            'assigned': 'Ditugaskan ke Operator',
            'in_progress': 'Sedang Ditangani',
            'resolved': 'Selesai',
            'rejected': 'Ditolak',
        };
        const badge = document.getElementById('detail-status-badge');
        badge.className = `px-2.5 py-1 rounded-md text-xs font-semibold border ${statusMap[r.status] || 'bg-slate-100 text-slate-700'}`;
        badge.textContent = statusLabel[r.status] || r.status;

        // Photo Gallery
        const gallery = document.getElementById('photo-gallery');
        if (data.images && data.images.length > 0) {
            gallery.innerHTML = data.images.map(img => `
                <div class="group relative rounded-lg overflow-hidden border border-slate-200 bg-slate-100">
                    <img src="${img.url}" alt="Foto Bukti" class="w-full h-56 object-cover transition transform group-hover:scale-102">
                    <a href="${img.url}" target="_blank" class="absolute bottom-2 right-2 px-2.5 py-1 text-[11px] font-semibold bg-slate-900/80 text-white rounded-md shadow-xs backdrop-blur-xs hover:bg-slate-900">
                        Buka Foto Asli &rarr;
                    </a>
                </div>
            `).join('');
        } else {
            gallery.innerHTML = '<div class="col-span-2 p-6 text-center text-slate-400 text-sm">Tidak ada foto dilampirkan.</div>';
        }

        // AI / System Analysis
        renderAiAnalysis(data.analysis);

        // Assignment Panel
        if (data.assignment) {
            document.getElementById('assignment-panel').classList.remove('hidden');
            document.getElementById('assignee-name').textContent = data.assignment.operator ? data.assignment.operator.name : 'Instansi Terkait';
            document.getElementById('assignee-due-date').textContent = data.assignment.due_date || 'Tidak ditentukan';
            document.getElementById('assignee-note').textContent = data.assignment.note || 'Tidak ada catatan tambahan.';
        } else {
            document.getElementById('assignment-panel').classList.add('hidden');
        }

        // Status Timeline
        renderTimeline(data.status_history);

        // Render Action Buttons
        renderActionButtons(r.status);
    }

    function renderAiAnalysis(analysis) {
        const pill = document.getElementById('ai-status-pill');
        const list = document.getElementById('ai-classifications-list');

        if (!analysis || analysis.status === 'failed' || !analysis.classifications || analysis.classifications.length === 0) {
            pill.textContent = 'Review Manual';
            pill.className = 'text-[11px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200';
            list.innerHTML = `
                <div class="p-3 rounded-lg bg-amber-50/60 border border-amber-200 text-xs text-amber-800">
                    <strong>Pemberitahuan:</strong> Model pengenalan gambar belum mendeteksi objek secara otomatis pada laporan ini. Silakan tetapkan kategori secara manual saat verifikasi.
                </div>
            `;
            return;
        }

        pill.textContent = 'Analisis Tersedia';
        pill.className = 'text-[11px] font-semibold px-2 py-0.5 rounded bg-sky-50 text-sky-700 border border-sky-200';

        list.innerHTML = analysis.classifications.map(c => {
            const conf = Math.round(c.confidence * 100);
            let correctionBadge = '';
            if (c.admin_corrected_label) {
                correctionBadge = `<div class="mt-1 text-[11px] text-indigo-700 font-medium">Koreksi Admin: ${c.admin_corrected_label} (Tersimpan)</div>`;
            }

            return `
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 space-y-1">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-800 capitalize">${c.label.replace('_', ' ')}</span>
                        <span class="font-mono text-slate-500">${conf}%</span>
                    </div>
                    <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-sky-600 h-1.5 rounded-full" style="width: ${conf}%"></div>
                    </div>
                    ${correctionBadge}
                </div>
            `;
        }).join('');
    }

    function renderTimeline(history) {
        const container = document.getElementById('status-timeline');
        if (!history || history.length === 0) {
            container.innerHTML = '<div class="text-xs text-slate-400">Belum ada riwayat tercatat.</div>';
            return;
        }

        container.innerHTML = history.map((item, idx) => {
            const time = new Date(item.created_at).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit'
            });
            const actor = item.changed_by ? item.changed_by.name : 'Sistem TobaCare';

            return `
                <div class="flex items-start space-x-3 text-xs">
                    <div class="w-2 h-2 rounded-full bg-slate-400 mt-1.5 shrink-0"></div>
                    <div class="flex-1">
                        <div class="font-semibold text-slate-800">${item.to_status}</div>
                        <div class="text-slate-500 text-[11px]">Oleh: ${actor} &bull; ${time}</div>
                        ${item.note ? `<div class="mt-1 text-slate-600 italic bg-slate-50 p-2 rounded border border-slate-100">${item.note}</div>` : ''}
                    </div>
                </div>
            `;
        }).join('');
    }

    function renderActionButtons(status) {
        const container = document.getElementById('detail-actions');
        let html = '';

        if (status === 'pending_verification') {
            html += `
                <button type="button" onclick="openModal('modal-correct')"
                        class="px-3.5 py-2 text-xs font-semibold rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 shadow-2xs transition cursor-pointer">
                    Koreksi Hasil AI
                </button>
                <button type="button" onclick="openModal('modal-reject')"
                        class="px-3.5 py-2 text-xs font-semibold rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 transition cursor-pointer">
                    Tolak Laporan
                </button>
                <button type="button" onclick="openModal('modal-verify')"
                        class="px-4 py-2 text-xs font-semibold rounded-lg bg-sky-600 hover:bg-sky-700 text-white shadow-xs transition cursor-pointer">
                    Verifikasi Laporan &rarr;
                </button>
            `;
        } else if (status === 'verified' || status === 'assigned') {
            html += `
                <button type="button" onclick="openModal('modal-assign')"
                        class="px-4 py-2 text-xs font-semibold rounded-lg bg-slate-900 hover:bg-slate-800 text-white shadow-xs transition cursor-pointer">
                    ${status === 'assigned' ? 'Alihkan / Tugaskan Ulang' : 'Tugaskan ke Operator &rarr;'}
                </button>
            `;
        }

        container.innerHTML = html;
    }

    // Form Submissions
    async function submitVerify(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-submit-verify');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        try {
            await TobaCare.api(`/api/v1/reports/${reportId}/verify`, {
                method: 'POST',
                body: JSON.stringify({
                    category_id: parseInt(document.getElementById('verify-category').value),
                    priority: document.getElementById('verify-priority').value,
                    note: document.getElementById('verify-note').value
                })
            });

            closeModal('modal-verify');
            TobaCare.toast('Laporan berhasil diverifikasi!', 'success');
            loadData();
        } catch (err) {
            TobaCare.toast(err.message, 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Verifikasi Sekarang';
        }
    }

    async function submitReject(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-submit-reject');
        btn.disabled = true;
        btn.textContent = 'Menolak...';

        try {
            await TobaCare.api(`/api/v1/reports/${reportId}/reject`, {
                method: 'POST',
                body: JSON.stringify({
                    reason: document.getElementById('reject-reason').value
                })
            });

            closeModal('modal-reject');
            TobaCare.toast('Laporan berhasil ditolak.', 'warning');
            loadData();
        } catch (err) {
            TobaCare.toast(err.message, 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Tolak Laporan';
        }
    }

    async function submitCorrect(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-submit-correct');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        try {
            await TobaCare.api(`/api/v1/reports/${reportId}/analysis/correct`, {
                method: 'POST',
                body: JSON.stringify({
                    label: document.getElementById('correct-label').value,
                    subtype: document.getElementById('correct-subtype').value || null,
                    reason: document.getElementById('correct-reason').value || null
                })
            });

            closeModal('modal-correct');
            TobaCare.toast('Koreksi klasifikasi berhasil disimpan ke dataset.', 'success');
            loadData();
        } catch (err) {
            TobaCare.toast(err.message, 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Simpan Koreksi';
        }
    }

    async function submitAssign(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-submit-assign');
        btn.disabled = true;
        btn.textContent = 'Menugaskan...';

        try {
            await TobaCare.api(`/api/v1/reports/${reportId}/assign`, {
                method: 'POST',
                body: JSON.stringify({
                    operator_id: document.getElementById('assign-operator').value,
                    due_date: document.getElementById('assign-due-date').value || null,
                    note: document.getElementById('assign-note').value || null
                })
            });

            closeModal('modal-assign');
            TobaCare.toast('Laporan berhasil ditugaskan ke operator!', 'success');
            loadData();
        } catch (err) {
            TobaCare.toast(err.message, 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Tugaskan Sekarang';
        }
    }

    document.addEventListener('DOMContentLoaded', loadData);
</script>
@endpush
@endsection
