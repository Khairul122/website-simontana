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
        $url = $this->apiBaseUrl . '/' . ltrim($endpoint, '/');

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-Requested-With: XMLHttpRequest'
        ];

        if ($token) {
            $headers[] = 'Authorization: Bearer ' . $token;
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

        if ($error) {
            $this->lastError = "CURL Error: " . $error;
            throw new Exception($this->lastError);
        }

        $responseData = json_decode($response, true);

        if ($httpCode >= 400) {
            $message = 'API Error';
            if (isset($responseData['message'])) {
                $message = $responseData['message'];
            } elseif (isset($responseData['error'])) {
                $message = $responseData['error'];
            }
            $this->lastError = $message;
            throw new Exception($message);
        }

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
        return $this->apiRequest('auth/profile', 'GET', null, $token);
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
        $endpoint = 'tindaklanjut' . ($query ? '?' . $query : '');
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function createTindaklanjut($token, $data) {
        return $this->apiRequest('tindaklanjut', 'POST', $data, $token);
    }

    public function getTindaklanjutDetail($token, $id) {
        return $this->apiRequest("tindaklanjut/$id", 'GET', null, $token);
    }

    public function updateTindaklanjut($token, $id, $data) {
        return $this->apiRequest("tindaklanjut/$id", 'PUT', $data, $token);
    }

    public function deleteTindaklanjut($token, $id) {
        return $this->apiRequest("tindaklanjut/$id", 'DELETE', null, $token);
    }

    public function getTindaklanjutStatistics($token) {
        return $this->apiRequest('tindaklanjut/statistics', 'GET', null, $token);
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
        return $this->apiRequest("monitoring/laporan/$laporan_id", 'GET', null, $token);
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
        $query = $province ? '?province=' . urlencode($province) : '';
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
        $url = $this->apiBaseUrl . '/../bmkg-test/earthquake/latest';
        return $this->makeApiCall($url);
    }

    public function getMockAllBMKGData() {
        $url = $this->apiBaseUrl . '/../bmkg-test/all';
        return $this->makeApiCall($url);
    }

    /**
     * Generic API call untuk mock data
     */
    private function makeApiCall($url) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'X-Requested-With: XMLHttpRequest'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => $this->apiTimeout,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("CURL Error: " . $error);
        }

        $responseData = json_decode($response, true);
        if ($httpCode >= 400) {
            throw new Exception('API Error: ' . ($responseData['message'] ?? 'Unknown error'));
        }

        return $responseData;
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
        return $this->apiRequest('desa-statistics', 'GET', null, $token);
    }

    public function getKecamatan($token) {
        return $this->apiRequest('desa-list/kecamatan', 'GET', null, $token);
    }

    public function getKabupaten($token) {
        return $this->apiRequest('desa-list/kabupaten', 'GET', null, $token);
    }

    public function getKategoriBencana($token, $params = []) {
        $query = http_build_query($params);
        $endpoint = 'kategori-bencana' . ($query ? '?' . $query : '');
        return $this->apiRequest($endpoint, 'GET', null, $token);
    }

    public function createKategoriBencana($token, $data) {
        return $this->apiRequest('kategori-bencana', 'POST', $data, $token);
    }

    public function updateKategoriBencana($token, $id, $data) {
        return $this->apiRequest("kategori-bencana/$id", 'PUT', $data, $token);
    }

    public function deleteKategoriBencana($token, $id) {
        return $this->apiRequest("kategori-bencana/$id", 'DELETE', null, $token);
    }

    public function getKategoriBencanaStatistics($token) {
        return $this->apiRequest('kategori-bencana-statistics', 'GET', null, $token);
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
        $this->logToConsole('Laporan Stats', $result);
        return $result;
    }

    public function getUserStats($token) {
        // Get user statistics from existing endpoints
        $usersResponse = $this->apiRequest('admin/users', 'GET', null, $token);
        $this->logToConsole('Admin Users Response', $usersResponse);

        $stats = [
            'total' => $usersResponse['success'] ? count($usersResponse['data'] ?? []) : 0,
            'aktif' => $usersResponse['success'] ? count(array_filter($usersResponse['data'] ?? [], function($user) {
                return isset($user['status']) && $user['status'] === 'active';
            })) : 0
        ];

        $this->logToConsole('User Stats Calculated', $stats);
        return $stats;
    }

    public function getRecentMonitoring($token, $limit = 10) {
        // Get recent monitoring data
        $monitoringResponse = $this->apiRequest("monitoring?limit=$limit", 'GET', null, $token);
        $result = [
            'success' => $monitoringResponse['success'] ?? false,
            'monitoring' => $monitoringResponse['data'] ?? []
        ];
        $this->logToConsole('Recent Monitoring', $result);
        return $result;
    }

    public function getLatestBMKG($token) {
        // Get BMKG dashboard data
        $result = $this->apiRequest('bmkg/dashboard', 'GET', null, $token);
        $this->logToConsole('Latest BMKG', $result);
        return $result;
    }

    public function getPendingLaporan($token) {
        // Get laporan with status 'menunggu'
        $result = $this->apiRequest('laporan?status=menunggu', 'GET', null, $token);
        $this->logToConsole('Pending Laporan', $result);
        return $result;
    }

    public function getBMKGWarnings($token) {
        // Get BMKG weather warnings
        $result = $this->apiRequest('bmkg/cuaca/peringatan', 'GET', null, $token);
        $this->logToConsole('BMKG Warnings', $result);
        return $result;
    }

    public function getDesaLaporan($token, $userId) {
        // Get user's own reports (Operator Desa can see their desa reports)
        $result = $this->apiRequest('my-reports', 'GET', null, $token);
        $this->logToConsole("Desa Laporan for User $userId", $result);
        return $result;
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
    public function getDashboardOverview($token) {
        // Get dashboard overview using existing endpoint
        $result = $this->apiRequest('dashboard', 'GET', null, $token);
        $this->logToConsole('Dashboard Overview', $result);
        return $result;
    }

    public function getAdminUsers($token) {
        // Get admin users management
        $result = $this->apiRequest('admin/users', 'GET', null, $token);
        $this->logToConsole('Admin Users', $result);
        return $result;
    }

    public function getBPBDReports($token) {
        // Get BPBD reports
        $result = $this->apiRequest('bpbd/reports', 'GET', null, $token);
        $this->logToConsole('BPBD Reports', $result);
        return $result;
    }

    public function getOperatorReports($token) {
        // Get operator village reports
        $result = $this->apiRequest('operator/reports', 'GET', null, $token);
        $this->logToConsole('Operator Reports', $result);
        return $result;
    }

    /**
     * Extract data from API response dengan fallback untuk berbagai format
     */
    private function extractData($response, $fallbackKey = null) {
        // Handle standard Laravel API response format
        if (isset($response['data'])) {
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
?>