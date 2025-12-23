<?php

require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/WilayahService.php';

class WilayahController
{
    private $service;

    public function __construct()
    {
        $this->service = new WilayahService();
    }

    /**
     * Ambil semua provinsi (API endpoint)
     */
    public function getAllProvinsi()
    {
        $response = $this->service->getAllProvinsi();

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil kabupaten berdasarkan provinsi (API endpoint)
     */
    public function getKabupatenByProvinsi()
    {
        $provinsiId = $_GET['provinsi_id'] ?? null;

        if (!$provinsiId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID provinsi tidak ditemukan'
            ]);
            return;
        }

        // Kita perlu mengakses endpoint wilayah yang benar
        $response = $this->service->getKabupatenByProvinsi($provinsiId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil kecamatan berdasarkan kabupaten (API endpoint)
     */
    public function getKecamatanByKabupaten()
    {
        $kabupatenId = $_GET['kabupaten_id'] ?? null;

        if (!$kabupatenId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID kabupaten tidak ditemukan'
            ]);
            return;
        }

        $response = $this->service->getKecamatanByKabupaten($kabupatenId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil desa berdasarkan kecamatan (API endpoint)
     */
    public function getDesaByKecamatan()
    {
        $kecamatanId = $_GET['kecamatan_id'] ?? null;

        if (!$kecamatanId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID kecamatan tidak ditemukan'
            ]);
            return;
        }

        $response = $this->service->getDesaByKecamatan($kecamatanId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Ambil detail wilayah lengkap berdasarkan ID desa (API endpoint)
     */
    public function getWilayahDetailByDesa()
    {
        $desaId = $_GET['desa_id'] ?? null;

        if (!$desaId) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID desa tidak ditemukan'
            ]);
            return;
        }

        $response = $this->service->getWilayahDetailByDesa($desaId);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}