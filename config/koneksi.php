<?php

require_once __DIR__ . '/api.php';

if (!defined('API_AUTH_REGISTER')) {
    define('API_AUTH_REGISTER', API_BASE_URL . '/auth/register');
}
if (!defined('API_AUTH_LOGIN')) {
    define('API_AUTH_LOGIN', API_BASE_URL . '/auth/login');
}
if (!defined('API_AUTH_ROLES')) {
    define('API_AUTH_ROLES', API_BASE_URL . '/auth/roles');
}
if (!defined('API_AUTH_ME')) {
    define('API_AUTH_ME', API_BASE_URL . '/auth/me');
}
if (!defined('API_AUTH_REFRESH')) {
    define('API_AUTH_REFRESH', API_BASE_URL . '/auth/refresh');
}
if (!defined('API_AUTH_LOGOUT')) {
    define('API_AUTH_LOGOUT', API_BASE_URL . '/auth/logout');
}
if (!defined('API_CHECK_TOKEN')) {
    define('API_CHECK_TOKEN', API_BASE_URL . '/check-token');
}

if (!defined('API_USERS')) {
    define('API_USERS', API_BASE_URL . '/users');
}
if (!defined('API_USERS_PROFILE')) {
    define('API_USERS_PROFILE', API_BASE_URL . '/users/profile');
}
if (!defined('API_USERS_STATISTICS')) {
    define('API_USERS_STATISTICS', API_BASE_URL . '/users/statistics');
}

if (!defined('API_LAPORANS')) {
    define('API_LAPORANS', API_BASE_URL . '/laporans');
}
if (!defined('API_LAPORANS_STATISTICS')) {
    define('API_LAPORANS_STATISTICS', API_BASE_URL . '/laporans/statistics');
}

if (!defined('API_MONITORING')) {
    define('API_MONITORING', API_BASE_URL . '/monitoring');
}
if (!defined('API_MONITORING_BY_ID')) {
    define('API_MONITORING_BY_ID', API_BASE_URL . '/monitoring/{id}');
}

if (!defined('API_TINDAK_LANJUT')) {
    define('API_TINDAK_LANJUT', API_BASE_URL . '/tindak-lanjut');
}
if (!defined('API_TINDAK_LANJUT_BY_ID')) {
    define('API_TINDAK_LANJUT_BY_ID', API_BASE_URL . '/tindak-lanjut/{id}');
}

if (!defined('API_RIWAYAT_TINDAKAN')) {
    define('API_RIWAYAT_TINDAKAN', API_BASE_URL . '/riwayat-tindakan');
}
if (!defined('API_RIWAYAT_TINDAKAN_BY_ID')) {
    define('API_RIWAYAT_TINDAKAN_BY_ID', API_BASE_URL . '/riwayat-tindakan/{id}');
}

if (!defined('API_KATEGORI_BENCANA')) {
    define('API_KATEGORI_BENCANA', API_BASE_URL . '/kategori-bencana');
}

if (!defined('API_WILAYAH_ALL')) {
    define('API_WILAYAH_ALL', API_BASE_URL . '/wilayah/{id}');
}
if (!defined('API_WILAYAH_BY_ID')) {
    define('API_WILAYAH_BY_ID', API_BASE_URL . '/wilayah/{id}');
}
if (!defined('API_WILAYAH_DELETE')) {
    define('API_WILAYAH_DELETE', API_BASE_URL . '/wilayah/{id}');
}

if (!defined('API_WILAYAH_PROVINSI')) {
    define('API_WILAYAH_PROVINSI', API_BASE_URL . '/wilayah/provinsi');
}
if (!defined('API_WILAYAH_PROVINSI_BY_ID')) {
    define('API_WILAYAH_PROVINSI_BY_ID', API_BASE_URL . '/wilayah/provinsi/{id}');
}

if (!defined('API_WILAYAH_KABUPATEN')) {
    define('API_WILAYAH_KABUPATEN', API_BASE_URL . '/wilayah/kabupaten/{provinsi_id}');
}
if (!defined('API_WILAYAH_KABUPATEN_CREATE')) {
    define('API_WILAYAH_KABUPATEN_CREATE', API_BASE_URL . '/wilayah/kabupaten');
}
if (!defined('API_WILAYAH_KABUPATEN_BY_ID')) {
    define('API_WILAYAH_KABUPATEN_BY_ID', API_BASE_URL . '/wilayah/kabupaten/{id}');
}

if (!defined('API_WILAYAH_KECAMATAN')) {
    define('API_WILAYAH_KECAMATAN', API_BASE_URL . '/wilayah/kecamatan/{kabupaten_id}');
}
if (!defined('API_WILAYAH_KECAMATAN_CREATE')) {
    define('API_WILAYAH_KECAMATAN_CREATE', API_BASE_URL . '/wilayah/kecamatan');
}
if (!defined('API_WILAYAH_KECAMATAN_BY_ID')) {
    define('API_WILAYAH_KECAMATAN_BY_ID', API_BASE_URL . '/wilayah/kecamatan/{id}');
}

if (!defined('API_WILAYAH_DESA')) {
    define('API_WILAYAH_DESA', API_BASE_URL . '/wilayah/desa/{kecamatan_id}');
}
if (!defined('API_WILAYAH_DESA_CREATE')) {
    define('API_WILAYAH_DESA_CREATE', API_BASE_URL . '/wilayah/desa');
}
if (!defined('API_WILAYAH_DESA_BY_ID')) {
    define('API_WILAYAH_DESA_BY_ID', API_BASE_URL . '/wilayah/desa/{id}');
}

if (!defined('API_WILAYAH_DETAIL')) {
    define('API_WILAYAH_DETAIL', API_BASE_URL . '/wilayah/detail/{desa_id}');
}
if (!defined('API_WILAYAH_HIERARCHY')) {
    define('API_WILAYAH_HIERARCHY', API_BASE_URL . '/wilayah/hierarchy/{desa_id}');
}
if (!defined('API_WILAYAH_SEARCH')) {
    define('API_WILAYAH_SEARCH', API_BASE_URL . '/wilayah/search');
}
if (!defined('API_DESA')) {
    define('API_DESA', API_BASE_URL . '/wilayah?jenis=desa');
}

if (!defined('API_BMKG')) {
    define('API_BMKG', API_BASE_URL . '/bmkg');
}
if (!defined('API_BMKG_GEMPATERBARU')) {
    define('API_BMKG_GEMPATERBARU', API_BASE_URL . '/bmkg/gempa/terbaru');
}
if (!defined('API_BMKG_GEMPA_TERKINI')) {
    define('API_BMKG_GEMPA_TERKINI', API_BASE_URL . '/bmkg/gempa/terkini');
}
if (!defined('API_BMKG_GEMPA_DIRASAKAN')) {
    define('API_BMKG_GEMPA_DIRASAKAN', API_BASE_URL . '/bmkg/gempa/dirasakan');
}
if (!defined('API_BMKG_PRAKIRAAN_CUACA')) {
    define('API_BMKG_PRAKIRAAN_CUACA', API_BASE_URL . '/bmkg/prakiraan-cuaca');
}
if (!defined('API_BMKG_PERINGATAN_DINI_CUACA')) {
    define('API_BMKG_PERINGATAN_DINI_CUACA', API_BASE_URL . '/bmkg/peringatan-dini-cuaca');
}
if (!defined('API_BMKG_CACHE_STATUS')) {
    define('API_BMKG_CACHE_STATUS', API_BASE_URL . '/bmkg/cache/status');
}
if (!defined('API_BMKG_CACHE_CLEAR')) {
    define('API_BMKG_CACHE_CLEAR', API_BASE_URL . '/bmkg/cache/clear');
}

function getAuthHeaders(?string $token = null): array
{
    $headers = [
        'Accept: application/json'
    ];

    if ($token !== null && $token !== '') {
        $headers[] = 'Authorization: Bearer ' . $token;
    }

    return $headers;
}

function normalizeApiResponse(array $payload, int $httpCode = 200): array
{
    $hasSuccess = array_key_exists('success', $payload);
    $success = $hasSuccess ? (bool) $payload['success'] : ($httpCode >= 200 && $httpCode < 300);

    $message = $payload['message'] ?? null;
    if (!$message) {
        if ($httpCode === 401) {
            $message = 'Sesi berakhir atau token tidak valid.';
        } elseif ($httpCode === 403) {
            $message = 'Akses ditolak.';
        } elseif ($httpCode === 404) {
            $message = 'Data tidak ditemukan.';
        } elseif ($httpCode === 422) {
            $message = 'Validasi gagal.';
        } elseif ($httpCode >= 500) {
            $message = 'Terjadi kesalahan pada server.';
        } else {
            $message = $success ? 'Permintaan berhasil diproses.' : 'Permintaan gagal diproses.';
        }
    }

    $errors = [];
    if (isset($payload['errors']) && is_array($payload['errors'])) {
        $errors = $payload['errors'];
    }

    $details = [];
    if (isset($payload['details']) && is_array($payload['details'])) {
        $details = $payload['details'];
    } elseif (!empty($errors)) {
        $details = $errors;
    }

    return [
        'success' => $success,
        'message' => (string) $message,
        'code' => $payload['code'] ?? null,
        'http_code' => $httpCode,
        'data' => $payload['data'] ?? null,
        'meta' => $payload['meta'] ?? null,
        'errors' => $errors,
        'details' => $details,
        'request_id' => $payload['request_id'] ?? null,
        'raw' => $payload
    ];
}

function apiRequest(string $url, string $method = 'GET', $data = null, array $headers = []): array
{
    $curl = curl_init();
    $method = strtoupper($method);

    $requestHeaders = $headers;
    $body = null;

    $isMultipart = is_array($data) && !empty($data['is_multipart']) && isset($data['data']) && is_array($data['data']);

    if ($isMultipart) {
        $body = $data['data'];
    } elseif ($data !== null && $method !== 'GET') {
        $hasJsonHeader = false;
        foreach ($requestHeaders as $h) {
            if (stripos($h, 'Content-Type:') === 0) {
                $hasJsonHeader = true;
                break;
            }
        }

        if (is_array($data)) {
            if (!$hasJsonHeader) {
                $requestHeaders[] = 'Content-Type: application/json';
            }
            $body = json_encode($data);
        } else {
            $body = (string) $data;
        }
    }

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $requestHeaders,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    if ($body !== null && $method !== 'GET') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    }

    $rawResponse = curl_exec($curl);
    $curlError = curl_error($curl);
    $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($curlError) {
        return normalizeApiResponse([
            'success' => false,
            'message' => 'Koneksi ke API gagal: ' . $curlError,
            'code' => 'CONNECTION_ERROR'
        ], 0);
    }

    if ($rawResponse === false || $rawResponse === '') {
        return normalizeApiResponse([
            'success' => false,
            'message' => 'Respons API kosong.',
            'code' => 'EMPTY_RESPONSE'
        ], $httpCode);
    }

    $decoded = json_decode($rawResponse, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
        return normalizeApiResponse([
            'success' => $httpCode >= 200 && $httpCode < 300,
            'message' => $httpCode >= 200 && $httpCode < 300
                ? 'Respons API non-JSON diterima.'
                : 'Respons API tidak valid.',
            'code' => 'INVALID_RESPONSE_FORMAT',
            'data' => ['raw_response' => $rawResponse]
        ], $httpCode);
    }

    return normalizeApiResponse($decoded, $httpCode);
}

function apiDataList($data): array
{
    if (is_array($data) && isset($data['data']) && is_array($data['data'])) {
        return $data['data'];
    }

    return is_array($data) ? $data : [];
}

function apiDataEntity($data): array
{
    if (is_array($data) && isset($data['data']) && is_array($data['data'])) {
        return $data['data'];
    }

    return is_array($data) ? $data : [];
}

function apiResolveId(array $row, array $keys): int
{
    foreach ($keys as $key) {
        if (isset($row[$key]) && $row[$key] !== '' && is_numeric($row[$key])) {
            return (int) $row[$key];
        }
    }
    return 0;
}

function buildApiUrlLaporansById(int $id): string
{
    return API_LAPORANS . '/' . $id;
}

function buildApiUrlLaporansVerifikasiById(int $id): string
{
    return API_LAPORANS . '/' . $id . '/verifikasi';
}

function buildApiUrlLaporansProsesById(int $id): string
{
    return API_LAPORANS . '/' . $id . '/proses';
}

function buildApiUrlLaporansRiwayatById(int $id): string
{
    return API_LAPORANS . '/' . $id . '/riwayat';
}

function buildApiUrlMonitoringById(int $id): string
{
    return str_replace('{id}', (string) $id, API_MONITORING_BY_ID);
}

function buildApiUrlTindakLanjutById(int $id): string
{
    return str_replace('{id}', (string) $id, API_TINDAK_LANJUT_BY_ID);
}

function buildApiUrlRiwayatTindakanById(int $id): string
{
    return str_replace('{id}', (string) $id, API_RIWAYAT_TINDAKAN_BY_ID);
}

function buildApiUrlWilayahDetailByDesaId(int $desaId): string
{
    return str_replace('{desa_id}', (string) $desaId, API_WILAYAH_DETAIL);
}

function createLaporan(array $data, array $files = []): array
{
    $token = $_SESSION['token'] ?? null;
    $headers = getAuthHeaders($token);

    if (!empty($files)) {
        $multipartData = $data;
        foreach (['foto_bukti_1', 'foto_bukti_2', 'foto_bukti_3', 'video_bukti'] as $field) {
            if (isset($files[$field]) && is_array($files[$field]) && ($files[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                $multipartData[$field] = new CURLFile(
                    $files[$field]['tmp_name'],
                    $files[$field]['type'] ?? 'application/octet-stream',
                    $files[$field]['name'] ?? $field
                );
            }
        }

        return apiRequest(API_LAPORANS, 'POST', [
            'is_multipart' => true,
            'data' => $multipartData
        ], $headers);
    }

    return apiRequest(API_LAPORANS, 'POST', $data, $headers);
}
