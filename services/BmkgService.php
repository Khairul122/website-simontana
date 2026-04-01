<?php
require_once __DIR__ . '/../config/koneksi.php';

class BmkgService {

    public function getSummary() {
        $url = API_BMKG;
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getGempaTerbaru() {
        $url = API_BMKG_GEMPATERBARU;
        $headers = getAuthHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getGempaTerkini() {
        $url = API_BMKG_GEMPA_TERKINI;
        $headers = getAuthHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getGempaDirasakan() {
        $url = API_BMKG_GEMPA_DIRASAKAN;
        $headers = getAuthHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }

    public function getPeringatanDiniCuaca() {
        $url = API_BMKG_PERINGATAN_DINI_CUACA;
        $headers = getAuthHeaders();
        return apiRequest($url, 'GET', null, $headers);
    }





    public function getCacheStatus() {
        $url = API_BMKG_CACHE_STATUS;
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'GET', null, $headers);
    }

    public function clearCache() {
        $url = API_BMKG_CACHE_CLEAR;
        $headers = getAuthHeaders($_SESSION['token'] ?? null);
        return apiRequest($url, 'POST', null, $headers);
    }
}
