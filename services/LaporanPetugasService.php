<?php

// Require konfigurasi dan service otentikasi
require_once __DIR__ . '/../config/koneksi.php';

class LaporanPetugasService
{
    private $apiEndpoint;

    public function __construct()
    {
        // Gabungkan konstanta global + endpoint spesifik
        $this->apiEndpoint = API_LAPORANS;
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
     * Ambil semua laporan bencana untuk petugas
     */
    public function getAll($filters = [])
    {
        $url = $this->apiEndpoint;

        // Add query parameters if filters are provided
        if (!empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }

        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil laporan bencana berdasarkan ID
     */
    public function getById($id)
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Update status laporan bencana
     */
    public function updateStatus($id, $data)
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'PUT', $data, $headers);
    }

    /**
     * Update status laporan ke "Diproses"
     */
    public function updateToProses($id, $data = [])
    {
        $url = buildApiUrlLaporansProsesById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'POST', $data, $headers);
    }

    /**
     * Update status laporan ke "Selesai"
     */
    public function updateToSelesai($id, $data = [])
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        // Data untuk mengubah status menjadi Selesai
        $updateData = array_merge([
            'status' => 'Selesai'
        ], $data);

        return apiRequest($url, 'PUT', $updateData, $headers);
    }

    /**
     * Update status laporan ke "Ditolak"
     */
    public function updateToDitolak($id, $data = [])
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        // Data untuk mengubah status menjadi Ditolak
        $updateData = array_merge([
            'status' => 'Ditolak'
        ], $data);

        return apiRequest($url, 'PUT', $updateData, $headers);
    }

    /**
     * Tambahkan tindak lanjut untuk laporan
     */
    public function addTindakLanjut($id, $data)
    {
        $url = buildApiUrlLaporansById($id);
        $headers = $this->getHeaders();

        // Data untuk tindak lanjut
        $updateData = array_merge([
            'status' => 'Tindak Lanjut'
        ], $data);

        return apiRequest($url, 'PUT', $updateData, $headers);
    }

    /**
     * Tambahkan monitoring untuk laporan
     */
    public function addMonitoring($id, $data)
    {
        $url = buildApiUrlLaporansRiwayatById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'POST', $data, $headers);
    }
}