<?php
require_once 'config/koneksi.php';

class DashboardService {
    private $authService;
    
    public function __construct() {
        require_once 'services/AuthService.php';
        $this->authService = new AuthService();
    }
    
    private function getAuthHeaders() {
        $token = null;
        if (isset($_SESSION['token'])) {
            $token = $_SESSION['token'];
        }
        
        return getAuthHeaders($token);
    }
    
    // Fungsi untuk mendapatkan statistik dasbor admin
    public function getAdminDashboardStats() {
        $headers = $this->getAuthHeaders();

        try {
            // Endpoint untuk mendapatkan statistik laporan
            $url = API_LAPORANS_STATISTICS;
            $response = apiRequest($url, 'GET', null, $headers);

            if ($response['success'] && isset($response['data'])) {
                // Jika endpoint statistik tersedia, gunakan data dari sana
                return [
                    'success' => true,
                    'data' => $response['data'],
                    'message' => 'Data statistik dashboard berhasil diambil',
                    'errors' => []
                ];
            } else {
                // Jika endpoint statistik tidak tersedia, ambil dari endpoint laporan biasa dan hitung manual
                $totalLaporan = $this->getTotalReports();
                $laporanBaru = $this->getNewReports();
                $laporanDitangani = $this->getHandledReports();

                $dashboardData = [
                    'total_laporan' => $this->getCountFromResponse($totalLaporan),
                    'laporan_baru' => $this->getCountFromResponse($laporanBaru),
                    'laporan_ditangani' => $this->getCountFromResponse($laporanDitangani)
                ];

                $response = [
                    'success' => true,
                    'data' => $dashboardData,
                    'message' => 'Data statistik dashboard berhasil diambil',
                    'errors' => []
                ];

                // Tambahkan pesan error jika ada permintaan gagal
                if (!$totalLaporan['success']) {
                    $response['success'] = false;
                    $response['errors'][] = "Gagal mengambil data total laporan: " . ($totalLaporan['message'] ?? 'Unknown error');
                }

                if (!$laporanBaru['success']) {
                    $response['success'] = false;
                    $response['errors'][] = "Gagal mengambil data laporan baru: " . ($laporanBaru['message'] ?? 'Unknown error');
                }

                if (!$laporanDitangani['success']) {
                    $response['success'] = false;
                    $response['errors'][] = "Gagal mengambil data laporan ditangani: " . ($laporanDitangani['message'] ?? 'Unknown error');
                }

                return $response;
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error saat mengambil data dashboard: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ];
        }
    }

    private function getTotalReports() {
        $headers = $this->getAuthHeaders();
        return apiRequest(API_LAPORANS, 'GET', null, $headers);
    }

    private function getNewReports() {
        $headers = $this->getAuthHeaders();
        // Filter laporan dengan status 'Draft' sesuai dokumentasi API
        return apiRequest(API_LAPORANS . '?status=Draft', 'GET', null, $headers);
    }

    private function getHandledReports() {
        $headers = $this->getAuthHeaders();
        // Filter laporan dengan status 'Diproses' sesuai dokumentasi API
        return apiRequest(API_LAPORANS . '?status=Diproses', 'GET', null, $headers);
    }

    // Fungsi untuk mendapatkan data BMKG (Gempa Terbaru)
    public function getBmkgData() {
        try {
            // Endpoint BMKG public (tidak perlu authentication)
            $response = apiRequest(API_BMKG_GEMPATERBARU, 'GET', null, []);

            if ($response['success'] && isset($response['data'])) {
                return [
                    'success' => true,
                    'data' => $response['data'],
                    'message' => 'Data BMKG berhasil diambil',
                    'errors' => []
                ];
            } else {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Gagal mengambil data BMKG',
                    'errors' => [$response['message'] ?? 'Unknown error']
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error saat mengambil data BMKG: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ];
        }
    }

    // Fungsi untuk mendapatkan data gempa dirasakan
    public function getBmkgGempaDirasakan() {
        try {
            $response = apiRequest(API_BMKG_GEMPA_DIRASAKAN, 'GET', null, []);

            return [
                'success' => $response['success'],
                'data' => $response['data'] ?? null,
                'message' => $response['message'] ?? 'Gempa dirasakan data retrieved',
                'errors' => $response['success'] ? [] : [$response['message'] ?? 'Unknown error']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error saat mengambil data gempa dirasakan: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ];
        }
    }

    // Fungsi pembantu untuk menghitung jumlah dari respons API
    private function getCountFromResponse($response) {
        if (!$response['success'] || !isset($response['data'])) {
            return 0;
        }

        // Jika respons dalam format pagination (dengan properti 'data' sebagai array)
        if (isset($response['data']['data']) && is_array($response['data']['data'])) {
            return count($response['data']['data']);
        }

        // Jika respons dalam format data langsung (bukan pagination)
        if (is_array($response['data'])) {
            return count($response['data']);
        }

        // Jika respons berisi informasi jumlah secara eksplisit
        if (isset($response['data']['total'])) {
            return $response['data']['total'];
        }

        // Default kembalikan 0 jika tidak dapat menentukan jumlah
        return 0;
    }

    // Fungsi untuk memeriksa apakah API endpoint tersedia
    public function checkAPIConnection() {
        $headers = $this->getAuthHeaders();
        $response = apiRequest(API_AUTH_ME, 'GET', null, $headers);

        return [
            'connected' => $response['success'],
            'message' => $response['message'],
            'data' => $response['data']
        ];
    }
    
    // Fungsi untuk mendapatkan daftar laporan terbaru
    public function getLatestReports($limit = 5) {
        $headers = $this->getAuthHeaders();

        // Tambahkan parameter limit ke endpoint
        $url = API_LAPORANS . "?limit={$limit}";
        $response = apiRequest($url, 'GET', null, $headers);

        // Format ulang respons untuk konsistensi
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }
    
    // Fungsi untuk mendapatkan statistik laporan mingguan
    public function getWeeklyReportStats() {
        $headers = $this->getAuthHeaders();

        // endpoint khusus untuk statistik laporan mingguan
        $response = apiRequest(API_LAPORANS . '/statistics?period=weekly', 'GET', null, $headers);

        // Jika endpoint statistik mingguan tidak tersedia, coba endpoint umum
        if (!$response['success'] || !isset($response['data'])) {
            $response = apiRequest(API_LAPORANS_STATISTICS, 'GET', null, $headers);
        }

        // Format ulang respons untuk konsistensi
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    // Fungsi untuk mendapatkan statistik bulanan
    public function getMonthlyReportStats() {
        $headers = $this->getAuthHeaders();

        // endpoint khusus untuk statistik laporan bulanan
        $response = apiRequest(API_LAPORANS . '/statistics?period=monthly', 'GET', null, $headers);

        // Jika endpoint statistik bulanan tidak tersedia, coba endpoint umum
        if (!$response['success'] || !isset($response['data'])) {
            $response = apiRequest(API_LAPORANS_STATISTICS, 'GET', null, $headers);
        }

        // Format ulang respons untuk konsistensi
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    // Fungsi untuk mendapatkan data pengguna (untuk admin)
    public function getUserStatistics() {
        $headers = $this->getAuthHeaders();

        $response = apiRequest(API_USERS_STATISTICS, 'GET', null, $headers);

        // Format ulang respons untuk konsistensi
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    // Fungsi untuk mendapatkan data kategori bencana
    public function getCategories() {
        $headers = $this->getAuthHeaders();

        $response = apiRequest(API_KATEGORI_BENCANA, 'GET', null, $headers);

        // Format ulang respons untuk konsistensi
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    // Fungsi untuk mendapatkan data wilayah
    public function getRegions() {
        $headers = $this->getAuthHeaders();

        $response = apiRequest(API_DESA, 'GET', null, $headers);

        // Format ulang respons untuk konsistensi
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    // Fungsi untuk mendapatkan data untuk chart
    public function getChartData() {
        $headers = $this->getAuthHeaders();

        // Gunakan endpoint statistik laporan sesuai dokumentasi API
        $response = apiRequest(API_LAPORANS_STATISTICS, 'GET', null, $headers);

        // Format ulang respons untuk konsistensi
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    // Fungsi untuk mendapatkan statistik desa (untuk Operator Desa)
    public function getStatistikDesa($id_desa) {
        $headers = $this->getAuthHeaders();

        try {
            // Ambil total laporan untuk desa ini
            $url = API_LAPORANS . '?id_desa=' . $id_desa . '&limit=100'; // Ambil semua laporan untuk perhitungan
            $response = apiRequest($url, 'GET', null, $headers);

            $total_laporan = 0;
            $total_warga_terdampak = 0;
            $total_rumah_rusak = 0;
            $laporan_terbaru = [];
            $logistik_status = null;
            $laporan_stats = null;
            $laporan_list = []; // Initialize as empty array to prevent foreach error

            if ($response['success'] && isset($response['data'])) {

                // Ambil data laporan dari respons
                if (isset($response['data']['data']) && is_array($response['data']['data'])) {
                    $laporan_list = $response['data']['data'];
                } elseif (is_array($response['data'])) {
                    $laporan_list = $response['data'];
                }

                // Hitung total laporan
                $total_laporan = count($laporan_list);

                // Hitung total warga terdampak dan rumah rusak
                foreach ($laporan_list as $laporan) {
                    $total_warga_terdampak += (int)($laporan['jumlah_korban'] ?? 0);
                    $total_rumah_rusak += (int)($laporan['jumlah_rumah_rusak'] ?? 0);
                }

                // Ambil 5 laporan terbaru berdasarkan tanggal
                usort($laporan_list, function($a, $b) {
                    return strtotime($b['waktu_laporan'] ?? '') - strtotime($a['waktu_laporan'] ?? '');
                });

                $laporan_terbaru = array_slice($laporan_list, 0, 5);
            }

            // Ambil detail desa untuk informasi tambahan
            $desa_detail_url = buildApiUrlWilayahDetailByDesaId($id_desa);
            $desa_response = apiRequest($desa_detail_url, 'GET', null, $headers);

            $desa_info = null;
            if ($desa_response['success'] && isset($desa_response['data'])) {
                $desa_info = $desa_response['data'];
            }

            // Ambil statistik laporan untuk desa ini
            $stats_url = API_LAPORANS_STATISTICS . '?id_desa=' . $id_desa;
            $stats_response = apiRequest($stats_url, 'GET', null, $headers);

            if ($stats_response['success'] && isset($stats_response['data'])) {
                $laporan_stats = $stats_response['data'];
            } else {
                // Jika endpoint statistik tidak tersedia, buat statistik manual dari data yang ada
                $laporan_stats = [
                    'total_laporan' => $total_laporan,
                    'total_warga_terdampak' => $total_warga_terdampak,
                    'total_rumah_rusak' => $total_rumah_rusak,
                    'laporan_perlu_verifikasi' => 0,
                    'laporan_ditindak' => 0,
                    'laporan_selesai' => 0,
                    'laporan_ditolak' => 0,
                    'weekly_stats' => [],
                    'categories_stats' => [],
                    'monthly_trend' => []
                ];

                // Hitung statistik berdasarkan status laporan
                foreach ($laporan_list as $laporan) {
                    $status = $laporan['status'] ?? '';
                    switch ($status) {
                        case 'Menunggu Verifikasi':
                            $laporan_stats['laporan_perlu_verifikasi']++;
                            break;
                        case 'Diproses':
                        case 'Tindak Lanjut':
                            $laporan_stats['laporan_ditindak']++;
                            break;
                        case 'Selesai':
                            $laporan_stats['laporan_selesai']++;
                            break;
                        case 'Ditolak':
                            $laporan_stats['laporan_ditolak']++;
                            break;
                    }
                }
            }

            // Ambil data logistik untuk desa (jika endpoint tersedia)
            // Kita coba endpoint khusus logistik desa jika tersedia
            $logistik_url = API_WILAYAH_DETAIL . '?id_desa=' . $id_desa . '&include=logistik';
            $logistik_response = apiRequest($logistik_url, 'GET', null, $headers);

            if ($logistik_response['success'] && isset($logistik_response['data'])) {
                $logistik_status = $logistik_response['data'];
            } else {
                // Jika tidak ada endpoint logistik khusus, gunakan data umum
                $logistik_status = [
                    'total_distribusi' => 0,
                    'status_terakhir' => 'Tidak ada data'
                ];
            }

            $dashboardData = [
                'total_laporan' => $total_laporan,
                'total_warga_terdampak' => $total_warga_terdampak,
                'total_rumah_rusak' => $total_rumah_rusak,
                'logistik_status' => $logistik_status,
                'laporan_terbaru' => $laporan_terbaru,
                'desa_info' => $desa_info,
                'laporan_stats' => $laporan_stats
            ];

            return [
                'success' => true,
                'data' => $dashboardData,
                'message' => 'Data statistik desa berhasil diambil',
                'errors' => []
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error saat mengambil data statistik desa: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ];
        }
    }

    // Fungsi untuk mendapatkan statistik dashboard petugas BPBD
    public function getDashboardPetugas() {
        $headers = $this->getAuthHeaders();

        try {
            // Endpoint untuk mendapatkan statistik laporan
            $url = API_LAPORANS_STATISTICS;
            $response = apiRequest($url, 'GET', null, $headers);

            if ($response['success'] && isset($response['data'])) {
                // Jika endpoint statistik tersedia, gunakan data dari sana
                return [
                    'success' => true,
                    'data' => $response['data'],
                    'message' => 'Data statistik dashboard petugas berhasil diambil',
                    'errors' => []
                ];
            } else {
                // Jika endpoint statistik tidak tersedia, ambil dari endpoint laporan biasa dan hitung manual
                $totalLaporan = $this->getTotalReports();
                $laporanMenunggu = $this->getPendingReports();
                $laporanDiproses = $this->getProcessedReports();
                $laporanSelesai = $this->getCompletedReports();

                $dashboardData = [
                    'total_laporan' => $this->getCountFromResponse($totalLaporan),
                    'laporan_perlu_verifikasi' => $this->getCountFromResponse($laporanMenunggu),
                    'laporan_ditindak' => $this->getCountFromResponse($laporanDiproses),
                    'laporan_selesai' => $this->getCountFromResponse($laporanSelesai)
                ];

                $response = [
                    'success' => true,
                    'data' => $dashboardData,
                    'message' => 'Data statistik dashboard petugas berhasil diambil',
                    'errors' => []
                ];

                // Tambahkan pesan error jika ada permintaan gagal
                if (!$totalLaporan['success']) {
                    $response['success'] = false;
                    $response['errors'][] = "Gagal mengambil data total laporan: " . ($totalLaporan['message'] ?? 'Unknown error');
                }

                if (!$laporanMenunggu['success']) {
                    $response['success'] = false;
                    $response['errors'][] = "Gagal mengambil data laporan menunggu: " . ($laporanMenunggu['message'] ?? 'Unknown error');
                }

                if (!$laporanDiproses['success']) {
                    $response['success'] = false;
                    $response['errors'][] = "Gagal mengambil data laporan diproses: " . ($laporanDiproses['message'] ?? 'Unknown error');
                }

                if (!$laporanSelesai['success']) {
                    $response['success'] = false;
                    $response['errors'][] = "Gagal mengambil data laporan selesai: " . ($laporanSelesai['message'] ?? 'Unknown error');
                }

                return $response;
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error saat mengambil data dashboard petugas: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ];
        }
    }

    private function getPendingReports() {
        $headers = $this->getAuthHeaders();
        // Filter laporan dengan status 'Menunggu Verifikasi' sesuai dokumentasi API
        return apiRequest(API_LAPORANS . '?status=Menunggu%20Verifikasi', 'GET', null, $headers);
    }

    private function getProcessedReports() {
        $headers = $this->getAuthHeaders();
        // Filter laporan dengan status 'Diproses' atau 'Tindak Lanjut' sesuai dokumentasi API
        return apiRequest(API_LAPORANS . '?status=Diproses', 'GET', null, $headers);
    }

    private function getCompletedReports() {
        $headers = $this->getAuthHeaders();
        // Filter laporan dengan status 'Selesai' sesuai dokumentasi API
        return apiRequest(API_LAPORANS . '?status=Selesai', 'GET', null, $headers);
    }
}