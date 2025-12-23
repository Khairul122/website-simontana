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
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    /**
     * Ambil semua pengguna
     */
    public function getAll()
    {
        $url = $this->apiEndpoint;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil pengguna berdasarkan ID
     */
    public function getById($id)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Buat pengguna baru
     */
    public function create($data)
    {
        $url = $this->apiEndpoint;
        $headers = $this->getHeaders();

        return apiRequest($url, 'POST', $data, $headers);
    }

    /**
     * Update pengguna
     */
    public function update($id, $data)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'PUT', $data, $headers);
    }

    /**
     * Hapus pengguna
     */
    public function delete($id)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'DELETE', null, $headers);
    }
}