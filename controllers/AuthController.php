<?php
require_once 'services/AuthService.php';

class AuthController {
    private $authService;
    
    public function __construct() {
        $this->authService = new AuthService();
    }
    
    public function login() {
        // Jika user sudah login, redirect ke dashboard
        $currentUser = $this->authService->getCurrentUser();
        if ($currentUser['success']) {
            $this->redirectToDashboard($currentUser['data']['role']);
            return;
        }

        // Jika ada redirect setelah login berhasil
        if (isset($_SESSION['redirect_after_login']) && $_SESSION['redirect_after_login']) {
            $role = $_SESSION['user_role'] ?? 'Warga';
            unset($_SESSION['redirect_after_login']);
            unset($_SESSION['user_role']);

            // Tampilkan halaman login dengan toast dan redirect script
            $title = "Login - SIMONTA BENCANA";
            $should_redirect = true;
            include 'views/auth/login.php';
            return;
        }

        // Tampilkan halaman login
        $title = "Login - SIMONTA BENCANA";
        $should_redirect = false;
        include 'views/auth/login.php';
    }
    
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Username dan password harus diisi'
                ];
                header('Location: index.php?controller=Auth&action=login');
                return;
            }
            
            $response = $this->authService->login($username, $password);

            if ($response['success']) {
                // Login berhasil, simpan informasi redirect ke session
                $_SESSION['redirect_after_login'] = true;
                $_SESSION['user_role'] = $response['data']['user']['role'];
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Login berhasil'
                ];
                header('Location: index.php?controller=Auth&action=login');
                return;
            } else {
                // Login gagal
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => $response['message'] ?? 'Login gagal'
                ];
                header('Location: index.php?controller=Auth&action=login');
                return;
            }
        }
        
        header('Location: index.php?controller=Auth&action=login');
    }
    
    public function register() {
        // Tampilkan halaman register
        $title = "Register - SIMONTA BENCANA";
        include 'views/auth/register.php';
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
            
            // Validasi input
            if (empty($nama) || empty($username) || empty($email) || empty($password)) {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Semua field wajib diisi'
                ];
                header('Location: index.php?controller=Auth&action=register');
                return;
            }
            
            if ($password !== $password_confirmation) {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Konfirmasi password tidak sesuai'
                ];
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
                // Register berhasil, tampilkan pesan dan arahkan ke login
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Registrasi berhasil. Silakan login'
                ];
                header('Location: index.php?controller=Auth&action=login');
                return;
            } else {
                // Register gagal
                $message = $response['message'] ?? 'Registrasi gagal';
                if (isset($response['data']['errors'])) {
                    $errors = $response['data']['errors'];
                    $errorMessages = [];
                    foreach ($errors as $field => $error) {
                        $errorMessages[] = is_array($error) ? $error[0] : $error;
                    }
                    $message = implode(', ', $errorMessages);
                }

                $_SESSION['toast'] = [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => $message
                ];
                header('Location: index.php?controller=Auth&action=register');
                return;
            }
        }
        
        header('Location: index.php?controller=Auth&action=register');
    }
    
    public function logout() {
        $this->authService->logout();
        
        $_SESSION['toast'] = [
            'type' => 'success',
            'title' => 'Berhasil',
            'message' => 'Berhasil logout'
        ];
        
        header('Location: index.php?controller=Auth&action=login');
    }
    
    private function redirectToDashboard($role) {
        // Redirect berdasarkan role pengguna
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
                header('Location: index.php?controller=Beranda&action=index');
                break;
            default:
                header('Location: index.php?controller=Beranda&action=index');
                break;
        }
    }
}