<?php
// Konfigurasi koneksi ke API backend SIMONTA BENCANA

// Mode debugging - nonaktifkan untuk mencegah JavaScript error
define('DEBUG_MODE', false);
define('DEBUG_API', false); // Matikan debugging API

// URL utama API backend
define('API_BASE_URL', 'http://localhost:8000/api');

// Endpoint otentikasi
define('API_LOGIN', API_BASE_URL . '/auth/login');
define('API_REGISTER', API_BASE_URL . '/auth/register');
define('API_LOGOUT', API_BASE_URL . '/auth/logout');
define('API_REFRESH', API_BASE_URL . '/auth/refresh');
define('API_ME', API_BASE_URL . '/auth/me');

// Endpoint laporan bencana
define('API_REPORTS', API_BASE_URL . '/laporans');
define('API_REPORT_BY_ID', API_BASE_URL . '/laporans/{id}');
define('API_VERIFY_REPORT', API_BASE_URL . '/laporans/{id}/verifikasi');
define('API_TANGGAPAN_REPORT', API_BASE_URL . '/laporans/{id}/proses');

// Endpoint tindak lanjut
define('API_TINDAK_LANJUT', API_BASE_URL . '/tindak-lanjut');

// Endpoint riwayat tindakan
define('API_RIWAYAT_TINDAKAN', API_BASE_URL . '/riwayat-tindakan');

// Endpoint manajemen pengguna
define('API_USERS', API_BASE_URL . '/users');
define('API_USER_BY_ID', API_BASE_URL . '/users/{id}');
define('API_USER_PROFILE', API_BASE_URL . '/users/profile');
define('API_USER_STATISTICS', API_BASE_URL . '/users/statistics');

// Endpoint kategori bencana
define('API_KATEGORIS', API_BASE_URL . '/kategoris');
define('API_KATEGORI_BENCANA', API_BASE_URL . '/kategori-bencana');

// Endpoint wilayah
define('API_DESA', API_BASE_URL . '/desa');
define('API_KECAMATAN', API_BASE_URL . '/kecamatan');
define('API_KABUPATEN', API_BASE_URL . '/kabupaten');
define('API_PROVINSI', API_BASE_URL . '/provinsi');

// Endpoint monitoring
define('API_MONITORING', API_BASE_URL . '/monitoring');

// Endpoint BMKG Integration
define('API_BMKG_GEMPA_TERBARU', API_BASE_URL . '/bmkg/gempa/terbaru');
define('API_BMKG_GEMPA_TERKINI', API_BASE_URL . '/bmkg/gempa/terkini');
define('API_BMKG_GEMPA_DIRASAKAN', API_BASE_URL . '/bmkg/gempa/dirasakan');
define('API_BMKG_PRAKIRAAN_CUACA', API_BASE_URL . '/bmkg/prakiraan-cuaca');
define('API_BMKG_PERINGATAN_TSUNAMI', API_BASE_URL . '/bmkg/peringatan-tsunami');
define('API_BMKG_CACHE_STATUS', API_BASE_URL . '/bmkg/cache/status');
define('API_BMKG_CACHE_CLEAR', API_BASE_URL . '/bmkg/cache/clear');

// Endpoint statistik laporan
define('API_REPORTS_STATISTICS', API_BASE_URL . '/laporans/statistics');

// Fungsi untuk mendapatkan header otentikasi
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

// Fungsi untuk melakukan request ke API
function apiRequest($endpoint, $method = 'GET', $data = null, $headers = []) {
    $curl = curl_init();

    // Konfigurasi default cURL
    $curlOptions = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $endpoint,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HEADER => false, // Jangan ikutkan header dalam output
        CURLOPT_VERBOSE => true, // Aktifkan verbose untuk debugging
    ];

    // Tambahkan variable untuk menyimpan informasi debugging
    $debugInfo = [
        'endpoint' => $endpoint,
        'method' => $method,
        'data' => $data,
        'headers' => $headers
    ];

    // Menentukan metode HTTP
    switch (strtoupper($method)) {
        case 'POST':
            $curlOptions[CURLOPT_POST] = true;
            if ($data) {
                $curlOptions[CURLOPT_POSTFIELDS] = is_array($data) ? json_encode($data) : $data;
                // Tambahkan header Content-Type jika data adalah JSON
                if (is_array($data)) {
                    $existingContentHeader = false;
                    foreach ($headers as $header) {
                        if (stripos($header, 'Content-Type:') !== false) {
                            $existingContentHeader = true;
                            break;
                        }
                    }
                    if (!$existingContentHeader) {
                        $curlOptions[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
                    }
                }
            }
            break;
        case 'PUT':
            $curlOptions[CURLOPT_CUSTOMREQUEST] = 'PUT';
            if ($data) {
                $curlOptions[CURLOPT_POSTFIELDS] = is_array($data) ? json_encode($data) : $data;
                // Tambahkan header Content-Type jika data adalah JSON
                if (is_array($data)) {
                    $existingContentHeader = false;
                    foreach ($headers as $header) {
                        if (stripos($header, 'Content-Type:') !== false) {
                            $existingContentHeader = true;
                            break;
                        }
                    }
                    if (!$existingContentHeader) {
                        $curlOptions[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
                    }
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

    // Debug: Tampilkan informasi request ke browser console jika mode debug aktif
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        $debugOutput = "
        <script>
        console.groupCollapsed('API Request: " . addslashes($method) . " " . addslashes($endpoint) . "');
        console.log({
            endpoint: '" . addslashes($endpoint) . "',
            method: '" . addslashes($method) . "',
            httpCode: " . $httpCode . ",
            response: " . json_encode($response) . ",
            debugInfo: " . json_encode($debugInfo) . "
        });
        console.groupEnd();
        </script>";

        // Simpan debug output ke dalam buffer agar tidak langsung ditampilkan
        if (!isset($GLOBALS['debug_buffer'])) {
            $GLOBALS['debug_buffer'] = [];
        }
        $GLOBALS['debug_buffer'][] = $debugOutput;
    }

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

    // Jika response bukan JSON valid, kembalikan error
    if ($response !== '' && $decodedResponse === null && json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'message' => 'Invalid JSON response from API: ' . $response,
            'data' => null,
            'http_code' => $httpCode,
            'raw_response' => $response
        ];
    }

    // Debug: Tampilkan respons API ke browser console
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        $debugOutput = "
        <script>
        console.groupCollapsed('API Response: " . addslashes($method) . " " . addslashes($endpoint) . " [" . $httpCode . "]');
        console.log({
            success: " . ($httpCode >= 200 && $httpCode < 300 ? 'true' : 'false') . ",
            httpCode: " . $httpCode . ",
            decodedResponse: " . json_encode($decodedResponse) . ",
            rawResponse: '" . addslashes(substr($response, 0, 500)) . "' + '" . (strlen($response) > 500 ? '...' : '') . "'
        });
        console.groupEnd();
        </script>";

        // Simpan debug output ke dalam buffer agar tidak langsung ditampilkan
        if (!isset($GLOBALS['debug_buffer'])) {
            $GLOBALS['debug_buffer'] = [];
        }
        $GLOBALS['debug_buffer'][] = $debugOutput;
    }

    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'http_code' => $httpCode,
        'message' => $decodedResponse && isset($decodedResponse['message']) ? $decodedResponse['message'] : 'Request completed',
        'data' => $decodedResponse && isset($decodedResponse['data']) ? $decodedResponse['data'] : $decodedResponse,
        'raw_response' => $response
    ];
}

// Fungsi untuk mengupload file ke API
function uploadFileToAPI($endpoint, $filePath, $fieldName = 'file', $token = null) {
    $curl = curl_init();

    $headers = [
        'Accept: application/json'
    ];

    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }

    // Persiapan data untuk upload
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
        CURLOPT_TIMEOUT => 60 // Lebih lama untuk upload file
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

// Fungsi untuk menampilkan semua debug output di akhir halaman
function flushDebugBuffer() {
    if (isset($GLOBALS['debug_buffer']) && is_array($GLOBALS['debug_buffer'])) {
        foreach ($GLOBALS['debug_buffer'] as $debugOutput) {
            echo $debugOutput;
        }
        // Kosongkan buffer setelah ditampilkan
        $GLOBALS['debug_buffer'] = [];
    }
}

// Register fungsi untuk dijalankan di akhir eksekusi script
register_shutdown_function('flushDebugBuffer');
?>