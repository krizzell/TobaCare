# TobaCare — Product Requirements Document (PRD)

**Versi:** 1.0 (draft kompetisi) **Status:** Prototype / konsep teknologi **Catatan posisi:** TobaCare bukan platform pengaduan resmi dan bukan pengganti sistem pemerintahan. TobaCare adalah prototype yang mendemonstrasikan bagaimana civic reporting dan transparansi tindak lanjut dapat dibantu teknologi.

Legenda: **\[MVP\]** wajib untuk demo, **\[ENH\]** enhancement jika waktu memungkinkan, **\[FUT\]** pengembangan lanjutan, **TBD** keputusan belum dapat ditentukan (opsi diberikan).

---

## 1. Product Overview

**TobaCare** adalah platform web civic reporting untuk melaporkan permasalahan lingkungan: jalan rusak, sampah, lampu jalan rusak, drainase, fasilitas umum, dan isu lingkungan lain.

Alur end-to-end:

**Masyarakat membuat laporan → AI menganalisis → laporan diverifikasi → diteruskan ke pihak/dinas terkait → ditindaklanjuti → masyarakat memantau progres → laporan diselesaikan.**

Prinsip utama:

1. **AI sebagai decision-support.** AI memberi prediksi, confidence, dan rekomendasi. Keputusan akhir (validasi, prioritas, tindak lanjut) selalu oleh manusia.
2. **Transparansi.** Masyarakat dapat melihat status dan riwayat laporan.
3. **Terstruktur.** Setiap laporan memiliki foto, teks, lokasi, kategori, dan metadata yang konsisten.
4. **Human-in-the-loop.** Koreksi manusia disimpan sebagai data terverifikasi untuk pengembangan model.

---

## 2. Problem Statement

| # | Masalah | Dampak |
| --- | --- | --- |
| P1 | Masyarakat kesulitan menyampaikan masalah lingkungan secara terstruktur | Laporan tidak lengkap, sulit ditindaklanjuti |
| P2 | Laporan tersebar di banyak kanal | Sulit dikelola dan dilacak |
| P3 | Pengelola harus membaca dan mengklasifikasi laporan satu per satu | Waktu triase lama |
| P4 | Laporan sama/mirip dikirim banyak orang | Beban kerja ganda, data bias |
| P5 | Pelapor tidak tahu perkembangan laporan | Kepercayaan menurun |
| P6 | Tidak ada gambaran visual persebaran masalah | Sulit menentukan area bermasalah |
| P7 | Data laporan belum dimanfaatkan untuk pola/tren | Perencanaan reaktif |

**Batasan klaim:** TobaCare tidak mengklaim menggantikan sistem pemerintah. TobaCare adalah konsep/prototype.

---

## 3. Goals

| ID | Tujuan | Indikator (target awal, dapat disesuaikan) |
| --- | --- | --- |
| G1 | Mempermudah pembuatan laporan | Laporan dapat dibuat dalam alur ≤ 5 langkah dari perangkat mobile |
| G2 | Laporan lebih terstruktur | Semua laporan memiliki foto, lokasi, kategori |
| G3 | Membantu admin memahami laporan dengan AI | Admin melihat ringkasan AI di halaman review |
| G4 | Computer Vision menganalisis foto | Setiap foto valid menghasilkan prediksi + confidence |
| G5 | AI teks membantu klasifikasi | Teks menghasilkan kategori, urgensi, keyword |
| G6 | Mengurangi duplikat | Kandidat duplikat ditampilkan ke admin |
| G7 | Rekomendasi prioritas | Setiap laporan punya prioritas rekomendasi + alasan |
| G8 | Transparansi tindak lanjut | Timeline status terlihat oleh pelapor |
| G9 | Dashboard dan visualisasi | Dashboard publik, dashboard admin, peta |

Target numerik bersifat **TBD** sampai ada data uji; jangan dipresentasikan sebagai klaim performa.

---

## 4. Target Users

| Role | Deskripsi | Kemampuan utama |
| --- | --- | --- |
| **Masyarakat** | Warga umum, dominan mobile, literasi digital beragam | Membuat laporan, upload foto, deskripsi, lokasi, lihat hasil AI, pantau status, lihat laporan publik, beri feedback |
| **Admin/Moderator** | Staf yang memverifikasi dan mengatur alur | Lihat semua laporan, verifikasi, koreksi AI, ubah kategori/prioritas, merge duplikat, assign, ubah status, statistik |
| **Operator/Penanggung Jawab** | Pihak lapangan/dinas yang menangani | Lihat laporan yang ditugaskan, terima, ubah status penanganan, tambah update, upload bukti, catatan |

---

## 5. User Personas

**Persona 1 — Rina (31), ibu rumah tangga/pedagang.** Ponsel Android, sering lewat jalan berlubang depan sekolah anaknya. Butuh lapor cepat tanpa form panjang, ingin tahu kapan diperbaiki. *Pain:* lapor lewat grup chat, tidak ada kabar.

**Persona 2 — Bagas (24), mahasiswa/relawan lingkungan.** Aktif melaporkan sampah dan drainase. Ingin melihat peta dan tren wilayah, membagikan laporan. *Pain:* tidak tahu apakah laporannya sudah ada yang mengirim.

**Persona 3 — Pak Hotman (45), admin verifikasi.** Menerima puluhan laporan per hari. Butuh triase cepat, duplikat terdeteksi, alasan rekomendasi jelas. *Pain:* membaca satu per satu, laporan kembar.

**Persona 4 — Pak Darma (38), operator lapangan.** Menerima tugas, update dari lapangan via ponsel. Butuh detail lokasi jelas, form update sederhana, upload bukti cepat.

---

## 6. User Stories

### Masyarakat

- **US-01** Sebagai warga, saya ingin membuat laporan dengan foto, deskripsi, dan lokasi agar masalah tercatat rapi.
- **US-02** Sebagai warga, saya ingin melihat hasil analisis AI sebelum mengirim agar dapat mengoreksi kategori.
- **US-03** Sebagai warga, saya ingin memantau status laporan agar tahu progresnya.
- **US-04** Sebagai warga, saya ingin menerima notifikasi saat status berubah.
- **US-05** Sebagai warga, saya ingin menjelajah peta dan laporan publik agar tahu masalah di sekitar saya.
- **US-06** Sebagai warga, saya ingin memberi feedback setelah laporan selesai.

### Admin

- **US-07** Sebagai admin, saya ingin melihat antrean laporan baru dengan hasil AI agar triase cepat.
- **US-08** Sebagai admin, saya ingin mengoreksi kategori dan prioritas AI.
- **US-09** Sebagai admin, saya ingin melihat kandidat duplikat dan menggabungkannya.
- **US-10** Sebagai admin, saya ingin menugaskan laporan ke operator.
- **US-11** Sebagai admin, saya ingin melihat statistik dan peta agar memahami persebaran.
- **US-12** Sebagai admin, saya ingin melihat alasan rekomendasi prioritas agar tidak black box.

### Operator

- **US-13** Sebagai operator, saya ingin melihat laporan yang ditugaskan kepada saya.
- **US-14** Sebagai operator, saya ingin menerima tugas dan memperbarui status.
- **US-15** Sebagai operator, saya ingin mengunggah bukti penyelesaian dan catatan.

---

## 7. Functional Requirements

### 7.1 Create Report \[MVP\]

| Field | Wajib | Validasi |
| --- | --- | --- |
| Judul | Ya | 5–100 karakter, trim, sanitasi HTML |
| Deskripsi | Ya | 20–1000 karakter, sanitasi HTML |
| Foto | Ya (minimal 1) | Maks. 3 foto (TBD), format JPEG/PNG/WebP, maks. 5 MB/foto (TBD), validasi MIME dan magic bytes |
| Lokasi | Ya | Koordinat lat/lng valid dan berada dalam wilayah layanan prototype (wilayah TBD); alamat teks opsional; bisa dari GPS, pin di peta, atau pencarian alamat |
| Kategori | Ya (terisi saran AI, dapat diubah) | Harus ada di tabel Category aktif |
| Waktu kejadian | Opsional (default: saat ini) | Tidak boleh di masa depan; maks. 30 hari ke belakang (TBD) |
| Informasi tambahan | Opsional | Maks. 500 karakter (contoh: patok lokasi, tingkat bahaya) |

Perilaku:

- FR-01 Form bersifat mobile-first, dapat mengambil foto langsung dari kamera.
- FR-02 Setelah foto diunggah, analisis AI berjalan otomatis dan hasilnya ditampilkan pada langkah review.
- FR-03 User dapat menerima atau mengubah kategori saran AI sebelum submit.
- FR-04 Jika lokasi tidak tersedia dari GPS, user wajib menandai lokasi di peta.
- FR-05 Laporan tidak dapat dikirim jika field wajib belum valid; pesan error per field.
- FR-06 Draft disimpan sementara di sisi klien agar tidak hilang saat koneksi terputus \[ENH\].

### 7.2 Explore & Track

- FR-10 Daftar laporan publik dengan filter kategori, status, periode, dan pencarian \[MVP\].
- FR-11 Halaman detail laporan dengan foto, deskripsi, status, timeline, dan bukti penyelesaian \[MVP\].
- FR-12 Pelapor dapat melihat hasil AI miliknya; laporan publik hanya menampilkan kategori dan status final, bukan skor internal (TBD: apakah confidence publik ditampilkan).
- FR-13 Identitas pelapor disamarkan di tampilan publik (nama inisial/anonim) \[MVP\].

### 7.3 Admin & Operator Workflow

- FR-20 Antrean verifikasi dengan filter (prioritas, confidence rendah, duplikat) \[MVP\].
- FR-21 Admin dapat mengoreksi kategori, prioritas, dan menambah catatan \[MVP\].
- FR-22 Admin dapat assign ke operator/instansi \[MVP\].
- FR-23 Operator dapat menerima, mengubah status, menambah update dan bukti \[MVP\].
- FR-24 Admin dapat meminta informasi tambahan dari pelapor \[ENH\].

### 7.4 Feedback

- FR-30 Setelah status Resolved, pelapor dapat memberi rating 1–5 dan komentar; pelapor dapat menyatakan "belum selesai" sehingga admin melihat flag \[ENH\].

---

## 8. AI/ML Requirements

| ID | Requirement |
| --- | --- |
| AI-01 | AI berperan sebagai rekomendasi; tidak ada perubahan status/prioritas final otomatis tanpa konfirmasi manusia. |
| AI-02 | Setiap output AI menyimpan: versi model, waktu, input ringkas, output, confidence. |
| AI-03 | Output AI selalu ditampilkan berlabel "Rekomendasi AI". |
| AI-04 | Arsitektur modular: Text Analysis, Computer Vision, Duplicate Detection, Priority Recommendation dapat diganti tanpa mengubah kontrak API internal. |
| AI-05 | Kegagalan AI tidak boleh memblokir pembuatan laporan (fallback ke manual). |
| AI-06 | Koreksi manusia disimpan sebagai label terverifikasi untuk pelatihan ulang. |
| AI-07 | Implementasi tidak dikunci pada satu provider/library (lihat bagian 22). |

### 8.1 AI Text Analysis

Input: judul + deskripsi (+ informasi tambahan). Output:

```json
{
  "category": "jalan_rusak",
  "subcategory": "lubang",
  "suggested_agency": "Dinas PU (rekomendasi)",
  "urgency_indication": "high",
  "keywords": ["jalan", "berlubang", "sekolah", "kendaraan"],
  "confidence": 0.88
}
```

- Contoh: "Jalan di depan sekolah berlubang dan membahayakan pengendara." → Infrastruktur / Jalan Rusak, urgensi tinggi (kata kunci bahaya + sekolah).
- Hasil berupa rekomendasi. Daftar instansi **TBD** (tergantung wilayah dan data real).

### 8.2 Multimodal Analysis

Sistem menggabungkan sinyal: **foto + teks + lokasi + metadata** (waktu, jumlah laporan serupa, umur laporan).

Pendekatan konseptual (*late fusion*, dapat diganti *joint model* kemudian):

1. Masing-masing modalitas menghasilkan prediksi + confidence.
2. **Fusion layer** menggabungkan: jika foto dan teks sepakat, confidence gabungan naik; jika bertentangan, laporan ditandai **konflik modalitas** dan diarahkan ke review manual.
3. Sinyal lokasi (dekat sekolah, rumah sakit, jalan utama) dan metadata masuk ke modul prioritas sebagai fitur.

Contoh output:

```
Category: Infrastruktur / Jalan Rusak
Priority Recommendation: Tinggi
Confidence: 92%
Reasoning: foto = lubang (91%), teks menyebut sekolah & kendaraan, lokasi dekat sekolah
```

Admin tetap dapat mengubah seluruh hasil.

---

## 9. Computer Vision Requirements

### 9.1 Alur

| Tahap | Deskripsi |
| --- | --- |
| 1. Penerimaan | Frontend mengirim foto via `multipart/form-data` ke backend. Backend memvalidasi ukuran, MIME, magic bytes, dimensi minimum. |
| 2. Penyimpanan | Foto disimpan di object storage dengan nama acak (UUID); metadata disimpan di `ReportImage`. EXIF lokasi/sensitif dihapus dari salinan publik. |
| 3. Preprocessing | Resize (mis. ke resolusi input model), normalisasi, koreksi orientasi EXIF. Cek kualitas dasar (blur/gelap, lihat bagian 18). |
| 4. Inferensi | Model vision melakukan klasifikasi kategori (dan subkategori/kondisi bila didukung). |
| 5. Output | Top-k kelas + confidence, versi model, waktu proses. |
| 6. Penyimpanan hasil | Disimpan ke `AIAnalysis` dan `AIClassification`. |

### 9.2 Format output model

```json
{
  "model_version": "cv-v0.1",
  "predictions": [
    {"label": "jalan_rusak", "subtype": "lubang", "confidence": 0.91},
    {"label": "lainnya", "confidence": 0.05}
  ],
  "quality_flags": {"blur": false, "too_dark": false},
  "processing_ms": 820
}
```

Contoh: foto jalan berlubang → Object: Jalan, Condition: Rusak, Type: Lubang, Confidence 91%. Foto sampah → Kategori Lingkungan/Sampah, 94%.

### 9.3 Penggunaan confidence score

Ambang bersifat **konfigurabel** dan nilainya **TBD** (ditentukan dari evaluasi pada dataset uji). Skema awal yang dapat dipertimbangkan:

| Confidence | Perlakuan |
| --- | --- |
| ≥ T_high | Kategori disarankan dan dipilih otomatis (masih dapat diubah user/admin) |
| T_low – T_high | Kategori disarankan, ditandai "perlu konfirmasi" |
| \< T_low | Dikategorikan **Lainnya / Tidak Teridentifikasi**, masuk antrean review manual |

### 9.4 Confidence rendah

Tampilkan pesan: **"Permasalahan belum dapat diidentifikasi dengan cukup yakin. Silakan verifikasi kategori laporan."** Laporan tetap dapat dikirim dan diproses admin.

### 9.5 Tampilan hasil

- **User:** kartu "Hasil Analisis AI" — kategori saran, tingkat keyakinan dalam bahasa sederhana (Tinggi/Sedang/Rendah), tombol "Ubah kategori".
- **Admin:** kategori, subkategori, confidence numerik, top-3 prediksi, flag kualitas foto, versi model.

### 9.6 Koreksi admin

Admin memilih kategori benar dari dropdown, mengisi alasan opsional. Sistem menyimpan: prediksi AI asli, label koreksi, admin, waktu. Data ini ditandai `verified = true` untuk dataset pengembangan.

### 9.7 Data & model

- Model **tidak dibuat dari nol**. Menggunakan **pretrained vision model** yang dapat di-*fine-tune* dengan dataset TobaCare (lihat bagian 22).
- Sumber dan jumlah dataset **belum ditentukan (TBD)**. Dokumen ini tidak menetapkan jumlah data final.

---

## 10. Non-Functional Requirements

| ID | Kategori | Requirement |
| --- | --- | --- |
| NFR-01 | Performa | Halaman utama LCP ≤ 3 detik pada jaringan 4G (target, TBD setelah uji) |
| NFR-02 | Performa AI | Hasil analisis foto ditampilkan dalam target ≤ 10 detik (TBD); pemrosesan asinkron dengan indikator progres |
| NFR-03 | Ketersediaan | Kegagalan AI tidak menghentikan alur laporan |
| NFR-04 | Responsif | Mobile-first, breakpoint minimal 360 px, tablet, desktop |
| NFR-05 | Aksesibilitas | Kontras teks memadai, label form, navigasi keyboard pada halaman utama |
| NFR-06 | Skalabilitas | Komponen AI dapat dipisah sebagai service; database dapat diindeks geospasial |
| NFR-07 | Observability | Log terstruktur, pelacakan error, metrik waktu inferensi |
| NFR-08 | Maintainability | Kategori dan ambang AI berbasis konfigurasi/database, bukan hardcode |
| NFR-09 | Bahasa | Antarmuka Bahasa Indonesia (multi-bahasa \[FUT\]) |
| NFR-10 | Kompatibilitas | Dua versi terbaru Chrome, Edge, Safari, Firefox; Chrome Android |

---

## 11. User Flow

### 11.1 Flow Masyarakat

Landing Page → Login → Create Report → Upload Photo → Write Description → **AI Analysis** → Review AI Result → Submit → Track Report → Receive Updates → View Resolution

### 11.2 Flow Admin

Login → Dashboard → Review New Report → Review AI Analysis → Verify → Set/Confirm Priority → Assign → Monitor Progress → Review Evidence → Close Report

### 11.3 Lifecycle Status

**Submitted → AI Analysis → Pending Verification → Verified → Assigned → In Progress → Resolved → Closed**

| Transisi | Pelaku | Data wajib dicatat |
| --- | --- | --- |
| → Submitted | User | Waktu, user, versi form |
| → AI Analysis | Sistem | Waktu mulai, versi model |
| → Pending Verification | Sistem | Hasil AI, flag review manual |
| → Verified | Admin | Admin, waktu, kategori final, prioritas final, catatan |
| → Assigned | Admin | Operator/instansi, waktu, tenggat (opsional) |
| → In Progress | Operator | Operator, waktu, catatan awal |
| → Resolved | Operator | Bukti penyelesaian (foto), catatan, waktu |
| → Closed | Admin (atau otomatis setelah N hari tanpa keberatan, N = TBD) | Admin, waktu, ringkasan akhir |
| Ditolak (opsional) | Admin | Alasan penolakan wajib, terlihat oleh pelapor |
| Reopen (opsional) \[ENH\] | Admin | Alasan |

Setiap perubahan status menulis satu baris `ReportStatusHistory`.

---

## 12. System Architecture

```text
User
 ↓
Frontend (Web, mobile-first)
 ↓
Backend API (REST)
 ↓
Report Service
 ├── Text Analysis
 ├── Computer Vision
 ├── Duplicate Detection
 └── Priority Recommendation
 ↓
AI Result (disimpan + confidence + reasoning)
 ↓
Human Verification (Admin)
 ↓
Report Workflow (Assign → Progress → Resolve)
 ↓
Database (+ Object Storage)
```

### Komponen dan aliran data

1. **Frontend** mengirim form + foto ke Backend API (terautentikasi).
2. **Backend** memvalidasi, menyimpan foto ke storage, menulis `Report` status `Submitted`.
3. **Report Service** membuat job analisis (sinkron untuk prototype kecil; queue/background worker jika TBD diperlukan).
4. Empat modul AI dipanggil:
   - *Text Analysis* → kategori, urgensi, keyword.
   - *Computer Vision* → klasifikasi foto.
   - *Duplicate Detection* → kandidat laporan serupa (teks, lokasi, kategori, waktu, visual bila ada).
   - *Priority Recommendation* → skor prioritas + reasoning dari keluaran modul lain.
5. Hasil disimpan (`AIAnalysis`, `AIClassification`, `DuplicateCandidate`, `PriorityRecommendation`).
6. Status menjadi **Pending Verification**; admin melakukan review, koreksi, konfirmasi.
7. Koreksi disimpan sebagai label terverifikasi.
8. Workflow penugasan dan penyelesaian berjalan; notifikasi dikirim di tiap transisi.

Modul AI diakses melalui antarmuka internal yang stabil (`analyze_text`, `analyze_image`, `find_duplicates`, `recommend_priority`) sehingga implementasi dapat ditukar.

---

## 13. Database / Data Model

### Entity dan atribut utama

| Entity | Atribut inti |
| --- | --- |
| **Role** | id, name (user, admin, operator) |
| **User** | id, name, email, password_hash, role_id, is_active, created_at |
| **Category** | id, code, name, parent_id (subkategori), is_active, default_agency (nullable) |
| **Location** | id, report_id, latitude, longitude, address_text, region (kelurahan/kecamatan, TBD) |
| **Report** | id, user_id, title, description, category_id (final), event_time, additional_info, status, priority_final, priority_source (ai/admin), is_public, merged_into_id (nullable), created_at, updated_at |
| **ReportImage** | id, report_id, storage_key, mime_type, size_bytes, width, height, quality_flags, created_at |
| **AIAnalysis** | id, report_id, model_versions (json), started_at, finished_at, status (success/failed/partial), needs_manual_review, fused_confidence, error_message |
| **AIClassification** | id, analysis_id, source (vision/text/fusion), label, subtype, confidence, raw_output (json), admin_corrected_label (nullable), corrected_by, corrected_at, verified (bool) |
| **DuplicateCandidate** | id, report_id, candidate_report_id, similarity_score, signals (json: text, geo, time, category, visual), decision (pending/merged/kept_separate/ignored), decided_by, decided_at |
| **PriorityRecommendation** | id, report_id, recommended_level (low/medium/high/critical), score, reasoning (json), admin_final_level, decided_by, decided_at |
| **ReportStatusHistory** | id, report_id, from_status, to_status, changed_by, note, created_at |
| **Assignment** | id, report_id, assigned_by, operator_id (atau agency_id, TBD), due_date, accepted_at, created_at |
| **ResolutionEvidence** | id, report_id, assignment_id, uploaded_by, storage_key, note, created_at |
| **Notification** | id, user_id, report_id, type, message, is_read, created_at |
| **AuditLog** | id, actor_id, action, entity_type, entity_id, before (json), after (json), ip, created_at |

### Relationship

- Role 1—N User
- User 1—N Report
- Category 1—N Report; Category 1—N Category (subkategori)
- Report 1—N ReportImage
- Report 1—1 Location
- Report 1—N AIAnalysis (riwayat analisis ulang); AIAnalysis 1—N AIClassification
- Report 1—N DuplicateCandidate (kedua arah: report dan candidate_report)
- Report 1—N PriorityRecommendation (riwayat); satu berlaku saat ini
- Report 1—N ReportStatusHistory
- Report 1—N Assignment; Assignment 1—N ResolutionEvidence
- User 1—N Notification; Report 1—N Notification
- User 1—N AuditLog (sebagai actor)

Penambahan kategori baru cukup menambah baris di `Category`; daftar label model dipetakan melalui `Category.code`. Indeks geospasial pada `Location` (opsi: PostGIS atau indeks lat/lng biasa untuk prototype, TBD).

---

## 14. API Specification

Base path: `/api/v1`. Format JSON (kecuali upload). Auth: Bearer token/JWT atau session cookie (TBD). Error standar:

```json
{ "error": { "code": "VALIDATION_ERROR", "message": "…", "fields": {"title": "Minimal 5 karakter"} } }
```

Kode umum: `400` validasi, `401` tidak terautentikasi, `403` tidak berwenang, `404` tidak ditemukan, `409` konflik status, `413` file terlalu besar, `415` tipe file tidak didukung, `422` tidak dapat diproses, `429` rate limit, `500` error server, `503` layanan AI tidak tersedia.

### 14.1 Authentication

| Endpoint | Method | Auth | Request | Response | Error |
| --- | --- | --- | --- | --- | --- |
| `/auth/register` | POST | Publik | `{name,email,password}` | `201 {user}` | 400, 409 (email sudah dipakai) |
| `/auth/login` | POST | Publik | `{email,password}` | `200 {token,user}` | 401, 429 |
| `/auth/logout` | POST | Login | — | `204` | 401 |
| `/auth/me` | GET | Login | — | `200 {user}` | 401 |

### 14.2 Reports

| Endpoint | Method | Auth | Request | Response | Error |
| --- | --- | --- | --- | --- | --- |
| `/reports` | POST | User | `{title,description,category_id,event_time,additional_info,location{lat,lng,address},image_ids[]}` | `201 {report,status:"submitted"}` | 400, 401, 422 |
| `/reports/images` | POST | User | `multipart: file` | `201 {image_id,url,quality_flags}` | 413, 415, 422 |
| `/reports` | GET | Publik (terfilter) | query: `category,status,from,to,bbox,page,q` | `200 {items[],page,total}` (data pribadi disamarkan) | 400 |
| `/reports/{id}` | GET | Publik (publik) / pemilik / admin / operator penugasan | — | `200 {report,timeline,ai_result?}` | 403, 404 |
| `/reports/{id}` | PATCH | Pemilik (sebelum Verified) / Admin | field yang diubah | `200 {report}` | 400, 403, 409 |
| `/reports/mine` | GET | User | `page,status` | `200 {items[]}` | 401 |

### 14.3 AI Analysis & Duplicate

| Endpoint | Method | Auth | Request | Response | Error |
| --- | --- | --- | --- | --- | --- |
| `/ai/analyze` | POST | User | `{image_ids[],title,description,location}` (pra-submit) | `200 {category,subcategory,confidence,urgency,priority_recommendation,needs_manual_review,quality_flags}` | 422, 503 (fallback manual) |
| `/reports/{id}/analysis` | GET | Pemilik / Admin | — | `200 {analysis,classifications[],reasoning}` | 403, 404 |
| `/reports/{id}/analysis/rerun` | POST | Admin | — | `202 {analysis_id}` | 403, 503 |
| `/reports/{id}/analysis/correct` | POST | Admin | `{label,subtype?,reason?}` | `200 {classification}` | 400, 403 |
| `/reports/{id}/duplicates` | GET | Admin | — | `200 {candidates:[{report_id,similarity,signals}]}` | 403 |
| `/reports/{id}/duplicates/{candidate_id}/decision` | POST | Admin | \`{decision:"merge | keep | ignore"}\` |

### 14.4 Verifikasi, Assign, Status

| Endpoint | Method | Auth | Request | Response | Error |
| --- | --- | --- | --- | --- | --- |
| `/reports/{id}/verify` | POST | Admin | `{category_id,priority,note}` | `200 {report,status:"verified"}` | 403, 409 |
| `/reports/{id}/reject` | POST | Admin | `{reason}` | `200 {report}` | 400, 403 |
| `/reports/{id}/assign` | POST | Admin | `{operator_id,due_date?,note?}` | `200 {assignment}` | 403, 404, 409 |
| `/reports/{id}/status` | PATCH | Admin / Operator ditugaskan | `{status,note,evidence_ids[]?}` | `200 {report,history_entry}` | 400 (transisi tidak valid), 403, 409 |
| `/reports/{id}/evidence` | POST | Operator | `multipart: file, note` | `201 {evidence}` | 413, 415 |
| `/reports/{id}/feedback` | POST | Pemilik | `{rating,comment}` | `201` | 403, 409 |

Validasi transisi status dilakukan di backend menggunakan matriks transisi (bagian 11.3).

### 14.5 Dashboard, Peta, Notifikasi

| Endpoint | Method | Auth | Request | Response | Error |
| --- | --- | --- | --- | --- | --- |
| `/stats/public` | GET | Publik | `from,to,region?` | `200 {totals,by_category,trend,by_region,avg_resolution_hours}` | 400 |
| `/stats/admin` | GET | Admin | `from,to` | `200 {new,pending_verification,high_priority,duplicates,low_confidence,by_category,by_region,performance}` | 403 |
| `/map/reports` | GET | Publik | `bbox,category,status,from,to,zoom` | `200 GeoJSON/cluster` (koordinat publik dapat dibulatkan, TBD) | 400 |
| `/notifications` | GET | Login | `unread?,page` | `200 {items[]}` | 401 |
| `/notifications/{id}/read` | PATCH | Pemilik | — | `204` | 403, 404 |
| `/users` | GET/PATCH | Admin | kelola user/role | `200` | 403 |

---

## 15. UI/UX Requirements

### 15.1 Arah Desain

- Modern, bersih, *trustworthy*, civic-oriented. Bukan estetika "AI futuristik".
- Mobile-first, responsif, hierarki visual jelas, satu aksi utama per layar.
- Warna status konsisten (mis. Submitted abu, Verified biru, In Progress oranye, Resolved hijau, tetap disertai teks/ikon, tidak hanya warna). Palet final **TBD** oleh desainer.
- Hasil AI ditampilkan seperti "saran" — netral, dengan label jelas dan tombol ubah.
- Bahasa sederhana, hindari istilah teknis pada sisi masyarakat.

### 15.2 Daftar Halaman

**Public:** Landing Page · Explore Reports · Report Map · Public Dashboard · Report Detail **User:** Login/Register · User Dashboard · Create Report · AI Analysis Result · My Reports · Report Tracking · Notification **Admin:** Admin Dashboard · Report Management · Report Verification · AI Review · Duplicate Review · Assignment · Statistics · Map · User Management

### 15.3 Spesifikasi halaman penting

| Halaman | Isi wajib | Catatan |
| --- | --- | --- |
| Landing | Value proposition, CTA "Buat Laporan", statistik ringkas, peta mini, cara kerja 4 langkah | Disclaimer prototype |
| Create Report | Stepper: Foto → Deskripsi → Lokasi → Review AI → Kirim | Kamera langsung, GPS auto, pin peta |
| AI Analysis Result | Kategori saran, tingkat keyakinan, peringatan jika rendah, tombol ubah kategori | Pesan fallback sesuai bagian 9.4 |
| Report Tracking | Timeline status vertikal, foto, catatan update, bukti penyelesaian | Notifikasi terkait |
| Public Dashboard | KPI, grafik kategori, tren, top wilayah, rata-rata waktu penyelesaian | Tanpa data pribadi |
| Report Map | Marker per kategori/status, cluster, filter, popup ringkas |  |
| Admin Dashboard | Antrean prioritas, butuh verifikasi, duplikat, confidence rendah, performa | Hanya informasi yang dapat ditindaklanjuti |

---

## 16. Admin Requirements

| ID | Requirement |
| --- | --- |
| ADM-01 | Dashboard menampilkan: laporan baru, butuh verifikasi, prioritas tinggi, kandidat duplikat, per kategori, per wilayah, performa penyelesaian, rekomendasi AI, confidence, butuh review manual. |
| ADM-02 | Halaman AI Review menampilkan foto, teks, prediksi CV, prediksi teks, hasil fusi, reasoning, dan tombol koreksi. |
| ADM-03 | Halaman Duplicate Review: tampilan berdampingan laporan baru vs kandidat, skor, sinyal pendukung, tiga aksi (gabungkan, tetap laporan baru, abaikan). |
| ADM-04 | Aksi gabung: laporan sekunder menjadi `merged_into_id`, pelapor sekunder tetap menerima update, jumlah pelapor menambah bobot prioritas. |
| ADM-05 | Prioritas: tampilkan rekomendasi AI, admin dapat mengubah; perubahan dicatat di `AuditLog` beserta alasan. |
| ADM-06 | Assign ke operator dengan tenggat opsional. |
| ADM-07 | Manajemen user: lihat, aktif/nonaktif, ubah role \[MVP minimal\]. |
| ADM-08 | Manajemen kategori (tambah/nonaktifkan) \[ENH\]. |
| ADM-09 | Ekspor data laporan CSV \[ENH\]. |

### Prioritas AI dan Reasoning

Faktor: kategori, urgensi teks, hasil foto, lokasi (mis. dekat sekolah/fasilitas penting, jalan utama), jumlah laporan serupa, jumlah terdampak (jika ada), umur laporan belum ditangani.

Contoh: `AI Recommended Priority: HIGH`.

Reasoning yang ditampilkan (contoh):

```
Prioritas: TINGGI (skor 0,82)
+ Kategori jalan rusak (bobot dasar sedang)
+ Teks menyebut "membahayakan pengendara" (urgensi tinggi)
+ Lokasi dalam radius 100 m dari sekolah
+ 3 laporan serupa dalam 7 hari
+ Belum ditangani 5 hari
```

Bobot dan radius adalah parameter konfigurasi **(nilai TBD)**; awalnya scoring berbasis aturan agar dapat dijelaskan.

### Human-in-the-loop

1. AI: **Prediction → Confidence → Recommendation**
2. Manusia: **Review → Correction → Confirmation**
3. Koreksi disimpan (`verified = true`) dengan label asli AI dan label manusia.
4. Data terverifikasi dapat dipakai untuk evaluasi dan fine-tuning berikutnya (kebijakan persetujuan penggunaan data **TBD**).

---

## 17. Security & Privacy

| Area | Requirement |
| --- | --- |
| Autentikasi | Register/login, password di-hash (bcrypt/argon2), rate limit login, token kedaluwarsa |
| Otorisasi | RBAC: user, operator, admin; cek kepemilikan resource di backend (bukan hanya frontend) |
| Upload file | Whitelist MIME (JPEG/PNG/WebP), cek magic bytes, batas ukuran, nama file di-acak, simpan di luar web root/object storage, re-encode gambar untuk menghilangkan payload tersembunyi, hapus EXIF sensitif |
| Sanitasi input | Sanitasi/escape semua teks, query terparameterisasi (anti SQL injection), proteksi XSS, CSRF (jika cookie) |
| Data pribadi | Minimalkan data yang dikumpulkan; tampilan publik tanpa nama/email; koordinat publik dapat dibulatkan (TBD) |
| Kontrol akses laporan | Laporan publik vs privat (opsional pelapor, TBD); detail AI internal hanya admin/pemilik |
| Audit log | Catat verifikasi, koreksi AI, perubahan prioritas/status, assign, aksi user management |
| Endpoint API | HTTPS, rate limiting, validasi schema, CORS terbatas, pesan error tidak membocorkan detail internal |
| Kebijakan | Halaman kebijakan privasi sederhana dan persetujuan pengguna. Tidak ada klaim kepatuhan hukum tertentu di prototype; kajian kepatuhan (mis. regulasi perlindungan data pribadi) adalah **\[FUT\]** dan perlu ditinjau ahli hukum |

---

## 18. Edge Cases

| Kasus | Penanganan |
| --- | --- |
| Foto blur | Deteksi (mis. variance of Laplacian); beri peringatan "Foto kurang jelas, ambil ulang?"; tetap boleh kirim, ditandai review manual |
| Foto terlalu gelap | Cek brightness; saran ulang foto; ditandai |
| Foto tidak relevan | Prediksi "Lainnya"/confidence rendah → review manual; admin dapat tolak dengan alasan |
| Foto tanpa objek dikenali | Kategori "Lainnya / Tidak Teridentifikasi" + pesan fallback |
| Multiple objects | Tampilkan top-k prediksi; pilih dominan; admin/user dapat memilih kategori lain; multi-label \[FUT\] |
| Kategori tidak tersedia | Gunakan "Lainnya"; admin dapat mengusulkan kategori baru |
| Confidence rendah | Ikuti bagian 9.3/9.4 |
| Laporan duplikat | Kandidat ditandai; admin memutuskan; user diberi tahu "mungkin sudah ada laporan serupa" sebelum submit \[ENH\] |
| Lokasi tidak tersedia | Izin GPS ditolak → user wajib tandai di peta atau cari alamat; tanpa lokasi laporan tidak dapat dikirim (MVP) |
| Foto palsu/tidak relevan | Deteksi dasar (hash duplikat foto yang sama oleh user berbeda, metadata tidak konsisten \[ENH\]); laporan flagged; admin menolak; pelanggaran berulang dapat dinonaktifkan |
| File berbahaya | Validasi magic bytes, re-encode, tolak tipe tidak dikenal (415), batas ukuran (413); opsional antivirus scan \[FUT\] |
| AI gagal memproses gambar | Analisis berstatus `failed`; laporan tetap tersimpan; `needs_manual_review = true`; opsi rerun oleh admin |
| API/model AI tidak tersedia | Timeout + retry terbatas; fallback ke scoring rule-based/manual; banner "Analisis AI sementara tidak tersedia"; laporan masuk antrean |
| Koneksi buruk saat upload | Retry upload, kompres di klien, draft lokal \[ENH\] |

---

## 19. MVP Scope

### MVP (wajib demo)

- Register/login, tiga role
- Create Report (foto, deskripsi, lokasi, kategori) dengan validasi
- Upload foto aman
- AI Computer Vision: klasifikasi 6 kategori + confidence + fallback "Lainnya"
- AI teks: kategori, urgensi, keyword (boleh berbasis rule/embedding sederhana)
- Rekomendasi prioritas berbasis skor yang dapat dijelaskan
- Deteksi duplikat dasar (teks + lokasi + kategori + waktu)
- Verifikasi admin + koreksi AI + ubah prioritas
- Assign ke operator, update status, upload bukti
- Lifecycle status + timeline + notifikasi dalam aplikasi
- Peta laporan dengan filter dasar dan cluster
- Dashboard publik dan dashboard admin ringkas
- Audit log dasar

### Enhancement (jika waktu ada)

- Kemiripan visual untuk duplikat
- Fusi multimodal yang lebih canggih (model terlatih)
- Feedback/rating pelapor
- Permintaan informasi tambahan ke pelapor
- Manajemen kategori dari UI
- Ekspor CSV, heatmap
- Draft offline, PWA
- Tampilan analisis kualitas foto lanjutan

### Future Development

- Integrasi kanal resmi/dinas nyata, SLA, eskalasi otomatis
- Notifikasi email/WhatsApp/push
- Multi-bahasa, multi-wilayah
- Pelatihan ulang model otomatis (MLOps), active learning
- Multi-label dan segmentasi objek
- Verifikasi anti-fraud lanjutan, reputasi pelapor
- Kajian kepatuhan hukum dan kebijakan data
- Aplikasi mobile native

---

## 20. Future Scope

Lihat bagian "Future Development" pada 19. Prioritas yang direkomendasikan jika produk dilanjutkan: (1) integrasi instansi nyata, (2) MLOps dan dataset terkurasi, (3) notifikasi multi-kanal, (4) tata kelola data dan kepatuhan.

---

## 21. Technology Recommendation

Stack tidak dikunci; berikut rekomendasi realistis untuk tim kompetisi. Final **TBD** sesuai keahlian tim.

| Layer | Rekomendasi | Alasan singkat | Alternatif |
| --- | --- | --- | --- |
| Frontend | Next.js/React + Tailwind CSS | Cepat, komponen siap, SSR untuk halaman publik | Vue/Nuxt, SvelteKit |
| Backend | Node.js (NestJS/Express) atau Python (FastAPI) | FastAPI memudahkan integrasi ML; Node menyatukan bahasa dengan frontend | Laravel, Django |
| Database | PostgreSQL (+ PostGIS jika memungkinkan) | Relasional, dukungan geospasial | MySQL, MongoDB |
| Storage | Object storage (S3-compatible, Supabase Storage, Cloudinary) | Penyimpanan foto terpisah dari server | Disk lokal (hanya dev) |
| Authentication | JWT/session + bcrypt, atau Auth provider (Supabase Auth/Auth.js) | Cepat dan aman jika memakai library matang | Keycloak (berlebihan untuk MVP) |
| AI/ML | Python service (PyTorch/TensorFlow atau ONNX runtime) | Ekosistem ML | Layanan inferensi terkelola |
| Computer Vision | Pretrained backbone (mis. MobileNet/EfficientNet/ResNet/ViT kecil) + fine-tuning | Ringan, cukup untuk 6 kelas | Vision API/multimodal LLM |
| Text/Embedding | Sentence embedding multilingual (termasuk Indonesia) | Kemiripan teks dan klasifikasi | TF-IDF sebagai baseline |
| Maps | Leaflet + OpenStreetMap (gratis) | Tanpa biaya, cukup untuk cluster | Mapbox, Google Maps |
| Deployment | Vercel/Netlify (frontend), Railway/Render/VPS (backend), Docker untuk AI service | Mudah untuk demo | Cloud provider lain |
| Monitoring | Logging terstruktur + Sentry/Grafana (opsional) | Deteksi error saat demo | Log sederhana |

---

## 22. AI Model Strategy

### Perbandingan pendekatan

| # | Pendekatan | Kelebihan | Kekurangan | Kebutuhan data | Kesesuaian prototype |
| --- | --- | --- | --- | --- | --- |
| 1 | Pretrained vision model + fine-tuning penuh/sebagian | Akurasi lebih baik pada domain spesifik | Butuh dataset berlabel dan waktu/GPU | Sedang (jumlah **TBD**) | Baik jika dataset tersedia |
| 2 | Pretrained vision model (frozen) + classification head | Cepat dilatih, butuh data lebih sedikit, stabil | Akurasi di bawah fine-tuning penuh | Lebih kecil dari #1 | **Sangat baik** |
| 3 | Vision API / model inference siap pakai (zero-shot/few-shot) | Tanpa pelatihan, cepat | Biaya, latensi, ketergantungan eksternal, label sulit dikontrol | Hampir nol | Baik untuk baseline dan fallback |
| 4 | Text embedding untuk similarity | Ringan, efektif untuk duplikat teks | Perlu model yang mendukung Bahasa Indonesia | Tanpa label | **Sangat baik** untuk duplikat |
| 5 | Rule-based scoring | Transparan, tanpa data, cepat | Tidak adaptif | Tidak ada | **Wajib** sebagai fallback dan untuk prioritas awal |

### Rekomendasi (waktu terbatas)

1. **Computer Vision:** mulai dengan **#3 sebagai baseline** (validasi alur cepat), lalu **#2 (pretrained + classification head)**; lanjut **#1 (fine-tuning sebagian)** bila data cukup. Ini mencapai model yang "di-fine-tune dengan dataset TobaCare" tanpa membuat jaringan dari nol.
2. **Duplikat:** **#4 (embedding teks)** + kemiripan geospasial (jarak) + kategori + selisih waktu; kemiripan visual (embedding gambar) sebagai \[ENH\].
3. **Prioritas:** **#5 rule-based** berbobot dan dapat dijelaskan; model pembelajaran \[FUT\].
4. **Fallback:** jika AI tidak tersedia, alur manual tetap berjalan.

### Dataset

- Sumber dan jumlah dataset **belum ditentukan (TBD)**; dokumen ini tidak mengarang angka final.
- Opsi sumber: dataset publik relevan (lisensi perlu dicek), foto dikumpulkan tim sendiri, foto dari laporan terverifikasi (butuh persetujuan), augmentasi data.
- Pelabelan: skema label mengikuti `Category`; label manusia dari koreksi admin disimpan sebagai data terverifikasi.
- Pembagian train/validation/test **TBD**; set uji tidak boleh dipakai untuk pelatihan.

---

## 23. Evaluation Metrics

### Computer Vision

Accuracy, precision, recall, F1-score per kelas dan macro, confusion matrix (terutama kebingungan antar kelas dan ke "Lainnya"). Dievaluasi pada test set terpisah.

### Duplicate Detection

Similarity threshold (ditentukan dari evaluasi, **TBD**); precision/recall jika ada set evaluasi berlabel pasangan duplikat.

### Sistem Keseluruhan

- Waktu pemrosesan laporan (upload → hasil AI)
- Persentase laporan berhasil diklasifikasikan
- Persentase laporan yang membutuhkan review manual
- Persentase koreksi admin terhadap prediksi AI (indikator kualitas nyata)
- Waktu verifikasi admin, waktu penyelesaian rata-rata

### Catatan penting: confidence ≠ accuracy

Confidence adalah keluaran model untuk satu prediksi, bukan jaminan kebenaran. Model dapat *overconfident*. Accuracy diukur pada data uji. Sebelum ambang confidence dipakai untuk keputusan (mis. auto-pilih kategori), lakukan evaluasi kalibrasi (mis. reliability diagram) pada data uji.

---

## 24. Testing Strategy

| Jenis | Cakupan |
| --- | --- |
| Unit test | Validasi field, matriks transisi status, scoring prioritas, fungsi similarity |
| Integration test | Alur create report → analisis → verifikasi → assign → resolve; upload dan storage |
| API test | Seluruh endpoint: sukses, validasi, 401/403, batas file |
| Security test | Upload file berbahaya, akses lintas role, XSS/SQLi dasar, rate limit |
| AI test | Evaluasi offline (bagian 23), uji set foto edge case (blur, gelap, tak relevan), uji fallback saat model mati |
| UAT | Skenario demo dengan 3–5 penguji (masyarakat, admin) pada perangkat mobile nyata |
| Non-fungsional | Waktu muat, responsif berbagai layar, uji beban ringan |
| Regression | Sebelum demo: jalankan checklist Success Criteria |

---

## 25. Competition Demo Scenario

Durasi target: **5–7 menit**. Data seed disiapkan (beberapa laporan selesai, satu laporan serupa untuk duplikat, akun user/admin/operator).

| # | Langkah | Yang ditunjukkan | Waktu |
| --- | --- | --- | --- |
| 1 | Pembukaan: masalah + posisi prototype | Landing page, statistik publik | 0:30 |
| 2 | User login, buka Create Report | Mobile view | 0:20 |
| 3 | Ambil/unggah foto jalan berlubang | Validasi upload | 0:20 |
| 4 | Tulis deskripsi ("Jalan di depan sekolah berlubang…") | Form | 0:20 |
| 5 | Computer Vision: Jalan Rusak, 91% | Kartu hasil AI | 0:30 |
| 6 | AI teks + lokasi dekat sekolah | Urgensi, keyword | 0:20 |
| 7 | Kemungkinan laporan serupa 89% | Peringatan duplikat | 0:30 |
| 8 | Rekomendasi prioritas TINGGI + reasoning | Transparansi | 0:30 |
| 9 | User kirim laporan | Notifikasi "berhasil dikirim" | 0:15 |
| 10 | Pindah ke admin: laporan di antrean | Dashboard admin | 0:20 |
| 11 | Admin review AI, koreksi/konfirmasi | Human-in-the-loop | 0:40 |
| 12 | Admin gabung/putuskan duplikat, verifikasi, assign | Workflow | 0:40 |
| 13 | Operator ubah status In Progress | Update | 0:20 |
| 14 | Operator unggah bukti penyelesaian, Resolved | Bukti | 0:30 |
| 15 | User lihat timeline berubah Resolved | Tracking + notifikasi | 0:20 |
| 16 | Dashboard publik dan peta ter-update | Statistik | 0:30 |

Rencana cadangan: siapkan data dan hasil AI ter-cache jika internet/model bermasalah; video rekaman singkat sebagai cadangan.

---

## 26. Success Criteria

| ID | Acceptance Criteria |
| --- | --- |
| SC-01 | User dapat membuat laporan dengan foto, deskripsi, lokasi; field wajib divalidasi. |
| SC-02 | Foto valid berhasil diproses AI; hasil ditampilkan sebelum submit. |
| SC-03 | AI menghasilkan kategori dan confidence untuk foto yang didukung. |
| SC-04 | Confidence di bawah ambang → kategori "Lainnya/Tidak Teridentifikasi", pesan fallback tampil, laporan masuk review manual. |
| SC-05 | Admin dapat mengoreksi kategori dan prioritas AI; koreksi tersimpan dengan label asli. |
| SC-06 | Hasil analisis (CV, teks, prioritas, duplikat) tersimpan di database. |
| SC-07 | Kandidat duplikat tampil dengan skor; admin dapat menggabungkan, mempertahankan, atau mengabaikan. |
| SC-08 | Prioritas rekomendasi tampil dengan alasan yang dapat dibaca. |
| SC-09 | User dapat melihat status dan timeline laporan sendiri. |
| SC-10 | Admin dapat verifikasi, assign, dan mengubah status; transisi tidak valid ditolak (409/400). |
| SC-11 | Operator hanya melihat laporan yang ditugaskan dan dapat mengunggah bukti. |
| SC-12 | Dashboard publik dan admin menampilkan data agregat yang benar tanpa data pribadi. |
| SC-13 | Peta menampilkan laporan dengan filter kategori/status/periode dan cluster. |
| SC-14 | Notifikasi dalam aplikasi muncul pada perubahan status. |
| SC-15 | Upload file non-gambar atau melebihi batas ditolak. |
| SC-16 | Saat layanan AI dimatikan, laporan tetap dapat dibuat dan diproses manual. |
| SC-17 | Akses lintas role tanpa izin ditolak (403). |
| SC-18 | Seluruh perubahan penting tercatat di audit log. |
| SC-19 | Aplikasi dapat digunakan pada layar ≥ 360 px tanpa scroll horizontal. |
| SC-20 | Skenario demo (bagian 25) dapat dijalankan end-to-end tanpa kesalahan. |

---

## 27. Risks & Mitigation

| # | Risiko | Dampak | Mitigasi |
| --- | --- | --- | --- |
| R1 | Dataset foto tidak cukup/tidak seimbang | Akurasi rendah | Mulai dengan pretrained + classification head, augmentasi, baseline vision API, kelas "Lainnya" |
| R2 | Model salah dengan confidence tinggi | Keputusan keliru | Human-in-the-loop, kalibrasi, label "rekomendasi", review sampel |
| R3 | Waktu pengembangan terbatas | MVP tidak selesai | Scope MVP ketat, stack yang dikuasai tim, prioritaskan alur end-to-end |
| R4 | Layanan AI/API eksternal gagal saat demo | Demo gagal | Fallback rule-based, hasil ter-cache, video cadangan |
| R5 | Upload berbahaya/penyalahgunaan | Keamanan | Validasi ketat, re-encode, rate limit, audit log |
| R6 | Privasi pelapor terekspos | Kepercayaan | Penyamaran data publik, minimalisasi data, kontrol akses |
| R7 | Laporan palsu/spam | Beban admin | Flagging, batas pelaporan per user, reputasi \[FUT\] |
| R8 | Dianggap mengklaim sebagai sistem resmi | Reputasi/etika | Disclaimer prototype jelas di UI dan presentasi |
| R9 | Duplikat salah digabung | Laporan hilang | Merge hanya oleh admin, dapat dibatalkan (undo) \[ENH\], pelapor tetap dinotifikasi |
| R10 | Performa inferensi lambat | UX buruk | Model ringan, resize gambar, proses asinkron dan indikator progres |
| R11 | Bias wilayah/kondisi foto (malam, hujan) | Akurasi tidak merata | Variasi data, evaluasi per kondisi, flag kualitas foto |
| R12 | Lisensi dataset publik | Hukum | Periksa lisensi, dokumentasikan sumber |
| R13 | Ruang lingkup terlalu luas | Kualitas turun | Pisahkan MVP/Enhancement/Future, freeze fitur sebelum demo |

---

## Lampiran A — Positioning untuk Kompetisi

TobaCare diposisikan sebagai **aplikasi web fungsional dengan AI yang memiliki fungsi nyata** pada masalah dunia nyata:

| Aspek | Bukti pada produk |
| --- | --- |
| Real-world problem | Pelaporan permasalahan lingkungan yang tersebar, tidak terstruktur, tanpa kejelasan progres |
| Functional web app | Alur end-to-end: lapor → verifikasi → tugaskan → selesaikan → pantau |
| AI dengan fungsi nyata | CV untuk klasifikasi foto, teks untuk analisis, duplikat, prioritas dengan alasan |
| Human-in-the-loop | Admin mengoreksi; koreksi menjadi data terverifikasi |
| Transparansi | Timeline status, reasoning AI, dashboard publik |
| Data visualization | Peta cluster, dashboard publik dan admin |
| Responsive UX | Mobile-first, alur pendek |
| Scalability | Kategori dinamis, modul AI terpisah, indeks geospasial |

Penting: TobaCare **bukan** solusi resmi pemerintah; selalu nyatakan sebagai prototype/konsep teknologi.

## Lampiran B — Daftar Keputusan TBD

| # | Keputusan | Opsi |
| --- | --- | --- |
| 1 | Wilayah layanan prototype | Satu kabupaten/kota, satu kecamatan, simulasi |
| 2 | Ambang confidence (T_low, T_high) | Ditentukan dari evaluasi set uji |
| 3 | Dataset (sumber, jumlah) | Publik, kumpulan sendiri, kombinasi |
| 4 | Model CV | Pretrained + head, fine-tuning sebagian, vision API |
| 5 | Model embedding teks | Multilingual sentence embedding, TF-IDF baseline |
| 6 | Mekanisme autentikasi | JWT, session, auth provider |
| 7 | Antrean proses AI | Sinkron, background job/queue |
| 8 | Penugasan | Ke operator individu atau ke instansi |
| 9 | Laporan privat (anonim) | Didukung atau publik-saja |
| 10 | Pembulatan koordinat publik | Ya/tidak, presisi |
| 11 | Batas ukuran dan jumlah foto | 3 foto dan 5 MB (usulan awal) |
| 12 | Auto-close setelah Resolved | Ya (N hari) atau manual |
| 13 | Daftar instansi terkait | Sesuai wilayah |
| 14 | Hosting dan stack final | Sesuai keahlian tim |