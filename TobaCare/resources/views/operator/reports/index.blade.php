@extends('layouts.admin')

@section('title', 'Tugas Lapangan — Operator TobaCare')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tugas Lapangan Petugas</h1>
            <p class="mt-1 text-sm text-slate-500">
                Pantau dan tangani laporan kerusakan lingkungan yang ditugaskan kepada Anda.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <button type="button" onclick="loadTasks(1)"
                    class="inline-flex items-center px-4 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold shadow-2xs transition">
                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Segarkan Tugas
            </button>
        </div>
    </div>

    <!-- Quick Stats Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Baru Ditugaskan</span>
                <span class="p-2 rounded-lg bg-amber-50 text-amber-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline">
                <span id="stat-assigned" class="text-2xl font-bold text-slate-900">0</span>
                <span class="ml-2 text-xs text-slate-500">menunggu mulai kerja</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sedang Dikerjakan</span>
                <span class="p-2 rounded-lg bg-sky-50 text-sky-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline">
                <span id="stat-in-progress" class="text-2xl font-bold text-slate-900">0</span>
                <span class="ml-2 text-xs text-slate-500">dalam penanganan fisik</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai Dituntaskan</span>
                <span class="p-2 rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline">
                <span id="stat-resolved" class="text-2xl font-bold text-slate-900">0</span>
                <span class="ml-2 text-xs text-slate-500">pekerjaan tuntas</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs space-y-4">
        <!-- Status Tabs -->
        <div class="flex items-center space-x-2 border-b border-slate-100 pb-3 overflow-x-auto">
            <button type="button" onclick="setFilterStatus('')" id="tab-all"
                    class="tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-white transition">
                Semua Tugas
            </button>
            <button type="button" onclick="setFilterStatus('assigned')" id="tab-assigned"
                    class="tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                Baru Ditugaskan
            </button>
            <button type="button" onclick="setFilterStatus('in_progress')" id="tab-in-progress"
                    class="tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                Sedang Dikerjakan
            </button>
            <button type="button" onclick="setFilterStatus('resolved')" id="tab-resolved"
                    class="tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                Selesai
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <!-- Search Input -->
            <div class="sm:col-span-8">
                <div class="relative rounded-lg shadow-2xs">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="filter-search" oninput="debounceSearch()"
                           placeholder="Cari tugas berdasarkan judul atau lokasi..."
                           class="block w-full pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
            </div>

            <!-- Priority Filter -->
            <div class="sm:col-span-4">
                <select id="filter-priority" onchange="loadTasks(1)"
                        class="block w-full py-2 px-3 border border-slate-300 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="">Semua Prioritas</option>
                    <option value="critical">Kritis (Critical)</option>
                    <option value="high">Tinggi (High)</option>
                    <option value="medium">Sedang (Medium)</option>
                    <option value="low">Rendah (Low)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Task List Table -->
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                    <tr>
                        <th scope="col" class="px-5 py-3.5">Foto</th>
                        <th scope="col" class="px-5 py-3.5">Judul & Lokasi Laporan</th>
                        <th scope="col" class="px-5 py-3.5">Kategori</th>
                        <th scope="col" class="px-5 py-3.5">Prioritas</th>
                        <th scope="col" class="px-5 py-3.5">Tenggat Waktu</th>
                        <th scope="col" class="px-5 py-3.5">Status</th>
                        <th scope="col" class="px-5 py-3.5 text-right">Tindakan Lapangan</th>
                    </tr>
                </thead>
                <tbody id="task-tbody" class="divide-y divide-slate-100 bg-white">
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <div class="inline-flex items-center space-x-2">
                                <svg class="animate-spin h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memuat daftar tugas lapangan...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination-bar" class="hidden px-5 py-3.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span id="page-info">Halaman 1</span>
            <div class="flex space-x-2">
                <button type="button" id="btn-prev" onclick="changePage(-1)"
                        class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 disabled:opacity-50 font-medium">
                    Sebelumnya
                </button>
                <button type="button" id="btn-next" onclick="changePage(1)"
                        class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 disabled:opacity-50 font-medium">
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Selesaikan Pengerjaan (Resolve Modal) -->
<div id="resolve-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
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
            Laporkan hasil penanganan kerusakan fisik dan catatan perbaikan teknis. Laporan ini akan dicatat dalam riwayat dan diberitahukan ke warga pelapor.
        </p>

        <div>
            <label for="resolve-note" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Penyelesaian Lapangan <span class="text-rose-500">*</span></label>
            <textarea id="resolve-note" rows="4" required
                      placeholder="Contoh: Lubang jalan telah ditambal dengan lapisan aspal hotmix setebal 5 cm. Aliran lalu lintas telah normal dan aman dilalui warga."
                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-2 border-t border-slate-100">
            <button type="button" onclick="closeResolveModal()"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                Batal
            </button>
            <button type="button" id="btn-submit-resolve" onclick="submitResolve()"
                    class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-sm font-semibold text-white shadow-xs transition flex items-center">
                <span>Konfirmasi Selesai</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Preview Foto Laporan -->
<div id="image-preview-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/80 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-4 shadow-2xl border border-slate-200 space-y-3">
        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
            <h3 id="preview-image-title" class="text-sm font-bold text-slate-900 truncate">Foto Bukti Laporan</h3>
            <button type="button" onclick="closeImagePreview()" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="rounded-xl overflow-hidden bg-slate-950 flex items-center justify-center max-h-[70vh]">
            <img id="preview-image-src" src="" alt="Pratinjau Foto" class="max-h-[70vh] w-auto object-contain">
        </div>
        <div class="text-right pt-1">
            <button type="button" onclick="closeImagePreview()"
                    class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentStatus = '';
    let currentPage = 1;
    let totalPages = 1;
    let searchTimeout = null;
    let activeResolveId = null;

    function previewImage(url, title) {
        document.getElementById('preview-image-src').src = url;
        document.getElementById('preview-image-title').textContent = title || 'Foto Bukti Laporan';
        document.getElementById('image-preview-modal').classList.remove('hidden');
    }

    function closeImagePreview() {
        document.getElementById('image-preview-modal').classList.add('hidden');
        document.getElementById('preview-image-src').src = '';
    }

    function debounceSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadTasks(1);
        }, 300);
    }

    function setFilterStatus(status) {
        currentStatus = status;
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = 'tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition';
        });

        const activeTabId = status === '' ? 'tab-all' : (status === 'assigned' ? 'tab-assigned' : (status === 'in_progress' ? 'tab-in-progress' : 'tab-resolved'));
        const el = document.getElementById(activeTabId);
        if (el) {
            el.className = 'tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-white transition';
        }

        loadTasks(1);
    }

    async function loadTasks(page = 1) {
        currentPage = page;
        const tbody = document.getElementById('task-tbody');
        const priority = document.getElementById('filter-priority').value;
        const q = document.getElementById('filter-search').value.trim();

        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                    <div class="inline-flex items-center space-x-2">
                        <svg class="animate-spin h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memuat data tugas...</span>
                    </div>
                </td>
            </tr>
        `;

        try {
            const params = new URLSearchParams({
                page: currentPage,
                per_page: 15,
            });
            if (currentStatus) params.append('status', currentStatus);
            if (priority) params.append('priority', priority);
            if (q) params.append('q', q);

            const res = await TobaCare.api(`/api/v1/operator/reports?${params.toString()}`);
            const items = res.data || [];
            totalPages = res.meta?.last_page || 1;

            // Update stats
            if (res.stats) {
                document.getElementById('stat-assigned').textContent = res.stats.total_assigned || 0;
                document.getElementById('stat-in-progress').textContent = res.stats.in_progress || 0;
                document.getElementById('stat-resolved').textContent = res.stats.resolved || 0;
            }

            if (items.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada tugas lapangan yang cocok dengan filter saat ini.
                        </td>
                    </tr>
                `;
                document.getElementById('pagination-bar').classList.add('hidden');
                return;
            }

            tbody.innerHTML = items.map(t => renderTaskRow(t)).join('');

            document.getElementById('pagination-bar').classList.remove('hidden');
            document.getElementById('page-info').textContent = `Halaman ${res.meta.current_page} dari ${totalPages} (Total ${res.meta.total} Tugas)`;
            document.getElementById('btn-prev').disabled = currentPage <= 1;
            document.getElementById('btn-next').disabled = currentPage >= totalPages;

        } catch (err) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-rose-600 bg-rose-50/50">
                        Gagal memuat tugas: ${err.message}
                    </td>
                </tr>
            `;
        }
    }

    function renderTaskRow(report) {
        // Thumbnail
        const firstImg = report.thumbnail_url || (report.images && report.images[0] ? (report.images[0].url || `/storage/${report.images[0].storage_key}`) : null);
        const thumb = firstImg
            ? `<div class="relative group cursor-pointer inline-block" onclick="previewImage('${firstImg}', '${report.title.replace(/'/g, "\\'")}')">
                 <img src="${firstImg}" alt="Foto Laporan" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-2xs group-hover:scale-105 group-hover:shadow-md transition">
                 <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 rounded-xl flex items-center justify-center transition">
                   <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                   </svg>
                 </div>
               </div>`
            : `<div class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 flex flex-col items-center justify-center text-slate-400 text-[10px]">
                 <svg class="w-5 h-5 mb-0.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                 </svg>
                 <span>Tanpa Foto</span>
               </div>`;

        // Address snippet
        const address = report.location?.address_text 
            ? `<div class="text-xs text-slate-500 truncate max-w-xs">${report.location.address_text}</div>` 
            : `<div class="text-xs text-slate-400">Koordinat: ${report.location?.latitude?.toFixed(4)}, ${report.location?.longitude?.toFixed(4)}</div>`;

        // Category Badge
        const catBadge = report.category
            ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">${report.category.name}</span>`
            : `<span class="text-xs text-slate-400 italic">Umum</span>`;

        // Priority Badge
        let priorityBadge = '';
        if (report.priority_final === 'critical' || report.priority === 'critical') {
            priorityBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">Kritis</span>';
        } else if (report.priority_final === 'high' || report.priority === 'high') {
            priorityBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">Tinggi</span>';
        } else if (report.priority_final === 'medium' || report.priority === 'medium') {
            priorityBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-700 border border-sky-200">Sedang</span>';
        } else {
            priorityBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">Rendah</span>';
        }

        // Status Badge
        let statusBadge = '';
        if (report.status === 'assigned') {
            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Ditugaskan</span>';
        } else if (report.status === 'in_progress') {
            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">Sedang Dikerjakan</span>';
        } else if (report.status === 'resolved') {
            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span>';
        } else {
            statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">${report.status}</span>`;
        }

        // Due date
        const dueDate = report.active_assignment?.due_date
            ? new Date(report.active_assignment.due_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
            : '-';

        // Action buttons
        let actionBtn = '';
        if (report.status === 'assigned') {
            actionBtn = `
                <button type="button" onclick="startProgress('${report.id}')"
                        class="inline-flex items-center px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs shadow-xs transition duration-150 cursor-pointer">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Mulai Kerjakan
                </button>
            `;
        } else if (report.status === 'in_progress') {
            actionBtn = `
                <button type="button" onclick="openResolveModal('${report.id}')"
                        class="inline-flex items-center px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-xs transition duration-150 cursor-pointer">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Tandai Selesai
                </button>
            `;
        } else if (report.status === 'resolved') {
            actionBtn = `
                <span class="inline-flex items-center px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                    <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    Tuntas Dikerjakan
                </span>
            `;
        }

        return `
            <tr class="hover:bg-slate-50/70 transition">
                <td class="px-5 py-4 whitespace-nowrap">
                    ${thumb}
                </td>
                <td class="px-5 py-4">
                    <div class="font-bold text-slate-900 line-clamp-1">${report.title}</div>
                    ${address}
                </td>
                <td class="px-5 py-4 whitespace-nowrap">
                    ${catBadge}
                </td>
                <td class="px-5 py-4 whitespace-nowrap">
                    ${priorityBadge}
                </td>
                <td class="px-5 py-4 whitespace-nowrap text-xs text-slate-600 font-medium">
                    ${dueDate}
                </td>
                <td class="px-5 py-4 whitespace-nowrap">
                    ${statusBadge}
                </td>
                <td class="px-5 py-4 whitespace-nowrap text-right">
                    ${actionBtn}
                </td>
            </tr>
        `;
    }

    function startProgress(reportId) {
        TobaCare.confirm({
            title: 'Mulai Penanganan Lapangan',
            message: 'Konfirmasi untuk memulai pekerjaan fisik untuk laporan ini? Status akan diperbarui menjadi "Sedang Dikerjakan" (in_progress) dan notifikasi akan dikirimkan ke warga.',
            confirmText: 'Mulai Penanganan',
            confirmClass: 'bg-amber-500 hover:bg-amber-600 text-white',
            onConfirm: async () => {
                try {
                    await TobaCare.api(`/api/v1/operator/reports/${reportId}/start-progress`, {
                        method: 'POST',
                    });
                    TobaCare.toast('Pekerjaan dimulai! Status diubah menjadi sedang dikerjakan.', 'success');
                    loadTasks(currentPage);
                } catch (err) {
                    TobaCare.toast(err.message || 'Gagal memulai pekerjaan.', 'error');
                }
            }
        });
    }

    function openResolveModal(reportId) {
        activeResolveId = reportId;
        document.getElementById('resolve-note').value = '';
        document.getElementById('resolve-modal').classList.remove('hidden');
    }

    function closeResolveModal() {
        activeResolveId = null;
        document.getElementById('resolve-modal').classList.add('hidden');
    }

    async function submitResolve() {
        if (!activeResolveId) return;

        const note = document.getElementById('resolve-note').value.trim();
        if (note.length < 5) {
            TobaCare.toast('Catatan penyelesaian minimal 5 karakter.', 'warning');
            return;
        }

        const btn = document.getElementById('btn-submit-resolve');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        try {
            await TobaCare.api(`/api/v1/operator/reports/${activeResolveId}/resolve`, {
                method: 'POST',
                body: JSON.stringify({ note })
            });

            TobaCare.toast('Laporan pengerjaan berhasil diselesaikan!', 'success');
            closeResolveModal();
            loadTasks(currentPage);
        } catch (err) {
            TobaCare.toast(err.message || 'Gagal menyelesaikan laporan.', 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Konfirmasi Selesai';
        }
    }

    function changePage(delta) {
        const target = currentPage + delta;
        if (target >= 1 && target <= totalPages) {
            loadTasks(target);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadTasks(1);
    });
</script>
@endpush
@endsection
