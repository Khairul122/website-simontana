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
     * Get quick actions berdasarkan role
     */
    public function getQuickActions($role) {
        $actions = [
            'Admin' => [
                ['icon' => 'fa-plus', 'text' => 'Tambah Pengguna', 'url' => 'index.php?controller=user&action=create'],
                ['icon' => 'fa-chart-bar', 'text' => 'Lihat Statistik', 'url' => 'index.php?controller=report&action=stats'],
                ['icon' => 'fa-cog', 'text' => 'Pengaturan', 'url' => 'index.php?controller=settings&action=index'],
                ['icon' => 'fa-download', 'text' => 'Export Data', 'url' => 'index.php?controller=export&action=index']
            ],
            'PetugasBPBD' => [
                ['icon' => 'fa-list', 'text' => 'Laporan Menunggu', 'url' => 'index.php?controller=laporan&action=menunggu'],
                ['icon' => 'fa-map-marker-alt', 'text' => 'Peta Bencana', 'url' => 'index.php?controller=map&action=index'],
                ['icon' => 'fa-bell', 'text' => 'Peringatan', 'url' => 'index.php?controller=warning&action=index'],
                ['icon' => 'fa-file-alt', 'text' => 'Buat Laporan', 'url' => 'index.php?controller=laporan&action=create']
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
}
?>