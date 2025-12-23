<?php
require_once __DIR__ . '/../config/koneksi.php';

class AuthService {

    public function login($username, $password) {
        $data = [
            'username' => $username,
            'password' => $password
        ];

        // Tidak perlu header otentikasi untuk login
        $response = apiRequest(API_AUTH_LOGIN, 'POST', $data);

        if ($response['success']) {
            // Simpan token dan data pengguna ke session
            if (isset($response['data']['token'])) {
                $_SESSION['token'] = $response['data']['token'];
            } elseif (isset($response['data']['data']['token'])) {
                $_SESSION['token'] = $response['data']['data']['token'];
            }

            // Ambil data user dari struktur respons API
            $user = null;

            if (isset($response['data']['data']['user'])) {
                $user = $response['data']['data']['user'];
            } elseif (isset($response['data']['user'])) {
                $user = $response['data']['user'];
            } elseif (isset($response['data']['data'])) {
                $user = $response['data']['data'];
            } elseif (isset($response['data'])) {
                $user = $response['data'];
            }

            if ($user) {
                $_SESSION['user'] = $user;
            }
        }

        return $response;
    }

    public function register($userData) {
        // Tidak perlu header otentikasi untuk register
        $response = apiRequest(API_AUTH_REGISTER, 'POST', $userData);

        if ($response['success']) {
            // Jika registrasi berhasil, simpan token jika sudah dikembalikan
            if (isset($response['data']['token'])) {
                $_SESSION['token'] = $response['data']['token'];
            } elseif (isset($response['data']['data']['token'])) {
                $_SESSION['token'] = $response['data']['data']['token'];
            }

            // Ambil data user dari struktur respons API
            $user = null;

            if (isset($response['data']['data']['user'])) {
                $user = $response['data']['data']['user'];
            } elseif (isset($response['data']['user'])) {
                $user = $response['data']['user'];
            } elseif (isset($response['data']['data'])) {
                $user = $response['data']['data'];
            } elseif (isset($response['data'])) {
                $user = $response['data'];
            }

            if ($user) {
                $_SESSION['user'] = $user;
            }
        }

        return $response;
    }

    public function logout() {
        if (isset($_SESSION['token'])) {
            $headers = getAuthHeaders($_SESSION['token']);
            $response = apiRequest(API_AUTH_LOGOUT, 'POST', null, $headers);

            // Hapus session lokal terlepas dari apakah API logout sukses atau tidak
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
            // Kembalikan data user dari session
            return [
                'success' => true,
                'message' => 'Data user ditemukan',
                'data' => $_SESSION['user']
            ];
        } else {
            // Coba panggil API untuk mendapatkan data user
            if (isset($_SESSION['token'])) {
                $headers = getAuthHeaders($_SESSION['token']);
                $response = apiRequest(API_AUTH_ME, 'GET', null, $headers);

                if ($response['success']) {
                    // Ambil data user dari struktur respons API
                    $userData = null;

                    if (isset($response['data']['data'])) {
                        // Jika API mengembalikan data dalam format { success: true, data: { data: {...} }}
                        $userData = $response['data']['data'];
                    } elseif (isset($response['data']['user'])) {
                        // Jika API mengembalikan data dalam format { success: true, data: { user: {...} }}
                        $userData = $response['data']['user'];
                    } elseif (isset($response['data'])) {
                        // Jika API mengembalikan data dalam format { success: true, data: {...} }
                        $userData = $response['data'];
                    }

                    if ($userData) {
                        $_SESSION['user'] = $userData;
                    }

                    return [
                        'success' => true,
                        'message' => $response['message'] ?? 'Data user berhasil diambil',
                        'data' => $userData
                    ];
                } else {
                    // Jika API gagal, hapus session
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