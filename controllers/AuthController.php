<?php
require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/AuthService.php';

class AuthController {
    private $authService;

    private function jsonResponse(bool $success, $data = null, string $message = ''): void {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function login() {
        
        $currentUser = $this->authService->getCurrentUser();
        if ($currentUser['success'] && isset($currentUser['data'])) {
            $role = $currentUser['data']['role'] ?? $currentUser['data']['user']['role'] ?? 'Warga';
            $this->redirectToDashboard($role);
            return;
        }

        
        if (isset($_SESSION['redirect_after_login']) && $_SESSION['redirect_after_login']) {
            $role = $_SESSION['user_role'] ?? 'Warga';
            unset($_SESSION['redirect_after_login']);
            unset($_SESSION['user_role']);

            
            $title = "Login - SIMONTA BENCANA";
            $should_redirect = true;
            include dirname(__DIR__) . '/views/auth/login.php';
            return;
        }

        
        $title = "Login - SIMONTA BENCANA";
        $should_redirect = false;
        include dirname(__DIR__) . '/views/auth/login.php';
    }

    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                setToast('error', 'Gagal', 'Username dan password harus diisi');
                header('Location: index.php?controller=Auth&action=login');
                exit;
            }

            $response = $this->authService->login($username, $password);

            if ($response['success']) {
                
                $userData = apiDataEntity($response['data']);
                $userRole = $userData['user']['role'] ?? $userData['role'] ?? 'Warga';

                setToast('success', 'Berhasil', 'Login berhasil');

                $this->redirectToDashboard($userRole);
                exit;
            } else {
                
                $errorMessage = $response['message'] ?? 'Username atau password salah';

                
                if (isset($response['errors']) && is_array($response['errors'])) {
                    $errors = $response['errors'];
                    $firstError = reset($errors);
                    $errorMessage = is_array($firstError) ? ($firstError[0] ?? $errorMessage) : $firstError;
                } elseif (isset($response['details']) && is_array($response['details'])) {
                    $firstError = reset($response['details']);
                    $errorMessage = is_array($firstError) ? ($firstError[0] ?? $errorMessage) : $firstError;
                } elseif (isset($response['data']) && is_array($response['data'])) {
                    if (isset($response['data']['errors']) && is_array($response['data']['errors'])) {
                        $firstError = reset($response['data']['errors']);
                        $errorMessage = is_array($firstError) ? $firstError[0] : $firstError;
                    }
                }

                setToast('error', 'Login Gagal', $errorMessage);
                header('Location: index.php?controller=Auth&action=login');
                exit;
            }
        }

        header('Location: index.php?controller=Auth&action=login');
        exit;
    }

    public function register() {
        
        $title = "Register - SIMONTA BENCANA";
        $desaList = [];

        $desaResponse = apiRequest(API_DESA, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
        if ($desaResponse['success']) {
            $desaList = apiDataList($desaResponse['data']);
        } else {
            $error_message = $desaResponse['message'] ?? 'Daftar desa belum dapat dimuat saat ini.';
        }

        include dirname(__DIR__) . '/views/auth/register.php';
    }

    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirmation = $_POST['password_confirmation'] ?? '';
            $role = $_POST['role'] ?? 'Warga';
            $no_telepon = $_POST['no_telepon'] ?? '';
            $alamat = $_POST['alamat'] ?? '';
            $id_desa = $_POST['id_desa'] ?? '';

            
            if (empty($nama) || empty($username) || empty($email) || empty($password)) {
                setToast('error', 'Gagal', 'Semua field wajib diisi');
                header('Location: index.php?controller=Auth&action=register');
                return;
            }

            if ($password !== $password_confirmation) {
                setToast('error', 'Gagal', 'Konfirmasi password tidak sesuai');
                header('Location: index.php?controller=Auth&action=register');
                return;
            }

            $userData = [
                'nama' => $nama,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'role' => $role,
                'no_telepon' => $no_telepon,
                'alamat' => $alamat,
                'id_desa' => $id_desa
            ];

            $response = $this->authService->register($userData);

            if ($response['success']) {
                
                setToast('success', 'Berhasil', 'Registrasi berhasil. Silakan login');
                header('Location: index.php?controller=Auth&action=login');
                return;
            } else {
                
                $message = $response['message'] ?? 'Registrasi gagal';

                
                if (isset($response['errors']) && is_array($response['errors'])) {
                    $firstError = reset($response['errors']);
                    $message = is_array($firstError) ? ($firstError[0] ?? $message) : $firstError;
                } elseif (isset($response['details']) && is_array($response['details'])) {
                    $firstError = reset($response['details']);
                    $message = is_array($firstError) ? ($firstError[0] ?? $message) : $firstError;
                } elseif (isset($response['data']) && is_array($response['data'])) {
                    if (isset($response['data']['errors']) && is_array($response['data']['errors'])) {
                        $firstError = reset($response['data']['errors']);
                        $message = is_array($firstError) ? $firstError[0] : $firstError;
                    }
                }

                setToast('error', 'Gagal', $message);
                header('Location: index.php?controller=Auth&action=register');
                return;
            }
        }

        header('Location: index.php?controller=Auth&action=register');
    }

    public function getAllProvinsi()
    {
        $response = apiRequest(API_WILAYAH_PROVINSI, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
        if ($response['success']) {
            $this->jsonResponse(true, apiDataList($response['data']));
        }
        $this->jsonResponse(false, null, $response['message'] ?? 'Gagal mengambil data provinsi');
    }

    public function getKabupatenByProvinsi()
    {
        $provinsiId = (int)($_GET['id'] ?? 0);
        if ($provinsiId <= 0) {
            $this->jsonResponse(false, null, 'Provinsi tidak valid');
        }

        $url = str_replace('{provinsi_id}', (string)$provinsiId, API_WILAYAH_KABUPATEN);
        $response = apiRequest($url, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
        if ($response['success']) {
            $this->jsonResponse(true, apiDataList($response['data']));
        }
        $this->jsonResponse(false, null, $response['message'] ?? 'Gagal mengambil data kabupaten');
    }

    public function getKecamatanByKabupaten()
    {
        $kabupatenId = (int)($_GET['id'] ?? 0);
        if ($kabupatenId <= 0) {
            $this->jsonResponse(false, null, 'Kabupaten tidak valid');
        }

        $url = str_replace('{kabupaten_id}', (string)$kabupatenId, API_WILAYAH_KECAMATAN);
        $response = apiRequest($url, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
        if ($response['success']) {
            $this->jsonResponse(true, apiDataList($response['data']));
        }
        $this->jsonResponse(false, null, $response['message'] ?? 'Gagal mengambil data kecamatan');
    }

    public function getDesaByKecamatan()
    {
        $kecamatanId = (int)($_GET['id'] ?? 0);
        if ($kecamatanId <= 0) {
            $this->jsonResponse(false, null, 'Kecamatan tidak valid');
        }

        $url = str_replace('{kecamatan_id}', (string)$kecamatanId, API_WILAYAH_DESA);
        $response = apiRequest($url, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
        if ($response['success']) {
            $this->jsonResponse(true, apiDataList($response['data']));
        }
        $this->jsonResponse(false, null, $response['message'] ?? 'Gagal mengambil data desa');
    }

    public function logout() {
        $this->authService->logout();

        setToast('success', 'Berhasil', 'Berhasil logout');

        header('Location: index.php?controller=Auth&action=login');
    }

    private function redirectToDashboard($role) {
        
        switch ($role) {
            case 'Admin':
                header('Location: index.php?controller=Dashboard&action=admin');
                break;
            case 'PetugasBPBD':
                header('Location: index.php?controller=Dashboard&action=petugas');
                break;
            case 'OperatorDesa':
                header('Location: index.php?controller=Dashboard&action=operator');
                break;
            case 'Warga':
                header('Location: index.php?controller=Dashboard&action=warga');
                break;
            default:
                header('Location: index.php?controller=Dashboard&action=warga');
                break;
        }
    }
}
