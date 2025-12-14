<?php
/**
 * DashboardController - Controller untuk halaman dashboard
 * Sesuai PERANCANGAN.md: Website hanya untuk Admin, Petugas BPBD, Operator Desa
 */

class DashboardController {
    private $apiClient;
    private $dashboardService;

    public function __construct() {
        // Inisialisasi API Client
        require_once 'config/koneksi.php';
        require_once 'services/DashboardService.php';
        $this->apiClient = getAPIClient();
        $this->dashboardService = new DashboardService($this->apiClient);
    }

    /**
     * Cek apakah user sudah login
     */
    private function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Redirect ke login jika belum login
     */
    private function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    /**
     * Get current user role
     */
    private function getCurrentRole() {
        return $_SESSION['role'] ?? '';
    }

    /**
     * Main dashboard entry point - routing berdasarkan role
     */
    public function index() {
        $this->requireLogin();

        $role = $this->getCurrentRole();

        switch ($role) {
            case 'Admin':
                $this->admin();
                break;
            case 'PetugasBPBD':
                $this->petugas();
                break;
            case 'OperatorDesa':
                $this->operator();
                break;
            default:
                // Role tidak dikenal, redirect ke login
                $_SESSION['error'] = 'Role tidak valid. Silakan login kembali.';
                header('Location: index.php?controller=auth&action=login');
                exit;
        }
    }

    /**
     * Dashboard untuk Admin
     */
    public function admin() {
        $this->requireLogin();

        if ($this->getCurrentRole() !== 'Admin') {
            $_SESSION['error'] = 'Akses ditolak. Anda tidak memiliki hak akses sebagai Admin.';
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        try {
            // Ambil data dashboard untuk admin menggunakan DashboardService
            $token = $this->apiClient->getApiToken();
            $dashboardData = $this->dashboardService->getDashboardData($token, 'Admin');
            $dashboardSummary = $this->dashboardService->getDashboardSummary($dashboardData, 'Admin');

            // Format BMKG data untuk display
            $bmkgFormatted = [];
            if (!empty($dashboardData['bmkg_data'])) {
                $bmkgFormatted = $this->dashboardService->formatBMKGData($dashboardData['bmkg_data']);
            }

            // Get quick actions
            $quickActions = $this->dashboardService->getQuickActions('Admin');

            $data = [
                'title' => 'Dashboard Admin - SIMONTA BENCANA',
                'page' => 'dashboard',
                'role' => 'Admin',
                'user' => [
                    'nama' => $_SESSION['nama'] ?? '',
                    'username' => $_SESSION['username'] ?? '',
                    'avatar' => $this->dashboardService->getUserAvatar($_SESSION['nama'] ?? '')
                ],
                'dashboard' => array_merge($dashboardData, [
                    'summary' => $dashboardSummary,
                    'bmkg_formatted' => $bmkgFormatted,
                    'quick_actions' => $quickActions,
                    'notifications' => $this->dashboardService->getNotifications($_SESSION['user_id'] ?? null, 'Admin')
                ])
            ];

            // Ambil notifikasi dari session
            if (isset($_SESSION['success'])) {
                $data['success'] = $_SESSION['success'];
                unset($_SESSION['success']);
            }

            if (isset($_SESSION['error'])) {
                $data['error'] = $_SESSION['error'];
                unset($_SESSION['error']);
            }

            $this->loadView('dashboard/admin', $data);

        } catch (Exception $e) {
            $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->loadView('dashboard/admin', [
                'title' => 'Dashboard Admin - SIMONTA BENCANA',
                'page' => 'dashboard',
                'role' => 'Admin',
                'user' => [
                    'nama' => $_SESSION['nama'] ?? '',
                    'username' => $_SESSION['username'] ?? ''
                ],
                'dashboard' => $this->getDefaultDashboardData()
            ]);
        }
    }

    /**
     * Dashboard untuk Petugas BPBD
     */
    public function petugas() {
        $this->requireLogin();

        if ($this->getCurrentRole() !== 'PetugasBPBD') {
            $_SESSION['error'] = 'Akses ditolak. Anda tidak memiliki hak akses sebagai Petugas BPBD.';
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        try {
            // Ambil data dashboard untuk petugas BPBD menggunakan DashboardService
            $token = $this->apiClient->getApiToken();
            $dashboardData = $this->dashboardService->getDashboardData($token, 'PetugasBPBD');
            $dashboardSummary = $this->dashboardService->getDashboardSummary($dashboardData, 'PetugasBPBD');

            // Format BMKG data untuk display
            $bmkgFormatted = [];
            if (!empty($dashboardData['bmkg_data'])) {
                $bmkgFormatted = $this->dashboardService->formatBMKGData($dashboardData['bmkg_data']);
            }

            // Get quick actions
            $quickActions = $this->dashboardService->getQuickActions('PetugasBPBD');

            $data = [
                'title' => 'Dashboard Petugas BPBD - SIMONTA BENCANA',
                'page' => 'dashboard',
                'role' => 'PetugasBPBD',
                'user' => [
                    'nama' => $_SESSION['nama'] ?? '',
                    'username' => $_SESSION['username'] ?? '',
                    'avatar' => $this->dashboardService->getUserAvatar($_SESSION['nama'] ?? '')
                ],
                'dashboard' => array_merge($dashboardData, [
                    'summary' => $dashboardSummary,
                    'bmkg_formatted' => $bmkgFormatted,
                    'quick_actions' => $quickActions,
                    'notifications' => $this->dashboardService->getNotifications($_SESSION['user_id'] ?? null, 'PetugasBPBD')
                ])
            ];

            // Ambil notifikasi dari session
            if (isset($_SESSION['success'])) {
                $data['success'] = $_SESSION['success'];
                unset($_SESSION['success']);
            }

            if (isset($_SESSION['error'])) {
                $data['error'] = $_SESSION['error'];
                unset($_SESSION['error']);
            }

            $this->loadView('dashboard/petugas', $data);

        } catch (Exception $e) {
            $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->loadView('dashboard/petugas', [
                'title' => 'Dashboard Petugas BPBD - SIMONTA BENCANA',
                'page' => 'dashboard',
                'role' => 'PetugasBPBD',
                'user' => [
                    'nama' => $_SESSION['nama'] ?? '',
                    'username' => $_SESSION['username'] ?? ''
                ],
                'dashboard' => $this->getDefaultDashboardData()
            ]);
        }
    }

    /**
     * Dashboard untuk Operator Desa
     */
    public function operator() {
        $this->requireLogin();

        if ($this->getCurrentRole() !== 'OperatorDesa') {
            $_SESSION['error'] = 'Akses ditolak. Anda tidak memiliki hak akses sebagai Operator Desa.';
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        try {
            // Ambil data dashboard untuk operator desa menggunakan DashboardService
            $token = $this->apiClient->getApiToken();
            $dashboardData = $this->dashboardService->getDashboardData($token, 'OperatorDesa');
            $dashboardSummary = $this->dashboardService->getDashboardSummary($dashboardData, 'OperatorDesa');

            // Format BMKG data untuk display
            $bmkgFormatted = [];
            if (!empty($dashboardData['local_cuaca'])) {
                $bmkgFormatted = $this->dashboardService->formatBMKGData($dashboardData['local_cuaca']);
            }

            // Get quick actions
            $quickActions = $this->dashboardService->getQuickActions('OperatorDesa');

            $data = [
                'title' => 'Dashboard Operator Desa - SIMONTA BENCANA',
                'page' => 'dashboard',
                'role' => 'OperatorDesa',
                'user' => [
                    'nama' => $_SESSION['nama'] ?? '',
                    'username' => $_SESSION['username'] ?? '',
                    'avatar' => $this->dashboardService->getUserAvatar($_SESSION['nama'] ?? '')
                ],
                'dashboard' => array_merge($dashboardData, [
                    'summary' => $dashboardSummary,
                    'bmkg_formatted' => $bmkgFormatted,
                    'quick_actions' => $quickActions,
                    'notifications' => $this->dashboardService->getNotifications($_SESSION['user_id'] ?? null, 'OperatorDesa')
                ])
            ];

            // Ambil notifikasi dari session
            if (isset($_SESSION['success'])) {
                $data['success'] = $_SESSION['success'];
                unset($_SESSION['success']);
            }

            if (isset($_SESSION['error'])) {
                $data['error'] = $_SESSION['error'];
                unset($_SESSION['error']);
            }

            $this->loadView('dashboard/operator', $data);

        } catch (Exception $e) {
            $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->loadView('dashboard/operator', [
                'title' => 'Dashboard Operator Desa - SIMONTA BENCANA',
                'page' => 'dashboard',
                'role' => 'OperatorDesa',
                'user' => [
                    'nama' => $_SESSION['nama'] ?? '',
                    'username' => $_SESSION['username'] ?? ''
                ],
                'dashboard' => $this->getDefaultDashboardData()
            ]);
        }
    }

    /**
     * Get admin dashboard data
     */
    private function getAdminDashboardData() {
        try {
            $token = $this->apiClient->getApiToken();
            if (!$token) {
                throw new Exception('Token tidak ditemukan');
            }

            // Ambil laporan statistics - gunakan method yang sesuai
            $laporanStats = $this->apiClient->getLaporanStats($token);

            // Ambil user statistics dari admin users endpoint
            $userStats = $this->apiClient->getUserStats($token);

            // Ambil recent laporan - gunakan method yang sesuai
            $laporanResponse = $this->apiClient->getLaporan($token, ['limit' => 5]);

            // Ambil recent monitoring - gunakan method yang sesuai
            $recentMonitoring = $this->apiClient->getRecentMonitoring($token, 5);

            // Ambil data BMKG Dashboard - gunakan method yang sesuai
            $bmkgData = $this->apiClient->getLatestBMKG($token);

            // Debug: Log semua response
            error_log("Admin Dashboard - Laporan Stats: " . json_encode($laporanStats));
            error_log("Admin Dashboard - User Stats: " . json_encode($userStats));
            error_log("Admin Dashboard - Recent Laporan: " . json_encode($laporanResponse));
            error_log("Admin Dashboard - Recent Monitoring: " . json_encode($recentMonitoring));
            error_log("Admin Dashboard - BMKG Data: " . json_encode($bmkgData));

            return [
                'stats' => [
                    'total_laporan' => $this->apiClient->extractStats($laporanStats)['total'] ?? 0,
                    'laporan_menunggu' => $this->apiClient->extractStats($laporanStats)['menunggu'] ?? 0,
                    'laporan_diproses' => $this->apiClient->extractStats($laporanStats)['diproses'] ?? 0,
                    'laporan_selesai' => $this->apiClient->extractStats($laporanStats)['selesai'] ?? 0,
                    'total_pengguna' => $userStats['total'] ?? 0,
                    'pengguna_aktif' => $userStats['aktif'] ?? 0
                ],
                'recent_laporan' => $this->apiClient->extractData($laporanResponse, 'laporan'),
                'recent_monitoring' => $this->apiClient->extractData($recentMonitoring, 'monitoring'),
                'bmkg_info' => $bmkgData
            ];

        } catch (Exception $e) {
            error_log("Dashboard Admin Error: " . $e->getMessage());
            return $this->getDefaultDashboardData();
        }
    }

    /**
     * Get petugas dashboard data
     */
    private function getPetugasDashboardData() {
        try {
            $token = $this->apiClient->getApiToken();
            if (!$token) {
                throw new Exception('Token tidak ditemukan');
            }

            // Ambil laporan statistics - gunakan method yang sesuai
            $laporanStats = $this->apiClient->getLaporanStats($token);

            // Ambil pending laporan - gunakan method yang sesuai
            $pendingLaporan = $this->apiClient->getPendingLaporan($token);

            // Ambil recent monitoring - gunakan method yang sesuai
            $recentMonitoring = $this->apiClient->getRecentMonitoring($token, 10);

            // Ambil BMKG warnings - gunakan method yang sesuai
            $bmkgWarnings = $this->apiClient->getBMKGWarnings($token);

            // Get BPBD statistics - gunakan method yang sesuai
            $bpbdStats = $this->apiClient->getBPBDReports($token);

            // Debug: Log semua response
            error_log("Petugas Dashboard - Laporan Stats: " . json_encode($laporanStats));
            error_log("Petugas Dashboard - Pending Laporan: " . json_encode($pendingLaporan));
            error_log("Petugas Dashboard - Recent Monitoring: " . json_encode($recentMonitoring));
            error_log("Petugas Dashboard - BMKG Warnings: " . json_encode($bmkgWarnings));
            error_log("Petugas Dashboard - BPBD Stats: " . json_encode($bpbdStats));

            return [
                'stats' => [
                    'laporan_menunggu' => count($pendingLaporan['data'] ?? $pendingLaporan['laporan'] ?? []),
                    'laporan_diproses' => $laporanStats['data']['diproses'] ?? ($laporanStats['diproses'] ?? 0),
                    'laporan_selesai' => $laporanStats['data']['selesai'] ?? ($laporanStats['selesai'] ?? 0),
                    'peringatan_aktif' => count($bmkgWarnings['data'] ?? $bmkgWarnings['warnings'] ?? [])
                ],
                'pending_laporan' => $pendingLaporan['data'] ?? $pendingLaporan['laporan'] ?? [],
                'recent_monitoring' => $recentMonitoring['monitoring'] ?? $recentMonitoring['data'] ?? [],
                'bmkg_warnings' => $bmkgWarnings['data'] ?? $bmkgWarnings['warnings'] ?? []
            ];

        } catch (Exception $e) {
            error_log("Dashboard Petugas Error: " . $e->getMessage());
            return $this->getDefaultDashboardData();
        }
    }

    /**
     * Get operator dashboard data
     */
    private function getOperatorDashboardData() {
        try {
            $token = $this->apiClient->getApiToken();
            if (!$token) {
                throw new Exception('Token tidak ditemukan');
            }

            // Ambil laporan desa operator - gunakan method yang sesuai
            $desaLaporan = $this->apiClient->getDesaLaporan($token, $_SESSION['user_id']);

            // Ambil monitoring yang perlu dilakukan - gunakan method yang sesuai
            $pendingMonitoring = $this->apiClient->getPendingMonitoring($token);

            // Ambil data BMKG lokal - gunakan method yang sesuai
            $localBMKG = $this->apiClient->getLocalBMKG($token);

            // Get operator reports for additional stats - gunakan method yang sesuai
            $operatorReports = $this->apiClient->getOperatorReports($token);

            // Debug: Log semua response
            error_log("Operator Dashboard - Desa Laporan: " . json_encode($desaLaporan));
            error_log("Operator Dashboard - Pending Monitoring: " . json_encode($pendingMonitoring));
            error_log("Operator Dashboard - Local BMKG: " . json_encode($localBMKG));
            error_log("Operator Dashboard - Operator Reports: " . json_encode($operatorReports));

            // Count reports today - handle multiple data structures
            $reportsData = $desaLaporan['data'] ?? $desaLaporan['laporan'] ?? [];
            $todayReports = count(array_filter($reportsData, function($report) {
                return isset($report['created_at']) &&
                       date('Y-m-d', strtotime($report['created_at'])) === date('Y-m-d');
            }));

            // Determine village status based on warnings - handle multiple data structures
            $warningsData = $localBMKG['warnings'] ?? $localBMKG['data'] ?? [];
            $statusDesa = 'aman';
            if (!empty($warningsData)) {
                $statusDesa = 'waspada';
            }

            return [
                'stats' => [
                    'total_laporan_desa' => count($reportsData),
                    'laporan_hari_ini' => $todayReports,
                    'monitoring_menunggu' => count($pendingMonitoring['data'] ?? $pendingMonitoring['monitoring'] ?? []),
                    'status_desa' => $statusDesa
                ],
                'desa_laporan' => $reportsData,
                'pending_monitoring' => $pendingMonitoring['data'] ?? $pendingMonitoring['monitoring'] ?? [],
                'local_bmkg' => $localBMKG
            ];

        } catch (Exception $e) {
            error_log("Dashboard Operator Error: " . $e->getMessage());
            return $this->getDefaultDashboardData();
        }
    }

    /**
     * Get default dashboard data (fallback)
     */
    private function getDefaultDashboardData() {
        return [
            'stats' => [
                'total_laporan' => 0,
                'laporan_menunggu' => 0,
                'laporan_diproses' => 0,
                'laporan_selesai' => 0,
                'total_pengguna' => 0,
                'pengguna_aktif' => 0,
                'peringatan_aktif' => 0
            ],
            'recent_laporan' => [],
            'recent_monitoring' => [],
            'bmkg_info' => null,
            'bmkg_warnings' => [],
            'pending_laporan' => [],
            'desa_laporan' => [],
            'pending_monitoring' => [],
            'local_bmkg' => null
        ];
    }

    
    /**
     * Load view standalone dengan template admin
     */
    private function loadView($viewName, $data = []) {
        // Extract data agar bisa diakses sebagai variabel
        extract($data);

        // Load view file yang sudah lengkap dengan template
        include 'views/' . $viewName . '.php';
    }

    /**
     * Test dashboard API endpoints (untuk development)
     */
    public function testDashboardAPI() {
        try {
            $token = $this->apiClient->getApiToken();
            $role = $this->getCurrentRole();

            if (!$token) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'User not authenticated'
                ]);
                return;
            }

            // Test various dashboard endpoints
            $testResults = [
                'laporan_stats' => $this->apiClient->getLaporanStats($token),
                'recent_laporan' => $this->apiClient->getLaporan($token, ['limit' => 5]),
                'pending_laporan' => $this->apiClient->getPendingLaporan($token),
                'bmkg_data' => $this->apiClient->getMockAllBMKGData(),
                'bmkg_earthquake' => $this->apiClient->getMockGempaTerbaru()
            ];

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Dashboard API test completed',
                'role' => $role,
                'results' => $testResults,
                'timestamp' => date('Y-m-d H:i:s')
            ]);

        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Dashboard API test failed: ' . $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Refresh dashboard data via AJAX
     */
    public function refreshData() {
        try {
            $token = $this->apiClient->getApiToken();
            $role = $this->getCurrentRole();

            if (!$token) {
                throw new Exception('User not authenticated');
            }

            // Get fresh dashboard data
            $dashboardData = $this->dashboardService->getDashboardData($token, $role);
            $dashboardSummary = $this->dashboardService->getDashboardSummary($dashboardData, $role);

            // Format BMKG data
            $bmkgFormatted = [];
            if (!empty($dashboardData['bmkg_data']) || !empty($dashboardData['local_cuaca'])) {
                $bmkgSource = $dashboardData['bmkg_data'] ?? $dashboardData['local_cuaca'];
                $bmkgFormatted = $this->dashboardService->formatBMKGData($bmkgSource);
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Dashboard data refreshed successfully',
                'data' => [
                    'dashboard' => $dashboardData,
                    'summary' => $dashboardSummary,
                    'bmkg_formatted' => $bmkgFormatted
                ],
                'timestamp' => date('Y-m-d H:i:s')
            ]);

        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Failed to refresh dashboard data: ' . $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
?>