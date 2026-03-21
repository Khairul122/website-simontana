<?php
require_once __DIR__ . '/../config/koneksi.php';

class BmkgService {

    public function getSummary() {
        $url = API_BASE_URL . '/bmkg';
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getGempaTerbaru() {
        $url = API_BASE_URL . '/bmkg/gempa/terbaru';
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getGempaTerkini() {
        $url = API_BASE_URL . '/bmkg/gempa/terkini';
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getGempaDirasakan() {
        $url = API_BASE_URL . '/bmkg/gempa/dirasakan';
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getPeringatanTsunami() {
        $url = API_BASE_URL . '/bmkg/peringatan-tsunami';
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getPrakiraanCuaca($wilayahId) {
        $url = API_BASE_URL . '/bmkg/prakiraan-cuaca?wilayah_id=' . urlencode($wilayahId);
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getCacheStatus() {
        $url = API_BASE_URL . '/bmkg/cache/status';
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function clearCache() {
        $url = API_BASE_URL . '/bmkg/cache/clear';
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'POST', null, $headers);
    }
}
