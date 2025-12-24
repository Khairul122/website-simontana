<?php
// Konfigurasi koneksi ke API backend SIMONTA BENCANA

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mode debugging - nonaktifkan untuk production
define('DEBUG_MODE', false);
define('DEBUG_API', false);  

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
define('API_WILAYAH_BY_ID', API_BASE_URL . '/wilayah/{id}'); // GET/PUT/DELETE detail wilayah by ID

// === PROVINSI ENDPOINTS ===
define('API_WILAYAH_PROVINSI', API_BASE_URL . '/wilayah/provinsi'); // GET list, POST create
define('API_WILAYAH_PROVINSI_BY_ID', API_BASE_URL . '/wilayah/provinsi/{id}'); // GET/PUT/DELETE by ID

// === KABUPATEN ENDPOINTS ===
define('API_WILAYAH_KABUPATEN', API_BASE_URL . '/wilayah/kabupaten/{provinsi_id}'); // GET by provinsi
define('API_WILAYAH_KABUPATEN_CREATE', API_BASE_URL . '/wilayah/kabupaten'); // POST create kabupaten
define('API_WILAYAH_KABUPATEN_BY_ID', API_BASE_URL . '/wilayah/kabupaten/{id}'); // PUT update kabupaten

// === KECAMATAN ENDPOINTS ===
define('API_WILAYAH_KECAMATAN', API_BASE_URL . '/wilayah/kecamatan/{kabupaten_id}'); // GET by kabupaten
define('API_WILAYAH_KECAMATAN_CREATE', API_BASE_URL . '/wilayah/kecamatan'); // POST create kecamatan
define('API_WILAYAH_KECAMATAN_BY_ID', API_BASE_URL . '/wilayah/kecamatan/{id}'); // PUT update kecamatan

// === DESA ENDPOINTS ===
define('API_WILAYAH_DESA', API_BASE_URL . '/wilayah/desa/{kecamatan_id}'); // GET by kecamatan
define('API_WILAYAH_DESA_CREATE', API_BASE_URL . '/wilayah/desa'); // POST create desa (dedicated endpoint)
define('API_WILAYAH_DESA_BY_ID', API_BASE_URL . '/wilayah/desa/{id}'); // PUT/DELETE desa (dedicated endpoint)

// === WILAYAH DELETE ENDPOINTS (for specific jenis) ===
define('API_WILAYAH_DELETE', API_BASE_URL . '/wilayah/{id}'); // DELETE with jenis parameter

// === WILAYAH UTILITY ENDPOINTS ===
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

// === BMKG INTEGRATION ENDPOINTS ===
define('API_BMKG_ALL', API_BASE_URL . '/bmkg');
define('API_BMKG_GEMPATERBARU', API_BASE_URL . '/bmkg/gempa/terbaru');
define('API_BMKG_GEMPA_TERKINI', API_BASE_URL . '/bmkg/gempa/terkini');
define('API_BMKG_GEMPA_DIRASAKAN', API_BASE_URL . '/bmkg/gempa/dirasakan');
define('API_BMKG_PERINGATAN_TSUNAMI', API_BASE_URL . '/bmkg/peringatan-tsunami');
define('API_BMKG_PRAKIRAAN_CUACA', API_BASE_URL . '/bmkg/prakiraan-cuaca');
define('API_BMKG_CACHE_STATUS', API_BASE_URL . '/bmkg/cache/status');
define('API_BMKG_CACHE_CLEAR', API_BASE_URL . '/bmkg/cache/clear');

// === FILE UPLOAD PATH ===
define('TEMP_UPLOAD_PATH', __DIR__ . '/../uploads/temp/');

// === AUTH HELPER ===

/**
 * Save token and user data to session
 */
function saveToken(string $token, array $user): void {
    $_SESSION['api_token'] = $token;
    $_SESSION['user'] = $user;
    $_SESSION['token_created_at'] = time();
}

/**
 * Get token from session
 */
function getToken(): ?string {
    return $_SESSION['api_token'] ?? null;
}

/**
 * Check if user is logged in
 */
function isLoggedIn(): bool {
    return isset($_SESSION['api_token']) && !empty($_SESSION['api_token']);
}

/**
 * Clear user session data
 */
function clearSession(): void {
    unset($_SESSION['api_token']);
    unset($_SESSION['user']);
    unset($_SESSION['token_created_at']);
}

/**
 * Get authentication headers
 */
function getAuthHeaders(?string $token = null): array {
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json'
    ];

    if ($token === null) {
        $token = getToken();
    }

    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }

    return $headers;
}

/**
 * Function to make API requests with automatic token handling and error handling
 */
function apiRequest(string $url, string $method = 'GET', $data = null, array $headers = []): array {
    // Add authentication headers if not already provided
    if (empty($headers)) {
        $headers = getAuthHeaders();
    }

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
                // For multipart form data (file uploads), don't encode as JSON
                if (is_array($data) && isset($data['is_multipart']) && $data['is_multipart']) {
                    $curlOptions[CURLOPT_POSTFIELDS] = $data['data'];
                    // Remove Content-Type header for multipart data
                    $newHeaders = [];
                    foreach ($headers as $header) {
                        if (stripos($header, 'Content-Type:') === false) {
                            $newHeaders[] = $header;
                        }
                    }
                    $curlOptions[CURLOPT_HTTPHEADER] = $newHeaders;
                } else {
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

    // Handle 401 Unauthorized - automatically logout user
    if ($httpCode === 401) {
        clearSession();
        return [
            'success' => false,
            'message' => 'Unauthorized. Please login again.',
            'data' => null,
            'http_code' => $httpCode,
            'raw_response' => $response
        ];
    }

    $decodedResponse = json_decode($response, true);

    // If response is not valid JSON, return error
    if ($response !== '' && $decodedResponse === null && json_last_error() !== JSON_ERROR_NONE) {
        if (DEBUG_API) {
            error_log("Invalid JSON response from API: " . $response);
        }
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
function uploadFileToAPI(string $endpoint, string $filePath, string $fieldName = 'file', ?string $token = null): array {
    $curl = curl_init();

    $headers = [
        'Accept: application/json'
    ];

    if ($token === null) {
        $token = getToken();
    }

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

    // Handle 401 Unauthorized - automatically logout user
    if ($httpCode === 401) {
        clearSession();
        return [
            'success' => false,
            'message' => 'Unauthorized. Please login again.',
            'data' => null,
            'http_code' => $httpCode,
            'raw_response' => $response
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

// === AUTHENTICATION WRAPPER FUNCTIONS ===

/**
 * Login user and save token to session
 */
function doLogin(string $email, string $password): array {
    $data = [
        'email' => $email,
        'password' => $password
    ];

    $response = apiRequest(API_AUTH_LOGIN, 'POST', $data, getAuthHeaders(null));

    if ($response['success']) {
        $token = $response['data']['token'] ?? null;
        $user = $response['data']['user'] ?? null;

        if ($token && $user) {
            saveToken($token, $user);
            return [
                'success' => true,
                'message' => 'Login successful',
                'data' => $user
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Invalid response from server',
                'data' => null
            ];
        }
    }

    return $response;
}

/**
 * Register new user
 */
function doRegister(array $data): array {
    return apiRequest(API_AUTH_REGISTER, 'POST', $data, getAuthHeaders(null));
}

/**
 * Logout user and clear session
 */
function doLogout(): array {
    $response = apiRequest(API_AUTH_LOGOUT, 'POST', null, getAuthHeaders());

    // Clear session regardless of API response
    clearSession();

    // Return success response even if API call failed
    return [
        'success' => true,
        'message' => 'Logout successful',
        'data' => null
    ];
}

// === WILAYAH (LOCATION) WRAPPER FUNCTIONS ===

/**
 * Get all provinces with optional caching
 */
function getProvinsi(bool $useCache = true): array {
    if ($useCache && isset($_SESSION['wilayah_cache']['provinsi'])) {
        $cache = $_SESSION['wilayah_cache']['provinsi'];
        // Cache for 1 hour
        if (time() - $cache['timestamp'] < 3600) {
            return [
                'success' => true,
                'message' => 'Data provinsi diambil dari cache',
                'data' => $cache['data']
            ];
        }
    }

    $response = apiRequest(API_WILAYAH_PROVINSI, 'GET', null, getAuthHeaders());

    if ($response['success'] && $useCache) {
        $_SESSION['wilayah_cache']['provinsi'] = [
            'timestamp' => time(),
            'data' => $response['data']
        ];
    }

    return $response;
}

/**
 * Get all regencies by province ID with optional caching
 */
function getKabupaten(int $provinsiId, bool $useCache = true): array {
    $cacheKey = 'kabupaten_' . $provinsiId;

    if ($useCache && isset($_SESSION['wilayah_cache'][$cacheKey])) {
        $cache = $_SESSION['wilayah_cache'][$cacheKey];
        // Cache for 1 hour
        if (time() - $cache['timestamp'] < 3600) {
            return [
                'success' => true,
                'message' => 'Data kabupaten diambil dari cache',
                'data' => $cache['data']
            ];
        }
    }

    $url = str_replace('{provinsi_id}', $provinsiId, API_WILAYAH_KABUPATEN);
    $response = apiRequest($url, 'GET', null, getAuthHeaders());

    if ($response['success'] && $useCache) {
        $_SESSION['wilayah_cache'][$cacheKey] = [
            'timestamp' => time(),
            'data' => $response['data']
        ];
    }

    return $response;
}

/**
 * Get all districts by regency ID with optional caching
 */
function getKecamatan(int $kabupatenId, bool $useCache = true): array {
    $cacheKey = 'kecamatan_' . $kabupatenId;

    if ($useCache && isset($_SESSION['wilayah_cache'][$cacheKey])) {
        $cache = $_SESSION['wilayah_cache'][$cacheKey];
        // Cache for 1 hour
        if (time() - $cache['timestamp'] < 3600) {
            return [
                'success' => true,
                'message' => 'Data kecamatan diambil dari cache',
                'data' => $cache['data']
            ];
        }
    }

    $url = str_replace('{kabupaten_id}', $kabupatenId, API_WILAYAH_KECAMATAN);
    $response = apiRequest($url, 'GET', null, getAuthHeaders());

    if ($response['success'] && $useCache) {
        $_SESSION['wilayah_cache'][$cacheKey] = [
            'timestamp' => time(),
            'data' => $response['data']
        ];
    }

    return $response;
}

/**
 * Get all villages by district ID with optional caching
 */
function getDesa(int $kecamatanId, bool $useCache = true): array {
    $cacheKey = 'desa_' . $kecamatanId;

    if ($useCache && isset($_SESSION['wilayah_cache'][$cacheKey])) {
        $cache = $_SESSION['wilayah_cache'][$cacheKey];
        // Cache for 1 hour
        if (time() - $cache['timestamp'] < 3600) {
            return [
                'success' => true,
                'message' => 'Data desa diambil dari cache',
                'data' => $cache['data']
            ];
        }
    }

    $url = str_replace('{kecamatan_id}', $kecamatanId, API_WILAYAH_DESA);
    $response = apiRequest($url, 'GET', null, getAuthHeaders());

    if ($response['success'] && $useCache) {
        $_SESSION['wilayah_cache'][$cacheKey] = [
            'timestamp' => time(),
            'data' => $response['data']
        ];
    }

    return $response;
}

// === LAPORAN (REPORT) WRAPPER FUNCTIONS ===

/**
 * Get all reports with optional filters
 */
function getAllLaporan(array $filters = []): array {
    $url = API_LAPORANS;

    // Add query parameters if filters are provided
    if (!empty($filters)) {
        $url .= '?' . http_build_query($filters);
    }

    return apiRequest($url, 'GET', null, getAuthHeaders());
}

/**
 * Get report detail by ID
 */
function getLaporanDetail(int $id): array {
    $url = str_replace('{id}', $id, API_LAPORANS_BY_ID);
    return apiRequest($url, 'GET', null, getAuthHeaders());
}

/**
 * Create new report with file uploads
 */
function createLaporan(array $data, array $files = []): array {
    // Prepare multipart form data
    $multipartData = [];

    // Add regular form fields
    foreach ($data as $key => $value) {
        if ($key !== 'is_multipart' && $key !== 'data') { // Avoid recursive data
            $multipartData[$key] = $value;
        }
    }

    // Add file fields if provided
    $fileFields = ['foto_bukti_1', 'foto_bukti_2', 'foto_bukti_3', 'video_bukti'];

    foreach ($fileFields as $field) {
        if (isset($files[$field]) && $files[$field]['error'] === UPLOAD_ERR_OK) {
            $multipartData[$field] = new CURLFile(
                $files[$field]['tmp_name'],
                $files[$field]['type'],
                $files[$field]['name']
            );
        }
    }

    // Prepare request data for multipart
    $requestData = [
        'is_multipart' => true,
        'data' => $multipartData
    ];

    return apiRequest(API_LAPORANS, 'POST', $requestData);
}

// === BMKG (METEOROLOGY) WRAPPER FUNCTIONS ===

/**
 * Get latest earthquake data (public endpoint - no auth required)
 */
function getGempaTerbaru(): array {
    return apiRequest(API_BMKG_GEMPATERBARU, 'GET', null, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
}

/**
 * Get weather forecast (requires authentication)
 */
function getPrakiraanCuaca(): array {
    return apiRequest(API_BMKG_PRAKIRAAN_CUACA, 'GET', null, getAuthHeaders());
}

// === HELPER FUNCTIONS ===

/**
 * Function to replace placeholders in URL with actual values
 */
function buildApiUrl(string $baseUrl, array $params = []): string {
    $url = $baseUrl;

    foreach ($params as $placeholder => $value) {
        $url = str_replace('{' . $placeholder . '}', $value, $url);
    }

    return $url;
}

/**
 * Specific functions for building wilayah URLs
 */
function buildApiUrlWilayahById(int $id): string {
    return str_replace('{id}', $id, API_WILAYAH_BY_ID);
}

function buildApiUrlProvinsiById(int $id): string {
    return str_replace('{id}', $id, API_WILAYAH_PROVINSI_BY_ID);
}

function buildApiUrlKabupatenByProvinsiId(int $provinsiId): string {
    return str_replace('{provinsi_id}', $provinsiId, API_WILAYAH_KABUPATEN);
}

function buildApiUrlKabupatenById(int $id): string {
    return str_replace('{id}', $id, API_WILAYAH_KABUPATEN_BY_ID);
}

function buildApiUrlKecamatanByKabupatenId(int $kabupatenId): string {
    return str_replace('{kabupaten_id}', $kabupatenId, API_WILAYAH_KECAMATAN);
}

function buildApiUrlKecamatanById(int $id): string {
    return str_replace('{id}', $id, API_WILAYAH_KECAMATAN_BY_ID);
}

function buildApiUrlDesaByKecamatanId(int $kecamatanId): string {
    return str_replace('{kecamatan_id}', $kecamatanId, API_WILAYAH_DESA);
}

function buildApiUrlDesaById(int $id): string {
    // Gunakan API_WILAYAH_BY_ID untuk update/delete desa
    return str_replace('{id}', $id, API_WILAYAH_BY_ID);
}

function buildApiUrlWilayahDetailByDesaId(int $desaId): string {
    return str_replace('{desa_id}', $desaId, API_WILAYAH_DETAIL);
}

function buildApiUrlWilayahHierarchyByDesaId(int $desaId): string {
    return str_replace('{desa_id}', $desaId, API_WILAYAH_HIERARCHY);
}

/**
 * Functions for other dynamic endpoints with ID
 */
function buildApiUrlUsersById(int $id): string {
    return str_replace('{id}', $id, API_USERS_BY_ID);
}

function buildApiUrlKategoriBencanaById(int $id): string {
    return str_replace('{id}', $id, API_KATEGORI_BENCANA_BY_ID);
}

function buildApiUrlLaporansById(int $id): string {
    return str_replace('{id}', $id, API_LAPORANS_BY_ID);
}

function buildApiUrlLaporansVerifikasiById(int $id): string {
    return str_replace('{id}', $id, API_LAPORANS_VERIFIKASI);
}

function buildApiUrlLaporansProsesById(int $id): string {
    return str_replace('{id}', $id, API_LAPORANS_PROSES);
}

function buildApiUrlLaporansRiwayatById(int $id): string {
    return str_replace('{id}', $id, API_LAPORANS_RIWAYAT);
}

function buildApiUrlTindakLanjutById(int $id): string {
    return str_replace('{id}', $id, API_TINDAK_LANJUT_BY_ID);
}

function buildApiUrlRiwayatTindakanById(int $id): string {
    return str_replace('{id}', $id, API_RIWAYAT_TINDAKAN_BY_ID);
}

function buildApiUrlMonitoringById(int $id): string {
    return str_replace('{id}', $id, API_MONITORING_BY_ID);
}