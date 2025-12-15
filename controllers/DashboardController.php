<?php
/**
 * Dashboard Controller for SIMONTA BENCANA Web Application
 * Handles dashboard functionality for Admin, Petugas BPBD, and Operator Desa
 */

class DashboardController {
    private $dashboardService;
    private $apiClient;

    public function __construct() {
        require_once __DIR__ . '/../services/DashboardService.php';
        require_once __DIR__ . '/../config/koneksi.php';

        $this->dashboardService = new DashboardService();
        $this->apiClient = getAPIClient();
    }

    /**
     * Admin Dashboard - Main dashboard for Admin role
     * URL: index.php?controller=dashboard&action=admin
     */
    public function admin() {
        // Check if user is logged in and has admin role
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        // Get API token
        $token = $this->apiClient->getApiToken();

        // Debug token status
        error_log("=== DASHBOARD CONTROLLER TOKEN DEBUG ===");
        error_log("Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? "ACTIVE" : "NOT ACTIVE"));
        error_log("Session Data: " . json_encode($_SESSION));
        error_log("Token from API Client: " . ($token ? "YES (" . strlen($token) . " chars)" : "NO"));
        error_log("Token Preview: " . ($token ? substr($token, 0, 30) . "..." : "N/A"));

        // If no token but user is logged in via session, create a mock token for testing
        if (!$token && isset($_SESSION['user']) && $_SESSION['logged_in']) {
            error_log("User logged in via session but no API token, creating mock token");
            $mockToken = 'mock_token_' . $_SESSION['user_id'] . '_' . time() . '_' . md5($_SESSION['username']);
            $this->apiClient->storeApiToken($mockToken);
            $token = $mockToken;
            error_log("Mock token created: " . substr($token, 0, 30) . "...");
        }

        if (!$token) {
            error_log("No token found and no active session, redirecting to login");
            // Try to refresh token or redirect to login
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        // Get dashboard data from backend API
        $dashboardData = $this->dashboardService->getAdminDashboardData($token);

        // Log API responses for debugging
        error_log("Admin Dashboard Data: " . json_encode($dashboardData));

        // Add API token to dashboard data for frontend use
        $dashboardData['api_token'] = $token;

        // Debug: Log token availability
        error_log("Dashboard token available: " . ($token ? "YES" : "NO"));
        error_log("Session token: " . ($_SESSION['bencana_api_token'] ?? "NOT SET"));

        // Extract variables for view
        $pageTitle = 'Dashboard Admin';
        $user = $_SESSION['user'];
        $dashboardData = $dashboardData;
        $lastUpdated = date('Y-m-d H:i:s');
        $apiClient = $this->apiClient;

        // Load view
        require_once __DIR__ . '/../views/dashboard/admin.php';
    }

    /**
     * Petugas Dashboard - Dashboard for Petugas BPBD role
     * URL: index.php?controller=dashboard&action=petugas
     */
    public function petugas() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'PetugasBPBD') {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        $token = $this->apiClient->getApiToken();
        if (!$token) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        $dashboardData = $this->dashboardService->getPetugasDashboardData($token);

        // Add API token to dashboard data for frontend use
        $dashboardData['api_token'] = $token;

        // Extract variables for view
        $pageTitle = 'Dashboard Petugas BPBD';
        $user = $_SESSION['user'];
        $dashboardData = $dashboardData;
        $lastUpdated = date('Y-m-d H:i:s');

        require_once __DIR__ . '/../views/dashboard/petugas.php';
    }

    /**
     * Operator Dashboard - Dashboard for Operator Desa role
     * URL: index.php?controller=dashboard&action=operator
     */
    public function operator() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        $token = $this->apiClient->getApiToken();
        if (!$token) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        $dashboardData = $this->dashboardService->getOperatorDashboardData($token);

        // Add API token to dashboard data for frontend use
        $dashboardData['api_token'] = $token;

        // Extract variables for view
        $pageTitle = 'Dashboard Operator Desa';
        $user = $_SESSION['user'];
        $dashboardData = $dashboardData;
        $lastUpdated = date('Y-m-d H:i:s');

        require_once __DIR__ . '/../views/dashboard/operator.php';
    }

    /**
     * API endpoint for refreshing dashboard data
     * URL: index.php?controller=dashboard&action=refreshData
     */
    public function refreshData() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['user'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
            exit();
        }

        $token = $this->apiClient->getApiToken();
        if (!$token) {
            echo json_encode([
                'success' => false,
                'message' => 'Token not found'
            ]);
            exit();
        }

        $role = $_SESSION['user']['role'];

        error_log("=== DASHBOARD REFRESH DATA REQUEST ===");
        error_log("User Role: " . $role);
        error_log("Token Available: " . ($token ? "YES" : "NO"));

        try {
            switch ($role) {
                case 'Admin':
                    error_log("Fetching Admin Dashboard Data...");
                    $data = $this->dashboardService->getAdminDashboardData($token);
                    break;
                case 'PetugasBPBD':
                    error_log("Fetching Petugas Dashboard Data...");
                    $data = $this->dashboardService->getPetugasDashboardData($token);
                    break;
                case 'OperatorDesa':
                    error_log("Fetching Operator Dashboard Data...");
                    $data = $this->dashboardService->getOperatorDashboardData($token);
                    break;
                default:
                    throw new Exception('Invalid role: ' . $role);
            }

            // Add API token to the response for frontend use
            $data['api_token'] = $token;
            error_log("Dashboard refresh successful. Data keys: " . json_encode(array_keys($data)));

            echo json_encode([
                'success' => true,
                'data' => $data,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Default action - redirect to appropriate dashboard based on role
     */
    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        $role = $_SESSION['user']['role'];

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
                // Redirect to login if role is not recognized
                header('Location: index.php?controller=auth&action=login');
                break;
        }
    }
}
?>