<?php
require_once 'config/koneksi.php';

class ProfileService {
    private $apiUrl;

    public function __construct() {
        $this->apiUrl = API_BASE_URL . '/auth/me';
    }

    public function getProfile() {
        return apiRequest($this->apiUrl, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
    }

    public function updateProfile($data) {
        return apiRequest($this->apiUrl, 'PUT', $data, getAuthHeaders($_SESSION['token'] ?? null));
    }
}