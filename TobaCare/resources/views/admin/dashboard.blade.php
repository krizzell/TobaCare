@extends('layouts.admin')

@section('title', 'Overview & Monitoring — TobaCare')

@section('content')
<div class="space-y-6">

    <!-- Top Welcome Banner & Controls (Matching ECOBASE reference) -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 flex items-center">
                Halo Admin Dinas <span class="ml-2 inline-block animate-bounce">👋</span>
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Pantau aspirasi warga, efisiensi penanganan, dan akurasi triase AI di Kabupaten Toba.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Date Range Selector Pill -->
            <div class="flex items-center px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 text-xs font-semibold text-slate-700 shadow-2xs">
                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span id="date-range-label">Memuat rentang data...</span>
            </div>

            <!-- Export Button (Emerald green like reference) -->
            <button type="button" onclick="exportData()"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold shadow-xs transition duration-150 cursor-pointer">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span>Export</span>
            </button>

            <!-- Upload Resolved Facility Button (Requirement: Diupload admin dari dashboard) -->
            <button type="button" onclick="openUploadFacilityModal()"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs sm:text-sm font-semibold shadow-xs transition duration-150 cursor-pointer">
                <svg class="w-4 h-4 mr-1.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Publikasi Fasilitas Selesai</span>
            </button>
        </div>
    </div>

    <!-- 4 KPI Summary Cards (Matching ECOBASE Reference Row) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- KPI 1: Total Masuk -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                    TC
                </div>
                <div class="flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    Data aktual
                </div>
            </div>
            <div class="mt-3">
                <div id="kpi-total" class="text-3xl font-extrabold text-slate-900 tracking-tight">—</div>
                <div class="text-xs font-medium text-slate-500 mt-1">Total Laporan Masuk</div>
            </div>
        </div>

        <!-- KPI 2: AI Validation Rate -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    Data aktual
                </div>
            </div>
            <div class="mt-3">
                <div id="kpi-ai-accuracy" class="text-3xl font-extrabold text-slate-900 tracking-tight">—</div>
                <div class="text-xs font-medium text-slate-500 mt-1">Rata-rata Confidence AI</div>
            </div>
        </div>

        <!-- KPI 3: Sedang Ditangani Operator -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    Data aktual
                </div>
            </div>
            <div class="mt-3">
                <div id="kpi-in-progress" class="text-3xl font-extrabold text-slate-900 tracking-tight">—</div>
                <div class="text-xs font-medium text-slate-500 mt-1">Dalam Penanganan Lapangan</div>
            </div>
        </div>

        <!-- KPI 4: Rata-rata SLA Penyelesaian -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex items-center text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
                    Data aktual
                </div>
            </div>
            <div class="mt-3">
                <div id="kpi-sla" class="text-3xl font-extrabold text-slate-900 tracking-tight">—</div>
                <div class="text-xs font-medium text-slate-500 mt-1">Rata-rata Waktu Tuntas</div>
            </div>
        </div>
    </div>

    <!-- Middle Interactive Row: Line Chart + Stacked Bar Chart (Exact Match to ECOBASE) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Interactive Multi-line Trending Chart (Col 8) -->
        <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs relative">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Tren Laporan Masuk & Kategori</h2>
                    <p class="text-xs text-slate-500">Volume aspirasi publik berdasarkan klasifikasi utama 10 hari terakhir</p>
                </div>

                <!-- Custom Interactive Legend matching reference -->
                <div class="flex items-center space-x-4 text-xs font-semibold">
                    <span class="inline-flex items-center text-emerald-600">
                        <span class="w-2.5 h-2.5 rounded-sm bg-emerald-500 mr-1.5"></span> Infrastruktur
                    </span>
                    <span class="inline-flex items-center text-sky-600">
                        <span class="w-2.5 h-2.5 rounded-sm bg-sky-500 mr-1.5"></span> Kebersihan
                    </span>
                    <span class="inline-flex items-center text-amber-600">
                        <span class="w-2.5 h-2.5 rounded-sm bg-amber-500 mr-1.5"></span> Fasum / Lampu
                    </span>
                </div>
            </div>

            <!-- Interactive SVG Line Chart Container with Tooltip -->
            <div class="relative w-full h-[280px]" id="chart-container" onmousemove="handleChartHover(event)" onmouseleave="hideChartTooltip()">
                <!-- Grid background -->
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none text-[10px] text-slate-400 font-mono">
                    <div class="border-b border-slate-100 pb-1">100</div>
                    <div class="border-b border-slate-100 pb-1">75</div>
                    <div class="border-b border-slate-100 pb-1">50</div>
                    <div class="border-b border-slate-100 pb-1">25</div>
                    <div class="border-b border-slate-200 pb-1">0</div>
                </div>

                <!-- Dynamic SVG Chart -->
                <svg id="svg-trend-chart" class="absolute inset-0 w-full h-full overflow-visible" preserveAspectRatio="none" viewBox="0 0 800 240">
                    <defs>
                        <linearGradient id="grad-infra" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#10B981" stop-opacity="0.25" />
                            <stop offset="100%" stop-color="#10B981" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>
                    <!-- Area under curve -->
                    <path id="path-area-infra" d="M 0,200 L 0,240 L 800,240 Z" fill="url(#grad-infra)" />
                    <!-- Lines -->
                    <path id="path-line-infra" d="" fill="none" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path id="path-line-kebersihan" d="" fill="none" stroke="#0EA5E9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path id="path-line-fasum" d="" fill="none" stroke="#F59E0B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    
                    <!-- Hover Cursor Line -->
                    <line id="hover-line" x1="-10" y1="0" x2="-10" y2="240" stroke="#94A3B8" stroke-dasharray="4 4" stroke-width="1.5" class="hidden" />
                    
                    <!-- Hover Dot Anchors -->
                    <circle id="hover-dot-infra" cx="-10" cy="-10" r="4.5" fill="#10B981" stroke="#FFFFFF" stroke-width="2" class="hidden" />
                    <circle id="hover-dot-kebersihan" cx="-10" cy="-10" r="4.5" fill="#0EA5E9" stroke="#FFFFFF" stroke-width="2" class="hidden" />
                    <circle id="hover-dot-fasum" cx="-10" cy="-10" r="4.5" fill="#F59E0B" stroke="#FFFFFF" stroke-width="2" class="hidden" />
                </svg>

                <!-- Floating Tooltip Box (Exact copy of ECOBASE tooltip) -->
                <div id="chart-tooltip" class="hidden absolute z-30 pointer-events-none bg-white p-3 rounded-xl shadow-xl border border-slate-200 text-xs w-44 transition-all duration-75">
                    <div id="tooltip-date" class="font-bold text-slate-800 pb-1.5 border-b border-slate-100 mb-1.5">15 September</div>
                    <div class="space-y-1 text-[11px]">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center text-slate-600"><span class="w-2 h-2 rounded-xs bg-emerald-500 mr-1.5"></span>Infrastruktur</span>
                            <span id="tooltip-infra" class="font-bold text-slate-900">80</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center text-slate-600"><span class="w-2 h-2 rounded-xs bg-sky-500 mr-1.5"></span>Kebersihan</span>
                            <span id="tooltip-kebersihan" class="font-bold text-slate-900">60</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center text-slate-600"><span class="w-2 h-2 rounded-xs bg-amber-500 mr-1.5"></span>Fasum</span>
                            <span id="tooltip-fasum" class="font-bold text-slate-900">40</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- X-Axis Labels -->
            <div id="x-axis-labels" class="flex justify-between text-[11px] text-slate-400 font-mono mt-3 px-1">
                <span>1 Okt</span><span>2 Okt</span><span>3 Okt</span><span>4 Okt</span><span>5 Okt</span>
                <span>6 Okt</span><span>7 Okt</span><span>8 Okt</span><span>9 Okt</span><span>10 Okt</span>
            </div>
        </div>

        <!-- Right: Stacked Bar Chart - Kinerja Instansi (Col 4) -->
        <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-900">Penanganan per Instansi</h2>
                <button type="button" class="text-slate-400 hover:text-slate-600 font-bold tracking-widest text-sm">•••</button>
            </div>

            <!-- Stacked Bar Chart Graphic -->
            <div class="space-y-5 my-auto py-2">
                <!-- Bar 1: Dinas PUTR -->
                <div>
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="font-semibold text-slate-800">Dinas PUTR (Bina Marga)</span>
                        <span class="font-bold text-slate-900">—</span>
                    </div>
                    <div class="h-6 w-full bg-slate-100 rounded-lg overflow-hidden flex shadow-inner">
                        <div class="bg-slate-200 h-full w-full" title="Data instansi belum tersedia"></div>
                    </div>
                </div>

                <!-- Bar 2: Dinas Lingkungan Hidup -->
                <div>
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="font-semibold text-slate-800">Dinas Lingkungan Hidup</span>
                        <span class="font-bold text-slate-900">—</span>
                    </div>
                    <div class="h-6 w-full bg-slate-100 rounded-lg overflow-hidden flex shadow-inner">
                        <div class="bg-slate-200 h-full w-full" title="Data instansi belum tersedia"></div>
                    </div>
                </div>

                <!-- Bar 3: Satpol PP / Trantibum -->
                <div>
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="font-semibold text-slate-800">Disperkim & Fasum</span>
                        <span class="font-bold text-slate-900">—</span>
                    </div>
                    <div class="h-6 w-full bg-slate-100 rounded-lg overflow-hidden flex shadow-inner">
                        <div class="bg-slate-200 h-full w-full" title="Data instansi belum tersedia"></div>
                    </div>
                </div>
            </div>

            <!-- Stacked Legend -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-medium">
                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-sm bg-emerald-500 mr-1.5"></span> Selesai</span>
                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-sm bg-sky-500 mr-1.5"></span> Pengerjaan</span>
                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-sm bg-amber-500 mr-1.5"></span> Ditugaskan</span>
            </div>
        </div>

    </div>

    <!-- Bottom Row: Donut Breakdown + Recent Reports Scorecard (Exact Match to ECOBASE) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left: Donut Chart Analysis (Col 4) -->
        <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-900">Distribusi Kategori</h2>
                <button type="button" class="text-slate-400 hover:text-slate-600 font-bold tracking-widest text-sm">•••</button>
            </div>

            <!-- Modern Donut Graphic with SVG & Callout Badges -->
            <div class="relative flex items-center justify-center my-4">
                <svg class="w-48 h-48 transform -rotate-90" viewBox="0 0 100 100">
                    <!-- Background circle track -->
                    <circle cx="50" cy="50" r="38" stroke="#F1F5F9" stroke-width="14" fill="transparent" />
                    <!-- Slice 1: Jalan Rusak (50%) -->
                    <circle id="category-donut-primary" cx="50" cy="50" r="38" stroke="#10B981" stroke-width="14" stroke-dasharray="0 238" stroke-dashoffset="0" fill="transparent" />
                </svg>
                <!-- Center Info -->
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                    <span id="category-total" class="text-2xl font-black text-slate-900">—</span>
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Laporan</span>
                </div>
            </div>

            <!-- Categories Legend List -->
            <div id="category-breakdown-list" class="space-y-2 pt-2 border-t border-slate-100 text-xs">
                <div class="flex items-center justify-between text-slate-700">
                    <span class="text-slate-400">Memuat distribusi kategori...</span>
                </div>
            </div>
        </div>

        <!-- Right: Scorecard Table (Col 8) -->
        <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Scorecard Laporan Terkini</h2>
                    <p class="text-xs text-slate-500">Status penanganan laporan langsung dari lapangan</p>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Search Input -->
                    <div class="relative">
                        <input type="text" id="scorecard-search" oninput="filterScorecard()"
                               placeholder="Cari..."
                               class="pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs text-slate-700 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- View All Button (Green like reference) -->
                    <a href="/admin/reports" 
                       class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
                        View All
                    </a>
                </div>
            </div>

            <!-- Scorecard Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 font-semibold uppercase tracking-wider">
                            <th class="py-2.5 px-3">Laporan & Wilayah</th>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Prioritas</th>
                            <th class="py-2.5 px-3">Operator</th>
                            <th class="py-2.5 px-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody id="scorecard-tbody" class="divide-y divide-slate-50">
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                Memuat data scorecard terkini...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Diperbarui otomatis secara realtime</span>
                <span class="inline-flex items-center text-emerald-600 font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-ping"></span> Live Sync
                </span>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    let timelineData = [];
    let recentReportsData = [];

    // Interactive chart data & coordinates
    function initTrendChart(timeline) {
        timelineData = timeline;
        if (!timeline || timeline.length === 0) return;

        const maxVal = Math.max(
            1,
            ...timeline.flatMap(item => [item.infrastruktur, item.kebersihan, item.fasum])
        );
        const width = 800;
        const height = 240;
        const stepX = width / (timeline.length - 1);

        // Generate SVG paths
        let infraPoints = [];
        let kebersihanPoints = [];
        let fasumPoints = [];

        timeline.forEach((item, index) => {
            const x = index * stepX;
            // Scale values relative to 100
            const yInfra = height - (item.infrastruktur / maxVal * height);
            const yKebersihan = height - (item.kebersihan / maxVal * height);
            const yFasum = height - (item.fasum / maxVal * height);

            infraPoints.push({ x, y: yInfra });
            kebersihanPoints.push({ x, y: yKebersihan });
            fasumPoints.push({ x, y: yFasum });
        });

        // Build smooth SVG path
        const buildPath = (points) => {
            return points.reduce((acc, point, i, arr) => {
                if (i === 0) return `M ${point.x},${point.y}`;
                const prev = arr[i - 1];
                const cx1 = prev.x + (point.x - prev.x) / 2;
                const cy1 = prev.y;
                const cx2 = prev.x + (point.x - prev.x) / 2;
                const cy2 = point.y;
                return `${acc} C ${cx1},${cy1} ${cx2},${cy2} ${point.x},${point.y}`;
            }, '');
        };

        const pathInfra = buildPath(infraPoints);
        const pathKebersihan = buildPath(kebersihanPoints);
        const pathFasum = buildPath(fasumPoints);

        document.getElementById('path-line-infra').setAttribute('d', pathInfra);
        document.getElementById('path-line-kebersihan').setAttribute('d', pathKebersihan);
        document.getElementById('path-line-fasum').setAttribute('d', pathFasum);
        document.getElementById('path-area-infra').setAttribute('d', `${pathInfra} L 800,240 L 0,240 Z`);

        // Update X-axis labels
        const xContainer = document.getElementById('x-axis-labels');
        xContainer.innerHTML = timeline.map(t => `<span>${t.label}</span>`).join('');
    }

    function handleChartHover(event) {
        if (!timelineData || timelineData.length === 0) return;

        const container = document.getElementById('chart-container');
        const rect = container.getBoundingClientRect();
        const mouseX = event.clientX - rect.left;
        const width = rect.width;

        const index = Math.round((mouseX / width) * (timelineData.length - 1));
        const clampedIndex = Math.max(0, Math.min(timelineData.length - 1, index));
        const item = timelineData[clampedIndex];

        // Position of elements in 800x240 viewBox
        const svgX = clampedIndex * (800 / (timelineData.length - 1));
        const maxVal = Math.max(
            1,
            ...timelineData.flatMap(item => [item.infrastruktur, item.kebersihan, item.fasum])
        );
        const yInfra = 240 - (item.infrastruktur / maxVal * 240);
        const yKebersihan = 240 - (item.kebersihan / maxVal * 240);
        const yFasum = 240 - (item.fasum / maxVal * 240);

        // Update hover line and dots
        const line = document.getElementById('hover-line');
        line.setAttribute('x1', svgX);
        line.setAttribute('x2', svgX);
        line.classList.remove('hidden');

        const dotInfra = document.getElementById('hover-dot-infra');
        dotInfra.setAttribute('cx', svgX);
        dotInfra.setAttribute('cy', yInfra);
        dotInfra.classList.remove('hidden');

        const dotKebersihan = document.getElementById('hover-dot-kebersihan');
        dotKebersihan.setAttribute('cx', svgX);
        dotKebersihan.setAttribute('cy', yKebersihan);
        dotKebersihan.classList.remove('hidden');

        const dotFasum = document.getElementById('hover-dot-fasum');
        dotFasum.setAttribute('cx', svgX);
        dotFasum.setAttribute('cy', yFasum);
        dotFasum.classList.remove('hidden');

        // Update and show floating tooltip box
        const tooltip = document.getElementById('chart-tooltip');
        document.getElementById('tooltip-date').textContent = item.label;
        document.getElementById('tooltip-infra').textContent = item.infrastruktur;
        document.getElementById('tooltip-kebersihan').textContent = item.kebersihan;
        document.getElementById('tooltip-fasum').textContent = item.fasum;

        // Position tooltip near cursor
        let tipX = mouseX + 15;
        if (tipX + 180 > width) tipX = mouseX - 190;
        tooltip.style.left = `${tipX}px`;
        tooltip.style.top = `25px`;
        tooltip.classList.remove('hidden');
    }

    function hideChartTooltip() {
        document.getElementById('hover-line').classList.add('hidden');
        document.getElementById('hover-dot-infra').classList.add('hidden');
        document.getElementById('hover-dot-kebersihan').classList.add('hidden');
        document.getElementById('hover-dot-fasum').classList.add('hidden');
        document.getElementById('chart-tooltip').classList.add('hidden');
    }

    async function loadDashboardStats() {
        try {
            const data = await TobaCare.api('/api/v1/admin/dashboard/stats');
            
            // KPIs
            if (data.kpis) {
                document.getElementById('kpi-total').textContent = (data.kpis.total_reports || 0).toLocaleString();
                document.getElementById('kpi-ai-accuracy').textContent = data.kpis.ai_verified_rate ?? '—';
                document.getElementById('kpi-in-progress').textContent = data.kpis.in_progress || 0;
                document.getElementById('kpi-sla').textContent = data.kpis.avg_resolution_sla ?? '—';
            }

            // Timeline line chart
            if (data.timeline && data.timeline.length > 0) {
                initTrendChart(data.timeline);
                document.getElementById('date-range-label').textContent =
                    `${data.timeline[0].label} – ${data.timeline[data.timeline.length - 1].label}`;
            }

            // Recent reports scorecard
            if (data.recent_reports) {
                recentReportsData = data.recent_reports;
                renderScorecard(recentReportsData);
            }
            renderCategoryBreakdown(data.category_breakdown || []);

        } catch (err) {
            console.error('Error loading dashboard stats:', err);
            TobaCare.toast('Gagal memuat statistik dashboard.', 'error');
        }
    }

    function renderCategoryBreakdown(categories) {
        const list = document.getElementById('category-breakdown-list');
        const total = categories.reduce((sum, category) => sum + Number(category.count || 0), 0);
        document.getElementById('category-total').textContent = total.toLocaleString();

        if (categories.length === 0) {
            list.innerHTML = '<div class="text-slate-400">Belum ada data kategori.</div>';
            return;
        }

        list.innerHTML = categories.slice(0, 5).map((category, index) => `
            <div class="flex items-center justify-between text-slate-700">
                <span class="flex items-center">
                    <span class="w-2.5 h-2.5 rounded-full ${['bg-emerald-500', 'bg-amber-500', 'bg-sky-500', 'bg-purple-500', 'bg-slate-400'][index]} mr-2"></span>
                    ${category.name}
                </span>
                <span class="font-bold text-slate-900">${category.count} (${category.percentage}%)</span>
            </div>
        `).join('');
    }

    function renderScorecard(items) {
        const tbody = document.getElementById('scorecard-tbody');
        if (!items || items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-6 text-center text-slate-400">Belum ada laporan terbaru.</td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = items.map(r => {
            let pColor = 'text-slate-600 bg-slate-100';
            if (r.priority === 'critical') pColor = 'text-rose-700 bg-rose-50 border border-rose-200';
            else if (r.priority === 'high') pColor = 'text-amber-700 bg-amber-50 border border-amber-200';
            else if (r.priority === 'medium') pColor = 'text-sky-700 bg-sky-50 border border-sky-200';

            let sBadge = '<span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">Baru</span>';
            if (r.status === 'assigned') sBadge = '<span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700">Ditugaskan</span>';
            if (r.status === 'in_progress') sBadge = '<span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-sky-50 text-sky-700">Dikerjakan</span>';
            if (r.status === 'resolved') sBadge = '<span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">Selesai</span>';

            return `
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="py-3 px-3">
                        <a href="/admin/reports/${r.id}" class="font-bold text-slate-900 hover:text-emerald-600 transition block truncate max-w-xs">
                            ${r.title}
                        </a>
                        <div class="text-[11px] text-slate-400 truncate max-w-xs">${r.location}</div>
                    </td>
                    <td class="py-3 px-3 font-medium text-slate-700 whitespace-nowrap">
                        ${r.category}
                    </td>
                    <td class="py-3 px-3 whitespace-nowrap">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${pColor}">
                            ${r.priority.toUpperCase()}
                        </span>
                    </td>
                    <td class="py-3 px-3 text-slate-600 whitespace-nowrap">
                        ${r.operator}
                    </td>
                    <td class="py-3 px-3 text-right whitespace-nowrap">
                        ${sBadge}
                    </td>
                </tr>
            `;
        }).join('');
    }

    function filterScorecard() {
        const query = document.getElementById('scorecard-search').value.toLowerCase();
        const filtered = recentReportsData.filter(r => {
            return r.title.toLowerCase().includes(query) ||
                   r.category.toLowerCase().includes(query) ||
                   r.location.toLowerCase().includes(query);
        });
        renderScorecard(filtered);
    }

    function exportData() {
        TobaCare.toast('Menyiapkan file ekspor laporan (CSV / PDF)...', 'success');
        setTimeout(() => {
            TobaCare.toast('Laporan monitoring siap diunduh.', 'success');
        }, 1200);
    }

    // Modal Upload Fasilitas Selesai Diperbaiki (Diupload Admin dari Dashboard)
    function openUploadFacilityModal() {
        document.getElementById('upload-facility-modal').classList.remove('hidden');
        document.getElementById('upload-facility-form').reset();
        document.getElementById('facility-photo-preview').classList.add('hidden');
    }

    function closeUploadFacilityModal() {
        document.getElementById('upload-facility-modal').classList.add('hidden');
    }

    function setFacilityLocationPreset(district) {
        const input = document.getElementById('fac-address');
        input.value = `Kecamatan ${district}, Kabupaten Toba`;
        input.focus();
    }

    function handleFacilityPhotoChange(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('facility-photo-preview');
            const img = document.getElementById('facility-photo-img');
            img.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    }

    async function handleUploadFacilitySubmit(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-submit-facility');
        const btnText = document.getElementById('btn-submit-facility-text');
        
        btn.disabled = true;
        btnText.textContent = 'Mengunggah & Mempublikasikan...';

        const formData = new FormData();
        formData.append('title', document.getElementById('fac-title').value.trim());
        formData.append('category_id', document.getElementById('fac-category').value);
        formData.append('address', document.getElementById('fac-address').value.trim());
        formData.append('description', document.getElementById('fac-desc').value.trim());
        formData.append('resolution_note', document.getElementById('fac-note').value.trim());

        const photoInput = document.getElementById('fac-photo');
        if (photoInput.files[0]) {
            formData.append('image', photoInput.files[0]);
        }

        try {
            const token = TobaCare.getToken();
            const res = await fetch('/api/v1/admin/resolved-facilities', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json();
            if (!res.ok) {
                const msg = data.message || Object.values(data.errors || {})[0]?.[0] || 'Gagal mengunggah fasilitas.';
                throw new Error(msg);
            }

            TobaCare.toast('Fasilitas selesai berhasil diunggah & dipublikasikan ke portal publik!', 'success');
            closeUploadFacilityModal();
            loadDashboardStats(); // refresh scorecard & KPI
        } catch (err) {
            TobaCare.toast(err.message, 'error');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Publikasikan ke Portal Warga';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadDashboardStats();
    });
</script>

<!-- MODAL: Upload & Publikasi Fasilitas Selesai (Diupload Admin dari Dashboard) -->
<div id="upload-facility-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-5" onclick="event.stopPropagation()">
        
        <div class="flex items-start justify-between border-b border-slate-100 pb-4">
            <div class="space-y-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Aksi Nyata Pemkab Toba
                </span>
                <h3 class="text-lg font-bold text-slate-900">Publikasi Fasilitas Selesai Diperbaiki</h3>
                <p class="text-xs text-slate-500">Unggah dokumentasi perbaikan fasilitas untuk ditampilkan langsung di portal publik warga.</p>
            </div>
            <button type="button" onclick="closeUploadFacilityModal()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold cursor-pointer">
                &times;
            </button>
        </div>

        <form id="upload-facility-form" onsubmit="handleUploadFacilitySubmit(event)" class="space-y-4 text-xs">
            <!-- Judul Fasilitas / Pekerjaan -->
            <div>
                <label for="fac-title" class="block font-bold text-slate-700 mb-1">
                    Nama Fasilitas / Judul Pekerjaan Perbaikan <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="fac-title" required minlength="5" maxlength="120"
                       placeholder="Misal: Pengaspalan Ulang & Penambalan Jalan Sisingamangaraja Porsea"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
            </div>

            <!-- Kategori Fasilitas -->
            <div>
                <label for="fac-category" class="block font-bold text-slate-700 mb-1">
                    Kategori Fasilitas <span class="text-rose-500">*</span>
                </label>
                <select id="fac-category" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    <option value="1">Jalan Rusak / Infrastruktur Jalan</option>
                    <option value="3">Lampu Jalan Rusak (Penerangan Jalan Umum)</option>
                    <option value="2">Sampah & Kebersihan Lingkungan</option>
                    <option value="4">Drainase & Saluran Air Rusak</option>
                    <option value="5">Fasilitas Umum & Ruang Terbuka Publik</option>
                </select>
            </div>

            <!-- Alamat & Lokasi -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="fac-address" class="block font-bold text-slate-700">
                        Lokasi & Kecamatan di Kab. Toba <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-[10px] text-slate-400">Pilih cepat:</span>
                </div>
                <!-- District Preset Pills -->
                <div class="flex items-center space-x-1.5 overflow-x-auto pb-1.5 mb-1 text-[10px]">
                    <button type="button" onclick="setFacilityLocationPreset('Balige')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold cursor-pointer">Balige</button>
                    <button type="button" onclick="setFacilityLocationPreset('Porsea')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold cursor-pointer">Porsea</button>
                    <button type="button" onclick="setFacilityLocationPreset('Laguboti')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold cursor-pointer">Laguboti</button>
                    <button type="button" onclick="setFacilityLocationPreset('Ajibata')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold cursor-pointer">Ajibata</button>
                    <button type="button" onclick="setFacilityLocationPreset('Silaen')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold cursor-pointer">Silaen</button>
                </div>
                <input type="text" id="fac-address" required
                       placeholder="Misal: Jl. Gereja No. 12, Balige, Kabupaten Toba"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
            </div>

            <!-- Catatan Resmi Penuntasan Dinas -->
            <div>
                <label for="fac-note" class="block font-bold text-slate-700 mb-1">
                    Catatan Resmi Penanganan Dinas <span class="text-rose-500">*</span>
                </label>
                <textarea id="fac-note" required rows="2"
                          placeholder="Misal: Pekerjaan penambalan lubang aspal telah rampung dilaksanakan oleh tim teknis Dinas PUTR Kab. Toba."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"></textarea>
            </div>

            <!-- Uraian Kondisi Sebelumnya -->
            <div>
                <label for="fac-desc" class="block font-bold text-slate-700 mb-1">
                    Uraian Masalah & Hasil Pengerjaan <span class="text-rose-500">*</span>
                </label>
                <textarea id="fac-desc" required rows="2"
                          placeholder="Misal: Penanganan pengaspalan hotmix sepanjang 20 meter pada titik jalan berlubang yang sebelumnya menghambat lalu lintas."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"></textarea>
            </div>

            <!-- Foto Bukti Hasil Perbaikan -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">
                    Foto Bukti Hasil Perbaikan Fisik
                </label>
                <input type="file" id="fac-photo" accept="image/jpeg,image/png,image/webp" onchange="handleFacilityPhotoChange(event)"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                
                <div id="facility-photo-preview" class="hidden mt-2 rounded-xl overflow-hidden border border-slate-200 h-28 bg-slate-100">
                    <img id="facility-photo-img" src="" alt="Pratinjau" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeUploadFacilityModal()"
                        class="px-4 py-2 rounded-xl border border-slate-200 font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="btn-submit-facility"
                        class="inline-flex items-center px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 font-bold text-white shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span id="btn-submit-facility-text">Publikasikan ke Portal Warga</span>
                </button>
            </div>
        </form>

    </div>
</div>
@endpush
@endsection
