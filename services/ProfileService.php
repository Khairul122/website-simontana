<?php
require_once 'config/koneksi.php';

class ProfileService {
    private $apiUrl;

    public function __construct() {
        $this->apiUrl = API_BASE_URL . '/auth/me';
    }

    public function getProfile() {
        $response = apiRequest($this->apiUrl, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
        if ($response['success']) {
            $response['data'] = apiDataEntity($response['data']);
        }
        return $response;
    }

    public function updateProfile($data) {
        return apiRequest($this->apiUrl, 'PUT', $data, getAuthHeaders($_SESSION['token'] ?? null));
    }
}
