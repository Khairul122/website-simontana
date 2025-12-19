<?php

class AuthService {
    private $apiClient;

    public function __construct($apiClient) {
        $this->apiClient = $apiClient;
    }

    public function authenticate($username, $password) {
        try {
            $response = $this->apiClient->login($username, $password);

            return [
                'success' => $response['success'] ?? false,
                'data' => $response['data'] ?? null,
                'message' => $response['message'] ?? ($response['success'] ? 'Login berhasil' : 'Login gagal')
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function register($userData) {
        try {
            $response = $this->apiClient->register($userData);

            return [
                'success' => $response['success'] ?? false,
                'data' => $response['data'] ?? null,
                'message' => $response['message'] ?? ($response['success'] ? 'Registrasi berhasil' : 'Registrasi gagal'),
                'errors' => $response['errors'] ?? []
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'errors' => []
            ];
        }
    }

    public function logout() {
        try {
            $this->apiClient->logout();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getProfile() {
        try {
            $response = $this->apiClient->getProfile();

            return [
                'success' => $response['success'] ?? false,
                'data' => $response['data'] ?? null,
                'message' => $response['message'] ?? ($response['success'] ? 'Profile berhasil diambil' : 'Gagal mengambil profile')
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function updateProfile($profileData) {
        try {
            $response = $this->apiClient->put('auth/profile', $profileData);

            return [
                'success' => $response['success'] ?? false,
                'data' => $response['data'] ?? null,
                'message' => $response['message'] ?? ($response['success'] ? 'Profile berhasil diperbarui' : 'Gagal memperbarui profile')
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function changePassword($passwordData) {
        try {
            $response = $this->apiClient->put('auth/change-password', $passwordData);

            return [
                'success' => $response['success'] ?? false,
                'message' => $response['message'] ?? ($response['success'] ? 'Password berhasil diubah' : 'Gagal mengubah password')
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }
}
?>