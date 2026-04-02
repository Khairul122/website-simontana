# SIMONTANA Frontend (PHP MVC)

Frontend web untuk **SIMONTANA (Sistem Informasi Monitoring Tanggap Bencana)**.

Project ini berfungsi sebagai aplikasi antarmuka (dashboard dan operasional) yang mengonsumsi backend API SIMONTANA (`/api/v1`) untuk kebutuhan:

- autentikasi dan otorisasi berbasis role,
- manajemen laporan bencana end-to-end,
- monitoring, tindak lanjut, dan riwayat tindakan,
- manajemen wilayah dan kategori bencana,
- integrasi data BMKG (gempa, cuaca, peringatan dini).

---

## Daftar Isi

- [1. Ringkasan Project](#1-ringkasan-project)
- [2. Fitur Utama](#2-fitur-utama)
- [3. Stack Teknologi](#3-stack-teknologi)
- [4. Prasyarat Sistem](#4-prasyarat-sistem)
- [5. Instalasi dan Menjalankan Project](#5-instalasi-dan-menjalankan-project)
- [6. Konfigurasi API Backend](#6-konfigurasi-api-backend)
- [7. Cara Akses Aplikasi](#7-cara-akses-aplikasi)
- [8. Arsitektur Aplikasi](#8-arsitektur-aplikasi)
- [9. Struktur Folder](#9-struktur-folder)
- [10. Dokumentasi Role dan Alur Bisnis](#10-dokumentasi-role-dan-alur-bisnis)
- [11. Daftar Modul](#11-daftar-modul)
- [12. Integrasi API dan Kontrak Response](#12-integrasi-api-dan-kontrak-response)
- [13. Referensi Endpoint API](#13-referensi-endpoint-api)
- [14. Troubleshooting](#14-troubleshooting)
- [15. Panduan Pengembangan](#15-panduan-pengembangan)
- [16. Security Notes](#16-security-notes)
- [17. Deployment Notes](#17-deployment-notes)
- [18. FAQ](#18-faq)

---

## 1. Ringkasan Project

SIMONTANA Frontend dibangun dengan arsitektur **PHP MVC tanpa framework full-stack** (custom front-controller), lalu mengonsumsi API backend berbasis JSON.

Karakteristik utamanya:

- Front controller tunggal di `index.php`.
- Routing berbasis query string: `?controller=NamaController&action=namaAction`.
- Session-based auth state (`token` + `user`) yang disimpan di `$_SESSION`.
- Layer pemisahan concern:
  - `controllers/` untuk orkestrasi request,
  - `services/` untuk komunikasi API,
  - `views/` untuk rendering UI,
  - `template/` untuk layout shared.

---

## 2. Fitur Utama

### Autentikasi

- Login.
- Register publik (dibatasi role `Warga`).
- Logout.
- Role-aware redirect ke dashboard sesuai role.

### Dashboard berbasis Role

- `Admin`: statistik global, laporan terbaru, chart, ringkasan BMKG.
- `PetugasBPBD`: panel operasional lapangan, verifikasi/proses laporan.
- `OperatorDesa`: panel statistik desa, status laporan warga desa.
- `Warga`: ringkasan informasi publik + status laporan.

### Modul Operasional

- Laporan bencana (`laporan-admin`, `laporan-petugas`, `laporan-operator`).
- Monitoring.
- Tindak Lanjut.
- Riwayat Tindakan.

### Master Data

- Manajemen user.
- Kategori bencana.
- Hierarki wilayah (provinsi, kabupaten, kecamatan, desa).

### Integrasi BMKG

- Gempa terbaru.
- Gempa terkini.
- Gempa dirasakan.
- Peringatan dini cuaca.
- Prakiraan cuaca berdasarkan wilayah.
- Cache status/clear untuk role tertentu.

---

## 3. Stack Teknologi

### Backend-facing UI Layer

- PHP (native/custom MVC).
- cURL untuk komunikasi HTTP ke API backend.

### Frontend UI

- Tailwind CSS (via CDN).
- Chart.js (visualisasi chart).
- SweetAlert2 (dialog dan toast).
- Font Awesome (icon set).
- Google Fonts.

### Dependency Manager

- Composer.

### Library Composer yang digunakan

- `tecnickcom/tcpdf`
- `phpoffice/phpspreadsheet`

> Catatan: kedua library ini tersedia sebagai dependency project. Pemakaian fitur spesifiknya bergantung implementasi modul yang memanfaatkannya.

---

## 4. Prasyarat Sistem

Minimal environment yang disarankan:

- PHP `>= 8.0` (disarankan 8.1+).
- Composer terbaru.
- Web server lokal (Laragon/Apache/Nginx).
- Ekstensi PHP umum:
  - `curl`
  - `json`
  - `mbstring`
  - `session` (default)
  - `openssl`
- Backend API SIMONTANA sudah berjalan dan bisa diakses.

### Environment yang digunakan saat pengembangan project ini

- Platform: Windows (Laragon)
- Workspace: `C:\laragon\www\website-simontana`

---

## 5. Instalasi dan Menjalankan Project

## 5.1 Clone repository

```bash
git clone <url-repository-anda> website-simontana
cd website-simontana
```

## 5.2 Install dependency Composer

```bash
composer install
```

## 5.3 Pastikan backend API sudah running

Default base API di project ini mengarah ke:

- `http://localhost:8000/api/v1`

Jika backend Anda berjalan di host/port berbeda, ubah konfigurasi di `config/api.php`.

## 5.4 Jalankan melalui web server

### Opsi A: Laragon (direkomendasikan di Windows)

1. Taruh project di folder `www` Laragon.
2. Start Apache/Nginx melalui Laragon.
3. Akses project melalui browser.

### Opsi B: PHP built-in server (opsional untuk testing cepat)

```bash
php -S 127.0.0.1:8080
```

Lalu akses:

- `http://127.0.0.1:8080/index.php?controller=Auth&action=login`

---

## 6. Konfigurasi API Backend

Konfigurasi ada di:

- `config/api.php`

Default saat ini:

```php
define('API_DOMAIN_PREFIX', 'http://localhost:8000');
define('API_BASE_URL', rtrim(API_DOMAIN_PREFIX, '/') . '/api/v1');
```

Jika backend dipindah ke staging/production, update `API_DOMAIN_PREFIX` sesuai environment.

---

## 7. Cara Akses Aplikasi

Entry point utama:

- `index.php`

Route format:

```text
index.php?controller=<Controller>&action=<action>
```

Contoh:

- Login: `index.php?controller=Auth&action=login`
- Dashboard Admin: `index.php?controller=Dashboard&action=admin`
- Dashboard Warga: `index.php?controller=Dashboard&action=warga`
- BMKG: `index.php?controller=Bmkg&action=index`

---

## 8. Arsitektur Aplikasi

## 8.1 Front Controller

`index.php` bertugas untuk:

- `session_start()`.
- set timezone (`Asia/Jakarta`).
- validasi parameter `controller` dan `action`.
- include file controller sesuai nama.
- instantiate class controller.
- invoke method action.

## 8.2 Alur Request

1. Browser akses URL dengan query controller/action.
2. `index.php` resolve controller class.
3. Controller melakukan validasi session/role.
4. Controller memanggil service (`services/*`) untuk request API.
5. Service memanggil helper `apiRequest()` di `config/koneksi.php`.
6. Response dinormalisasi dan dikirim balik ke controller.
7. Controller menyiapkan data view.
8. View dirender dengan template global.

## 8.3 Session dan Auth

Data auth yang umumnya disimpan di session:

- `$_SESSION['token']`
- `$_SESSION['user']`
- `$_SESSION['toast']`
- `$_SESSION['dialog']`

---

## 9. Struktur Folder

```text
website-simontana/
|- index.php
|- composer.json
|- config/
|  |- api.php
|  |- globals.php
|  |- koneksi.php
|- controllers/
|- services/
|- views/
|- template/
|- assets/
|- fetch/
|  |- FETCH.md
|  |- FETCH_PUBLIC.md
|  |- FETCH_WARGA.md
|  |- FETCH_OPERATOR_DESA.md
|  |- FETCH_PETUGAS_BPBD.md
|  |- FETCH_ADMIN.md
```

Penjelasan singkat:

- `controllers/`: endpoint UI per modul.
- `services/`: adapter ke backend API.
- `views/`: halaman/fitur berdasarkan modul.
- `template/`: layout shell (header, navbar, sidebar, script).
- `config/`: konstanta endpoint + helper API + helper global.
- `fetch/`: dokumentasi endpoint API per role.

---

## 10. Dokumentasi Role dan Alur Bisnis

## 10.1 Admin

Kewenangan:

- akses dashboard admin,
- manajemen user,
- manajemen kategori,
- manajemen wilayah,
- akses laporan global,
- operasional monitoring/tindak lanjut/riwayat,
- akses endpoint BMKG protected (cache management).

## 10.2 PetugasBPBD

Kewenangan:

- akses dashboard petugas,
- lihat dan proses laporan,
- update transisi status tertentu,
- akses modul operasional terkait penanganan.

## 10.3 OperatorDesa

Kewenangan:

- akses dashboard operator,
- melihat laporan sesuai desa (`id_desa`),
- verifikasi/ubah status sesuai policy backend.

## 10.4 Warga

Kewenangan:

- registrasi akun publik,
- melihat dashboard warga,
- membuat dan memantau laporan,
- konsumsi informasi BMKG publik.

---

## 11. Daftar Modul

Modul utama pada `controllers/`:

- `AuthController`
- `DashboardController`
- `BmkgController`
- `LaporanAdminController`
- `LaporanPetugasController`
- `LaporanOperatorController`
- `MonitoringController`
- `TindakLanjutController`
- `RiwayatTindakanController`
- `KategoriBencanaController`
- `WilayahController`
- `UserController`
- `ProfileController`

Setiap modul memiliki pasangan service + view terkait.

---

## 12. Integrasi API dan Kontrak Response

Helper API utama ada di `config/koneksi.php`:

- `apiRequest(string $url, string $method, $data, array $headers)`
- `normalizeApiResponse(array $payload, int $httpCode)`
- `getAuthHeaders(?string $token)`
- helper data extractor (`apiDataList`, `apiDataEntity`)

### Header standar

- `Accept: application/json`
- `Authorization: Bearer <token>` untuk endpoint protected.

### Pola response sukses

```json
{
  "success": true,
  "message": "...",
  "data": {},
  "meta": {},
  "request_id": "..."
}
```

### Pola response error

```json
{
  "success": false,
  "message": "...",
  "code": "...",
  "errors": {},
  "details": {},
  "request_id": "..."
}
```

---

## 13. Referensi Endpoint API

Dokumentasi endpoint lengkap disediakan di folder `fetch/`:

- `fetch/FETCH.md` (master)
- `fetch/FETCH_PUBLIC.md`
- `fetch/FETCH_WARGA.md`
- `fetch/FETCH_OPERATOR_DESA.md`
- `fetch/FETCH_PETUGAS_BPBD.md`
- `fetch/FETCH_ADMIN.md`
- `fetch/FETCH_BMKG.md`

Ringkasan domain endpoint:

- Auth: `/auth/*`, `/check-token`
- Users: `/users*`
- Laporan: `/laporans*`
- Monitoring: `/monitoring*`
- Tindak Lanjut: `/tindak-lanjut*`
- Riwayat Tindakan: `/riwayat-tindakan*`
- Kategori Bencana: `/kategori-bencana*`
- Wilayah: `/wilayah*`
- BMKG: `/bmkg*`

---

## 14. Troubleshooting

## 14.1 Tidak bisa login / selalu kembali ke login

Checklist:

- backend API sedang berjalan,
- `API_DOMAIN_PREFIX` benar,
- token valid dari backend,
- session PHP aktif.

## 14.2 Error 401

- token tidak ada/expired/invalid,
- header `Authorization` tidak terkirim,
- role tidak sesuai policy endpoint.

## 14.3 Error 403

- akses role dibatasi oleh policy backend.

## 14.4 Error 404 pada API

- endpoint atau ID resource tidak ditemukan,
- pastikan path API versi `v1` digunakan.

## 14.5 Error 422

- payload tidak sesuai validasi,
- field wajib belum diisi,
- enum status/role/tingkat keparahan tidak valid.

## 14.6 Data BMKG tidak tampil

- cek konektivitas API BMKG dari backend,
- cek endpoint BMKG public/protected,
- cek cache status melalui modul cache (untuk role yang berhak).

---

## 15. Panduan Pengembangan

## 15.1 Menambah modul baru

Langkah umum:

1. Tambah service baru di `services/` untuk komunikasi API.
2. Tambah controller baru di `controllers/`.
3. Tambah view di `views/<modul>/`.
4. Tambahkan menu di `template/sidebar.php` sesuai role.
5. Uji route via `index.php?controller=...&action=...`.

## 15.2 Konvensi coding yang dipakai di project ini

- Controller fokus orchestration.
- Service fokus integration API.
- View fokus rendering.
- Flash message menggunakan `setToast()` atau `setDialog()`.
- Response API diproses melalui helper `apiDataList/apiDataEntity`.

## 15.3 Testing manual minimum sebelum merge

- Login/logout untuk semua role.
- Dashboard setiap role terbuka tanpa error.
- CRUD/flow pada modul yang diubah.
- Responsif mobile untuk halaman yang diubah.
- Validasi error state (empty state, API gagal, unauthorized).

---

## 16. Security Notes

- Jangan commit token/JWT ke repository.
- Jangan hardcode credential real production di source code.
- Session harus berjalan di environment yang aman.
- Untuk production, aktifkan SSL/TLS di semua layer.
- Gunakan domain API berbasis HTTPS untuk production.

---

## 17. Deployment Notes

Untuk deployment server staging/production:

1. Upload source code ke web root.
2. Jalankan `composer install --no-dev --optimize-autoloader`.
3. Set `API_DOMAIN_PREFIX` ke URL backend environment terkait.
4. Pastikan extension PHP dibutuhkan aktif.
5. Set permission folder yang diperlukan (jika ada upload/cache lokal).
6. Restart web server.

Checklist pasca deploy:

- login semua role,
- dashboard dan modul utama bisa diakses,
- request API tidak blocked CORS/network,
- BMKG dan laporan berjalan normal.

---

## 18. FAQ

### Q: Project ini menyimpan data langsung ke database?

A: Tidak. Frontend ini mengonsumsi backend API. Data utama dikelola oleh backend.

### Q: Kenapa ada banyak endpoint wilayah?

A: Karena wilayah bertingkat (provinsi > kabupaten > kecamatan > desa), digunakan untuk cascading select dan validasi lokasi.

### Q: Register publik bisa semua role?

A: Tidak. Register publik dibatasi untuk `Warga`, sesuai kebijakan backend saat ini.

### Q: Di mana dokumentasi endpoint paling lengkap?

A: Lihat folder `fetch/`, khususnya `fetch/FETCH.md` sebagai index utama.

---

## Penutup

README ini dirancang sebagai dokumentasi operasional lengkap untuk developer baru maupun tim existing.

Jika Anda ingin, saya bisa lanjutkan dengan:

- versi README bilingual (Indonesia + English),
- tambahan diagram alur (flow login, flow laporan, flow role),
- atau breakdown dokumentasi teknis per modul (`docs/modules/*.md`).
