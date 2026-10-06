@extends('layouts.citizen')

@section('title', 'Buat Laporan Baru — TobaCare')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Breadcrumb & Back to Home / Reports -->
    <div class="flex items-center justify-between text-xs text-slate-500">
        <div class="flex items-center space-x-2">
            <a href="/" class="hover:text-slate-900 transition flex items-center">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <span>/</span>
            <a href="/citizen/reports" class="hover:text-slate-900 transition font-medium">Aspirasi Saya</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Buat Laporan</span>
        </div>
        <a href="/" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition flex items-center">
            &larr; Kembali ke Beranda
        </a>
    </div>

    <!-- Stepper Header -->
    <div class="bg-white p-4 sm:p-6 rounded-3xl border border-slate-200/80 shadow-2xs">
        <div class="flex items-center justify-between text-xs font-bold text-slate-400 mb-3 px-1">
            <span id="step-label-1" class="text-rose-600 flex items-center">
                <span class="w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[10px] mr-1.5">1</span>
                Foto Bukti
            </span>
            <span class="w-8 sm:w-12 h-0.5 bg-slate-200" id="step-line-1"></span>
            <span id="step-label-2" class="flex items-center">
                <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] mr-1.5" id="step-num-2">2</span>
                Lokasi & Detail
            </span>
            <span class="w-8 sm:w-12 h-0.5 bg-slate-200" id="step-line-2"></span>
            <span id="step-label-3" class="flex items-center">
                <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] mr-1.5" id="step-num-3">3</span>
                Kirim
            </span>
        </div>
        <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900" id="wizard-title">
            Unggah Foto Bukti Kerusakan
        </h1>
        <p class="text-xs text-slate-500 mt-1" id="wizard-desc">
            Ambil foto jelas di lokasi kejadian (jalan berlubang, lampu padam, atau tumpukan sampah).
        </p>
    </div>

    <!-- Wizard Form Container -->
    <form id="report-form" onsubmit="event.preventDefault()">
        
        <!-- STEP 1: UPLOAD PHOTO (FR-01) -->
        <div id="step-content-1" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-2xs space-y-5">
            <div class="border-2 border-dashed border-slate-300 hover:border-rose-400 rounded-3xl p-6 sm:p-10 text-center transition cursor-pointer relative bg-slate-50/50 hover:bg-rose-50/30"
                 onclick="document.getElementById('photo-input').click()">
                <input type="file" id="photo-input" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="handlePhotoSelect(event)">
                
                <div class="space-y-3">
                    <div class="w-16 h-16 rounded-2xl bg-rose-100 text-rose-600 mx-auto flex items-center justify-center shadow-inner">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-800 block">Sentuh untuk Memilih / Mengambil Foto</span>
                        <span class="text-xs text-slate-400 mt-1 block">Format JPG, PNG, atau WebP (Maks. 5 MB)</span>
                    </div>
                </div>
            </div>

            <!-- Upload Preview Area -->
            <div id="photo-preview-box" class="hidden rounded-2xl border border-slate-200 p-4 bg-slate-50 items-center justify-between">
                <div class="flex items-center space-x-3 min-w-0">
                    <img id="photo-preview-img" src="" alt="Pratinjau" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-2xs shrink-0">
                    <div class="min-w-0">
                        <span id="photo-preview-name" class="text-xs font-bold text-slate-800 block truncate">foto_kejadian.jpg</span>
                        <span id="photo-upload-status" class="text-[11px] text-emerald-600 font-semibold flex items-center mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Siap Diproses
                        </span>
                    </div>
                </div>
                <button type="button" onclick="removePhoto()" class="text-xs text-rose-600 hover:text-rose-800 font-bold px-3 py-1.5 rounded-lg hover:bg-rose-50 transition cursor-pointer">
                    Ganti Foto
                </button>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="button" id="btn-next-1" onclick="goToStep(2)" disabled
                        class="px-6 py-2.5 rounded-full font-bold text-white text-xs sm:text-sm bg-slate-900 disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-800 shadow-xs transition cursor-pointer flex items-center">
                    <span>Lanjut ke Lokasi & Detail</span>
                    <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- STEP 2: DETAIL & LOCATION (FR-03, FR-04, FR-05) -->
        <div id="step-content-2" class="hidden bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-2xs space-y-4">
            
            <!-- Judul Laporan -->
            <div>
                <label for="report-title" class="block text-xs font-bold text-slate-700 mb-1">
                    Judul Pengaduan <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="report-title" required minlength="5" maxlength="100"
                       placeholder="Contoh: Aspal amblas berlubang dalam di depan Puskesmas Porsea"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                <span class="text-[10px] text-slate-400 mt-1 block">Tuliskan ringkasan inti permasalahan (minimal 5 karakter).</span>
            </div>

            <!-- Kategori Masalah -->
            <div>
                <label for="report-category" class="block text-xs font-bold text-slate-700 mb-1">
                    Kategori Fasilitas <span class="text-rose-500">*</span>
                </label>
                <select id="report-category" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                    <option value="">-- Pilih Kategori Kerusakan --</option>
                    @if(isset($categories) && count($categories) > 0)
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    @endif
                </select>
                <span class="text-[10px] text-slate-400 mt-1 block">Sistem akan memeriksa kesesuaian kategori ini dengan foto bukti yang Anda kirim.</span>
            </div>

            <!-- Deskripsi Rinci -->
            <div>
                <label for="report-desc" class="block text-xs font-bold text-slate-700 mb-1">
                    Deskripsi Lengkap Kejadian <span class="text-rose-500">*</span>
                </label>
                <textarea id="report-desc" rows="3" required minlength="20" maxlength="1000"
                          placeholder="Jelaskan kondisi kerusakan, potensi bahaya, atau sejak kapan kondisi ini terjadi (minimal 20 karakter)..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500"></textarea>
            </div>

            <!-- Lokasi & Alamat (FR-04) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-700">
                        Wilayah Kejadian di Kab. Toba <span class="text-rose-500">*</span>
                    </label>
                    <button type="button" onclick="detectGPSLocation()"
                            class="text-[11px] font-semibold text-rose-600 hover:text-rose-800 flex items-center cursor-pointer transition">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        <span>Gunakan GPS Saya</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <select id="report-district" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                        <option value="">Memuat kecamatan...</option>
                    </select>
                    <select id="report-village" required disabled
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-900 bg-white disabled:bg-slate-50 disabled:text-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                        <option value="">Pilih kecamatan terlebih dahulu</option>
                    </select>
                </div>
                <p id="region-status" class="text-[11px] text-slate-500 flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 text-slate-400 inline shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Pilih kecamatan lalu desa/kelurahan untuk mengisi koordinat otomatis.</span>
                </p>

                <div class="flex items-center pt-2">
                    <label for="report-address" class="block text-xs font-bold text-slate-700">
                        Deskripsi Alamat / Patokan <span class="text-rose-500">*</span>
                    </label>
                </div>
                <textarea id="report-address" required maxlength="255" rows="2"
                          placeholder="Contoh: Jl. Sisingamangaraja No. 45, samping kantor camat"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500"></textarea>

                <div class="flex items-center space-x-2 text-[11px] font-mono pt-1">
                    <span class="text-slate-500">Koordinat:</span>
                    <span id="coords-display" class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 border border-slate-200 text-[11px] font-medium">Belum dipilih</span>
                    <input type="hidden" id="report-lat">
                    <input type="hidden" id="report-lng">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-between border-t border-slate-100">
                <button type="button" onclick="goToStep(1)"
                        class="px-5 py-2.5 rounded-full border border-slate-200 font-semibold text-xs text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                    Kembali
                </button>
                <button type="button" onclick="goToStep(3)"
                        class="px-6 py-2.5 rounded-full font-bold text-white text-xs sm:text-sm bg-slate-900 hover:bg-slate-800 shadow-xs transition cursor-pointer flex items-center">
                    <span>Tinjau Laporan</span>
                    <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- STEP 3: REVIEW & SUBMIT -->
        <div id="step-content-3" class="hidden bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-2xs space-y-5">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-3">
                <div class="flex items-start space-x-4">
                    <img id="review-img" src="" alt="Bukti" class="w-20 h-20 rounded-xl object-cover border border-slate-200 shrink-0">
                    <div class="flex-1 min-w-0">
                        <span id="review-category" class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">Kategori</span>
                        <h3 id="review-title" class="text-sm font-bold text-slate-900 mt-1 line-clamp-2">Judul Laporan</h3>
                        <p id="review-address" class="text-xs text-slate-500 mt-0.5 line-clamp-1">Alamat Lokasi</p>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-200/60 text-xs text-slate-600 leading-relaxed">
                    <strong class="text-slate-800">Deskripsi:</strong>
                    <p id="review-desc" class="mt-0.5 text-slate-600 line-clamp-3"></p>
                </div>
            </div>

            <!-- Transparency Disclaimer -->
            <div class="p-3.5 rounded-2xl bg-sky-50 border border-sky-200 text-sky-900 text-xs flex items-start space-x-2.5">
                <svg class="w-4 h-4 text-sky-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="leading-relaxed">
                    Laporan akan diproses secara transparan dan diverifikasi langsung oleh Admin Dinas Pemkab Toba sebelum ditugaskan ke petugas teknis lapangan.
                </div>
            </div>

            <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                <button type="button" onclick="goToStep(2)"
                        class="px-5 py-2.5 rounded-full border border-slate-200 font-semibold text-xs text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                    Ubah Data
                </button>
                <button type="button" id="btn-submit-report" onclick="submitFinalReport()"
                        class="px-8 py-3 rounded-full font-bold text-white text-xs sm:text-sm shadow-lg shadow-orange-500/25 bg-linear-to-r from-[#FF4E20] via-[#FF5F2E] to-[#E92359] hover:from-[#E63F12] hover:to-[#CF1749] transition cursor-pointer flex items-center space-x-2">
                    <span id="btn-submit-text">Kirim Laporan Resmi</span>
                    <svg id="btn-submit-spinner" class="hidden animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </div>

    </form>

</div>

@push('scripts')
<script>
    let uploadedImageId = null;
    let uploadedImageUrl = null;
    let currentStep = 1;
    let categoriesList = [];
    let districtsList = [];
    let villagesList = [];

    const TOBA_DISTRICT_COORDS = {
        'Balige': { lat: 2.3354, lng: 99.0628 },
        'Laguboti': { lat: 2.3789, lng: 99.1178 },
        'Silaen': { lat: 2.3850, lng: 99.1920 },
        'Habinsaran': { lat: 2.3920, lng: 99.3400 },
        'Pintu Pohan Meranti': { lat: 2.5200, lng: 99.3000 },
        'Borbor': { lat: 2.3200, lng: 99.3300 },
        'Porsea': { lat: 2.4501, lng: 99.1412 },
        'Ajibata': { lat: 2.6680, lng: 98.9320 },
        'Lumban Julu': { lat: 2.5600, lng: 99.0800 },
        'Uluan': { lat: 2.4850, lng: 99.0900 },
        'Sigumpar': { lat: 2.4150, lng: 99.1350 },
        'Siantar Narumonda': { lat: 2.4350, lng: 99.1400 },
        'Nassau': { lat: 2.2900, lng: 99.4000 },
        'Tampahan': { lat: 2.3150, lng: 99.0250 },
        'Bonatua Lunasi': { lat: 2.4650, lng: 99.1550 },
        'Parmaksian': { lat: 2.4450, lng: 99.1650 },
    };

    function setCoordinates(lat, lng, label) {
        const numLat = Number(lat);
        const numLng = Number(lng);
        if (isNaN(numLat) || isNaN(numLng)) return;

        document.getElementById('report-lat').value = numLat.toFixed(6);
        document.getElementById('report-lng').value = numLng.toFixed(6);
        const display = document.getElementById('coords-display');
        display.textContent = `${numLat.toFixed(5)}, ${numLng.toFixed(5)} (${label || 'Kab. Toba'})`;
        display.className = 'px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-semibold flex items-center gap-1';
    }

    function resetCoordinates() {
        document.getElementById('report-lat').value = '';
        document.getElementById('report-lng').value = '';
        const display = document.getElementById('coords-display');
        display.textContent = 'Belum dipilih';
        display.className = 'px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 border border-slate-200 text-[11px] font-medium';
    }

    function detectGPSLocation() {
        if (!navigator.geolocation) {
            TobaCare.toast('Browser Anda tidak mendukung geolokasi GPS.', 'warning');
            return;
        }

        const status = document.getElementById('region-status');
        status.innerHTML = '<span class="text-rose-600 font-medium">Mendeteksi koordinat GPS perangkat Anda...</span>';
        TobaCare.toast('Sedang mengambil koordinat GPS perangkat...', 'info');

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                setCoordinates(lat, lng, 'GPS Akurat');
                status.innerHTML = `<span class="text-emerald-600 font-semibold">✓ Titik GPS berhasil dikunci (${lat.toFixed(5)}, ${lng.toFixed(5)})</span>`;
                TobaCare.toast('Titik koordinat GPS berhasil dikunci!', 'success');
            },
            (err) => {
                let msg = 'Izin lokasi GPS tidak diberikan.';
                if (err.code === 2) msg = 'Posisi GPS tidak dapat ditentukan.';
                if (err.code === 3) msg = 'Waktu permintaan GPS habis.';
                TobaCare.toast(msg + ' Tetap menggunakan koordinat wilayah terpilih.', 'info');
                status.innerHTML = '<span>Pilih kecamatan lalu desa/kelurahan untuk mengisi koordinat otomatis.</span>';
            },
            { enableHighAccuracy: true, timeout: 8000 }
        );
    }

    async function loadTobaRegions() {
        const districtSelect = document.getElementById('report-district');
        const villageSelect = document.getElementById('report-village');

        try {
            const response = await fetch('/api/v1/regions/districts');
            if (!response.ok) throw new Error('Gagal memuat daftar kecamatan.');
            const data = await response.json();
            districtsList = data.data || [];
            districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>' +
                districtsList.map(item => `<option value="${item.code}">${item.name}</option>`).join('');
        } catch (error) {
            districtSelect.innerHTML = '<option value="">Daftar wilayah gagal dimuat</option>';
            document.getElementById('region-status').textContent = 'Daftar wilayah tidak dapat dimuat. Periksa koneksi lalu muat ulang halaman.';
            TobaCare.toast(error.message, 'error');
        }
    }

    async function loadVillages(districtCode) {
        const villageSelect = document.getElementById('report-village');
        villageSelect.disabled = true;
        villageSelect.innerHTML = '<option value="">Memuat desa/kelurahan...</option>';

        if (!districtCode) {
            resetCoordinates();
            villageSelect.innerHTML = '<option value="">Pilih kecamatan terlebih dahulu</option>';
            return;
        }

        const district = districtsList.find(item => item.code === districtCode);
        const districtName = district ? district.name : '';

        // Immediately set coordinate to district centroid so user is never empty
        if (districtName) {
            const fallback = TOBA_DISTRICT_COORDS[districtName] || { lat: 2.3354, lng: 99.0628 };
            setCoordinates(fallback.lat, fallback.lng, `Kecamatan ${districtName}`);
            document.getElementById('region-status').innerHTML = `<span>Kecamatan ${districtName} terpilih. Silakan pilih desa/kelurahan untuk presisi lokasi.</span>`;
        }

        try {
            const response = await fetch(`/api/v1/regions/villages/${encodeURIComponent(districtCode)}`);
            if (!response.ok) throw new Error('Gagal memuat daftar desa.');
            const data = await response.json();
            villagesList = data.data || [];
            villageSelect.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>' +
                villagesList.map(item => `<option value="${item.code}">${item.name}</option>`).join('');
            villageSelect.disabled = false;
        } catch (error) {
            villageSelect.innerHTML = '<option value="">Daftar desa gagal dimuat</option>';
            document.getElementById('region-status').textContent = 'Daftar desa tidak dapat dimuat. Periksa koneksi lalu coba lagi.';
            TobaCare.toast(error.message, 'error');
        }
    }

    async function geocodeVillage() {
        const district = districtsList.find(item => item.code === document.getElementById('report-district').value);
        const village = villagesList.find(item => item.code === document.getElementById('report-village').value);
        if (!district || !village) return;

        const status = document.getElementById('region-status');
        status.innerHTML = `<span class="text-slate-500">Mencari koordinat presisi ${village.name}...</span>`;

        try {
            const params = new URLSearchParams({ district: district.name, village: village.name });
            const response = await fetch(`/api/v1/regions/geocode?${params.toString()}`);
            const result = await response.json();
            if (!response.ok) throw new Error(result?.error?.message || 'Koordinat desa belum ditemukan.');

            const lat = Number(result.lat);
            const lng = Number(result.lng);
            setCoordinates(lat, lng, `${village.name}, ${district.name}`);
            status.innerHTML = `<span class="text-emerald-600 font-semibold">✓ Koordinat otomatis terisi untuk ${village.name}, Kec. ${district.name}.</span>`;
        } catch (error) {
            // Never reset or wipe out coordinates on error! Fallback to district centroid
            const fallback = TOBA_DISTRICT_COORDS[district.name] || { lat: 2.3354, lng: 99.0628 };
            setCoordinates(fallback.lat, fallback.lng, `Kecamatan ${district.name}`);
            status.innerHTML = `<span class="text-emerald-700 font-medium">✓ Koordinat disetel ke wilayah ${district.name}.</span>`;
        }
    }

    async function loadCategoriesDropdown() {
        const select = document.getElementById('report-category');
        if (select && select.options.length > 1 && categoriesList.length === 0) {
            categoriesList = Array.from(select.options)
                .filter(opt => opt.value)
                .map(opt => ({ id: parseInt(opt.value), name: opt.textContent.trim() }));
        }

        try {
            const res = await fetch('/api/v1/categories', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const items = data.items || data.categories || data.data || (Array.isArray(data) ? data : []);
            if (items && items.length > 0) {
                categoriesList = items;
                const currentVal = select.value;
                select.innerHTML = '<option value="">-- Pilih Kategori Kerusakan --</option>' +
                    items.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
                if (currentVal) select.value = currentVal;
            }
        } catch (err) {
            console.error('Gagal memuat kategori via API:', err);
            if (select && select.options.length <= 1) {
                select.innerHTML = '<option value="">Kategori tidak tersedia</option>';
                select.disabled = true;
            }
            TobaCare.toast('Kategori laporan tidak dapat dimuat. Silakan muat ulang halaman.', 'error');
        }
    }

    async function handlePhotoSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);

        // Instant local preview
        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('photo-preview-img').src = e.target.result;
            document.getElementById('photo-preview-name').textContent = file.name;
            document.getElementById('photo-upload-status').innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span> Mengunggah foto ke server...';
            const previewBox = document.getElementById('photo-preview-box');
            previewBox.classList.remove('hidden');
            previewBox.classList.add('flex');
        };
        reader.readAsDataURL(file);

        try {
            const token = TobaCare.getToken();
            const res = await fetch('/api/v1/reports/images', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json();
            if (!res.ok) throw new Error(data?.error?.message || 'Gagal mengunggah foto.');

            uploadedImageId = data.image_id;
            uploadedImageUrl = data.url;

            document.getElementById('photo-upload-status').innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Foto Berhasil Terunggah';
            document.getElementById('btn-next-1').disabled = false;
            TobaCare.toast('Foto berhasil diunggah!', 'success');

        } catch (err) {
            TobaCare.toast(err.message || 'Gagal memproses foto.', 'error');
            document.getElementById('photo-upload-status').innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> ${err.message}`;
            document.getElementById('btn-next-1').disabled = true;
        }
    }

    function removePhoto() {
        uploadedImageId = null;
        uploadedImageUrl = null;
        document.getElementById('photo-input').value = '';
        const previewBox = document.getElementById('photo-preview-box');
        previewBox.classList.add('hidden');
        previewBox.classList.remove('flex');
        document.getElementById('btn-next-1').disabled = true;
    }

    function setPresetLocation(name, lat, lng) {
        document.getElementById('report-lat').value = lat;
        document.getElementById('report-lng').value = lng;
        document.getElementById('coords-display').textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)} (${name})`;
        TobaCare.toast('Lokasi disetel ke ' + name, 'info');
    }

    function goToStep(step) {
        if (step === 2 && !uploadedImageId) {
            TobaCare.toast('Silakan pilih dan unggah foto bukti terlebih dahulu.', 'warning');
            return;
        }

        if (step === 3) {
            const title = document.getElementById('report-title').value.trim();
            const desc = document.getElementById('report-desc').value.trim();
            const cat = document.getElementById('report-category').value;
            const addr = document.getElementById('report-address').value.trim();
            const district = document.getElementById('report-district').value;
            const village = document.getElementById('report-village').value;
            const lat = document.getElementById('report-lat').value;
            const lng = document.getElementById('report-lng').value;

            if (title.length < 5) {
                TobaCare.toast('Judul laporan minimal 5 karakter.', 'warning');
                return;
            }
            if (desc.length < 20) {
                TobaCare.toast('Deskripsi masalah minimal 20 karakter.', 'warning');
                return;
            }
            if (!cat) {
                TobaCare.toast('Silakan pilih kategori masalah.', 'warning');
                return;
            }
            if (!district || !village) {
                TobaCare.toast('Silakan pilih kecamatan dan desa/kelurahan.', 'warning');
                return;
            }
            if (!addr) {
                TobaCare.toast('Deskripsi alamat atau patokan wajib diisi.', 'warning');
                return;
            }
            if (!lat || !lng) {
                TobaCare.toast('Koordinat belum tersedia. Pilih kecamatan dan desa terlebih dahulu.', 'warning');
                return;
            }

            // Fill Step 3 review
            const select = document.getElementById('report-category');
            const catObj = categoriesList.find(c => c.id == cat);
            const catLabel = catObj ? catObj.name : (select.options[select.selectedIndex]?.text || 'Kategori Terpilih');
            document.getElementById('review-img').src = uploadedImageUrl || document.getElementById('photo-preview-img').src;
            document.getElementById('review-title').textContent = title;
            document.getElementById('review-desc').textContent = desc;
            document.getElementById('review-category').textContent = catLabel;
            document.getElementById('review-address').textContent = addr;
        }

        currentStep = step;
        document.getElementById('step-content-1').classList.toggle('hidden', step !== 1);
        document.getElementById('step-content-2').classList.toggle('hidden', step !== 2);
        document.getElementById('step-content-3').classList.toggle('hidden', step !== 3);

        // Update step titles
        const titles = {
            1: ['Unggah Foto Bukti Kerusakan', 'Ambil foto jelas di lokasi kejadian.'],
            2: ['Detail Masalah & Lokasi', 'Lengkapi informasi agar dinas dan petugas dapat menuju titik lokasi.'],
            3: ['Tinjau & Konfirmasi Laporan', 'Periksa kembali data Anda sebelum diteruskan ke admin dinas.']
        };
        document.getElementById('wizard-title').textContent = titles[step][0];
        document.getElementById('wizard-desc').textContent = titles[step][1];

        // Step numbers and lines color
        document.getElementById('step-label-1').className = step >= 1 ? 'text-rose-600 font-bold flex items-center' : 'text-slate-400 flex items-center';
        document.getElementById('step-label-2').className = step >= 2 ? 'text-rose-600 font-bold flex items-center' : 'text-slate-400 flex items-center';
        document.getElementById('step-num-2').className = step >= 2 ? 'w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[10px] mr-1.5' : 'w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] mr-1.5';
        document.getElementById('step-label-3').className = step >= 3 ? 'text-rose-600 font-bold flex items-center' : 'text-slate-400 flex items-center';
        document.getElementById('step-num-3').className = step >= 3 ? 'w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[10px] mr-1.5' : 'w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] mr-1.5';
        document.getElementById('step-line-1').className = step >= 2 ? 'w-8 sm:w-12 h-0.5 bg-rose-600' : 'w-8 sm:w-12 h-0.5 bg-slate-200';
        document.getElementById('step-line-2').className = step >= 3 ? 'w-8 sm:w-12 h-0.5 bg-rose-600' : 'w-8 sm:w-12 h-0.5 bg-slate-200';
    }

    async function submitFinalReport() {
        const btn = document.getElementById('btn-submit-report');
        const text = document.getElementById('btn-submit-text');
        const spinner = document.getElementById('btn-submit-spinner');

        btn.disabled = true;
        text.textContent = 'Mengirim Laporan & Menganalisis...';
        spinner.classList.remove('hidden');

        try {
            const payload = {
                title: document.getElementById('report-title').value.trim(),
                description: document.getElementById('report-desc').value.trim(),
                category_id: parseInt(document.getElementById('report-category').value),
                image_ids: [uploadedImageId],
                location: {
                    lat: parseFloat(document.getElementById('report-lat').value),
                    lng: parseFloat(document.getElementById('report-lng').value),
                    address: document.getElementById('report-address').value.trim(),
                    region: [
                        document.getElementById('report-district').selectedOptions[0]?.text,
                        document.getElementById('report-village').selectedOptions[0]?.text
                    ].filter(Boolean).join(', ') + ', Kabupaten Toba',
                }
            };

            const data = await TobaCare.api('/api/v1/reports', {
                method: 'POST',
                body: JSON.stringify(payload)
            });

            TobaCare.toast('Laporan berhasil dikirim! Sedang diproses dalam antrean triase dinas.', 'success');
            setTimeout(() => {
                window.location.href = '/citizen/reports';
            }, 800);

        } catch (err) {
            TobaCare.toast(err.message || 'Gagal mengirim laporan.', 'error');
            btn.disabled = false;
            text.textContent = 'Kirim Laporan Resmi';
            spinner.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCategoriesDropdown();
        loadTobaRegions();
        document.getElementById('report-district').addEventListener('change', (event) => loadVillages(event.target.value));
        document.getElementById('report-village').addEventListener('change', geocodeVillage);
    });
</script>
@endpush
@endsection
