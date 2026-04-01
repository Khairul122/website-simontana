<?php
require_once __DIR__ . '/../config/koneksi.php';

class AuthService {

    private function extractAuthPayload($data): array {
        if (!is_array($data)) {
            return [];
        }

        return apiDataEntity($data);
    }

    private function extractUserEntity(array $payload): array {
        if (isset($payload['user']) && is_array($payload['user'])) {
            return $payload['user'];
        }

        foreach (['role', 'id', 'username', 'nama', 'email'] as $key) {
            if (array_key_exists($key, $payload)) {
                return $payload;
            }
        }

        return [];
    }

    public function login($username, $password) {
        $data = [
            'username' => $username,
            'password' => $password
        ];

        
        $response = apiRequest(API_AUTH_LOGIN, 'POST', $data);

        if ($response['success']) {
            $payload = $this->extractAuthPayload($response['data'] ?? null);

            if (isset($payload['token']) && $payload['token'] !== '') {
                $_SESSION['token'] = $payload['token'];
            }

            $user = $this->extractUserEntity($payload);
            if (!empty($user)) {
                $_SESSION['user'] = $user;
            }
        }

        return $response;
    }

    public function getRoles() {
        $response = apiRequest(API_AUTH_ROLES, 'GET');
        if ($response['success']) {
            $response['data'] = apiDataEntity($response['data']);
        }
        return $response;
    }

    public function checkToken() {
        $token = $_SESSION['token'] ?? null;
        if (!$token) {
            return [
                'success' => false,
                'message' => 'Token tidak ditemukan',
                'data' => null
            ];
        }

        return apiRequest(API_CHECK_TOKEN, 'GET', null, getAuthHeaders($token));
    }

    public function register($userData) {
        
        $response = apiRequest(API_AUTH_REGISTER, 'POST', $userData);

        if ($response['success']) {
            $payload = $this->extractAuthPayload($response['data'] ?? null);

            if (isset($payload['token']) && $payload['token'] !== '') {
                $_SESSION['token'] = $payload['token'];
            }

            $user = $this->extractUserEntity($payload);
            if (!empty($user)) {
                $_SESSION['user'] = $user;
            }
        }

        return $response;
    }

    public function logout() {
        if (isset($_SESSION['token'])) {
            $headers = getAuthHeaders($_SESSION['token']);
            $response = apiRequest(API_AUTH_LOGOUT, 'POST', null, $headers);

            
            session_destroy();

            return $response;
        } else {
            session_destroy();
            return [
                'success' => true,
                'message' => 'Berhasil logout',
                'data' => null
            ];
        }
    }

    public function getCurrentUser() {
        if (isset($_SESSION['token']) && isset($_SESSION['user'])) {
            $check = $this->checkToken();
            if ($check['success']) {
                return [
                    'success' => true,
                    'message' => 'Data user ditemukan',
                    'data' => $_SESSION['user']
                ];
            }

            unset($_SESSION['token']);
            unset($_SESSION['user']);
            return [
                'success' => false,
                'message' => $check['message'] ?? 'Token tidak valid',
                'data' => null
            ];
        } else {
            
            if (isset($_SESSION['token'])) {
                $headers = getAuthHeaders($_SESSION['token']);
                $response = apiRequest(API_AUTH_ME, 'GET', null, $headers);

                if ($response['success']) {
                    $payload = $this->extractAuthPayload($response['data'] ?? null);
                    $userData = $this->extractUserEntity($payload);

                    if (!empty($userData)) {
                        $_SESSION['user'] = $userData;
                    }

                    return [
                        'success' => true,
                        'message' => $response['message'] ?? 'Data user berhasil diambil',
                        'data' => $userData
                    ];
                } else {
                    
                    unset($_SESSION['token']);
                    unset($_SESSION['user']);
                    return [
                        'success' => false,
                        'message' => $response['message'] ?? 'Token tidak valid',
                        'data' => null
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'User tidak login',
                    'data' => null
                ];
            }
        }
    }

    public function refreshToken() {
        if (isset($_SESSION['token'])) {
            $headers = getAuthHeaders($_SESSION['token']);
            $response = apiRequest(API_AUTH_REFRESH, 'POST', null, $headers);

            if ($response['success'] && isset($response['data']['token'])) {
                $_SESSION['token'] = $response['data']['token'];
            }

            return $response;
        } else {
            return [
                'success' => false,
                'message' => 'Token tidak ditemukan',
                'data' => null
            ];
        }
    }
}
