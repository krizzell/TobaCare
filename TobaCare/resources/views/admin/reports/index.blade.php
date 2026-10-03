@extends('layouts.admin')

@section('title', 'Antrean Verifikasi — TobaCare')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="sm:flex sm:items-center sm:justify-between border-b border-slate-200/80 pb-5">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Antrean Verifikasi Laporan Warga</h1>
            <p class="mt-1 text-sm text-slate-500">
                Lakukan triase laporan masuk, verifikasi kategori & prioritas, serta tugaskan ke instansi atau operator lapangan.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <button type="button" onclick="loadReports()" 
                    class="inline-flex items-center px-3.5 py-2 border border-slate-300 shadow-sm text-xs font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition cursor-pointer">
                <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Segarkan Antrean
            </button>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-5 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Search Title -->
            <div>
                <label for="filter-q" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Cari Judul / Masalah</label>
                <div class="relative">
                    <input type="text" id="filter-q" placeholder="Ketik kata kunci..." onkeydown="if(event.key==='Enter') loadReports()"
                           class="w-full pl-9 pr-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="filter-status" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Status Laporan</label>
                <select id="filter-status" onchange="loadReports()"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                    <option value="pending_verification" selected>Menunggu Verifikasi (Pending)</option>
                    <option value="verified">Sudah Diverifikasi (Verified)</option>
                    <option value="assigned">Sudah Ditugaskan (Assigned)</option>
                    <option value="rejected">Ditolak (Rejected)</option>
                    <option value="all">Semua Status Aktif</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label for="filter-category" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Kategori Masalah</label>
                <select id="filter-category" onchange="loadReports()"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                    <option value="">Semua Kategori</option>
                </select>
            </div>

            <!-- Priority Filter -->
            <div>
                <label for="filter-priority" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Tingkat Prioritas</label>
                <select id="filter-priority" onchange="loadReports()"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                    <option value="">Semua Prioritas</option>
                    <option value="critical">Kritis (Critical)</option>
                    <option value="high">Tinggi (High)</option>
                    <option value="medium">Sedang (Medium)</option>
                    <option value="low">Rendah (Low)</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs text-slate-600">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="filter-review" onchange="loadReports()"
                       class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-slate-300 rounded">
                <span class="ml-2 font-medium text-slate-700">Tampilkan hanya laporan yang memerlukan review manual</span>
            </label>
            <div id="queue-count" class="font-medium text-slate-500">
                Memuat antrean...
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/75 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-5 py-3.5 text-left w-20">Foto</th>
                        <th scope="col" class="px-5 py-3.5 text-left">Judul & Lokasi</th>
                        <th scope="col" class="px-5 py-3.5 text-left">Kategori Terpilih</th>
                        <th scope="col" class="px-5 py-3.5 text-left">Rekomendasi Sistem</th>
                        <th scope="col" class="px-5 py-3.5 text-left">Prioritas</th>
                        <th scope="col" class="px-5 py-3.5 text-left">Status</th>
                        <th scope="col" class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="reports-table-body" class="divide-y divide-slate-200 text-sm">
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <svg class="animate-spin h-6 w-6 text-sky-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memuat daftar laporan dari sistem...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        <div id="pagination-bar" class="hidden px-5 py-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-xs text-slate-600">
            <span id="page-info">Halaman 1 dari 1</span>
            <div class="flex space-x-2">
                <button type="button" id="btn-prev" onclick="changePage(-1)"
                        class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
                    Sebelumnya
                </button>
                <button type="button" id="btn-next" onclick="changePage(1)"
                        class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
                    Berikutnya
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentPage = 1;
    let totalPages = 1;

    async function loadCategories() {
        try {
            const data = await TobaCare.api('/api/v1/categories');
            const select = document.getElementById('filter-category');
            if (data?.items) {
                data.items.forEach(cat => {
                    const opt = document.createElement('option');
                    opt.value = cat.id;
                    opt.textContent = cat.name;
                    select.appendChild(opt);
                });
            }
        } catch (err) {
            console.error('Gagal memuat kategori:', err);
        }
    }

    async function loadReports(page = 1) {
        currentPage = page;
        const tbody = document.getElementById('reports-table-body');
        const countEl = document.getElementById('queue-count');

        const status = document.getElementById('filter-status').value;
        const catId = document.getElementById('filter-category').value;
        const priority = document.getElementById('filter-priority').value;
        const q = document.getElementById('filter-q').value.trim();
        const needsReview = document.getElementById('filter-review').checked;

        let query = `?page=${page}&per_page=15`;
        if (status) query += `&status=${encodeURIComponent(status)}`;
        if (catId) query += `&category_id=${encodeURIComponent(catId)}`;
        if (priority) query += `&priority=${encodeURIComponent(priority)}`;
        if (q) query += `&q=${encodeURIComponent(q)}`;
        if (needsReview) query += `&needs_manual_review=true`;

        try {
            const data = await TobaCare.api('/api/v1/admin/reports' + query);
            const items = data.items || [];
            totalPages = Math.ceil((data.total || 0) / (data.per_page || 15)) || 1;

            countEl.textContent = `Menampilkan ${items.length} dari ${data.total || 0} laporan`;

            if (items.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Tidak ada laporan yang sesuai dengan filter.
                        </td>
                    </tr>
                `;
                document.getElementById('pagination-bar').classList.add('hidden');
                return;
            }

            tbody.innerHTML = items.map(report => renderReportRow(report)).join('');

            // Pagination setup
            document.getElementById('pagination-bar').classList.remove('hidden');
            document.getElementById('page-info').textContent = `Halaman ${data.page} dari ${totalPages}`;
            document.getElementById('btn-prev').disabled = currentPage <= 1;
            document.getElementById('btn-next').disabled = currentPage >= totalPages;

        } catch (err) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-rose-600 bg-rose-50/50">
                        Gagal memuat data antrean: ${err.message}
                    </td>
                </tr>
            `;
            countEl.textContent = 'Gagal memuat antrean.';
        }
    }

    function renderReportRow(report) {
        // Thumbnail
        const thumb = report.thumbnail_url
            ? `<img src="${report.thumbnail_url}" alt="Foto" class="w-14 h-14 rounded-lg object-cover border border-slate-200 shadow-xs">`
            : `<div class="w-14 h-14 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-xs">Tanpa Foto</div>`;

        // Address snippet
        const address = report.location?.address_text 
            ? `<div class="text-xs text-slate-500 truncate max-w-xs">${report.location.address_text}</div>` 
            : `<div class="text-xs text-slate-400">Koordinat: ${report.location?.latitude?.toFixed(4)}, ${report.location?.longitude?.toFixed(4)}</div>`;

        // Date format
        const createdDate = new Date(report.created_at).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
        });

        // Category Badge
        const catBadge = report.category
            ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">${report.category.name}</span>`
            : `<span class="text-xs text-slate-400 italic">Belum dikategorikan</span>`;

        // AI System Recommendation Badge
        let aiRecommendation = '';
        if (report.ai?.status === 'success' && report.ai?.top_label) {
            const conf = Math.round((report.ai.top_confidence || 0) * 100);
            aiRecommendation = `
                <div>
                    <span class="inline-flex items-center text-xs font-medium text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span>
                        ${report.ai.top_label.replace('_', ' ')}
                    </span>
                    <span class="text-[11px] text-slate-400 ml-1 font-mono">(${conf}%)</span>
                </div>
            `;
        } else {
            aiRecommendation = `<span class="inline-flex items-center text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">Perlu Review Manual</span>`;
        }

        // Priority Badge
        const prioMap = {
            'critical': 'bg-rose-100 text-rose-800 border-rose-200 font-bold',
            'high': 'bg-orange-100 text-orange-800 border-orange-200 font-semibold',
            'medium': 'bg-amber-100 text-amber-800 border-amber-200 font-medium',
            'low': 'bg-slate-100 text-slate-700 border-slate-200',
        };
        const priorityBadge = report.priority_final
            ? `<span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] uppercase tracking-wide border ${prioMap[report.priority_final] || 'bg-slate-100 text-slate-700'}">${report.priority_final}</span>`
            : `<span class="text-xs text-slate-400">-</span>`;

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
            'assigned': 'Ditugaskan',
            'in_progress': 'Dalam Penanganan',
            'resolved': 'Selesai',
            'rejected': 'Ditolak',
        };
        const statusBadge = `
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border ${statusMap[report.status] || 'bg-slate-100 text-slate-700 border-slate-200'}">
                ${statusLabel[report.status] || report.status}
            </span>
        `;

        return `
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-5 py-4 whitespace-nowrap">
                    ${thumb}
                </td>
                <td class="px-5 py-4">
                    <a href="/admin/reports/${report.id}" class="font-semibold text-slate-900 hover:text-sky-600 line-clamp-1 block transition">
                        ${report.title}
                    </a>
                    ${address}
                    <span class="text-[11px] text-slate-400 block mt-0.5">${createdDate}</span>
                </td>
                <td class="px-5 py-4 whitespace-nowrap">
                    ${catBadge}
                </td>
                <td class="px-5 py-4 whitespace-nowrap">
                    ${aiRecommendation}
                </td>
                <td class="px-5 py-4 whitespace-nowrap">
                    ${priorityBadge}
                </td>
                <td class="px-5 py-4 whitespace-nowrap">
                    ${statusBadge}
                </td>
                <td class="px-5 py-4 whitespace-nowrap text-right text-xs">
                    <a href="/admin/reports/${report.id}" 
                       class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-900 hover:text-white hover:border-slate-900 text-slate-700 font-semibold shadow-2xs transition">
                        Tinjau & Verifikasi
                        <svg class="w-3.5 h-3.5 ml-1 text-slate-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </td>
            </tr>
        `;
    }

    function changePage(delta) {
        const target = currentPage + delta;
        if (target >= 1 && target <= totalPages) {
            loadReports(target);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const user = TobaCare.getUser();
        if (user?.role?.name === 'operator') {
            window.location.href = '/operator/reports';
            return;
        }
        loadCategories();
        loadReports(1);
    });
</script>
@endpush
@endsection
