<?php

// Require konfigurasi dan service otentikasi
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/AuthService.php';

class KategoriBencanaService
{
    private $apiEndpoint;

    public function __construct()
    {
        // Gabungkan konstanta global + endpoint spesifik
        $this->apiEndpoint = API_BASE_URL . '/kategori-bencana';
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
     * Ambil semua kategori bencana
     */
    public function getAll()
    {
        $url = $this->apiEndpoint;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kategori bencana berdasarkan ID
     */
    public function getById($id)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Buat kategori bencana baru
     */
    public function create($data)
    {
        $url = $this->apiEndpoint;
        $headers = $this->getHeaders();

        return apiRequest($url, 'POST', $data, $headers);
    }

    /**
     * Update kategori bencana
     */
    public function update($id, $data)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'PUT', $data, $headers);
    }

    /**
     * Hapus kategori bencana
     */
    public function delete($id)
    {
        $url = $this->apiEndpoint . '/' . $id;
        $headers = $this->getHeaders();

        return apiRequest($url, 'DELETE', null, $headers);
    }
}