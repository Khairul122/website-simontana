<?php

require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../config/globals.php';

class AuthController {
    private $authService;
    private $globalEnv;

    public function __construct() {
        $this->globalEnv = globalEnv();
        $this->authService = new AuthService($this->globalEnv->getAPIClient());
    }

    public function index() {
        if ($this->globalEnv->isLoggedIn()) {
            $this->globalEnv->redirectBasedOnRole();
            return;
        }

        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    public function login() {
        if ($this->globalEnv->isLoggedIn()) {
            $this->globalEnv->redirectBasedOnRole();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = $this->authService->authenticate($username, $password);

            if ($result['success']) {
                $this->globalEnv->login($result['data']['token']);
                $this->globalEnv->redirectBasedOnRole();
            } else {
                $error = $result['message'];
                require __DIR__ . '/../views/auth/login.php';
            }
        } else {
            require __DIR__ . '/../views/auth/login.php';
        }
    }

    public function register() {
        if ($this->globalEnv->isLoggedIn()) {
            $this->globalEnv->redirectBasedOnRole();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'name' => $_POST['name'] ?? '',
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'password_confirmation' => $_POST['password_confirmation'] ?? '',
                'role' => $_POST['role'] ?? 'warga',
                'phone' => $_POST['phone'] ?? '',
                'address' => $_POST['address'] ?? '',
                'provinsi_id' => $_POST['provinsi_id'] ?? '',
                'kabupaten_id' => $_POST['kabupaten_id'] ?? '',
                'kecamatan_id' => $_POST['kecamatan_id'] ?? '',
                'desa_id' => $_POST['desa_id'] ?? ''
            ];

            $result = $this->authService->register($userData);

            if ($result['success']) {
                $success = 'Registrasi berhasil! Silakan login dengan akun Anda.';
                require __DIR__ . '/../views/auth/login.php';
            } else {
                $error = $result['message'];
                $errors = $result['errors'] ?? [];
                require __DIR__ . '/../views/auth/register.php';
            }
        } else {
            require __DIR__ . '/../views/auth/register.php';
        }
    }

    public function logout() {
        $this->globalEnv->logout();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    public function profile() {
        if (!$this->globalEnv->isLoggedIn()) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profileData = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'address' => $_POST['address'] ?? ''
            ];

            $result = $this->globalEnv->getAPIClient()->put('auth/profile', $profileData);

            if ($result['success']) {
                $success = 'Profil berhasil diperbarui!';
                $this->globalEnv->refreshCurrentUser();
            } else {
                $error = $result['message'];
            }
        }

        $userData = $this->globalEnv->getCurrentUser();
        require __DIR__ . '/../views/auth/profile.php';
    }
}
?>