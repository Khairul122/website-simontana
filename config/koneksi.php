<?php
/**
 * Konfigurasi Koneksi REST API Client untuk SIMONTA BENCANA
 * File ini mengatur koneksi antara Web Frontend (PHP Native) dengan Backend Laravel API
 */

// Konfigurasi Base URL Backend API
define('BASE_API_URL', 'http://localhost:8000/api');

// Konfigurasi Headers untuk API requests
define('API_HEADERS', [
    'Content-Type: application/json',
    'Accept: application/json'
]);

/**
 * Class BencanaAPIClient
 * API Client untuk berkomunikasi dengan Backend Laravel SIMONTA BENCANA
 */
class BencanaAPIClient {
    private $baseUrl;
    private $token;
    private $lastResponse;

    public function __construct($baseUrl = BASE_API_URL) {
        $this->baseUrl = $baseUrl;
        $this->token = $this->getStoredToken();
    }

    /**
     * Mendapatkan token yang tersimpan di session
     */
    private function getStoredToken() {
        return $_SESSION['jwt_token'] ?? null;
    }

    /**
     * Menyimpan token ke session
     */
    public function setToken($token) {
        $_SESSION['jwt_token'] = $token;
        $_SESSION['user_data'] = $this->parseToken($token);
        $this->token = $token;
    }

    /**
     * Menghapus token dari session (logout)
     */
    public function clearToken() {
        unset($_SESSION['jwt_token']);
        unset($_SESSION['user_data']);
        $this->token = null;
    }

    /**
     * Parse JWT token untuk mendapatkan user data
     */
    private function parseToken($token) {
        try {
            $parts = explode('.', $token);
            if (count($parts) !== 3) return null;

            $payload = json_decode(base64_decode($parts[1]), true);
            return $payload ?? null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Mendapatkan user data dari session
     */
    public function getCurrentUser() {
        return $_SESSION['user_data'] ?? null;
    }

    /**
     * Mendapatkan role user saat ini
     */
    public function getCurrentRole() {
        $userData = $this->getCurrentUser();
        return $userData['role'] ?? null;
    }

    /**
     * Melakukan HTTP request ke API
     */
    private function request($method, $endpoint, $data = null) {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');

        $headers = API_HEADERS;
        if ($this->token) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]);

        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        $this->lastResponse = [
            'status_code' => $httpCode,
            'response' => $response,
            'error' => $error
        ];

        if ($error) {
            throw new Exception("Curl Error: " . $error);
        }

        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON response");
        }

        return $responseData;
    }

    /**
     * GET request
     */
    public function get($endpoint, $params = []) {
        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }
        return $this->request('GET', $endpoint);
    }

    /**
     * POST request
     */
    public function post($endpoint, $data = []) {
        return $this->request('POST', $endpoint, $data);
    }

    /**
     * PUT request
     */
    public function put($endpoint, $data = []) {
        return $this->request('PUT', $endpoint, $data);
    }

    /**
     * DELETE request
     */
    public function delete($endpoint) {
        return $this->request('DELETE', $endpoint);
    }

    /**
     * Mendapatkan last response untuk debugging
     */
    public function getLastResponse() {
        return $this->lastResponse;
    }

    // ==================== AUTHENTICATION METHODS ====================

    /**
     * Login user
     */
    public function login($username, $password) {
        return $this->post('auth/login', [
            'username' => $username,
            'password' => $password
        ]);
    }

    /**
     * Register user baru
     */
    public function register($userData) {
        return $this->post('auth/register', $userData);
    }

    /**
     * Logout user
     */
    public function logout() {
        try {
            $response = $this->post('auth/logout');
            $this->clearToken();
            return $response;
        } catch (Exception $e) {
            $this->clearToken();
            return ['success' => true, 'message' => 'Logged out'];
        }
    }

    /**
     * Refresh token
     */
    public function refreshToken() {
        return $this->post('auth/refresh');
    }

    /**
     * Get current user profile
     */
    public function getProfile() {
        return $this->get('auth/profile');
    }

    // ==================== LAPORAN METHODS ====================

    /**
     * Get semua laporan
     */
    public function getLaporan($params = []) {
        return $this->get('laporan', $params);
    }

    /**
     * Get laporan by ID
     */
    public function getLaporanById($id) {
        return $this->get("laporan/{$id}");
    }

    /**
     * Buat laporan baru
     */
    public function createLaporan($data) {
        return $this->post('laporan', $data);
    }

    /**
     * Update laporan
     */
    public function updateLaporan($id, $data) {
        return $this->put("laporan/{$id}", $data);
    }

    /**
     * Delete laporan
     */
    public function deleteLaporan($id) {
        return $this->delete("laporan/{$id}");
    }

    /**
     * Verifikasi laporan
     */
    public function verifikasiLaporan($id) {
        return $this->post("laporan/{$id}/verifikasi");
    }

    /**
     * Proses laporan
     */
    public function prosesLaporan($id, $data) {
        return $this->post("laporan/{$id}/proses", $data);
    }

    /**
     * Get statistik laporan
     */
    public function getStatistikLaporan() {
        return $this->get('laporan/statistik');
    }

    // ==================== TINDAK LANJUT METHODS ====================

    public function getTindakLanjut($params = []) {
        return $this->get('tindak-lanjut', $params);
    }

    public function getTindakLanjutById($id) {
        return $this->get("tindak-lanjut/{$id}");
    }

    public function createTindakLanjut($data) {
        return $this->post('tindak-lanjut', $data);
    }

    public function updateTindakLanjut($id, $data) {
        return $this->put("tindak-lanjut/{$id}", $data);
    }

    public function deleteTindakLanjut($id) {
        return $this->delete("tindak-lanjut/{$id}");
    }

    // ==================== MONITORING METHODS ====================

    public function getMonitoring($params = []) {
        return $this->get('monitoring', $params);
    }

    public function getMonitoringById($id) {
        return $this->get("monitoring/{$id}");
    }

    public function createMonitoring($data) {
        return $this->post('monitoring', $data);
    }

    public function updateMonitoring($id, $data) {
        return $this->put("monitoring/{$id}", $data);
    }

    public function deleteMonitoring($id) {
        return $this->delete("monitoring/{$id}");
    }

    // ==================== RIWAYAT TINDAKAN METHODS ====================

    public function getRiwayatTindakan($params = []) {
        return $this->get('riwayat-tindakan', $params);
    }

    public function getRiwayatTindakanById($id) {
        return $this->get("riwayat-tindakan/{$id}");
    }

    public function createRiwayatTindakan($data) {
        return $this->post('riwayat-tindakan', $data);
    }

    // ==================== BMKG METHODS ====================

    /**
     * Get data gempa terkini dari BMKG
     */
    public function getGempaTerkinini() {
        return $this->get('bmkg/gempa/terkini');
    }

    /**
     * Get prakiraan cuaca
     */
    public function getPrakiraanCuaca($params = []) {
        return $this->get('bmkg/prakiraan-cuaca', $params);
    }

    /**
     * Sync prakiraan cuaca
     */
    public function syncPrakiraanCuaca($params = []) {
        return $this->post('bmkg/sync-prakiraan-cuaca', $params);
    }

    /**
     * Get peringatan dini
     */
    public function getPeringatanDini() {
        return $this->get('bmkg/peringatan-dini');
    }

    /**
     * Get detail peringatan
     */
    public function getDetailPeringatan($alertCode) {
        return $this->get("bmkg/detail-peringatan/{$alertCode}");
    }

    /**
     * Sync peringatan dini
     */
    public function syncPeringatanDini() {
        return $this->post('bmkg/sync-peringatan-dini');
    }

    // ==================== MASTER DATA METHODS ====================

    /**
     * Get kategori bencana
     */
    public function getKategoriBencana() {
        return $this->get('kategori-bencana');
    }

    /**
     * Get provinsi
     */
    public function getProvinsi() {
        return $this->get('wilayah/provinsi');
    }

    /**
     * Get kabupaten by provinsi
     */
    public function getKabupaten($provinsiId) {
        return $this->get("wilayah/kabupaten/{$provinsiId}");
    }

    /**
     * Get kecamatan by kabupaten
     */
    public function getKecamatan($kabupatenId) {
        return $this->get("wilayah/kecamatan/{$kabupatenId}");
    }

    /**
     * Get desa by kecamatan
     */
    public function getDesa($kecamatanId) {
        return $this->get("wilayah/desa/{$kecamatanId}");
    }

    // ==================== USER MANAGEMENT ====================

    /**
     * Get semua users (untuk admin)
     */
    public function getUsers($params = []) {
        return $this->get('users', $params);
    }

    /**
     * Get user by ID
     */
    public function getUserById($id) {
        return $this->get("users/{$id}");
    }

    /**
     * Create user
     */
    public function createUser($data) {
        return $this->post('users', $data);
    }

    /**
     * Update user
     */
    public function updateUser($id, $data) {
        return $this->put("users/{$id}", $data);
    }

    /**
     * Delete user
     */
    public function deleteUser($id) {
        return $this->delete("users/{$id}");
    }
}


?>