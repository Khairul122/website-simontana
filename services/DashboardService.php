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

    private function extractList($data): array {
        return apiDataList($data);
    }
    
    
    public function getAdminDashboardStats() {
        $headers = $this->getAuthHeaders();

        try {
            
            $url = API_LAPORANS_STATISTICS;
            $response = apiRequest($url, 'GET', null, $headers);

            if ($response['success'] && isset($response['data'])) {
                
                return [
                    'success' => true,
                    'data' => $response['data'],
                    'message' => 'Data statistik dashboard berhasil diambil',
                    'errors' => []
                ];
            } else {
                
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
        
        return apiRequest(API_LAPORANS . '?status=Draft', 'GET', null, $headers);
    }

    private function getHandledReports() {
        $headers = $this->getAuthHeaders();
        
        return apiRequest(API_LAPORANS . '?status=Diproses', 'GET', null, $headers);
    }

    
    public function getBmkgData() {
        try {
            
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

    
    private function getCountFromResponse($response) {
        if (!$response['success'] || !isset($response['data'])) {
            return 0;
        }

        $list = $this->extractList($response['data']);
        if (!empty($list)) {
            return count($list);
        }

        
        if (isset($response['data']['total'])) {
            return $response['data']['total'];
        }

        
        return 0;
    }

    
    public function checkAPIConnection() {
        $headers = $this->getAuthHeaders();
        $response = apiRequest(API_AUTH_ME, 'GET', null, $headers);

        return [
            'connected' => $response['success'],
            'message' => $response['message'],
            'data' => $response['data']
        ];
    }
    
    
    public function getLatestReports($limit = 5) {
        $headers = $this->getAuthHeaders();

        
        $url = API_LAPORANS . "?limit={$limit}&per_page={$limit}";
        $response = apiRequest($url, 'GET', null, $headers);

        if ($response['success']) {
            $response['data'] = $this->extractList($response['data']);
        }

        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }
    
    
    public function getWeeklyReportStats() {
        $headers = $this->getAuthHeaders();

        
        $response = apiRequest(API_LAPORANS . '/statistics?period=weekly', 'GET', null, $headers);

        
        if (!$response['success'] || !isset($response['data'])) {
            $response = apiRequest(API_LAPORANS_STATISTICS, 'GET', null, $headers);
        }

        
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    
    public function getMonthlyReportStats() {
        $headers = $this->getAuthHeaders();

        
        $response = apiRequest(API_LAPORANS . '/statistics?period=monthly', 'GET', null, $headers);

        
        if (!$response['success'] || !isset($response['data'])) {
            $response = apiRequest(API_LAPORANS_STATISTICS, 'GET', null, $headers);
        }

        
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    
    public function getUserStatistics() {
        $headers = $this->getAuthHeaders();

        $response = apiRequest(API_USERS_STATISTICS, 'GET', null, $headers);

        
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    
    public function getCategories() {
        $headers = $this->getAuthHeaders();

        $response = apiRequest(API_KATEGORI_BENCANA, 'GET', null, $headers);

        
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    
    public function getRegions() {
        $headers = $this->getAuthHeaders();

        $response = apiRequest(API_DESA, 'GET', null, $headers);

        
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    
    public function getChartData() {
        $headers = $this->getAuthHeaders();

        
        $response = apiRequest(API_LAPORANS_STATISTICS, 'GET', null, $headers);

        
        return [
            'success' => $response['success'],
            'data' => $response['data'],
            'message' => $response['message'],
            'errors' => $response['success'] ? [] : [$response['message']]
        ];
    }

    
    public function getStatistikDesa($id_desa) {
        $headers = $this->getAuthHeaders();

        try {
            
            $url = API_LAPORANS . '?id_desa=' . $id_desa . '&limit=100&per_page=100'; 
            $response = apiRequest($url, 'GET', null, $headers);

            $total_laporan = 0;
            $total_warga_terdampak = 0;
            $total_rumah_rusak = 0;
            $laporan_terbaru = [];
            $logistik_status = null;
            $laporan_stats = null;
            $laporan_list = []; 

            if ($response['success'] && isset($response['data'])) {

                
                $laporan_list = $this->extractList($response['data']);

                
                $total_laporan = count($laporan_list);

                
                foreach ($laporan_list as $laporan) {
                    $total_warga_terdampak += (int)($laporan['jumlah_korban'] ?? 0);
                    $total_rumah_rusak += (int)($laporan['jumlah_rumah_rusak'] ?? 0);
                }

                
                usort($laporan_list, function($a, $b) {
                    return strtotime($b['waktu_laporan'] ?? '') - strtotime($a['waktu_laporan'] ?? '');
                });

                $laporan_terbaru = array_slice($laporan_list, 0, 5);
            }

            
            $desa_detail_url = buildApiUrlWilayahDetailByDesaId((int) $id_desa);
            $desa_response = apiRequest($desa_detail_url, 'GET', null, $headers);

            $desa_info = null;
            if ($desa_response['success'] && isset($desa_response['data'])) {
                $desa_info = $desa_response['data'];
            }

            
            $stats_url = API_LAPORANS_STATISTICS . '?id_desa=' . $id_desa;
            $stats_response = apiRequest($stats_url, 'GET', null, $headers);

            if ($stats_response['success'] && isset($stats_response['data'])) {
                $laporan_stats = $stats_response['data'];
            } else {
                
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

            
            
            $logistik_url = buildApiUrlWilayahDetailByDesaId((int) $id_desa) . '?include=logistik';
            $logistik_response = apiRequest($logistik_url, 'GET', null, $headers);

            if ($logistik_response['success'] && isset($logistik_response['data'])) {
                $logistik_status = $logistik_response['data'];
            } else {
                
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

    
    public function getDashboardPetugas() {
        $headers = $this->getAuthHeaders();

        try {
            
            $url = API_LAPORANS_STATISTICS;
            $response = apiRequest($url, 'GET', null, $headers);

            if ($response['success'] && isset($response['data'])) {
                
                return [
                    'success' => true,
                    'data' => $response['data'],
                    'message' => 'Data statistik dashboard petugas berhasil diambil',
                    'errors' => []
                ];
            } else {
                
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
        
        return apiRequest(API_LAPORANS . '?status=Menunggu%20Verifikasi', 'GET', null, $headers);
    }

    private function getProcessedReports() {
        $headers = $this->getAuthHeaders();
        
        return apiRequest(API_LAPORANS . '?status=Diproses', 'GET', null, $headers);
    }

    private function getCompletedReports() {
        $headers = $this->getAuthHeaders();
        
        return apiRequest(API_LAPORANS . '?status=Selesai', 'GET', null, $headers);
    }
}
