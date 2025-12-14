<?php
/**
 * AuthController - Controller untuk autentikasi user
 * Sesuai PERANCANGAN.md: Website hanya untuk Admin, Petugas BPBD, Operator Desa
 */

class AuthController {
    private $apiClient;

    public function __construct() {
        // Inisialisasi API Client
        require_once 'config/koneksi.php';
        $this->apiClient = getAPIClient();
    }

    /**
     * Menampilkan halaman login
     */
    public function index() {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        // Tampilkan halaman login
        $data = [
            'title' => 'Login - SIMONTA BENCANA',
            'page' => 'auth',
            'action' => 'login'
        ];

        $this->loadView('login', $data);
    }

    /**
     * Menampilkan halaman login dan proses login
     */
    public function login() {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        // Handle POST request (proses login)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $username = $_POST['username'] ?? '';
                $password = $_POST['password'] ?? '';

                if (empty($username) || empty($password)) {
                    $_SESSION['error'] = 'Username dan password wajib diisi';
                    $this->loadView('login', [
                        'title' => 'Login - SIMONTA BENCANA',
                        'page' => 'auth',
                        'action' => 'login'
                    ]);
                    return;
                }

                // Login ke API
                $response = $this->apiClient->login($username, $password);

                if ($response['success']) {
                    // Simpan token ke session
                    $token = $response['data']['token'];
                    $this->apiClient->storeApiToken($token);

                    // Simpan data user ke session
                    $userData = $response['data']['user'];
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['username'] = $userData['username'];
                    $_SESSION['nama'] = $userData['nama'] ?? $userData['username'];
                    $_SESSION['role'] = $userData['role'];
                    $_SESSION['logged_in'] = true;

                    // Redirect berdasarkan role
                    $this->redirectBasedOnRole();
                } else {
                    $_SESSION['error'] = $response['message'] ?? 'Login gagal';
                    $this->loadView('login', [
                        'title' => 'Login - SIMONTA BENCANA',
                        'page' => 'auth',
                        'action' => 'login'
                    ]);
                }

            } catch (Exception $e) {
                $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
                $this->loadView('login', [
                    'title' => 'Login - SIMONTA BENCANA',
                    'page' => 'auth',
                    'action' => 'login'
                ]);
            }
        } else {
            // Handle GET request (tampilkan halaman login)
            $data = [
                'title' => 'Login - SIMONTA BENCANA',
                'page' => 'auth',
                'action' => 'login'
            ];

            // Pass session data ke view untuk notifikasi
            if (isset($_SESSION['success'])) {
                $data['success'] = $_SESSION['success'];
                unset($_SESSION['success']);
            }

            if (isset($_SESSION['error'])) {
                $data['error'] = $_SESSION['error'];
                unset($_SESSION['error']);
            }

            $this->loadView('login', $data);
        }
    }

    /**
     * Menampilkan halaman register
     */
    public function register() {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        // Ambil notifikasi dari session
        $data = [
            'title' => 'Register - SIMONTA BENCANA',
            'page' => 'auth',
            'action' => 'register'
        ];

        // Pass session data ke view untuk notifikasi
        if (isset($_SESSION['success'])) {
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        if (isset($_SESSION['error'])) {
            $data['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['errors'])) {
            $data['errors'] = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }

        if (isset($_SESSION['old_data'])) {
            $data['old_data'] = $_SESSION['old_data'];
            unset($_SESSION['old_data']);
        }

        $this->loadView('register', $data);
    }

    /**
     * Menampilkan halaman login standalone
     */
    public function loginStandalone() {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        $data = [
            'title' => 'Login - SIMONTA BENCANA'
        ];

        $this->loadStandaloneView('login-standalone', $data);
    }

    /**
     * Menampilkan halaman register standalone
     */
    public function registerStandalone() {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        $data = [
            'title' => 'Register - SIMONTA BENCANA'
        ];

        $this->loadStandaloneView('register-standalone', $data);
    }

    /**
     * Proses register
     */
    public function doRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Debug logging
                error_log("=== Registration Form Submission ===");
                error_log("POST data: " . print_r($_POST, true));

                $data = [
                    'username' => $_POST['username'] ?? '',
                    'password' => $_POST['password'] ?? '',
                    'password_confirmation' => $_POST['password_confirmation'] ?? '',
                    'nama' => $_POST['nama'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'role' => $_POST['role'] ?? '',
                    'no_telepon' => $_POST['no_telepon'] ?? ''
                ];

                error_log("Processed data: " . print_r($data, true));

                // Validasi data
                $errors = $this->validateRegisterData($data);
                if (!empty($errors)) {
                    error_log("Validation errors: " . print_r($errors, true));
                    $_SESSION['errors'] = $errors;
                    $_SESSION['old_data'] = $data;
                    header('Location: index.php?controller=auth&action=register');
                    exit;
                }

                error_log("Validation passed, calling API register...");

                // Register ke API
                $response = $this->apiClient->register($data);

                error_log("API Response: " . print_r($response, true));

                if ($response['success']) {
                    $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
                    header('Location: index.php?controller=auth&action=index');
                    exit;
                } else {
                    $_SESSION['error'] = $response['message'] ?? 'Registrasi gagal';
                    $_SESSION['old_data'] = $data;
                    header('Location: index.php?controller=auth&action=register');
                    exit;
                }

            } catch (Exception $e) {
                error_log("Registration Exception: " . $e->getMessage());
                error_log("Stack trace: " . $e->getTraceAsString());
                $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
                $_SESSION['old_data'] = $data ?? [];
                header('Location: index.php?controller=auth&action=register');
                exit;
            }
        }
    }

    /**
     * Proses logout
     */
    public function logout() {
        try {
            // Logout dari API
            $token = $this->apiClient->getApiToken();
            if ($token) {
                $this->apiClient->logout($token);
            }

            // Clear session
            $this->apiClient->clearApiToken();
            session_destroy();

        } catch (Exception $e) {
            // Log error tapi tetap clear session
            error_log("Logout Error: " . $e->getMessage());
            session_destroy();
        }

        header('Location: index.php?controller=auth&action=index');
        exit;
    }

    /**
     * Validasi data registrasi (Updated dengan validasi backend baru)
     */
    private function validateRegisterData($data) {
        $errors = [];

        // Validasi username
        if (empty($data['username'])) {
            $errors['username'] = 'Username wajib diisi';
        } elseif (strlen($data['username']) < 4) {
            $errors['username'] = 'Username minimal 4 karakter';
        } elseif (strlen($data['username']) > 255) {
            $errors['username'] = 'Username maksimal 255 karakter';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors['username'] = 'Username hanya boleh mengandung huruf, angka, dan underscore';
        }

        // Validasi password (sesuai frontend - minimal 4 karakter)
        if (empty($data['password'])) {
            $errors['password'] = 'Password wajib diisi';
        } elseif (strlen($data['password']) < 4) {
            $errors['password'] = 'Password minimal 4 karakter';
        }

        // Validasi password confirmation
        if (empty($data['password_confirmation'])) {
            $errors['password_confirmation'] = 'Konfirmasi password wajib diisi';
        } elseif ($data['password'] !== $data['password_confirmation']) {
            $errors['password_confirmation'] = 'Konfirmasi password tidak cocok';
        }

        // Validasi nama
        if (empty($data['nama'])) {
            $errors['nama'] = 'Nama lengkap wajib diisi';
        } elseif (strlen($data['nama']) < 3) {
            $errors['nama'] = 'Nama minimal 3 karakter';
        } elseif (strlen($data['nama']) > 255) {
            $errors['nama'] = 'Nama maksimal 255 karakter';
        }

        // Validasi email
        if (empty($data['email'])) {
            $errors['email'] = 'Email wajib diisi';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid';
        } elseif (strlen($data['email']) > 255) {
            $errors['email'] = 'Email maksimal 255 karakter';
        }

        // Validasi role (sesuai backend Laravel)
        if (empty($data['role'])) {
            $errors['role'] = 'Role wajib dipilih';
        } elseif (!$this->apiClient->isValidWebRole($data['role'])) {
            $errors['role'] = 'Role tidak valid untuk website. Pilih: Admin, PetugasBPBD, atau OperatorDesa';
        }

        // Validasi no telepon (optional)
        if (!empty($data['no_telepon'])) {
            if (!preg_match('/^[0-9]{10,13}$/', $data['no_telepon'])) {
                $errors['no_telepon'] = 'Format nomor telepon tidak valid. Gunakan 10-13 digit angka';
            } elseif (strlen($data['no_telepon']) > 20) {
                $errors['no_telepon'] = 'Nomor telepon maksimal 20 digit';
            }
        }

        // Validasi alamat (optional)
        if (!empty($data['alamat']) && strlen($data['alamat']) > 1000) {
            $errors['alamat'] = 'Alamat maksimal 1000 karakter';
        }

        // Validasi ID Desa (optional, harus numeric jika ada)
        if (!empty($data['id_desa'])) {
            if (!is_numeric($data['id_desa'])) {
                $errors['id_desa'] = 'ID Desa harus berupa angka';
            }
        }

        return $errors;
    }

    /**
     * Cek apakah user sudah login
     */
    private function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Redirect berdasarkan role user
     */
    private function redirectBasedOnRole() {
        $role = $_SESSION['role'] ?? '';

        switch ($role) {
            case 'Admin':
                header('Location: index.php?controller=dashboard&action=index');
                break;
            case 'PetugasBPBD':
                header('Location: index.php?controller=dashboard&action=index');
                break;
            case 'OperatorDesa':
                header('Location: index.php?controller=dashboard&action=index');
                break;
            default:
                header('Location: index.php?controller=beranda&action=index');
                break;
        }
        exit;
    }

    /**
     * Load view dengan template
     */
    private function loadView($viewName, $data = []) {
        // Extract data agar bisa diakses sebagai variabel
        extract($data);
        include 'views/auth/' . $viewName . '.php';
    }

    /**
     * Load standalone view tanpa template
     */
    private function loadStandaloneView($viewName, $data = []) {
        // Extract data agar bisa diakses sebagai variabel
        extract($data);

        // Include hanya view file
        include 'views/auth/' . $viewName . '.php';
    }

    /**
     * AJAX handler untuk check username availability
     */
    public function checkUsername() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';

            try {
                // Mock response untuk sekarang (nanti bisa diganti dengan API call)
                $isAvailable = !empty($username) && strlen($username) >= 4;

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'available' => $isAvailable
                ]);
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * AJAX handler untuk check email availability
     */
    public function checkEmail() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            try {
                $isAvailable = !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'available' => $isAvailable
                ]);
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Test connection ke backend API
     */
    public function testConnection() {
        try {
            // Test basic API connection
            $response = $this->apiClient->getApiStatus();

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Backend connection successful',
                'api_status' => $response,
                'api_base_url' => $this->apiClient->getApiBaseUrl(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Backend connection failed',
                'error' => $e->getMessage(),
                'api_base_url' => $this->apiClient->getApiBaseUrl(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Test BMKG API integration
     */
    public function testBMKGAPI() {
        try {
            // Test mock BMKG data (no auth required)
            $gempaResponse = $this->apiClient->getMockGempaTerbaru();
            $allDataResponse = $this->apiClient->getMockAllBMKGData();

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'BMKG API integration successful',
                'gempa_terbaru' => $gempaResponse,
                'all_data' => $allDataResponse,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'BMKG API integration failed',
                'error' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
?>