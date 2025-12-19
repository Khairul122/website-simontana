<?php

require_once 'koneksi.php';

class GlobalEnvironment {
    private $apiClient;
    private $currentUser;
    private $isLoggedIn;

    public function __construct($apiClient = null) {
        $this->apiClient = $apiClient ?: new BencanaAPIClient();
        $this->refreshAuthStatus();
    }

    public function getAPIClient() {
        return $this->apiClient;
    }

    public function getCurrentUser() {
        return $this->currentUser;
    }

    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

    public function getCurrentRole() {
        return $this->currentUser['role'] ?? null;
    }

    public function getCurrentUserId() {
        return $this->currentUser['sub'] ?? null;
    }

    public function getCurrentUsername() {
        return $this->currentUser['username'] ?? null;
    }

    public function hasRole($requiredRole) {
        $currentRole = $this->getCurrentRole();

        // Normalisasi role untuk perbandingan
        $normalizedCurrentRole = $this->normalizeRole($currentRole);
        $normalizedRequiredRole = $this->normalizeRole($requiredRole);

        return $normalizedCurrentRole === $normalizedRequiredRole;
    }

    public function hasAnyRole(array $roles) {
        $currentRole = $this->getCurrentRole();
        $normalizedCurrentRole = $this->normalizeRole($currentRole);

        foreach ($roles as $role) {
            if ($normalizedCurrentRole === $this->normalizeRole($role)) {
                return true;
            }
        }

        return false;
    }

    private function normalizeRole($role) {
        // Normalisasi role untuk perbandingan
        $role = (string)$role;

        // Mapping role ke bentuk yang seragam (tanpa duplikat)
        $roleMap = [
            'admin' => 'admin',
            'PetugasBPBD' => 'petugas',
            'OperatorDesa' => 'operator'
        ];

        return $roleMap[$role] ?? $role;
    }

    public function requireAuth() {
        if (!$this->isLoggedIn) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    public function requireRole($requiredRole) {
        $this->requireAuth();

        if (!$this->hasRole($requiredRole)) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit;
        }
    }

    public function requireAnyRole(array $roles) {
        $this->requireAuth();

        if (!$this->hasAnyRole($roles)) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit;
        }
    }

    public function redirectBasedOnRole() {
        if (!$this->isLoggedIn) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $role = $this->normalizeRole($this->getCurrentRole());

        switch ($role) {
            case 'admin':
                header('Location: index.php?controller=dashboard&action=admin');
                break;
            case 'petugas':
                header('Location: index.php?controller=dashboard&action=petugas');
                break;
            case 'operator':
                header('Location: index.php?controller=dashboard&action=operator');
                break;
            default:
                header('Location: index.php?controller=dashboard&action=index');
                break;
        }
        exit;
    }

    public function login($token) {
        $this->apiClient->setToken($token);
        $this->refreshAuthStatus();
    }

    public function logout() {
        $this->apiClient->clearToken();
        $this->currentUser = null;
        $this->isLoggedIn = false;
    }

    public function refreshAuthStatus() {
        $this->currentUser = $this->apiClient->getCurrentUser();
        $this->isLoggedIn = $this->currentUser !== null;
    }

    // Fungsi alias untuk backward compatibility
    public function refreshCurrentUser() {
        $this->refreshAuthStatus();
    }

    public function getDashboardUrl() {
        if (!$this->isLoggedIn) {
            return 'index.php?controller=auth&action=login';
        }

        $role = $this->normalizeRole($this->getCurrentRole());

        switch ($role) {
            case 'admin':
                return 'index.php?controller=dashboard&action=admin';
            case 'petugas':
                return 'index.php?controller=dashboard&action=petugas';
            case 'operator':
                return 'index.php?controller=dashboard&action=operator';
            default:
                return 'index.php?controller=dashboard&action=index';
        }
    }

    public function hasPermission($permission) {
        // Fungsi ini sementara selalu mengembalikan true karena permissions belum diimplementasikan
        return true;
    }

    public function requirePermission($permission) {
        $this->requireAuth();

        if (!$this->hasPermission($permission)) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit;
        }
    }
}

// Fungsi helper untuk membuat instance baru setiap kali dipanggil
function createGlobalEnvironment($apiClient = null) {
    return new GlobalEnvironment($apiClient);
}

// Fungsi untuk membuat instance baru setiap kali dipanggil (lebih dinamis)
function globalEnv() {
    return createGlobalEnvironment();
}

// Fungsi helper untuk mendapatkan API client langsung
function getAPIClient() {
    static $apiClient = null;

    if ($apiClient === null) {
        $apiClient = new BencanaAPIClient();
    }

    return $apiClient;
}

// Fungsi helper untuk mendapatkan data user secara langsung tanpa instance cache
function currentUser() {
    $env = createGlobalEnvironment();
    return $env->getCurrentUser();
}

function currentRole() {
    $env = createGlobalEnvironment();
    return $env->getCurrentRole();
}

function currentUserId() {
    $env = createGlobalEnvironment();
    return $env->getCurrentUserId();
}

function isLoggedIn() {
    $env = createGlobalEnvironment();
    return $env->isLoggedIn();
}

function hasRole($role) {
    $env = createGlobalEnvironment();
    return $env->hasRole($role);
}

function hasPermission($permission) {
    $env = createGlobalEnvironment();
    return $env->hasPermission($permission);
}

function requireAuth() {
    $env = createGlobalEnvironment();
    $env->requireAuth();
}

function requireRole($role) {
    $env = createGlobalEnvironment();
    $env->requireRole($role);
}

function requirePermission($permission) {
    $env = createGlobalEnvironment();
    $env->requirePermission($permission);
}

function redirectBasedOnRole() {
    $env = createGlobalEnvironment();
    $env->redirectBasedOnRole();
}
?>