<?php
/**
 * DashboardController - Controller untuk dashboard SIMONTA BENCANA
 * Menampilkan dashboard yang berbeda untuk setiap role (Admin, Petugas BPBD, Operator Desa, Warga)
 */

require_once __DIR__ . '/../config/koneksi.php';

class DashboardController {
    private $apiClient;

    public function __construct() {
        $this->apiClient = getAPIClient();
    }

    /**
     * Cek autentikasi sebelum mengakses dashboard
     */
    private function requireAuth() {
        if (!isLoggedIn()) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    /**
     * Dashboard untuk Admin
     */
    public function admin() {
        $this->requireAuth();

        if (!hasRole('admin')) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit;
        }

        try {
            // Get data statistik untuk dashboard admin
            $laporanStats = $this->apiClient->get('laporan/statistik')['data'] ?? [];
            $totalUsers = $this->apiClient->get('users/count')['data'] ?? 0;
            $totalLaporan = $this->apiClient->get('laporan/count')['data'] ?? 0;
            $recentLaporan = $this->apiClient->get('laporan', ['limit' => 5, 'sort' => 'created_at', 'order' => 'desc'])['data'] ?? [];
            $recentUsers = $this->apiClient->get('users', ['limit' => 5, 'sort' => 'created_at', 'order' => 'desc'])['data'] ?? [];

            $data = [
                'user' => $this->apiClient->getCurrentUser(),
                'laporan_stats' => $laporanStats,
                'total_users' => $totalUsers,
                'total_laporan' => $totalLaporan,
                'recent_laporan' => $recentLaporan,
                'recent_users' => $recentUsers,
                'page_title' => 'Dashboard Admin'
            ];

            include '../views/dashboard/admin.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data dashboard: ' . $e->getMessage();
            include '../views/errors/error.php';
        }
    }

    /**
     * Dashboard untuk Petugas BPBD
     */
    public function petugas() {
        $this->requireAuth();

        if (!hasRole('petugas')) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit;
        }

        try {
            // Get data untuk dashboard petugas BPBD
            $laporanStats = $this->apiClient->get('laporan/statistik')['data'] ?? [];
            $tindakLanjutCount = $this->apiClient->get('tindak-lanjut/count')['data'] ?? 0;
            $monitoringCount = $this->apiClient->get('monitoring/count')['data'] ?? 0;
            $recentLaporan = $this->apiClient->get('laporan', ['limit' => 10, 'sort' => 'created_at', 'order' => 'desc'])['data'] ?? [];
            $pendingLaporan = $this->apiClient->get('laporan', ['status' => 'verified'])['data'] ?? [];

            $data = [
                'user' => $this->apiClient->getCurrentUser(),
                'laporan_stats' => $laporanStats,
                'tindak_lanjut_count' => $tindakLanjutCount,
                'monitoring_count' => $monitoringCount,
                'recent_laporan' => $recentLaporan,
                'pending_laporan' => $pendingLaporan,
                'page_title' => 'Dashboard Petugas BPBD'
            ];

            include '../views/dashboard/petugas.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data dashboard: ' . $e->getMessage();
            include '../views/errors/error.php';
        }
    }

    /**
     * Dashboard untuk Operator Desa
     */
    public function operator() {
        $this->requireAuth();

        if (!hasRole('operator')) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit;
        }

        try {
            $userData = $this->apiClient->getCurrentUser();
            $desaId = $userData['desa_id'] ?? null;

            // Get data untuk dashboard operator desa (filter berdasarkan wilayah)
            $laporanStats = $this->apiClient->get('laporan/statistik', ['desa_id' => $desaId])['data'] ?? [];
            $recentLaporan = $this->apiClient->get('laporan', ['limit' => 10, 'desa_id' => $desaId, 'sort' => 'created_at', 'order' => 'desc'])['data'] ?? [];
            $unverifiedLaporan = $this->apiClient->get('laporan', ['status' => 'pending', 'desa_id' => $desaId])['data'] ?? [];
            $bmkgAlerts = $this->apiClient->get('bmkg/peringatan-dini')['data'] ?? [];

            $data = [
                'user' => $userData,
                'laporan_stats' => $laporanStats,
                'recent_laporan' => $recentLaporan,
                'unverified_laporan' => $unverifiedLaporan,
                'bmkg_alerts' => $bmkgAlerts,
                'page_title' => 'Dashboard Operator Desa'
            ];

            include '../views/dashboard/operator.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data dashboard: ' . $e->getMessage();
            include '../views/errors/error.php';
        }
    }

    /**
     * Dashboard default (redirect berdasarkan role)
     */
    public function index() {
        $this->requireAuth();

        $userData = $this->apiClient->getCurrentUser();
        $role = $userData['role'] ?? 'warga';

        // Redirect ke beranda action berdasarkan role
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
            case 'warga':
            default:
                header('Location: index.php?controller=beranda&action=warga');
                break;
        }
        exit;
    }

    /**
     * API endpoint untuk real-time dashboard data
     */
    public function getRealTimeData() {
        $this->requireAuth();

        header('Content-Type: application/json');

        try {
            $userData = $this->apiClient->getCurrentUser();
            $role = $userData['role'] ?? 'warga';

            $data = [
                'timestamp' => date('Y-m-d H:i:s'),
                'user_role' => $role
            ];

            switch ($role) {
                case 'admin':
                    $data['stats'] = $this->apiClient->get('laporan/statistik')['data'] ?? [];
                    $data['total_users'] = $this->apiClient->get('users/count')['data'] ?? 0;
                    $data['total_laporan'] = $this->apiClient->get('laporan/count')['data'] ?? 0;
                    break;
                case 'petugas':
                    $data['stats'] = $this->apiClient->get('laporan/statistik')['data'] ?? [];
                    $data['tindak_lanjut_count'] = $this->apiClient->get('tindak-lanjut/count')['data'] ?? 0;
                    $data['pending_laporan'] = $this->apiClient->get('laporan', ['status' => 'verified'])['data'] ?? [];
                    break;
                case 'operator':
                    $desaId = $userData['desa_id'] ?? null;
                    $data['stats'] = $this->apiClient->get('laporan/statistik', ['desa_id' => $desaId])['data'] ?? [];
                    $data['unverified_laporan'] = $this->apiClient->get('laporan', ['status' => 'pending', 'desa_id' => $desaId])['data'] ?? [];
                    $data['bmkg_alerts'] = $this->apiClient->get('bmkg/peringatan-dini')['data'] ?? [];
                    break;
            }

            echo json_encode(['success' => true, 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Export data dashboard
     */
    public function export() {
        $this->requireAuth();

        if (!hasRole('admin')) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit;
        }

        $type = $_GET['type'] ?? 'laporan';
        $format = $_GET['format'] ?? 'pdf';

        try {
            switch ($type) {
                case 'laporan':
                    $data = $this->apiClient->get('laporan')['data'] ?? [];
                    $filename = 'laporan_bencana_' . date('Y-m-d_H-i-s');
                    break;
                case 'users':
                    $data = $this->apiClient->get('users')['data'] ?? [];
                    $filename = 'data_users_' . date('Y-m-d_H-i-s');
                    break;
                default:
                    throw new Exception('Invalid export type');
            }

            if ($format === 'csv') {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

                $output = fopen('php://output', 'w');

                if (!empty($data)) {
                    // Header CSV
                    fputcsv($output, array_keys($data[0]));

                    // Data rows
                    foreach ($data as $row) {
                        fputcsv($output, $row);
                    }
                }

                fclose($output);
            } else {
                // PDF export (require library)
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
                echo 'PDF export not implemented yet';
            }
        } catch (Exception $e) {
            echo 'Export failed: ' . $e->getMessage();
        }
    }
}
?>