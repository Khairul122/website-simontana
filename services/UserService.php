<?php

// Require konfigurasi dan service otentikasi
require_once dirname(__DIR__) . '/config/koneksi.php';

class UserService
{
    private $apiEndpoint;

    public function __construct()
    {
        // Gabungkan konstanta global + endpoint spesifik
        $this->apiEndpoint = API_BASE_URL . '/users';
    }

    /**
     * Mendapatkan headers otentikasi
     */
    private function getHeaders()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_SESSION['token'] ?? null;

        // Return null if no token is found to prevent unauthorized requests
        if (!$token) {
            return null;
        }

        return getAuthHeaders($token);
    }

    /**
     * Ambil semua pengguna
     */
    public function getAll()
    {
        $headers = $this->getHeaders();

        // Return error response if no headers (no token)
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint;
        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil pengguna berdasarkan ID
     */
    public function getById($id)
    {
        $headers = $this->getHeaders();

        // Return error response if no headers (no token)
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Buat pengguna baru
     */
    public function create($data)
    {
        $headers = $this->getHeaders();

        // Return error response if no headers (no token)
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint;
        return apiRequest($url, 'POST', $data, $headers);
    }

    /**
     * Update pengguna
     */
    public function update($id, $data)
    {
        $headers = $this->getHeaders();

        // Return error response if no headers (no token)
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'PUT', $data, $headers);
    }

    /**
     * Hapus pengguna
     */
    public function delete($id)
    {
        $headers = $this->getHeaders();

        // Return error response if no headers (no token)
        if (!$headers) {
            return [
                'success' => false,
                'message' => 'Sesi login habis. Silakan login kembali.',
                'http_code' => 401
            ];
        }

        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'DELETE', null, $headers);
    }
}