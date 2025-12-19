<?php
session_start();
require_once 'config/globals.php';

// Mock beranda controller functionality
class TestBerandaController {
    private $globalEnv;

    public function __construct() {
        $this->globalEnv = globalEnv();
    }

    public function index() {
        $this->globalEnv->requireAuth();

        $currentUser = $this->globalEnv->getCurrentUser();

        $recentLaporan = [];
        $bmkgAlerts = [];
        $userStats = [
            'total_laporan' => 0,
            'pending_laporan' => 0,
            'verified_laporan' => 0
        ];

        try {
            $apiClient = $this->globalEnv->getAPIClient();
            $recentLaporan = $apiClient->get('laporan', ['limit' => 6, 'sort' => 'created_at', 'order' => 'desc'])['data'] ?? [];
            $bmkgAlerts = $apiClient->get('bmkg/peringatan-dini')['data'] ?? [];
            $userStats = $this->getUserStats($currentUser);
        } catch (Exception $apiError) {
            // Keep default values if API fails
        }

        $data = [
            'user' => $currentUser,
            'recent_laporan' => $recentLaporan,
            'bmkg_alerts' => $bmkgAlerts,
            'user_stats' => $userStats,
            'page_title' => 'Beranda'
        ];

        extract($data);
        include __DIR__ . '/views/beranda/index.php';
    }

    private function getUserStats($currentUser) {
        $stats = [
            'total_laporan' => 0,
            'pending_laporan' => 0,
            'verified_laporan' => 0
        ];

        try {
            $apiClient = $this->globalEnv->getAPIClient();
            $userLaporan = $apiClient->get('laporan', ['user_id' => $currentUser['sub']])['data'] ?? [];

            $stats['total_laporan'] = count($userLaporan);
            $stats['pending_laporan'] = count(array_filter($userLaporan, function($laporan) {
                return ($laporan['status'] ?? '') === 'pending';
            }));
            $stats['verified_laporan'] = count(array_filter($userLaporan, function($laporan) {
                return in_array($laporan['status'] ?? '', ['verified', 'proses', 'selesai']);
            }));
        } catch (Exception $e) {
            // Keep default values on error
        }

        return $stats;
    }
}

function getStatusBadgeColor($status) {
    $colors = [
        'pending' => 'warning',
        'verified' => 'info',
        'proses' => 'primary',
        'selesai' => 'success',
        'ditolak' => 'danger'
    ];
    return $colors[$status] ?? 'secondary';
}

// Test without actual login - just show the template
echo "Testing Beranda view with mock data...\n";

// Mock session data
$_SESSION['user_data'] = [
    'name' => 'Test User',
    'username' => 'testuser',
    'sub' => 1,
    'role' => 'warga'
];

$controller = new TestBerandaController();
echo "Controller created successfully\n";
?>