<?php
/**
 * Laporan Controller for SIMONTA BENCANA Web Application
 * Handles report data retrieval and API endpoints for laporan functionality
 */

class LaporanController {
    private $apiClient;

    public function __construct() {
        require_once __DIR__ . '/../config/koneksi.php';
        $this->apiClient = getAPIClient();
    }

    /**
     * Default action - handles both web requests and API calls
     */
    public function index() {
        // Check if this is an API request
        if ($this->isApiRequest()) {
            $this->handleApiRequest();
            return;
        }

        // Handle regular web request
        $this->showLaporanPage();
    }

    /**
     * List action for API requests
     */
    public function list() {
        header('Content-Type: application/json');
        $this->handleApiRequest();
    }

    /**
     * getData action for AJAX requests
     */
    public function getData() {
        header('Content-Type: application/json');
        $this->handleApiRequest();
    }

    /**
     * Handle API requests for laporan data
     */
    private function handleApiRequest() {
        try {
            // Get token from session or headers
            $token = $this->getToken();

            if (!$token) {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => 'Unauthorized - No token provided'
                ]);
                return;
            }

            // Get data from API
            $data = $this->fetchLaporanFromAPI($token);

            if ($data) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Laporan data retrieved successfully',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to retrieve laporan data from API'
                ]);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Fetch laporan data from the actual API
     */
    private function fetchLaporanFromAPI($token) {
        try {
            // Try to get data from the Laravel API
            $response = $this->apiClient->apiRequest('laporan', 'GET', null, $token);

            if ($response && isset($response['success']) && $response['success']) {
                return $response['data'];
            }

            return null;

        } catch (Exception $e) {
            error_log('Error fetching laporan from API: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Show regular laporan page (for web interface)
     */
    private function showLaporanPage() {
        // For now, redirect to dashboard since we're focusing on API functionality
        header('Location: index.php?controller=dashboard&action=admin');
        exit;
    }

    /**
     * Check if the current request is an API request
     */
    private function isApiRequest() {
        return (
            isset($_GET['action']) && in_array($_GET['action'], ['list', 'getData']) ||
            isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false ||
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
        );
    }

    /**
     * Get authentication token
     */
    private function getToken() {
        // Try to get token from session first
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Use the same session key as in koneksi.php
        if (isset($_SESSION['bencana_api_token'])) {
            return $_SESSION['bencana_api_token'];
        }

        // Fallback: try to get token from Authorization header
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            if (strpos($authHeader, 'Bearer ') === 0) {
                return substr($authHeader, 7);
            }
        }

        return null;
    }

    /**
     * Statistics action for dashboard statistics
     */
    public function statistics() {
        header('Content-Type: application/json');

        try {
            $token = $this->getToken();
            if (!$token) {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => 'Unauthorized'
                ]);
                return;
            }

            $data = $this->fetchLaporanFromAPI($token);
            $statistics = $this->processStatistics($data);

            echo json_encode([
                'success' => true,
                'message' => 'Statistics retrieved successfully',
                'data' => $statistics
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Process laporan data for statistics
     */
    private function processStatistics($data) {
        if (!$data || !isset($data['data'])) {
            return [
                'total' => 0,
                'masuk' => 0,
                'diproses' => 0,
                'selesai' => 0
            ];
        }

        $laporans = $data['data'];
        $stats = [
            'total' => count($laporans),
            'masuk' => 0,
            'diproses' => 0,
            'selesai' => 0
        ];

        foreach ($laporans as $laporan) {
            $status = $laporan['status_laporan'] ?? '';
            switch (strtolower($status)) {
                case 'masuk':
                    $stats['masuk']++;
                    break;
                case 'diproses':
                    $stats['diproses']++;
                    break;
                case 'selesai':
                    $stats['selesai']++;
                    break;
            }
        }

        return $stats;
    }
}
?>