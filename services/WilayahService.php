<?php

require_once __DIR__ . '/../config/globals.php';

class WilayahService {
    private $apiClient;

    public function __construct() {
        $this->apiClient = globalEnv()->getAPIClient();
    }

    public function getProvinsi() {
        try {
            $response = $this->apiClient->get('wilayah/provinsi');
            return $response['data'] ?? [];
        } catch (Exception $e) {
            error_log("WilayahService - Error getting provinsi: " . $e->getMessage());
            return [];
        }
    }

    public function getKabupaten($provinsiId) {
        try {
            $response = $this->apiClient->get("wilayah/kabupaten/{$provinsiId}");
            return $response['data'] ?? [];
        } catch (Exception $e) {
            error_log("WilayahService - Error getting kabupaten: " . $e->getMessage());
            return [];
        }
    }

    public function getKecamatan($kabupatenId) {
        try {
            $response = $this->apiClient->get("wilayah/kecamatan/{$kabupatenId}");
            return $response['data'] ?? [];
        } catch (Exception $e) {
            error_log("WilayahService - Error getting kecamatan: " . $e->getMessage());
            return [];
        }
    }

    public function getDesa($kecamatanId) {
        try {
            $response = $this->apiClient->get("wilayah/desa/{$kecamatanId}");
            return $response['data'] ?? [];
        } catch (Exception $e) {
            error_log("WilayahService - Error getting desa: " . $e->getMessage());
            return [];
        }
    }
}