<?php

require_once __DIR__ . '/../services/WilayahService.php';

class WilayahController {
    private $wilayahService;

    public function __construct() {
        $this->wilayahService = new WilayahService();
    }

    public function index() {
        $this->sendJson([
            'success' => true,
            'message' => 'Wilayah endpoints available',
            'endpoints' => [
                'GET ?controller=wilayah&action=provinsi' => 'Get all provinsi',
                'GET ?controller=wilayah&action=kabupaten&id={provinsi_id}' => 'Get kabupaten by provinsi',
                'GET ?controller=wilayah&action=kecamatan&id={kabupaten_id}' => 'Get kecamatan by kabupaten',
                'GET ?controller=wilayah&action=desa&id={kecamatan_id}' => 'Get desa by kecamatan'
            ]
        ]);
    }

    public function getProvinsi() {
        try {
            $provinsi = $this->wilayahService->getProvinsi();
            $this->sendJson([
                'success' => true,
                'message' => 'Data provinsi berhasil diambil',
                'data' => $provinsi
            ]);
        } catch (Exception $e) {
            $this->sendJson([
                'success' => false,
                'message' => 'Gagal mengambil data provinsi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getKabupaten() {
        $provinsiId = $_GET['id'] ?? null;

        if (!$provinsiId) {
            $this->sendJson([
                'success' => false,
                'message' => 'Provinsi ID diperlukan'
            ], 400);
            return;
        }

        try {
            $kabupaten = $this->wilayahService->getKabupaten($provinsiId);
            $this->sendJson([
                'success' => true,
                'message' => 'Data kabupaten berhasil diambil',
                'data' => $kabupaten
            ]);
        } catch (Exception $e) {
            $this->sendJson([
                'success' => false,
                'message' => 'Gagal mengambil data kabupaten',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getKecamatan() {
        $kabupatenId = $_GET['id'] ?? null;

        if (!$kabupatenId) {
            $this->sendJson([
                'success' => false,
                'message' => 'Kabupaten ID diperlukan'
            ], 400);
            return;
        }

        try {
            $kecamatan = $this->wilayahService->getKecamatan($kabupatenId);
            $this->sendJson([
                'success' => true,
                'message' => 'Data kecamatan berhasil diambil',
                'data' => $kecamatan
            ]);
        } catch (Exception $e) {
            $this->sendJson([
                'success' => false,
                'message' => 'Gagal mengambil data kecamatan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDesa() {
        $kecamatanId = $_GET['id'] ?? null;

        if (!$kecamatanId) {
            $this->sendJson([
                'success' => false,
                'message' => 'Kecamatan ID diperlukan'
            ], 400);
            return;
        }

        try {
            $desa = $this->wilayahService->getDesa($kecamatanId);
            $this->sendJson([
                'success' => true,
                'message' => 'Data desa berhasil diambil',
                'data' => $desa
            ]);
        } catch (Exception $e) {
            $this->sendJson([
                'success' => false,
                'message' => 'Gagal mengambil data desa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function sendJson($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}