<?php
require_once 'services/AuthService.php';
require_once 'services/ProfileService.php';

class ProfileController {
    private $authService;
    private $profileService;

    public function __construct() {
        $this->authService = new AuthService();
        $this->profileService = new ProfileService();

        // Pastikan pengguna sudah login
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function index() {
        $currentUser = $this->authService->getCurrentUser();

        // Ambil data profil dari service
        $response = $this->profileService->getProfile();

        if ($response['success']) {
            $user = $response['data'];
        } else {
            $user = null;
            $error_message = $response['message'] ?? 'Gagal mengambil data profil';
        }

        $title = "Profil Pengguna - SIMONTA BENCANA";
        include 'views/profile/index.php';
    }
}