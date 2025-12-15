<?php
/**
 * User Service for SIMONTA BENCANA Web Application
 * Handles user management operations including CRUD, filtering, and statistics
 */

class UserService {
    private $apiClient;

    public function __construct() {
        require_once __DIR__ . '/../config/koneksi.php';
        $this->apiClient = getAPIClient();
    }

    /**
     * Get all users with filtering and pagination
     */
    public function getAllUsers($token, $params = []) {
        error_log("=== Getting All Users ===");
        error_log("Token available: " . ($token ? "YES" : "NO"));
        error_log("Parameters: " . json_encode($params));

        try {
            $response = $this->apiClient->getUsers($token, $params);

            if ($response && isset($response['success']) && $response['success']) {
                error_log("Users retrieved successfully: " . count($response['data']['data'] ?? []) . " records");
                return $response;
            } else {
                error_log("Failed to retrieve users: " . ($response['message'] ?? 'Unknown error'));
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Failed to retrieve users',
                    'data' => ['data' => [], 'total' => 0, 'per_page' => 10, 'current_page' => 1]
                ];
            }
        } catch (Exception $e) {
            error_log("Exception in getAllUsers: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error retrieving users: ' . $e->getMessage(),
                'data' => ['data' => [], 'total' => 0, 'per_page' => 10, 'current_page' => 1]
            ];
        }
    }

    /**
     * Get user statistics
     */
    public function getUserStatistics($token) {
        error_log("=== Getting User Statistics ===");

        try {
            $response = $this->apiClient->getUsers($token, ['statistics' => true]);

            if ($response && isset($response['success']) && $response['success']) {
                error_log("User statistics retrieved successfully");
                return $response;
            } else {
                error_log("Failed to retrieve user statistics");
                return $this->generateMockUserStatistics();
            }
        } catch (Exception $e) {
            error_log("Exception in getUserStatistics: " . $e->getMessage());
            return $this->generateMockUserStatistics();
        }
    }

    /**
     * Get user by ID
     */
    public function getUserById($token, $id) {
        error_log("=== Getting User by ID: $id ===");

        try {
            $response = $this->apiClient->apiRequest("users/$id", 'GET', null, $token);

            if ($response && isset($response['success']) && $response['success']) {
                error_log("User retrieved successfully");
                return $response;
            } else {
                error_log("Failed to retrieve user: " . ($response['message'] ?? 'Unknown error'));
                return null;
            }
        } catch (Exception $e) {
            error_log("Exception in getUserById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create new user
     */
    public function createUser($token, $userData) {
        error_log("=== Creating New User ===");
        error_log("User data: " . json_encode($userData));

        try {
            $response = $this->apiClient->apiRequest('users', 'POST', $userData, $token);

            if ($response && isset($response['success']) && $response['success']) {
                error_log("User created successfully");
                return $response;
            } else {
                error_log("Failed to create user: " . ($response['message'] ?? 'Unknown error'));
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Failed to create user'
                ];
            }
        } catch (Exception $e) {
            error_log("Exception in createUser: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error creating user: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update existing user
     */
    public function updateUser($token, $id, $userData) {
        error_log("=== Updating User ID: $id ===");
        error_log("User data: " . json_encode($userData));

        try {
            $response = $this->apiClient->apiRequest("users/$id", 'PUT', $userData, $token);

            if ($response && isset($response['success']) && $response['success']) {
                error_log("User updated successfully");
                return $response;
            } else {
                error_log("Failed to update user: " . ($response['message'] ?? 'Unknown error'));
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Failed to update user'
                ];
            }
        } catch (Exception $e) {
            error_log("Exception in updateUser: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error updating user: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete user
     */
    public function deleteUser($token, $id) {
        error_log("=== Deleting User ID: $id ===");

        try {
            $response = $this->apiClient->apiRequest("users/$id", 'DELETE', null, $token);

            if ($response && isset($response['success']) && $response['success']) {
                error_log("User deleted successfully");
                return $response;
            } else {
                error_log("Failed to delete user: " . ($response['message'] ?? 'Unknown error'));
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Failed to delete user'
                ];
            }
        } catch (Exception $e) {
            error_log("Exception in deleteUser: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get all villages (desa) for dropdown
     */
    public function getVillages($token) {
        error_log("=== Getting All Villages ===");

        try {
            $response = $this->apiClient->apiRequest('desa', 'GET', null, $token);

            if ($response && isset($response['success']) && $response['success']) {
                error_log("Villages retrieved successfully: " . count($response['data'] ?? []) . " records");
                return $response;
            } else {
                error_log("Failed to retrieve villages, using mock data");
                return $this->generateMockVillages();
            }
        } catch (Exception $e) {
            error_log("Exception in getVillages: " . $e->getMessage());
            return $this->generateMockVillages();
        }
    }

    /**
     * Generate mock user statistics for fallback
     */
    private function generateMockUserStatistics() {
        return [
            'success' => true,
            'message' => 'Mock user statistics generated',
            'data' => [
                'total_users' => 158,
                'users_by_role' => [
                    'Admin' => 5,
                    'PetugasBPBD' => 28,
                    'OperatorDesa' => 45,
                    'Warga' => 80
                ],
                'users_by_desa' => [
                    ['desa_name' => 'Desa Mekar Jaya', 'user_count' => 12],
                    ['desa_name' => 'Desa Suka Maju', 'user_count' => 8],
                    ['desa_name' => 'Desa Indah', 'user_count' => 15]
                ],
                'recent_users' => [
                    ['id' => 158, 'nama' => 'Siti Rahayu', 'role' => 'Warga', 'created_at' => '2025-01-14 15:30:00'],
                    ['id' => 157, 'nama' => 'Budi Santoso', 'role' => 'Warga', 'created_at' => '2025-01-14 14:20:00'],
                    ['id' => 156, 'nama' => 'Ahmad Wijaya', 'role' => 'Warga', 'created_at' => '2025-01-14 13:15:00']
                ]
            ]
        ];
    }

    /**
     * Generate mock villages for fallback
     */
    private function generateMockVillages() {
        return [
            'success' => true,
            'message' => 'Mock villages generated',
            'data' => [
                ['id_desa' => 1, 'nama_desa' => 'Desa Mekar Jaya'],
                ['id_desa' => 2, 'nama_desa' => 'Desa Suka Maju'],
                ['id_desa' => 3, 'nama_desa' => 'Desa Indah'],
                ['id_desa' => 4, 'nama_desa' => 'Desa Harmoni'],
                ['id_desa' => 5, 'nama_desa' => 'Desa Sejahtera']
            ]
        ];
    }

    /**
     * Validate user data before saving
     */
    public function validateUserData($userData, $isEdit = false) {
        $errors = [];

        // Check required fields
        if (empty($userData['nama'])) {
            $errors[] = 'Nama harus diisi';
        }

        if (empty($userData['username'])) {
            $errors[] = 'Username harus diisi';
        }

        if (empty($userData['email'])) {
            $errors[] = 'Email harus diisi';
        } elseif (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid';
        }

        if (empty($userData['role'])) {
            $errors[] = 'Role harus dipilih';
        } elseif (!in_array($userData['role'], ['Admin', 'PetugasBPBD', 'OperatorDesa', 'Warga'])) {
            $errors[] = 'Role tidak valid';
        }

        if (!$isEdit && empty($userData['password'])) {
            $errors[] = 'Password harus diisi';
        } elseif (!$isEdit && strlen($userData['password']) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        }

        // Validate phone number if provided
        if (!empty($userData['no_telepon']) && !preg_match('/^[0-9+-]+$/', $userData['no_telepon'])) {
            $errors[] = 'Nomor telepon hanya boleh mengandung angka, +, dan -';
        }

        return $errors;
    }

    /**
     * Format user data for API
     */
    public function formatUserData($postData, $isEdit = false) {
        $userData = [
            'nama' => $postData['nama'] ?? '',
            'username' => $postData['username'] ?? '',
            'email' => $postData['email'] ?? '',
            'role' => $postData['role'] ?? '',
            'no_telepon' => $postData['no_telepon'] ?? '',
            'alamat' => $postData['alamat'] ?? '',
            'id_desa' => !empty($postData['id_desa']) ? (int)$postData['id_desa'] : null
        ];

        // Only include password if it's provided (for edit)
        if (!$isEdit || !empty($postData['password'])) {
            $userData['password'] = $postData['password'] ?? '';
        }

        return $userData;
    }
}
?>