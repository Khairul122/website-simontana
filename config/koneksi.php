<?php
// Konfigurasi koneksi ke API backend SIMONTA BENCANA

// Mode debugging - nonaktifkan untuk mencegah JavaScript error
define('DEBUG_MODE', false);
define('DEBUG_API', false); // Matikan debugging API

// URL utama API backend
define('API_BASE_URL', 'http://localhost:8000/api');

// === AUTHENTICATION ENDPOINTS ===
define('API_AUTH_LOGIN', API_BASE_URL . '/auth/login');
define('API_AUTH_LOGOUT', API_BASE_URL . '/auth/logout');
define('API_AUTH_ME', API_BASE_URL . '/auth/me');
define('API_AUTH_REFRESH', API_BASE_URL . '/auth/refresh');
define('API_AUTH_REGISTER', API_BASE_URL . '/auth/register');
define('API_AUTH_ROLES', API_BASE_URL . '/auth/roles');

// === USER MANAGEMENT ENDPOINTS ===
define('API_USERS', API_BASE_URL . '/users');
define('API_USERS_BY_ID', API_BASE_URL . '/users/{id}');
define('API_USERS_PROFILE', API_BASE_URL . '/users/profile');
define('API_USERS_STATISTICS', API_BASE_URL . '/users/statistics');

// === WILAYAH (Administrative Areas) ENDPOINTS ===
define('API_WILAYAH_ALL', API_BASE_URL . '/wilayah');
define('API_WILAYAH_PROVINSI', API_BASE_URL . '/wilayah/provinsi');
define('API_WILAYAH_PROVINSI_BY_ID', API_BASE_URL . '/wilayah/provinsi/{id}');
define('API_WILAYAH_KABUPATEN', API_BASE_URL . '/wilayah/kabupaten/{provinsi_id}');
define('API_WILAYAH_KECAMATAN', API_BASE_URL . '/wilayah/kecamatan/{kabupaten_id}');
define('API_WILAYAH_DESA', API_BASE_URL . '/wilayah/desa/{kecamatan_id}');
define('API_WILAYAH_DETAIL', API_BASE_URL . '/wilayah/detail/{desa_id}');
define('API_WILAYAH_HIERARCHY', API_BASE_URL . '/wilayah/hierarchy/{desa_id}');
define('API_WILAYAH_SEARCH', API_BASE_URL . '/wilayah/search');

// === KATEGORI BENCANA ENDPOINTS ===
define('API_KATEGORI_BENCANA', API_BASE_URL . '/kategori-bencana');
define('API_KATEGORI_BENCANA_BY_ID', API_BASE_URL . '/kategori-bencana/{id}');

// === LAPORAN BENCANA ENDPOINTS ===
define('API_LAPORANS', API_BASE_URL . '/laporans');
define('API_LAPORANS_BY_ID', API_BASE_URL . '/laporans/{id}');
define('API_LAPORANS_STATISTICS', API_BASE_URL . '/laporans/statistics');
define('API_LAPORANS_VERIFIKASI', API_BASE_URL . '/laporans/{id}/verifikasi');
define('API_LAPORANS_PROSES', API_BASE_URL . '/laporans/{id}/proses');
define('API_LAPORANS_RIWAYAT', API_BASE_URL . '/laporans/{id}/riwayat');

// === TINDAK LANJUT ENDPOINTS ===
define('API_TINDAK_LANJUT', API_BASE_URL . '/tindak-lanjut');
define('API_TINDAK_LANJUT_BY_ID', API_BASE_URL . '/tindak-lanjut/{id}');

// === RIWAYAT TINDAKAN ENDPOINTS ===
define('API_RIWAYAT_TINDAKAN', API_BASE_URL . '/riwayat-tindakan');
define('API_RIWAYAT_TINDAKAN_BY_ID', API_BASE_URL . '/riwayat-tindakan/{id}');

// === MONITORING ENDPOINTS ===
define('API_MONITORING', API_BASE_URL . '/monitoring');
define('API_MONITORING_BY_ID', API_BASE_URL . '/monitoring/{id}');

// === WILAYAH ENDPOINTS ===
define('API_DESA', API_BASE_URL . '/desa');

// === BMKG INTEGRATION ENDPOINTS ===
define('API_BMKG_ALL', API_BASE_URL . '/bmkg');
define('API_BMKG_GEMPATERBARU', API_BASE_URL . '/bmkg/gempa/terbaru');
define('API_BMKG_GEMPA_TERKINI', API_BASE_URL . '/bmkg/gempa/terkini');
define('API_BMKG_GEMPA_DIRASAKAN', API_BASE_URL . '/bmkg/gempa/dirasakan');
define('API_BMKG_PERINGATAN_TSUNAMI', API_BASE_URL . '/bmkg/peringatan-tsunami');
define('API_BMKG_PRAKIRAAN_CUACA', API_BASE_URL . '/bmkg/prakiraan-cuaca');
define('API_BMKG_CACHE_STATUS', API_BASE_URL . '/bmkg/cache/status');
define('API_BMKG_CACHE_CLEAR', API_BASE_URL . '/bmkg/cache/clear');

/**
 * Function to replace placeholders in URL with actual values
 */
function buildApiUrl($baseUrl, $params = []) {
    $url = $baseUrl;

    foreach ($params as $placeholder => $value) {
        $url = str_replace('{' . $placeholder . '}', $value, $url);
    }

    return $url;
}

/**
 * Specific functions for building wilayah URLs
 */
function buildApiUrlProvinsiById($id) {
    return str_replace('{id}', $id, API_WILAYAH_PROVINSI_BY_ID);
}

function buildApiUrlKabupatenByProvinsiId($provinsiId) {
    return str_replace('{provinsi_id}', $provinsiId, API_WILAYAH_KABUPATEN);
}

function buildApiUrlKecamatanByKabupatenId($kabupatenId) {
    return str_replace('{kabupaten_id}', $kabupatenId, API_WILAYAH_KECAMATAN);
}

function buildApiUrlDesaByKecamatanId($kecamatanId) {
    return str_replace('{kecamatan_id}', $kecamatanId, API_WILAYAH_DESA);
}

function buildApiUrlWilayahDetailByDesaId($desaId) {
    return str_replace('{desa_id}', $desaId, API_WILAYAH_DETAIL);
}

function buildApiUrlWilayahHierarchyByDesaId($desaId) {
    return str_replace('{desa_id}', $desaId, API_WILAYAH_HIERARCHY);
}

/**
 * Functions for other dynamic endpoints with ID
 */
function buildApiUrlUsersById($id) {
    return str_replace('{id}', $id, API_USERS_BY_ID);
}

function buildApiUrlKategoriBencanaById($id) {
    return str_replace('{id}', $id, API_KATEGORI_BENCANA_BY_ID);
}

function buildApiUrlLaporansById($id) {
    return str_replace('{id}', $id, API_LAPORANS_BY_ID);
}

function buildApiUrlLaporansVerifikasiById($id) {
    return str_replace('{id}', $id, API_LAPORANS_VERIFIKASI);
}

function buildApiUrlLaporansProsesById($id) {
    return str_replace('{id}', $id, API_LAPORANS_PROSES);
}

function buildApiUrlLaporansRiwayatById($id) {
    return str_replace('{id}', $id, API_LAPORANS_RIWAYAT);
}

function buildApiUrlTindakLanjutById($id) {
    return str_replace('{id}', $id, API_TINDAK_LANJUT_BY_ID);
}

function buildApiUrlRiwayatTindakanById($id) {
    return str_replace('{id}', $id, API_RIWAYAT_TINDAKAN_BY_ID);
}

function buildApiUrlMonitoringById($id) {
    return str_replace('{id}', $id, API_MONITORING_BY_ID);
}


/**
 * Get authentication headers
 */
function getAuthHeaders($token = null) {
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json'
    ];

    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }

    return $headers;
}

/**
 * Function to make API requests
 */
function apiRequest($url, $method = 'GET', $data = null, $headers = []) {
    $curl = curl_init();

    // Default cURL configuration
    $curlOptions = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HEADER => false, // Don't include header in output
    ];

    // Determine HTTP method
    switch (strtoupper($method)) {
        case 'POST':
            $curlOptions[CURLOPT_POST] = true;
            if ($data) {
                $curlOptions[CURLOPT_POSTFIELDS] = is_array($data) ? json_encode($data) : $data;
                // Add Content-Type header if data is JSON and not already in headers
                $hasContentType = false;
                foreach ($headers as $header) {
                    if (stripos($header, 'Content-Type:') !== false) {
                        $hasContentType = true;
                        break;
                    }
                }
                if (!$hasContentType && is_array($data)) {
                    $curlOptions[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
                }
            }
            break;
        case 'PUT':
            $curlOptions[CURLOPT_CUSTOMREQUEST] = 'PUT';
            if ($data) {
                $curlOptions[CURLOPT_POSTFIELDS] = is_array($data) ? json_encode($data) : $data;
                // Add Content-Type header if data is JSON and not already in headers
                $hasContentType = false;
                foreach ($headers as $header) {
                    if (stripos($header, 'Content-Type:') !== false) {
                        $hasContentType = true;
                        break;
                    }
                }
                if (!$hasContentType && is_array($data)) {
                    $curlOptions[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
                }
            }
            break;
        case 'DELETE':
            $curlOptions[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            break;
        default:
            $curlOptions[CURLOPT_HTTPGET] = true;
    }

    curl_setopt_array($curl, $curlOptions);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);

    curl_close($curl);

    if ($error) {
        return [
            'success' => false,
            'message' => 'Curl error: ' . $error,
            'data' => null,
            'http_code' => 0,
            'raw_response' => null
        ];
    }

    $decodedResponse = json_decode($response, true);

    // If response is not valid JSON, return error
    if ($response !== '' && $decodedResponse === null && json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'message' => 'Invalid JSON response from API: ' . $response,
            'data' => null,
            'http_code' => $httpCode,
            'raw_response' => $response
        ];
    }

    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'http_code' => $httpCode,
        'message' => $decodedResponse && isset($decodedResponse['message']) ? $decodedResponse['message'] : 'Request completed',
        'data' => $decodedResponse && isset($decodedResponse['data']) ? $decodedResponse['data'] : $decodedResponse,
        'raw_response' => $response
    ];
}

/**
 * Function to upload file to API
 */
function uploadFileToAPI($endpoint, $filePath, $fieldName = 'file', $token = null) {
    $curl = curl_init();

    $headers = [
        'Accept: application/json'
    ];

    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }

    // Prepare data for upload
    $postFields = [
        $fieldName => new CURLFile(realpath($filePath))
    ];

    $curlOptions = [
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 60 // Longer timeout for file upload
    ];

    curl_setopt_array($curl, $curlOptions);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);

    curl_close($curl);

    if ($error) {
        return [
            'success' => false,
            'message' => 'Curl error: ' . $error,
            'data' => null
        ];
    }

    $decodedResponse = json_decode($response, true);

    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'http_code' => $httpCode,
        'message' => $decodedResponse && isset($decodedResponse['message']) ? $decodedResponse['message'] : 'File upload completed',
        'data' => $decodedResponse && isset($decodedResponse['data']) ? $decodedResponse['data'] : $decodedResponse
    ];
}