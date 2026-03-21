<?php
require_once 'services/AuthService.php';

class DashboardController {
    private $authService;
    private $dashboardService;

    public function __construct() {
        $this->authService = new AuthService();

        
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        
        require_once 'services/DashboardService.php';
        $this->dashboardService = new DashboardService();

        require_once 'services/BmkgService.php';
        $this->bmkgService = new BmkgService();
    }

    public function admin() {
        $currentUser = $this->authService->getCurrentUser();

        
        if ($currentUser['data']['role'] !== 'Admin') {
            
            $this->redirectToRoleDashboard($currentUser['data']['role']);
            return;
        }

        
        $stats = $this->dashboardService->getAdminDashboardStats();
        $latestReports = $this->dashboardService->getLatestReports(5);
        $weeklyStats = $this->dashboardService->getWeeklyReportStats();
        $monthlyStats = $this->dashboardService->getMonthlyReportStats();
        $userStats = $this->dashboardService->getUserStatistics();
        $categories = $this->dashboardService->getCategories();

        
        $chartData = $this->dashboardService->getChartData();

        
        $bmkgData = $this->bmkgService->getGempaTerbaru();
        $bmkgGempaDirasakan = $this->bmkgService->getGempaDirasakan();

        
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

        
        if ($currentUser['data']['role'] !== 'PetugasBPBD') {
            
            $this->redirectToRoleDashboard($currentUser['data']['role']);
            return;
        }

        
        $stats = $this->dashboardService->getDashboardPetugas();
        $latestReports = $this->dashboardService->getLatestReports(5);
        $weeklyStats = $this->dashboardService->getWeeklyReportStats();
        $categories = $this->dashboardService->getCategories();

        
        $chartData = $this->dashboardService->getChartData();

        
        $bmkgData = $this->bmkgService->getGempaTerbaru();
        $bmkgGempaDirasakan = $this->bmkgService->getGempaDirasakan();

        
        $dashboardData = [
            'stats' => $stats,
            'latestReports' => $latestReports,
            'weeklyStats' => $weeklyStats,
            'categories' => $categories,
            'chartData' => $chartData,
            'bmkgData' => $bmkgData,
            'bmkgGempaDirasakan' => $bmkgGempaDirasakan
        ];

        $title = "Dashboard Petugas BPBD - SIMONTA BENCANA";
        include 'views/dashboard/petugas.php';
    }

    public function operator() {
        $currentUser = $this->authService->getCurrentUser();

        
        if (!$currentUser['success'] || $currentUser['data']['role'] !== 'OperatorDesa') {
            
            $this->redirectToRoleDashboard($currentUser['data']['role'] ?? 'Guest');
            return;
        }

        
        $id_desa = $currentUser['data']['id_desa'] ?? null;

        if (!$id_desa) {
            
            $error_message = "Data desa tidak ditemukan untuk user ini.";
            $title = "Dashboard Operator Desa - SIMONTA BENCANA";
            include 'views/dashboard/operator.php';
            return;
        }

        
        $dashboardData = $this->dashboardService->getStatistikDesa($id_desa);

        $title = "Dashboard Operator Desa - SIMONTA BENCANA";
        include 'views/dashboard/operator.php';
    }

    public function indexOperator() {
        $currentUser = $this->authService->getCurrentUser();

        
        if (!$currentUser['success'] || $currentUser['data']['role'] !== 'OperatorDesa') {
            
            $this->redirectToRoleDashboard($currentUser['data']['role'] ?? 'Guest');
            return;
        }

        
        $id_desa = $currentUser['data']['id_desa'] ?? null;

        if (!$id_desa) {
            
            $error_message = "Data desa tidak ditemukan untuk user ini.";
            $title = "Dashboard Operator Desa - SIMONTA BENCANA";
            include 'views/dashboard/operator.php';
            return;
        }

        
        $dashboardData = $this->dashboardService->getStatistikDesa($id_desa);

        $title = "Dashboard Operator Desa - SIMONTA BENCANA";
        include 'views/dashboard/operator.php';
    }

    public function warga() {
        $currentUser = $this->authService->getCurrentUser();

        if (!$currentUser['success'] || ($currentUser['data']['role'] ?? '') !== 'Warga') {
            $this->redirectToRoleDashboard($currentUser['data']['role'] ?? 'Guest');
            return;
        }

        $latestReports = $this->dashboardService->getLatestReports(5);
        $categories = $this->dashboardService->getCategories();
        $bmkgData = $this->bmkgService->getGempaTerbaru();

        $dashboardData = [
            'latestReports' => $latestReports,
            'categories' => $categories,
            'bmkgData' => $bmkgData
        ];

        $title = "Dashboard Warga - SIMONTA BENCANA";
        include 'views/dashboard/warga.php';
    }

    
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
                header('Location: index.php?controller=Dashboard&action=warga');
                break;
            default:
                header('Location: index.php?controller=Auth&action=login');
                break;
        }
        exit;
    }

    
    public function index() {
        $currentUser = $this->authService->getCurrentUser();
        $this->redirectToRoleDashboard($currentUser['data']['role']);
    }
}
