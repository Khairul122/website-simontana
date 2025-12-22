<?php
require_once 'config/koneksi.php';

class AuthService {

    public function login($username, $password) {
        $data = [
            'username' => $username,
            'password' => $password
        ];

        // Tidak perlu header otentikasi untuk login
        $response = apiRequest(API_LOGIN, 'POST', $data);

        if ($response['success']) {
            // Simpan token dan data pengguna ke session
            if (isset($response['data']['token'])) {
                $_SESSION['token'] = $response['data']['token'];
            }

            if (isset($response['data']['user'])) {
                $_SESSION['user'] = $response['data']['user'];
            }
        }

        return $response;
    }

    public function register($userData) {
        // Tidak perlu header otentikasi untuk register
        $response = apiRequest(API_REGISTER, 'POST', $userData);

        if ($response['success']) {
            // Jika registrasi berhasil, simpan token jika sudah dikembalikan
            if (isset($response['data']['token'])) {
                $_SESSION['token'] = $response['data']['token'];
            }

            if (isset($response['data']['user'])) {
                $_SESSION['user'] = $response['data']['user'];
            }
        }

        return $response;
    }

    public function logout() {
        if (isset($_SESSION['token'])) {
            $headers = getAuthHeaders($_SESSION['token']);
            $response = apiRequest(API_LOGOUT, 'POST', null, $headers);

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
                $response = apiRequest(API_ME, 'GET', null, $headers);

                if ($response['success']) {
                    $_SESSION['user'] = $response['data'];
                    return $response;
                } else {
                    // Jika API gagal, hapus session
                    unset($_SESSION['token']);
                    unset($_SESSION['user']);
                    return [
                        'success' => false,
                        'message' => 'Token tidak valid',
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
            $response = apiRequest(API_REFRESH, 'POST', null, $headers);

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