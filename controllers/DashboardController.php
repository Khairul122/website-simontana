<?php
require_once 'services/AuthService.php';

class DashboardController {
    private $authService;
    private $dashboardService;

    public function __construct() {
        $this->authService = new AuthService();

        // Pastikan pengguna sudah login
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        // Inisialisasi dashboard service
        require_once 'services/DashboardService.php';
        $this->dashboardService = new DashboardService();
    }

    public function admin() {
        $currentUser = $this->authService->getCurrentUser();

        // Pastikan role adalah Admin
        if ($currentUser['data']['role'] !== 'Admin') {
            // Jika bukan Admin, redirect ke halaman sesuai role
            $this->redirectToRoleDashboard($currentUser['data']['role']);
            return;
        }

        // Ambil data statistik untuk dashboard admin dengan error handling
        $stats = $this->dashboardService->getAdminDashboardStats();
        $latestReports = $this->dashboardService->getLatestReports(5);
        $weeklyStats = $this->dashboardService->getWeeklyReportStats();
        $monthlyStats = $this->dashboardService->getMonthlyReportStats();
        $userStats = $this->dashboardService->getUserStatistics();
        $categories = $this->dashboardService->getCategories();

        // Ambil data tambahan untuk chart
        $chartData = $this->dashboardService->getChartData();

        // Ambil data BMKG (Gempa Terbaru)
        $bmkgData = $this->dashboardService->getBmkgData();
        $bmkgGempaDirasakan = $this->dashboardService->getBmkgGempaDirasakan();

        // Siapkan semua data untuk ditampilkan di view
        $dashboardData = [
            'stats' => $stats,
            'latestReports' => $latestReports,
            'weeklyStats' => $weeklyStats,
            'monthlyStats' => $monthlyStats,
            'userStats' => $userStats,
            'categories' => $categories,
            'chartData' => $chartData,
            'bmkgData' => $bmkgData,
            'bmkgGempaDirasakan' => $bmkgGempaDirasakan
        ];

        $title = "Dashboard Admin - SIMONTA BENCANA";
        include 'views/dashboard/admin.php';
    }

    public function petugas() {
        $currentUser = $this->authService->getCurrentUser();

        // Pastikan role adalah PetugasBPBD
        if ($currentUser['data']['role'] !== 'PetugasBPBD') {
            // Jika bukan PetugasBPBD, redirect ke halaman sesuai role
            $this->redirectToRoleDashboard($currentUser['data']['role']);
            return;
        }

        $title = "Dashboard Petugas BPBD - SIMONTA BENCANA";
        include 'views/dashboard/petugas.php';
    }

    public function operator() {
        $currentUser = $this->authService->getCurrentUser();

        // Pastikan user login & role == 'OperatorDesa'
        if (!$currentUser['success'] || $currentUser['data']['role'] !== 'OperatorDesa') {
            // Jika bukan OperatorDesa, redirect ke halaman sesuai role
            $this->redirectToRoleDashboard($currentUser['data']['role'] ?? 'Guest');
            return;
        }

        // Ambil id_desa dari session user
        $id_desa = $currentUser['data']['id_desa'] ?? null;

        if (!$id_desa) {
            // Jika tidak ada id_desa, tampilkan error atau redirect
            $error_message = "Data desa tidak ditemukan untuk user ini.";
            $title = "Dashboard Operator Desa - SIMONTA BENCANA";
            include 'views/dashboard/operator.php';
            return;
        }

        // Panggil function service: $this->dashboardService->getStatistikDesa($id_desa)
        $dashboardData = $this->dashboardService->getStatistikDesa($id_desa);

        $title = "Dashboard Operator Desa - SIMONTA BENCANA";
        include 'views/dashboard/operator.php';
    }

    public function indexOperator() {
        $currentUser = $this->authService->getCurrentUser();

        // Pastikan user login & role == 'OperatorDesa'
        if (!$currentUser['success'] || $currentUser['data']['role'] !== 'OperatorDesa') {
            // Jika bukan OperatorDesa, redirect ke halaman sesuai role
            $this->redirectToRoleDashboard($currentUser['data']['role'] ?? 'Guest');
            return;
        }

        // Ambil id_desa dari session user
        $id_desa = $currentUser['data']['id_desa'] ?? null;

        if (!$id_desa) {
            // Jika tidak ada id_desa, tampilkan error atau redirect
            $error_message = "Data desa tidak ditemukan untuk user ini.";
            $title = "Dashboard Operator Desa - SIMONTA BENCANA";
            include 'views/dashboard/operator.php';
            return;
        }

        // Panggil function service: $this->dashboardService->getStatistikDesa($id_desa)
        $dashboardData = $this->dashboardService->getStatistikDesa($id_desa);

        $title = "Dashboard Operator Desa - SIMONTA BENCANA";
        include 'views/dashboard/operator.php';
    }

    // Fungsi umum untuk redirect berdasarkan role (untuk validasi akses)
    private function redirectToRoleDashboard($role) {
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
                header('Location: index.php?controller=Auth&action=login');
                break;
        }
        exit;
    }

    // Fungsi index yang bisa digunakan untuk redirect otomatis berdasarkan role
    public function index() {
        $currentUser = $this->authService->getCurrentUser();
        $this->redirectToRoleDashboard($currentUser['data']['role']);
    }
}