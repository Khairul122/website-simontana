<?php
/**
 * AuthService - Service untuk autentikasi user
 * Menggunakan BencanaAPIClient untuk komunikasi dengan Backend Laravel
 */

class AuthService {
    private $apiClient;

    public function __construct($apiClient) {
        $this->apiClient = $apiClient;
    }

    /**
     * Login user
     */
    public function authenticate($username, $password) {
        try {
            $response = $this->apiClient->login($username, $password);

            if ($response['success']) {
                return [
                    'success' => true,
                    'data' => $response['data'],
                    'message' => 'Login berhasil'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Login gagal'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Register user baru
     */
    public function register($userData) {
        try {
            $response = $this->apiClient->register($userData);

            if ($response['success']) {
                return [
                    'success' => true,
                    'data' => $response['data'],
                    'message' => 'Registrasi berhasil'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Registrasi gagal',
                    'errors' => $response['errors'] ?? []
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Logout user
     */
    public function logout($token) {
        try {
            $response = $this->apiClient->logout($token);
            return $response['success'] ?? false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Refresh token
     */
    public function refreshToken($token) {
        try {
            $response = $this->apiClient->refreshToken($token);

            if ($response['success']) {
                return [
                    'success' => true,
                    'token' => $response['data']['token'],
                    'message' => 'Token berhasil diperbarui'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Token gagal diperbarui'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get user profile
     */
    public function getUserProfile($token) {
        try {
            $response = $this->apiClient->getProfile($token);

            if ($response['success']) {
                return [
                    'success' => true,
                    'data' => $response['data'],
                    'message' => 'Profile berhasil diambil'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Gagal mengambil profile'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Validate token
     */
    public function validateToken($token) {
        try {
            return $this->apiClient->validateToken($token);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Check if user has valid role for website access
     */
    public function isValidWebUser($token) {
        try {
            $profile = $this->getUserProfile($token);

            if ($profile['success']) {
                $role = $profile['data']['role'] ?? '';
                return $this->apiClient->isValidWebRole($role);
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get user permissions based on role
     */
    public function getUserPermissions($token) {
        try {
            $profile = $this->getUserProfile($token);

            if ($profile['success']) {
                $role = $profile['data']['role'] ?? '';

                $permissions = [
                    'Admin' => [
                        'dashboard.view',
                        'user.create', 'user.read', 'user.update', 'user.delete',
                        'laporan.create', 'laporan.read', 'laporan.update', 'laporan.delete',
                        'tindaklanjut.create', 'tindaklanjut.read', 'tindaklanjut.update', 'tindaklanjut.delete',
                        'monitoring.create', 'monitoring.read', 'monitoring.update', 'monitoring.delete',
                        'desa.create', 'desa.read', 'desa.update', 'desa.delete',
                        'kategori.create', 'kategori.read', 'kategori.update', 'kategori.delete'
                    ],
                    'PetugasBPBD' => [
                        'dashboard.view',
                        'laporan.read', 'laporan.update',
                        'tindaklanjut.create', 'tindaklanjut.read', 'tindaklanjut.update',
                        'monitoring.read', 'monitoring.create', 'monitoring.update',
                        'bmkg.read'
                    ],
                    'OperatorDesa' => [
                        'dashboard.view',
                        'laporan.read', 'laporan.update',
                        'tindaklanjut.read', 'tindaklanjut.create',
                        'monitoring.read', 'monitoring.create', 'monitoring.update',
                        'desa.read'
                    ]
                ];

                return $permissions[$role] ?? [];
            }

            return [];
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Check if user has specific permission
     */
    public function hasPermission($token, $permission) {
        $permissions = $this->getUserPermissions($token);
        return in_array($permission, $permissions);
    }

    /**
     * Get user session data
     */
    public function getSessionData() {
        return [
            'user_id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'nama' => $_SESSION['nama'] ?? null,
            'role' => $_SESSION['role'] ?? null,
            'logged_in' => $_SESSION['logged_in'] ?? false,
            'login_time' => $_SESSION['login_time'] ?? null
        ];
    }

    /**
     * Set user session data
     */
    public function setSessionData($userData, $token) {
        $_SESSION['user_id'] = $userData['id'] ?? null;
        $_SESSION['username'] = $userData['username'] ?? null;
        $_SESSION['nama'] = $userData['nama'] ?? $userData['username'] ?? null;
        $_SESSION['role'] = $userData['role'] ?? null;
        $_SESSION['email'] = $userData['email'] ?? null;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();

        // Store API token
        $this->apiClient->storeApiToken($token);
    }

    /**
     * Clear user session data
     */
    public function clearSessionData() {
        // Clear all session data
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['nama']);
        unset($_SESSION['role']);
        unset($_SESSION['email']);
        unset($_SESSION['logged_in']);
        unset($_SESSION['login_time']);

        // Clear API token
        $this->apiClient->clearApiToken();
    }

    /**
     * Check if session is active and valid
     */
    public function isSessionActive() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            return false;
        }

        $token = $this->apiClient->getApiToken();
        if (!$token || $this->apiClient->isApiTokenExpired()) {
            return false;
        }

        return $this->validateToken($token);
    }

    /**
     * Validate user registration data
     */
    public function validateRegistrationData($data) {
        $errors = [];

        // Username validation
        if (empty($data['username'])) {
            $errors['username'] = 'Username wajib diisi';
        } elseif (strlen($data['username']) < 4) {
            $errors['username'] = 'Username minimal 4 karakter';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors['username'] = 'Username hanya boleh mengandung huruf, angka, dan underscore';
        }

        // Password validation
        if (empty($data['password'])) {
            $errors['password'] = 'Password wajib diisi';
        } elseif (strlen($data['password']) < 4) {
            $errors['password'] = 'Password minimal 4 karakter';
        }

        // Password confirmation
        if ($data['password'] !== $data['password_confirmation']) {
            $errors['password_confirmation'] = 'Konfirmasi password tidak cocok';
        }

        // Name validation
        if (empty($data['nama'])) {
            $errors['nama'] = 'Nama lengkap wajib diisi';
        } elseif (strlen($data['nama']) < 3) {
            $errors['nama'] = 'Nama minimal 3 karakter';
        }

        // Email validation
        if (empty($data['email'])) {
            $errors['email'] = 'Email wajib diisi';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid';
        }

        // Role validation
        if (empty($data['role'])) {
            $errors['role'] = 'Role wajib dipilih';
        } elseif (!$this->apiClient->isValidWebRole($data['role'])) {
            $errors['role'] = 'Role tidak valid untuk website access';
        }

        // Phone validation (optional)
        if (!empty($data['no_telepon'])) {
            if (!preg_match('/^[0-9]{10,13}$/', $data['no_telepon'])) {
                $errors['no_telepon'] = 'Format nomor telepon tidak valid';
            }
        }

        return $errors;
    }

    /**
     * Generate random token for password reset
     */
    public function generatePasswordResetToken() {
        return bin2hex(random_bytes(32));
    }

    /**
     * Send password reset email (mock implementation)
     */
    public function sendPasswordResetEmail($email) {
        // Mock implementation - implement email sending logic here
        return [
            'success' => true,
            'message' => 'Link reset password telah dikirim ke email Anda'
        ];
    }
}
?>