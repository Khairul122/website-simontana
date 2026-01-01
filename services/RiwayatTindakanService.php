<?php
require_once 'config/koneksi.php';

class RiwayatTindakanService {
    private $apiEndpoint;

    public function __construct() {
        $this->apiEndpoint = API_BASE_URL . '/riwayat-tindakan';
    }

    public function getAll($filters) {
        $url = $this->apiEndpoint;
        
        // Pass filters as query params
        if (!empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }
        
        return apiRequest($url, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
    }

    public function getById($id) {
        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
    }

    public function create($data) {
        return apiRequest($this->apiEndpoint, 'POST', $data, getAuthHeaders($_SESSION['token'] ?? null));
    }

    public function update($id, $data) {
        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'PUT', $data, getAuthHeaders($_SESSION['token'] ?? null));
    }

    public function delete($id) {
        $url = $this->apiEndpoint . '/' . $id;
        return apiRequest($url, 'DELETE', null, getAuthHeaders($_SESSION['token'] ?? null));
    }

    public function getAllTindakLanjut() {
        $url = API_BASE_URL . '/tindak-lanjut';
        return apiRequest($url, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
    }
}