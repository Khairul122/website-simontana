<?php

require_once 'koneksi.php';

class GlobalEnvironment {
    private static $instance = null;
    private $apiClient;
    private $currentUser;
    private $isLoggedIn;

    private function __construct() {
        static $apiClientInstance = null;

        if ($apiClientInstance === null) {
            $apiClientInstance = new BencanaAPIClient();
        }

        $this->apiClient = $apiClientInstance;
        $this->currentUser = $this->apiClient->getCurrentUser();
        $this->isLoggedIn = $this->currentUser !== null;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
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
        return $this->getCurrentRole() === $requiredRole;
    }

    public function hasAnyRole(array $roles) {
        return in_array($this->getCurrentRole(), $roles);
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

        $role = $this->getCurrentRole();

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
                header('Location: index.php?controller=beranda&action=index');
                break;
        }
        exit;
    }

    public function login($token) {
        $this->apiClient->setToken($token);
        $this->currentUser = $this->apiClient->getCurrentUser();
        $this->isLoggedIn = true;
    }

    public function logout() {
        $this->apiClient->logout();
        $this->currentUser = null;
        $this->isLoggedIn = false;
    }

    public function refreshCurrentUser() {
        $this->currentUser = $this->apiClient->getCurrentUser();
        $this->isLoggedIn = $this->currentUser !== null;
    }

    public function getDashboardUrl() {
        if (!$this->isLoggedIn) {
            return 'index.php?controller=auth&action=login';
        }

        $role = $this->getCurrentRole();

        switch ($role) {
            case 'admin':
                return 'index.php?controller=dashboard&action=admin';
            case 'petugas':
                return 'index.php?controller=dashboard&action=petugas';
            case 'operator':
                return 'index.php?controller=dashboard&action=operator';
            default:
                return 'index.php?controller=beranda&action=index';
        }
    }

    public function getPermissions() {
        $role = $this->getCurrentRole();

        $permissions = [
            'admin' => [
                'dashboard.view', 'user.create', 'user.read', 'user.update', 'user.delete',
                'laporan.create', 'laporan.read', 'laporan.update', 'laporan.delete',
                'tindaklanjut.create', 'tindaklanjut.read', 'tindaklanjut.update', 'tindaklanjut.delete',
                'monitoring.create', 'monitoring.read', 'monitoring.update', 'monitoring.delete',
                'kategori.create', 'kategori.read', 'kategori.update', 'kategori.delete'
            ],
            'petugas' => [
                'dashboard.view', 'laporan.read', 'laporan.update',
                'tindaklanjut.create', 'tindaklanjut.read', 'tindaklanjut.update',
                'monitoring.read', 'monitoring.create', 'monitoring.update',
                'bmkg.read'
            ],
            'operator' => [
                'dashboard.view', 'laporan.read', 'laporan.update',
                'tindaklanjut.read', 'tindaklanjut.create',
                'monitoring.read', 'monitoring.create', 'monitoring.update'
            ],
            'warga' => [
                'laporan.create', 'laporan.read',
                'informasi.read'
            ]
        ];

        return $permissions[$role] ?? [];
    }

    public function hasPermission($permission) {
        $permissions = $this->getPermissions();
        return in_array($permission, $permissions);
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

function globalEnv() {
    return GlobalEnvironment::getInstance();
}

function getAPIClient() {
    static $apiClient = null;

    if ($apiClient === null) {
        $apiClient = new BencanaAPIClient();
    }

    return $apiClient;
}

function currentUser() {
    return globalEnv()->getCurrentUser();
}

function currentRole() {
    return globalEnv()->getCurrentRole();
}

function currentUserId() {
    return globalEnv()->getCurrentUserId();
}

function isLoggedIn() {
    return globalEnv()->isLoggedIn();
}

function hasRole($role) {
    return globalEnv()->hasRole($role);
}

function hasPermission($permission) {
    return globalEnv()->hasPermission($permission);
}

function requireAuth() {
    globalEnv()->requireAuth();
}

function requireRole($role) {
    globalEnv()->requireRole($role);
}

function requirePermission($permission) {
    globalEnv()->requirePermission($permission);
}

function redirectBasedOnRole() {
    globalEnv()->redirectBasedOnRole();
}
?>