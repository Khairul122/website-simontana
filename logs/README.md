# Dashboard API Debug Logs

## ✅ PERBAIKAN FETCH API YANG NULL

### Masalah yang Diperbaiki:
1. **Method name mismatch** - DashboardController menggunakan method yang tidak ada di koneksi.php
2. **Response format handling** - API Laravel bisa mengembalikan format berbeda (`data`, `laporan`, `monitoring`, dll)
3. **Null data handling** - Fallback untuk berbagai struktur response

### Cara Melihat Hasil Fetch API

### 1. Console Log di Browser (RECOMMENDED)
Buka Developer Tools (F12) di browser dan lihat tab Console. Data yang akan ditampilkan:

- **DASHBOARD DATA DEBUG**: Menampilkan semua data dashboard yang di-fetch dari API
- **AUTHENTICATION DEBUG**: Menampilkan session dan token information
- **API CONNECTION TEST**: ✅ **NEW** - Test semua endpoint API dengan analisis struktur response
- **ENVIRONMENT DEBUG**: Menampilkan informasi environment

### 2. Response Structure Analysis (NEW)
Console sekarang menampilkan analisis struktur response untuk setiap endpoint:
```javascript
Response Structure [/api/laporan/statistics]: {
  hasData: true,
  hasSuccess: true,
  hasMessage: false,
  keys: ["success", "data", "message"],
  sampleFirstKey: "success",
  sampleFirstValue: true
}
```

### 3. Multiple Endpoint Testing (NEW)
Sekarang test endpoint:
- `/api/laporan/statistics`
- `/api/laporan?limit=5`
- `/api/monitoring?limit=5`
- `/api/admin/users`
- `/api/bmkg/dashboard`

### 4. Log File
Log file disimpan di: `website/logs/api_debug.log`

Format log:
```json
{"timestamp":"2024-01-01 12:00:00","label":"Laporan Stats","data":{"success":true,"data":{...}}}
```

### 5. PHP Error Log
Log juga dikirim ke PHP error log dengan detail:
```
Admin Dashboard - Laporan Stats: {"success":true,"data":{"total":10,"menunggu":3,...}}
```

## API Endpoints yang Diperbaiki

### Dashboard Admin ✅
- `GET /api/laporan/statistics` - Gunakan `getLaporanStats()`
- `GET /api/admin/users` - Gunakan `getUserStats()`
- `GET /api/monitoring?limit=5` - Gunakan `getRecentMonitoring()`
- `GET /api/bmkg/dashboard` - Gunakan `getLatestBMKG()`

### Dashboard Petugas BPBD ✅
- `GET /api/laporan/statistics` - Gunakan `getLaporanStats()`
- `GET /api/laporan?status=menunggu` - Gunakan `getPendingLaporan()`
- `GET /api/monitoring` - Gunakan `getRecentMonitoring()`
- `GET /api/bmkg/cuaca/peringatan` - Gunakan `getBMKGWarnings()`

### Dashboard Operator Desa ✅
- `GET /api/my-reports` - Gunakan `getDesaLaporan()`
- `GET /api/monitoring` - Gunakan `getPendingMonitoring()`
- `GET /api/bmkg/cuaca` - Gunakan `getLocalBMKG()`

## Helper Functions untuk Debugging

### extractData() - Handle Multiple Response Formats
```php
// Handle: {"success": true, "data": [...]}
// Handle: {"success": true, "laporan": [...]}
// Handle: {"success": true, "monitoring": [...]}
// Handle: [{"id":1,...}] // Direct array
```

### extractStats() - Handle Statistics Data
```php
// Handle: {"data": {"total":10, "menunggu":3,...}}
// Handle: {"total":10, "menunggu":3,...} // Direct stats
```

## API Endpoints yang Dimonitor

### Dashboard Admin
- `GET /api/laporan/statistics` - Statistik laporan
- `GET /api/admin/users` - Data pengguna
- `GET /api/monitoring?limit=5` - Recent monitoring
- `GET /api/bmkg/dashboard` - Data BMKG

### Dashboard Petugas BPBD
- `GET /api/laporan/statistics` - Statistik laporan
- `GET /api/laporan?status=menunggu` - Laporan pending
- `GET /api/monitoring` - Monitoring aktif
- `GET /api/bmkg/cuaca/peringatan` - Peringatan cuaca

### Dashboard Operator Desa
- `GET /api/my-reports` - Laporan desa operator
- `GET /api/monitoring` - Monitoring pending
- `GET /api/bmkg/cuaca` - Cuaca lokal
- `GET /api/bmkg/cuaca/peringatan` - Peringatan cuaca

## Troubleshooting

### Error "Token tidak ditemukan"
Pastikan user sudah login dan token tersedia di session.

### Error API Unreachable
Pastikan Laravel API server running di `http://127.0.0.1:8000`

### Data Kosong
Cek:
1. Apakah API endpoint mengembalikan data?
2. Apakah format response sesuai yang diharapkan?
3. Apakah permissions user cukup untuk mengakses data?

### Format Response yang Diharapkan

**Success Response:**
```json
{
  "success": true,
  "data": {...}
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error message"
}
```

## Melihat Log Real-time

### Di Browser
Buka dashboard dan lihat Console tab (F12 → Console)

### Di Server (Linux/Mac)
```bash
tail -f website/logs/api_debug.log
```

### Di Server (Windows)
```powershell
Get-Content website/logs/api_debug.log -Wait
```

## Debug Mode untuk Development

Untuk mengaktifkan debug mode, pastikan:
1. PHP error reporting enabled
2. Browser developer tools terbuka
3. Tidak ada caching yang menghalangi

## Monitoring Performance

Dashboard akan otomatis test koneksi API setiap 30 detik untuk monitoring koneksi real-time.