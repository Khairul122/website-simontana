<?php
/**
 * Konfigurasi REST API Client untuk Website SIMONTA BENCANA
 * Sesuai PERANCANGAN.md: Website mengakses data melalui RESTful API Backend Laravel saja
 * Website hanya untuk Admin, Petugas BPBD, dan Operator Desa
 */

class BencanaAPIClient {
    // Konfigurasi REST API Backend Laravel (Updated with BMKG Integration)
    private $apiBaseUrl = "http://127.0.0.1:8000/api";
    private $apiTimeout = 30;
    private $lastError = null;

    public function __construct() {
        // Tidak ada koneksi database langsung
        // Semua data melalui REST API Backend Laravel
    }

    /**
     * HTTP Request ke REST API Backend Laravel
     * Sesuai PERANCANGAN.md: Website mengakses data melalui RESTful API Backend Laravel
     */
    public function apiRequest($endpoint, $method = 'GET', $data = null, $token = null) {
        // Remove 'api/' prefix if already present to avoid duplication
        $endpoint = preg_replace('/^api\//', '', $endpoint);
        $url = $this->apiBaseUrl . '/' . $endpoint;

        // Debug logging
        error_log("=== API REQUEST ===");
        error_log("Endpoint: " . $endpoint);
        error_log("Method: " . $method);
        error_log("Full URL: " . $url);
        error_log("Token Available: " . ($token ? "YES (" . strlen($token) . " chars)" : "NO"));
        error_log("Token Preview: " . ($token ? substr($token, 0, 20) . "..." : "N/A"));

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-Requested-With: XMLHttpRequest',
            'User-Agent: Disaster-Monitoring-System/1.0'
        ];

        if ($token) {
            // For mock tokens, we'll modify the approach
            if (strpos($token, 'mock_token') === 0) {
                error_log("Using mock token - adjusting headers for development");
                // For mock tokens, we'll use a different approach or skip auth
                $headers[] = 'X-Mock-Auth: Bearer ' . $token;
                $headers[] = 'X-Dev-Mode: true';
            } else {
                $authHeader = 'Authorization: Bearer ' . $token;
                $headers[] = $authHeader;
                error_log("Auth Header Added: " . substr($authHeader, 0, 40) . "...");
            }
        } else {
            error_log("WARNING: No token provided for API request!");
        }

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => $this->apiTimeout,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        // Debug response logging
        error_log("HTTP Status: " . $httpCode);
        error_log("CURL Error: " . ($error ? $error : "NONE"));
        error_log("Raw Response: " . $response);

        if ($error) {
            $this->lastError = "CURL Error: " . $error;
            error_log("API REQUEST FAILED: " . $this->lastError);
            throw new Exception($this->lastError);
        }

        $responseData = json_decode($response, true);
        error_log("Parsed Response: " . json_encode($responseData));

        if ($httpCode >= 400) {
            $message = 'API Error';
            if (isset($responseData['message'])) {
                $message = $responseData['message'];
            } elseif (isset($responseData['error'])) {
                $message = $responseData['error'];
            }
            $this->lastError = $message;
            error_log("API ERROR (HTTP $httpCode): " . $message);
            throw new Exception($message);
        }

        error_log("=== API REQUEST SUCCESS ===");
        return $responseData;
    }

    /**
     * Auth endpoints untuk Website (Admin, Petugas BPBD, Operator Desa)
     */
    public function login($username, $password) {
        return $this->apiRequest('auth/login', 'POST', [
            'username' => $username,
            'password' => $password
        ]);
    }

    public function register($data) {
        return $this->apiRequest('auth/register', 'POST', $data);
    }

    public function getProfile($token) {
        return $this->apiRequest('auth/me', 'GET', null, $token);
    }

    public function logout($token) {
        return $this->apiRequest('auth/logout', 'POST', null, $token);
    }

    public function refreshToken($token) {
        return $this->apiRequest('auth/refresh', 'POST', null, $token);
    }

    /**
     * Laporan endpoints untuk Website
     */
    public function getLaporan($token, $params = []) {
        $query = http_build_query($params);
        $endpoint = 'laporan' . ($query ? '?' . $query : '');
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function createLaporan($token, $data) {
        return $this->apiRequest('laporan', 'POST', $data, $token);
    }

    public function getLaporanDetail($token, $id) {
        return $this->apiRequest("laporan/$id", 'GET', null, $token);
    }

    public function updateLaporan($token, $id, $data) {
        return $this->apiRequest("laporan/$id", 'PUT', $data, $token);
    }

    public function deleteLaporan($token, $id) {
        return $this->apiRequest("laporan/$id", 'DELETE', null, $token);
    }

    public function getLaporanStatistics($token) {
        return $this->apiRequest('laporan/statistics', 'GET', null, $token);
    }

    /**
     * Tindak Lanjut endpoints untuk Website
     */
    public function getTindaklanjut($token, $params = []) {
        $query = http_build_query($params);
        $endpoint = 'tindak-lanjut' . ($query ? '?' . $query : '');
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function createTindaklanjut($token, $data) {
        return $this->apiRequest('tindak-lanjut', 'POST', $data, $token);
    }

    public function getTindaklanjutDetail($token, $id) {
        return $this->apiRequest("tindak-lanjut/$id", 'GET', null, $token);
    }

    public function updateTindaklanjut($token, $id, $data) {
        return $this->apiRequest("tindak-lanjut/$id", 'PUT', $data, $token);
    }

    public function deleteTindaklanjut($token, $id) {
        return $this->apiRequest("tindak-lanjut/$id", 'DELETE', null, $token);
    }

    public function getTindaklanjutStatistics($token) {
        // Endpoint statistik untuk tindaklanjut mungkin tidak tersedia, kembalikan data umum
        return $this->apiRequest('tindaklanjut', 'GET', null, $token);
    }

    /**
     * Monitoring endpoints untuk Website
     */
    public function getMonitoring($token, $params = []) {
        $query = http_build_query($params);
        $endpoint = 'monitoring' . ($query ? '?' . $query : '');
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function createMonitoring($token, $data) {
        return $this->apiRequest('monitoring', 'POST', $data, $token);
    }

    public function getMonitoringDetail($token, $id) {
        return $this->apiRequest("monitoring/$id", 'GET', null, $token);
    }

    public function updateMonitoring($token, $id, $data) {
        return $this->apiRequest("monitoring/$id", 'PUT', $data, $token);
    }

    public function deleteMonitoring($token, $id) {
        return $this->apiRequest("monitoring/$id", 'DELETE', null, $token);
    }

    public function getMonitoringByLaporan($token, $laporan_id) {
        // Gunakan filter parameter sesuai dokumentasi
        return $this->apiRequest("monitoring?id_laporan=$laporan_id", 'GET', null, $token);
    }

    public function getMonitoringStatistics($token) {
        return $this->apiRequest('monitoring/statistics', 'GET', null, $token);
    }

    /**
     * BMKG endpoints untuk Website (Updated dengan backend baru yang sudah diintegrasikan)
     */
    public function getBMKGDashboard($token) {
        return $this->apiRequest('bmkg/all', 'GET', null, $token);
    }

    public function getGempaTerbaru($token) {
        return $this->apiRequest('bmkg/earthquake/latest', 'GET', null, $token);
    }

    public function getGempaDirasakan($token) {
        return $this->apiRequest('bmkg/earthquake/felt', 'GET', null, $token);
    }

    public function getRiwayatGempa($token, $params = []) {
        return $this->getGempaDirasakan($token); // Felt earthquakes sebagai riwayat
    }

    public function getStatistikGempa($token) {
        return $this->apiRequest('bmkg/statistics', 'GET', null, $token);
    }

    public function getCekGempaKoordinat($token, $params) {
        $query = http_build_query($params);
        $endpoint = 'bmkg/earthquake/check?' . $query;
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function getPeringatanTsunami($token) {
        return $this->apiRequest('bmkg/tsunami', 'GET', null, $token);
    }

    public function getCuacaInfo($token, $province = null) {
        $query = $province ? '?provinsi=' . urlencode($province) : '';
        $endpoint = 'bmkg/weather' . $query;
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function getPeringatanCuaca($token) {
        return $this->apiRequest('bmkg/weather', 'GET', null, $token); // Weather info includes warnings
    }

    /**
     * Additional BMKG endpoints untuk backend baru
     */
    public function getBMKGDataFromDatabase($token, $type = null, $limit = 10) {
        $params = [];
        if ($type) $params['type'] = $type;
        if ($limit != 10) $params['limit'] = $limit;

        $query = http_build_query($params);
        $endpoint = 'bmkg/database' . ($query ? '?' . $query : '');
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    /**
     * Mock BMKG data untuk testing (no auth required)
     */
    public function getMockGempaTerbaru() {
        // Gunakan endpoint testing yang benar sesuai dokumentasi
        $result = $this->apiRequest('bmkg-test/earthquake/latest', 'GET');
        return $result;
    }

    public function getMockAllBMKGData() {
        // Gunakan endpoint testing yang benar sesuai dokumentasi
        $result = $this->apiRequest('bmkg-test/all', 'GET');
        return $result;
    }


    /**
     * Master Data endpoints untuk Website
     */
    public function getDesa($token, $params = []) {
        $query = http_build_query($params);
        $endpoint = 'desa' . ($query ? '?' . $query : '');
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function createDesa($token, $data) {
        return $this->apiRequest('desa', 'POST', $data, $token);
    }

    public function updateDesa($token, $id, $data) {
        return $this->apiRequest("desa/$id", 'PUT', $data, $token);
    }

    public function deleteDesa($token, $id) {
        return $this->apiRequest("desa/$id", 'DELETE', null, $token);
    }

    public function getDesaStatistics($token) {
        // Endpoint statistik untuk desa mungkin tidak tersedia, kembalikan data umum
        return $this->apiRequest('desa', 'GET', null, $token);
    }

    public function getKecamatan($token) {
        // Gunakan endpoint yang sesuai dengan struktur data
        return $this->apiRequest('desa?jenis=kecamatan', 'GET', null, $token);
    }

    public function getKabupaten($token) {
        // Gunakan endpoint yang sesuai dengan struktur data
        return $this->apiRequest('desa?jenis=kabupaten', 'GET', null, $token);
    }

    public function getKategoriBencana($token, $params = []) {
        $query = http_build_query($params);
        $endpoint = 'kategori' . ($query ? '?' . $query : '');
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function createKategoriBencana($token, $data) {
        return $this->apiRequest('kategori', 'POST', $data, $token);
    }

    public function updateKategoriBencana($token, $id, $data) {
        return $this->apiRequest("kategori/$id", 'PUT', $data, $token);
    }

    public function deleteKategoriBencana($token, $id) {
        return $this->apiRequest("kategori/$id", 'DELETE', null, $token);
    }

    public function getKategoriBencanaStatistics($token) {
        return $this->apiRequest('kategori/statistics', 'GET', null, $token);
    }

    /**
     * Utility methods
     */
    public function getApiBaseUrl() {
        return $this->apiBaseUrl;
    }

    public function validateToken($token) {
        try {
            $response = $this->getProfile($token);
            return $response['success'] ?? false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Role validation sesuai PERANCANGAN.md
     * Website hanya untuk: Admin, Petugas BPBD, Operator Desa
     */
    public function isValidWebRole($role) {
        $validRoles = ['Admin', 'PetugasBPBD', 'OperatorDesa'];
        return in_array($role, $validRoles);
    }

    /**
     * Session management untuk API token
     */
    public function storeApiToken($token) {
        $_SESSION['bencana_api_token'] = $token;
        $_SESSION['bencana_api_login_time'] = time();
    }

    public function getApiToken() {
        return $_SESSION['bencana_api_token'] ?? null;
    }

    public function getStoredApiToken() {
        return $this->getApiToken();
    }

    public function clearApiToken() {
        unset($_SESSION['bencana_api_token']);
        unset($_SESSION['bencana_api_login_time']);
    }

    public function isApiTokenExpired() {
        $loginTime = $_SESSION['bencana_api_login_time'] ?? 0;
        $maxAge = 8 * 3600; // 8 jam

        return (time() - $loginTime) > $maxAge;
    }

    public function getLastError() {
        return $this->lastError;
    }

    /**
     * API Status check
     */
    public function getApiStatus($token = null) {
        try {
            return $this->apiRequest('test', 'GET', null, $token);
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'API Unreachable: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Dashboard endpoints untuk Website - menggunakan existing Laravel API endpoints
     * Ditambahkan console logging untuk debugging
     */
    public function getLaporanStats($token) {
        $result = $this->apiRequest('laporan/statistics', 'GET', null, $token);
        $this->logToConsole('Laporan Statistics', $result);
        return $result;
    }

    public function getUserStats($token) {
        // Get user statistics from existing endpoints
        $usersResponse = $this->apiRequest('admin/users', 'GET', null, $token);

        $stats = [
            'total' => $usersResponse['success'] ? count($usersResponse['data'] ?? []) : 0,
            'aktif' => $usersResponse['success'] ? count(array_filter($usersResponse['data'] ?? [], function($user) {
                return isset($user['status']) && $user['status'] === 'active';
            })) : 0
        ];
        return $stats;
    }

    public function getRecentMonitoring($token, $limit = 10) {
        // Get recent monitoring data
        $monitoringResponse = $this->apiRequest("monitoring?limit=$limit", 'GET', null, $token);
        return [
            'success' => $monitoringResponse['success'] ?? false,
            'monitoring' => $monitoringResponse['data'] ?? []
        ];
    }

    public function getLatestBMKG($token) {
        // Get BMKG dashboard data
        $result = $this->apiRequest('bmkg/dashboard', 'GET', null, $token);
        $this->logToConsole('Latest BMKG', $result);
        return $result;
    }

    public function getPendingLaporan($token) {
        // Get laporan with status 'Masuk' (new enum value based on our documentation)
        $result = $this->apiRequest('laporan?status=Masuk', 'GET', null, $token);
        $this->logToConsole('Pending Laporan', $result);
        return $result;
    }

    public function getBMKGWarnings($token) {
        // Get BMKG tsunami warnings
        $result = $this->apiRequest('bmkg/tsunami', 'GET', null, $token);
        $this->logToConsole('BMKG Warnings', $result);
        return $result;
    }

    /**
     * Additional endpoints untuk dashboard statistics
     */
    public function getBMKGStatistics($token) {
        $result = $this->apiRequest('bmkg/statistics', 'GET', null, $token);
        $this->logToConsole('BMKG Statistics', $result);
        return $result;
    }

    // getDesaStatistics already exists at line 301
// getKategoriBencanaStatistics already exists at line 334

    // getMonitoringStatistics already exists at line 204
// getRiwayatTindakanStatistics - new method
    public function getRiwayatTindakanStatistics($token) {
        $result = $this->apiRequest('riwayat-tindakan/statistics', 'GET', null, $token);
        $this->logToConsole('Riwayat Tindakan Statistics', $result);
        return $result;
    }

// getTindakLanjutStatistics - already handled by getTindaklanjutStatistics at line 169

    public function getDesaLaporan($token, $userId) {
        // Get user's own reports (Operator Desa can see their desa reports)
        // First try to get reports with desa ID if available in session
        try {
            $result = $this->apiRequest('laporan', 'GET', null, $token);
            $this->logToConsole("Desa Laporan for User", $result);
            return $result;
        } catch (Exception $e) {
            // Fallback if specific endpoint doesn't exist
            $result = $this->apiRequest('laporan', 'GET', null, $token);
            $this->logToConsole("Desa Laporan (Fallback) for User", $result);
            return $result;
        }
    }

    public function getPendingMonitoring($token) {
        // Get monitoring data that needs attention
        $monitoringResponse = $this->apiRequest('monitoring', 'GET', null, $token);
        $this->logToConsole('All Monitoring Response', $monitoringResponse);

        if ($monitoringResponse['success']) {
            // Filter monitoring that needs attention
            $pending = array_filter($monitoringResponse['data'] ?? [], function($monitoring) {
                return isset($monitoring['status']) && in_array($monitoring['status'], ['pending', 'menunggu']);
            });
            $result = [
                'success' => true,
                'data' => array_values($pending)
            ];
        } else {
            $result = $monitoringResponse;
        }

        $this->logToConsole('Pending Monitoring Filtered', $result);
        return $result;
    }

    public function getLocalBMKG($token) {
        // Get local weather data
        $cuacaResponse = $this->apiRequest('bmkg/cuaca', 'GET', null, $token);
        $warningsResponse = $this->apiRequest('bmkg/cuaca/peringatan', 'GET', null, $token);

        $this->logToConsole('Cuaca Response', $cuacaResponse);
        $this->logToConsole('Warnings Response', $warningsResponse);

        $result = [
            'success' => ($cuacaResponse['success'] ?? false) && ($warningsResponse['success'] ?? false),
            'cuaca' => $cuacaResponse['data'] ?? [],
            'warnings' => $warningsResponse['data'] ?? [],
            'icon' => 'fa-cloud-sun',
            'color' => 'warning',
            'description' => 'Data cuaca lokal',
            'temperature' => '28',
            'humidity' => '75',
            'wind' => '10',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->logToConsole('Local BMKG Result', $result);
        return $result;
    }

    /**
     * Additional methods for dashboard data
     */

    /**
     * Extract data from API response dengan fallback untuk berbagai format
     */
    private function extractData($response, $fallbackKey = null) {
        // Handle standard Laravel API response format
        if (isset($response['data'])) {
            // If the data is a paginated response, return the 'data' array from it
            if (isset($response['data']['data']) && is_array($response['data']['data'])) {
                return $response['data']['data'];
            }
            return $response['data'];
        }

        // Handle alternative response formats
        $possibleKeys = ['laporan', 'monitoring', 'users', 'warnings', 'cuaca', 'gempa'];
        if ($fallbackKey && isset($response[$fallbackKey])) {
            return $response[$fallbackKey];
        }

        foreach ($possibleKeys as $key) {
            if (isset($response[$key])) {
                return $response[$key];
            }
        }

        // Handle direct array response (no wrapper)
        if (is_array($response) && !isset($response['success']) && !isset($response['message'])) {
            return $response;
        }

        // Handle success flag with embedded data
        if (isset($response['success']) && $response['success'] && is_array($response)) {
            unset($response['success']);
            unset($response['message']);
            if (count($response) > 0) {
                return reset($response);
            }
        }

        return [];
    }

    /**
     * Extract statistics dari API response
     */
    private function extractStats($response, $default = []) {
        if (isset($response['data']) && is_array($response['data'])) {
            return $response['data'];
        }

        if (isset($response['total']) || isset($response['menunggu']) || isset($response['diproses']) || isset($response['selesai'])) {
            return $response;
        }

        return $default;
    }

    /**
     * User Management endpoints untuk Website
     */
    public function getUsers($token, $params = []) {
        $query = http_build_query($params);
        $endpoint = 'users' . ($query ? '?' . $query : '');
        $result = $this->apiRequest($endpoint, 'GET', null, $token);
        $this->logToConsole('Get Users', $result);
        return $result;
    }

    public function getUserStatistics($token) {
        $result = $this->apiRequest('users/statistics', 'GET', null, $token);
        $this->logToConsole('User Statistics', $result);
        return $result;
    }

    public function getUserDetail($token, $id) {
        $result = $this->apiRequest("users/{$id}", 'GET', null, $token);
        $this->logToConsole("Get User Detail (ID: {$id})", $result);
        return $result;
    }

    public function updateUser($token, $id, $data) {
        $result = $this->apiRequest("users/{$id}", 'PUT', $data, $token);
        $this->logToConsole("Update User (ID: {$id})", $result);
        return $result;
    }

    public function deleteUser($token, $id) {
        $result = $this->apiRequest("users/{$id}", 'DELETE', null, $token);
        $this->logToConsole("Delete User (ID: {$id})", $result);
        return $result;
    }

    /**
     * Log to console for debugging API calls
     */
    private function logToConsole($label, $data) {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'label' => $label,
            'data' => $data
        ];

        // Log to file
        $logFile = __DIR__ . '/../logs/api_debug.log';
        $logDir = dirname($logFile);

        // Create logs directory if it doesn't exist
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $logEntry = json_encode($logData) . "\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

        // Also log to PHP error log for easier access
        error_log("API DEBUG [$label]: " . json_encode($data));
    }

    /**
     * Get API debug logs (for admin debugging)
     */
    public function getAPIDebugLogs($limit = 50) {
        $logFile = __DIR__ . '/../logs/api_debug.log';
        if (!file_exists($logFile)) {
            return [];
        }

        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logs = [];

        // Get last $limit lines and reverse order (newest first)
        $recentLines = array_slice(array_reverse($lines), 0, $limit);

        foreach ($recentLines as $line) {
            $decoded = json_decode($line, true);
            if ($decoded !== null) {
                $logs[] = $decoded;
            }
        }

        return $logs;
    }
}

/**
 * Helper function untuk global access
 */
function getAPIClient() {
    static $client = null;
    if ($client === null) {
        $client = new BencanaAPIClient();
    }
    return $client;
}

/**
 * Helper function untuk membuat mock token
 */
function createMockToken($userId, $username) {
    return 'mock_token_' . $userId . '_' . time() . '_' . md5($username . time());
}

/**
 * Helper function untuk memeriksa apakah token valid
 */
function isValidToken($token) {
    return !empty($token) && (strpos($token, 'mock_token') === 0 || strlen($token) > 10);
}

/**
 * Helper function untuk sanitasi input
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Helper function untuk mendapatkan stored API token (backward compatibility)
 */
function getStoredApiToken() {
    $apiClient = getAPIClient();
    return $apiClient->getApiToken();
}
?>