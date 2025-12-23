<?php

// Require konfigurasi dan service otentikasi
require_once dirname(__DIR__) . '/config/koneksi.php';

class WilayahService
{
    /**
     * Mendapatkan headers otentikasi
     */
    private function getHeaders()
    {
        $token = $_SESSION['token'] ?? null;
        return getAuthHeaders($token);
    }

    /**
     * Ambil semua provinsi
     */
    public function getAllProvinsi()
    {
        $url = API_WILAYAH_PROVINSI;
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil provinsi berdasarkan ID
     */
    public function getProvinsiById($id)
    {
        $url = buildApiUrlProvinsiById($id);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kabupaten berdasarkan ID provinsi
     */
    public function getKabupatenByProvinsi($provinsiId)
    {
        $url = buildApiUrlKabupatenByProvinsiId($provinsiId);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kecamatan berdasarkan ID kabupaten
     */
    public function getKecamatanByKabupaten($kabupatenId)
    {
        $url = buildApiUrlKecamatanByKabupatenId($kabupatenId);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil desa berdasarkan ID kecamatan
     */
    public function getDesaByKecamatan($kecamatanId)
    {
        $url = buildApiUrlDesaByKecamatanId($kecamatanId);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil detail wilayah lengkap berdasarkan ID desa
     */
    public function getWilayahDetailByDesa($desaId)
    {
        $url = buildApiUrlWilayahDetailByDesaId($desaId);
        $headers = $this->getHeaders();

        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil desa berdasarkan ID
     */
    private function getDesaById($id)
    {
        $url = buildApiUrlDesaByKecamatanId($id); // Using the correct endpoint
        $headers = $this->getHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kecamatan berdasarkan ID
     */
    private function getKecamatanById($id)
    {
        $url = API_KECAMATAN . '/' . $id; // Using the correct endpoint
        $headers = $this->getHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }

    /**
     * Ambil kabupaten berdasarkan ID
     */
    private function getKabupatenById($id)
    {
        $url = API_KABUPATEN . '/' . $id; // Using the correct endpoint
        $headers = $this->getHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }
}