# FETCH Role: Warga

Panduan endpoint utama untuk role `Warga` dengan backend docs sebagai source of truth.

## Setup

```bash
BASE_URL="http://127.0.0.1:8000/api/v1"
TOKEN="token_warga"
```

## 1) Auth dan Profil

Endpoint:

- `POST /auth/register`
- `POST /auth/login`
- `GET /auth/me`
- `POST /auth/refresh`
- `POST /auth/logout`
- `GET /users/profile`
- `PUT /users/profile`

### Contoh GET /users/profile

```bash
curl -X GET "$BASE_URL/users/profile" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN"
```

## 2) Laporan Warga

Endpoint:

- `GET /laporans`
- `POST /laporans`
- `GET /laporans/{id}`
- `PUT /laporans/{id}` (sesuai policy)
- `DELETE /laporans/{id}` (sesuai policy)
- `GET /warga/laporans/{id}/detail-lengkap`

### POST /laporans (multipart)

Field penting:

- `judul_laporan` (required)
- `deskripsi` (required)
- `tingkat_keparahan` (required: `Rendah|Sedang|Tinggi|Kritis`)
- `id_kategori_bencana` (required)
- `id_desa` (required)
- `alamat_laporan` (required)

Catatan transisi frontend:

- sementara dual-field masih dipakai untuk kompatibilitas: kirim `alamat_laporan` + `alamat_lengkap` dengan nilai yang sama.

```bash
curl -X POST "$BASE_URL/laporans" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -F "judul_laporan=Banjir RT 03" \
  -F "deskripsi=Air naik setinggi lutut" \
  -F "tingkat_keparahan=Sedang" \
  -F "id_kategori_bencana=1" \
  -F "id_desa=1" \
  -F "alamat_laporan=RT 03 RW 02" \
  -F "alamat_lengkap=RT 03 RW 02" \
  -F "foto_bukti_1=@./sample1.jpg"
```

## 3) BMKG Public

Endpoint:

- `GET /bmkg/gempa/terbaru`
- `GET /bmkg/gempa/terkini`
- `GET /bmkg/gempa/dirasakan`
- `GET /bmkg/prakiraan-cuaca?wilayah_id=...`
- `GET /bmkg/peringatan-dini-cuaca`

## 4) Wilayah Public

Endpoint:

- `GET /wilayah`
- `GET /wilayah/provinsi`
- `GET /wilayah/kabupaten/{provinsi_id}`
- `GET /wilayah/kecamatan/{kabupaten_id}`
- `GET /wilayah/desa/{kecamatan_id}`
- `GET /wilayah/detail/{desa_id}`

## Error Mapping Umum

- `401` token tidak valid/expired
- `403` tidak punya akses ke resource
- `404` resource tidak ditemukan
- `422` validasi gagal (field required / enum salah)
