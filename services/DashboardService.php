<?php
/**
 * DashboardService - Service untuk mengelola data dashboard
 * Menyediakan fungsi-fungsi untuk mengambil dan memproses data dashboard
 */

class DashboardService {
    private $apiClient;

    public function __construct($apiClient) {
        $this->apiClient = $apiClient;
    }

    /**
     * Format angka untuk tampilan
     */
    public function formatNumber($number) {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 1) . 'K';
        }
        return number_format($number);
    }

    /**
     * Format tanggal untuk tampilan
     */
    public function formatDate($dateString, $format = 'd M Y, H:i') {
        $date = new DateTime($dateString);
        return $date->format($format);
    }

    /**
     * Hitung persentase perubahan
     */
    public function calculatePercentageChange($current, $previous) {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Get status label dengan warna
     */
    public function getStatusLabel($status) {
        $labels = [
            'menunggu' => ['text' => 'Menunggu', 'class' => 'warning'],
            'diproses' => ['text' => 'Diproses', 'class' => 'info'],
            'selesai' => ['text' => 'Selesai', 'class' => 'success'],
            'ditolak' => ['text' => 'Ditolak', 'class' => 'danger'],
            'darurat' => ['text' => 'Darurat', 'class' => 'danger'],
            'tinggi' => ['text' => 'Tinggi', 'class' => 'warning'],
            'sedang' => ['text' => 'Sedang', 'class' => 'info'],
            'rendah' => ['text' => 'Rendah', 'class' => 'success'],
            'aman' => ['text' => 'Aman', 'class' => 'success'],
            'waspada' => ['text' => 'Waspada', 'class' => 'warning'],
            'siaga' => ['text' => 'Siaga', 'class' => 'danger']
        ];

        return $labels[strtolower($status)] ?? ['text' => $status, 'class' => 'secondary'];
    }

    /**
     * Get icon untuk jenis laporan
     */
    public function getLaporanIcon($jenis) {
        $icons = [
            'banjir' => 'fa-water',
            'longsor' => 'fa-mountain',
            'kebakaran' => 'fa-fire',
            'angin_topan' => 'fa-wind',
            'gempa' => 'fa-house-crack',
            'tsunami' => 'fa-tsunami',
            'kekeringan' => 'fa-sun',
            'lainnya' => 'fa-exclamation-triangle'
        ];

        return $icons[strtolower($jenis)] ?? 'fa-exclamation-triangle';
    }

    /**
     * Generate trend indicator untuk statistik
     */
    public function getTrendIndicator($current, $previous) {
        $percentage = $this->calculatePercentageChange($current, $previous);

        if ($percentage > 0) {
            return [
                'trend' => 'up',
                'percentage' => $percentage,
                'icon' => 'fa-arrow-up',
                'class' => 'success'
            ];
        } elseif ($percentage < 0) {
            return [
                'trend' => 'down',
                'percentage' => abs($percentage),
                'icon' => 'fa-arrow-down',
                'class' => 'danger'
            ];
        }

        return [
            'trend' => 'stable',
            'percentage' => 0,
            'icon' => 'fa-minus',
            'class' => 'secondary'
        ];
    }

    /**
     * Get progress bar untuk persentase
     */
    public function getProgressBar($percentage, $type = 'primary') {
        return [
            'percentage' => min(100, max(0, $percentage)),
            'class' => $this->getProgressClass($percentage, $type),
            'label' => $percentage . '%'
        ];
    }

    /**
     * Get progress bar class berdasarkan persentase
     */
    private function getProgressClass($percentage, $type) {
        if ($type === 'success') {
            return $percentage >= 80 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger');
        } elseif ($type === 'danger') {
            return $percentage >= 80 ? 'bg-danger' : ($percentage >= 50 ? 'bg-warning' : 'bg-success');
        }

        return 'bg-' . $type;
    }

    /**
     * Format durasi waktu
     */
    public function formatDuration($dateString) {
        $date = new DateTime($dateString);
        $now = new DateTime();
        $interval = $now->diff($date);

        if ($interval->y > 0) {
            return $interval->y . ' tahun lalu';
        } elseif ($interval->m > 0) {
            return $interval->m . ' bulan lalu';
        } elseif ($interval->d > 0) {
            return $interval->d . ' hari lalu';
        } elseif ($interval->h > 0) {
            return $interval->h . ' jam lalu';
        } elseif ($interval->i > 0) {
            return $interval->i . ' menit lalu';
        } else {
            return 'Baru saja';
        }
    }

    /**
     * Get user avatar (dengan fallback ke initial)
     */
    public function getUserAvatar($nama, $avatarUrl = null) {
        if ($avatarUrl && filter_var($avatarUrl, FILTER_VALIDATE_URL)) {
            return $avatarUrl;
        }

        // Generate avatar dengan initial nama
        $initials = strtoupper(implode('', array_slice(explode(' ', $nama), 0, 2)));
        $colors = ['primary', 'success', 'danger', 'warning', 'info', 'secondary'];
        $colorIndex = crc32($nama) % count($colors);

        return [
            'type' => 'initial',
            'text' => substr($initials, 0, 2),
            'color' => $colors[$colorIndex]
        ];
    }

    /**
     * Generate QR code data (placeholder)
     */
    public function generateQRData($data) {
        return [
            'text' => json_encode($data),
            'size' => 200,
            'format' => 'svg'
        ];
    }

    /**
     * Export data to CSV
     */
    public function exportToCSV($data, $filename, $headers = []) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Write headers
        if (!empty($headers)) {
            fputcsv($output, $headers);
        }

        // Write data
        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

    /**
     * Get chart data untuk dashboard
     */
    public function getChartData($data, $type = 'line') {
        $chartData = [
            'type' => $type,
            'labels' => [],
            'datasets' => []
        ];

        foreach ($data as $key => $value) {
            $chartData['labels'][] = $key;

            if (is_array($value)) {
                foreach ($value as $dataset => $val) {
                    if (!isset($chartData['datasets'][$dataset])) {
                        $chartData['datasets'][$dataset] = [];
                    }
                    $chartData['datasets'][$dataset][] = $val;
                }
            } else {
                if (!isset($chartData['datasets'][0])) {
                    $chartData['datasets'][0] = [];
                }
                $chartData['datasets'][0][] = $value;
            }
        }

        return $chartData;
    }

    /**
     * Get notification data
     */
    public function getNotifications($userId, $role, $limit = 10) {
        // Mock notifications - nanti bisa diganti dengan API call
        $notifications = [
            [
                'id' => 1,
                'type' => 'laporan_baru',
                'title' => 'Laporan Baru',
                'message' => 'Laporan banjir di Desa Sukamaju',
                'timestamp' => '2024-01-10 14:30:00',
                'read' => false,
                'icon' => 'fa-exclamation-triangle',
                'color' => 'warning'
            ],
            [
                'id' => 2,
                'type' => 'peringatan_bmkg',
                'title' => 'Peringatan Cuaca',
                'message' => 'Waspada hujan lebat di wilayah Anda',
                'timestamp' => '2024-01-10 12:15:00',
                'read' => true,
                'icon' => 'fa-cloud-rain',
                'color' => 'info'
            ]
        ];

        return array_slice($notifications, 0, $limit);
    }

    /**
     * Get quick actions berdasarkan role (Updated dengan BMKG integration)
     */
    public function getQuickActions($role) {
        $actions = [
            'Admin' => [
                ['icon' => 'fa-plus', 'text' => 'Tambah Pengguna', 'url' => 'index.php?controller=user&action=create'],
                ['icon' => 'fa-chart-bar', 'text' => 'Lihat Statistik', 'url' => 'index.php?controller=report&action=stats'],
                ['icon' => 'fa-cog', 'text' => 'Pengaturan', 'url' => 'index.php?controller=settings&action=index'],
                ['icon' => 'fa-download', 'text' => 'Export Data', 'url' => 'index.php?controller=export&action=index'],
                ['icon' => 'fa-cloud', 'text' => 'BMKG Integration', 'url' => 'index.php?controller=bmkg&action=index']
            ],
            'PetugasBPBD' => [
                ['icon' => 'fa-list', 'text' => 'Laporan Menunggu', 'url' => 'index.php?controller=laporan&action=menunggu'],
                ['icon' => 'fa-map-marker-alt', 'text' => 'Peta Bencana', 'url' => 'index.php?controller=map&action=index'],
                ['icon' => 'fa-bell', 'text' => 'Peringatan', 'url' => 'index.php?controller=warning&action=index'],
                ['icon' => 'fa-file-alt', 'text' => 'Buat Laporan', 'url' => 'index.php?controller=laporan&action=create'],
                ['icon' => 'fa-house-crack', 'text' => 'Info Gempa', 'url' => 'index.php?controller=bmkg&action=earthquake']
            ],
            'OperatorDesa' => [
                ['icon' => 'fa-plus', 'text' => 'Lapor Bencana', 'url' => 'index.php?controller=laporan&action=create'],
                ['icon' => 'fa-eye', 'text' => 'Monitoring', 'url' => 'index.php?controller=monitoring&action=index'],
                ['icon' => 'fa-users', 'text' => 'Data Warga', 'url' => 'index.php?controller=warga&action=index'],
                ['icon' => 'fa-cloud-sun', 'text' => 'Cuaca Lokal', 'url' => 'index.php?controller=bmkg&action=local']
            ]
        ];

        return $actions[$role] ?? [];
    }

    /**
     * Get laporan statistics dari backend API
     */
    private function getLaporanStats($token) {
        try {
            // Get laporan statistics dari backend API
            $response = $this->apiClient->apiRequest('laporan/statistics', 'GET', null, $token);
            return $response['success'] ? ($response['data'] ?? []) : [];
        } catch (Exception $e) {
            error_log("getLaporanStats Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get dashboard data dari backend API
     */
    public function getDashboardData($token, $role) {
        try {
            // Data dasar untuk semua role
            $dashboardData = [
                'laporan_stats' => $this->getLaporanStats($token),
                'recent_laporan' => $this->getRecentLaporan($token),
                'pending_laporan' => $this->getPendingLaporan($token),
            ];

            // Role-specific data
            switch ($role) {
                case 'Admin':
                    $dashboardData['user_stats'] = $this->getUserStats($token);
                    $dashboardData['monitoring_stats'] = $this->getMonitoringStats($token);
                    break;
                case 'PetugasBPBD':
                    $dashboardData['bpbd_reports'] = $this->getBPBDReports($token);
                    $dashboardData['bmkg_data'] = $this->getBMKGData($token);
                    break;
                case 'OperatorDesa':
                    $dashboardData['desa_laporan'] = $this->getDesaLaporan($token);
                    $dashboardData['local_cuaca'] = $this->getLocalCuaca($token);
                    break;
            }

            return $dashboardData;
        } catch (Exception $e) {
            error_log("DashboardService Error: " . $e->getMessage());
            return $this->getFallbackDashboardData($role);
        }
    }

    /**
     * Get recent laporan data
     */
    private function getRecentLaporan($token) {
        try {
            // Get recent laporan dari backend API
            $response = $this->apiClient->apiRequest('laporan?limit=5', 'GET', null, $token);
            return $response['success'] ? ($response['data'] ?? []) : [];
        } catch (Exception $e) {
            error_log("getRecentLaporan Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get pending laporan data
     */
    private function getPendingLaporan($token) {
        try {
            // Get pending laporan dari backend API
            $response = $this->apiClient->apiRequest('laporan?status=menunggu', 'GET', null, $token);
            return $response['success'] ? ($response['data'] ?? []) : [];
        } catch (Exception $e) {
            error_log("getPendingLaporan Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get user statistics
     */
    private function getUserStats($token) {
        try {
            // Get user statistics dari backend API
            $response = $this->apiClient->apiRequest('admin/users', 'GET', null, $token);
            return [
                'total' => $response['success'] ? count($response['data'] ?? []) : 0,
                'aktif' => $response['success'] ? count(array_filter($response['data'] ?? [], function($user) {
                    return isset($user['status']) && $user['status'] === 'active';
                })) : 0
            ];
        } catch (Exception $e) {
            error_log("getUserStats Error: " . $e->getMessage());
            return ['total' => 0, 'aktif' => 0];
        }
    }

    /**
     * Get monitoring statistics
     */
    private function getMonitoringStats($token) {
        try {
            // Get monitoring statistics dari backend API
            $response = $this->apiClient->apiRequest('monitoring/statistics', 'GET', null, $token);
            return $response['success'] ? ($response['data'] ?? []) : [];
        } catch (Exception $e) {
            error_log("getMonitoringStats Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get BPBD reports
     */
    private function getBPBDReports($token) {
        try {
            $response = $this->apiClient->getBPBDReports($token);
            return $response['success'] ? ($response['data'] ?? []) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Get BMKG data untuk dashboard
     */
    private function getBMKGData($token) {
        try {
            // Gunakan endpoint BMKG yang tersedia
            $bmkgUrl = 'http://127.0.0.1:8000/api/bmkg/all';

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $bmkgUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Bearer ' . $token
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new Exception("CURL Error: " . $error);
            }

            $responseData = json_decode($response, true);

            if ($httpCode >= 400) {
                // Fallback ke mock data jika auth endpoint gagal
                return $this->getBMKGMockData();
            }

            // Jika data null, gunakan mock data
            if ($responseData['success'] && $responseData['data']['data']['earthquake'] === null) {
                return $this->getBMKGMockData();
            }

            return $responseData['success'] ? ($responseData['data'] ?? []) : $this->getBMKGMockData();
        } catch (Exception $e) {
            error_log("getBMKGData Error: " . $e->getMessage());
            return $this->getBMKGMockData();
        }
    }

    /**
     * Get BMKG mock data untuk fallback
     */
    private function getBMKGMockData() {
        try {
            $mockUrl = 'http://127.0.0.1:8000/api/bmkg-test/all';

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $mockUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true
            ]);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new Exception("CURL Error: " . $error);
            }

            $responseData = json_decode($response, true);
            return $responseData['success'] ? ($responseData['data'] ?? []) : [];
        } catch (Exception $e) {
            error_log("getBMKGMockData Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get desa laporan untuk operator
     */
    private function getDesaLaporan($token) {
        try {
            $userId = $_SESSION['user_id'] ?? null;
            $response = $this->apiClient->getDesaLaporan($token, $userId);
            return $response['success'] ? ($response['data'] ?? []) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Get local weather data
     */
    private function getLocalCuaca($token) {
        try {
            $response = $this->apiClient->getLocalBMKG($token);
            return $response['success'] ? ($response['data'] ?? []) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Get fallback dashboard data jika API error
     */
    private function getFallbackDashboardData($role) {
        return [
            'laporan_stats' => ['total' => 0, 'menunggu' => 0, 'diproses' => 0, 'selesai' => 0],
            'recent_laporan' => [],
            'pending_laporan' => [],
            'user_stats' => ['total' => 0, 'aktif' => 0],
            'bmkg_data' => [
                'earthquake' => ['magnitude' => 0, 'location' => 'Data tidak tersedia'],
                'weather' => ['temperature' => 'N/A', 'description' => 'Data tidak tersedia']
            ]
        ];
    }

    /**
     * Format BMKG data untuk dashboard display
     */
    public function formatBMKGData($bmkgData) {
        $formatted = [
            'latest_earthquake' => [
                'magnitude' => $bmkgData['earthquake']['magnitude'] ?? 0,
                'location' => $bmkgData['earthquake']['wilayah'] ?? 'Tidak diketahui',
                'depth' => $bmkgData['earthquake']['kedalaman'] ?? 'N/A',
                'status' => $bmkgData['earthquake']['potensi'] ?? 'Tidak ada data',
                'time' => $bmkgData['earthquake']['tanggal'] ?? 'N/A',
                'icon' => 'fa-house-crack',
                'color' => 'warning'
            ],
            'weather_info' => [
                'temperature' => $bmkgData['cuaca']['temperature'] ?? '28°C',
                'description' => $bmkgData['cuaca']['description'] ?? 'Cerah Berawan',
                'humidity' => $bmkgData['cuaca']['humidity'] ?? '75%',
                'wind' => $bmkgData['cuaca']['wind'] ?? '10 km/h',
                'updated_at' => $bmkgData['updated_at'] ?? date('Y-m-d H:i:s'),
                'icon' => 'fa-cloud-sun',
                'color' => 'info'
            ],
            'tsunami_warning' => [
                'status' => $bmkgData['tsunami']['status'] ?? 'Tidak Ada Peringatan',
                'message' => $bmkgData['tsunami']['informasi'] ?? 'Tidak ada informasi tsunami',
                'icon' => 'fa-water',
                'color' => 'success'
            ]
        ];

        return $formatted;
    }

    /**
     * Get dashboard statistics summary
     */
    public function getDashboardSummary($dashboardData, $role) {
        $summary = [
            'total_laporan' => $dashboardData['laporan_stats']['total'] ?? 0,
            'pending_laporan' => count($dashboardData['pending_laporan'] ?? []),
            'recent_activities' => count($dashboardData['recent_laporan'] ?? [])
        ];

        // Role-specific summary
        switch ($role) {
            case 'Admin':
                $summary['total_users'] = $dashboardData['user_stats']['total'] ?? 0;
                $summary['active_users'] = $dashboardData['user_stats']['aktif'] ?? 0;
                break;
            case 'PetugasBPBD':
                $summary['bpbd_reports'] = count($dashboardData['bpbd_reports'] ?? []);
                $summary['bmkg_alerts'] = !empty($dashboardData['bmkg_data']) ? 1 : 0;
                break;
            case 'OperatorDesa':
                $summary['desa_reports'] = count($dashboardData['desa_laporan'] ?? []);
                $summary['weather_alerts'] = !empty($dashboardData['local_cuaca']['warnings']) ? 1 : 0;
                break;
        }

        return $summary;
    }
}
?>