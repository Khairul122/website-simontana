<?php

require_once __DIR__ . '/../config/globals.php';

class BerandaController {
    private $globalEnv;

    public function __construct() {
        $this->globalEnv = globalEnv();
    }

    public function index() {
        $this->globalEnv->requireAuth();

        try {
            $currentUser = $this->globalEnv->getCurrentUser();
            $apiClient = $this->globalEnv->getAPIClient();

            $recentLaporan = [];
            $bmkgAlerts = [];
            $userStats = [
                'total_laporan' => 0,
                'pending_laporan' => 0,
                'verified_laporan' => 0
            ];

            try {
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

            include __DIR__ . '/../views/beranda/index.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data beranda: ' . $e->getMessage();
            include __DIR__ . '/../views/errors/error.php';
        }
    }

    public function buatLaporan() {
        $this->globalEnv->requireAuth();
        $this->globalEnv->requirePermission('laporan.create');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $laporanData = [
                'judul' => $_POST['judul'] ?? '',
                'deskripsi' => $_POST['deskripsi'] ?? '',
                'kategori_bencana_id' => $_POST['kategori_bencana_id'] ?? '',
                'latitude' => $_POST['latitude'] ?? '',
                'longitude' => $_POST['longitude'] ?? '',
                'alamat' => $_POST['alamat'] ?? '',
                'provinsi_id' => $_POST['provinsi_id'] ?? '',
                'kabupaten_id' => $_POST['kabupaten_id'] ?? '',
                'kecamatan_id' => $_POST['kecamatan_id'] ?? '',
                'desa_id' => $_POST['desa_id'] ?? ''
            ];

            try {
                $apiClient = $this->globalEnv->getAPIClient();
                $result = $apiClient->createLaporan($laporanData);

                if ($result['success']) {
                    $success = 'Laporan berhasil dikirim!';
                    header('Location: index.php?controller=beranda&action=index');
                    exit;
                } else {
                    $error = $result['message'];
                }
            } catch (Exception $e) {
                $error = 'Gagal mengirim laporan: ' . $e->getMessage();
            }
        }

        $this->showLaporanForm();
    }

    public function laporanSaya() {
        $this->globalEnv->requireAuth();

        try {
            $currentUser = $this->globalEnv->getCurrentUser();
            $apiClient = $this->globalEnv->getAPIClient();

            $userLaporan = $apiClient->get('laporan', ['user_id' => $currentUser['sub']])['data'] ?? [];

            $data = [
                'user' => $currentUser,
                'laporan_list' => $userLaporan,
                'page_title' => 'Laporan Saya'
            ];

            include __DIR__ . '/../views/beranda/laporan-saya.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data laporan: ' . $e->getMessage();
            include __DIR__ . '/../views/errors/error.php';
        }
    }

    public function informasi() {
        $this->globalEnv->requireAuth();

        try {
            $currentUser = $this->globalEnv->getCurrentUser();
            $apiClient = $this->globalEnv->getAPIClient();

            $bmkgData = [
                'gempa' => $apiClient->get('bmkg/gempa/terkini')['data'] ?? [],
                'peringatan' => $apiClient->get('bmkg/peringatan-dini')['data'] ?? [],
                'prakiraan' => []
            ];

            if (!empty($currentUser['desa_id'])) {
                $bmkgData['prakiraan'] = $apiClient->get('bmkg/prakiraan-cuaca', ['desa_id' => $currentUser['desa_id']])['data'] ?? [];
            }

            $data = [
                'user' => $currentUser,
                'bmkg_data' => $bmkgData,
                'page_title' => 'Informasi Bencana'
            ];

            include __DIR__ . '/../views/beranda/informasi.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data informasi: ' . $e->getMessage();
            include __DIR__ . '/../views/errors/error.php';
        }
    }

    public function profil() {
        header('Location: index.php?controller=auth&action=profile');
        exit;
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

    public function admin() {
        $this->globalEnv->requireRole('Admin');

        try {
            $currentUser = $this->globalEnv->getCurrentUser();
            $apiClient = $this->globalEnv->getAPIClient();

            $dashboardData = $this->getAdminDashboardData($apiClient);

            $data = [
                'user' => $currentUser,
                'total_users' => $dashboardData['total_users'],
                'total_laporan' => $dashboardData['total_laporan'],
                'laporan_stats' => $dashboardData['laporan_stats'],
                'recent_users' => $dashboardData['recent_users'],
                'recent_laporan' => $dashboardData['recent_laporan'],
                'page_title' => 'Dashboard Admin'
            ];

            include __DIR__ . '/../views/dashboard/admin.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data dashboard admin: ' . $e->getMessage();
            include __DIR__ . '/../views/errors/error.php';
        }
    }

    public function operator() {
        $this->globalEnv->requireRole('OperatorDesa');

        try {
            $currentUser = $this->globalEnv->getCurrentUser();
            $apiClient = $this->globalEnv->getAPIClient();

            $dashboardData = $this->getOperatorDashboardData($apiClient, $currentUser);

            $data = [
                'user' => $currentUser,
                'total_laporan' => $dashboardData['total_laporan'],
                'laporan_stats' => $dashboardData['laporan_stats'],
                'recent_laporan' => $dashboardData['recent_laporan'],
                'page_title' => 'Dashboard Operator'
            ];

            include __DIR__ . '/../views/dashboard/operator.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data dashboard operator: ' . $e->getMessage();
            include __DIR__ . '/../views/errors/error.php';
        }
    }

    public function petugas() {
        $this->globalEnv->requireRole('PetugasBPBD');

        try {
            $currentUser = $this->globalEnv->getCurrentUser();
            $apiClient = $this->globalEnv->getAPIClient();

            $dashboardData = $this->getPetugasDashboardData($apiClient, $currentUser);

            $data = [
                'user' => $currentUser,
                'total_laporan' => $dashboardData['total_laporan'],
                'laporan_stats' => $dashboardData['laporan_stats'],
                'recent_laporan' => $dashboardData['recent_laporan'],
                'tindak_lanjut_laporan' => $dashboardData['tindak_lanjut_laporan'],
                'page_title' => 'Dashboard Petugas'
            ];

            include __DIR__ . '/../views/dashboard/petugas.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data dashboard petugas: ' . $e->getMessage();
            include __DIR__ . '/../views/errors/error.php';
        }
    }

    private function getAdminDashboardData($apiClient) {
        $result = [
            'total_users' => 0,
            'total_laporan' => 0,
            'laporan_stats' => [
                'pending' => 0,
                'verified' => 0,
                'proses' => 0,
                'selesai' => 0
            ],
            'recent_users' => [],
            'recent_laporan' => []
        ];

        try {
            // Get total users
            $allUsers = $apiClient->get('users')['data'] ?? [];
            $result['total_users'] = count($allUsers);

            // Get all laporan
            $allLaporan = $apiClient->get('laporan')['data'] ?? [];
            $result['total_laporan'] = count($allLaporan);

            // Calculate laporan stats
            foreach ($allLaporan as $laporan) {
                $status = $laporan['status'] ?? 'pending';
                if (isset($result['laporan_stats'][$status])) {
                    $result['laporan_stats'][$status]++;
                }
            }

            // Get recent users (last 5)
            $result['recent_users'] = array_slice($allUsers, 0, 5);

            // Get recent laporan (last 5)
            $result['recent_laporan'] = array_slice($allLaporan, 0, 5);
        } catch (Exception $e) {
            // Return empty defaults on error
        }

        return $result;
    }

    private function getOperatorDashboardData($apiClient, $user) {
        $result = [
            'total_laporan' => 0,
            'laporan_stats' => [
                'pending' => 0,
                'verified' => 0,
                'proses' => 0,
                'selesai' => 0
            ],
            'recent_laporan' => []
        ];

        try {
            // Only get laporan related to the operator's area (desa level)
            $params = [];
            if (!empty($user['id_desa'])) {
                $params['id_desa'] = $user['id_desa'];
            }

            $laporanList = $apiClient->get('laporan', $params)['data'] ?? [];
            $result['total_laporan'] = count($laporanList);

            // Calculate laporan stats
            foreach ($laporanList as $laporan) {
                $status = $laporan['status'] ?? 'pending';
                if (isset($result['laporan_stats'][$status])) {
                    $result['laporan_stats'][$status]++;
                }
            }

            // Get recent laporan (last 5)
            $result['recent_laporan'] = array_slice($laporanList, 0, 5);
        } catch (Exception $e) {
            // Return empty defaults on error
        }

        return $result;
    }

    private function getPetugasDashboardData($apiClient, $user) {
        $result = [
            'total_laporan' => 0,
            'laporan_stats' => [
                'pending' => 0,
                'verified' => 0,
                'proses' => 0,
                'selesai' => 0
            ],
            'recent_laporan' => [],
            'tindak_lanjut_laporan' => 0
        ];

        try {
            // Get laporan assigned to petugas or from their area
            $params = [];
            if (!empty($user['id_desa'])) {
                $params['id_desa'] = $user['id_desa'];
            }

            $laporanList = $apiClient->get('laporan', $params)['data'] ?? [];
            $result['total_laporan'] = count($laporanList);

            // Calculate laporan stats
            foreach ($laporanList as $laporan) {
                $status = $laporan['status'] ?? 'pending';
                if (isset($result['laporan_stats'][$status])) {
                    $result['laporan_stats'][$status]++;
                }
            }

            // Get recent laporan (last 5)
            $result['recent_laporan'] = array_slice($laporanList, 0, 5);

            // Get laporan with tindak lanjut
            $result['tindak_lanjut_laporan'] = count(
                array_filter($laporanList, function($laporan) {
                    return !empty($laporan['tindak_lanjuts']) || !empty($laporan['penanggung_jawab']);
                })
            );
        } catch (Exception $e) {
            // Return empty defaults on error
        }

        return $result;
    }

    public function warga() {
        $this->globalEnv->requireAuth();
        $currentUser = $this->globalEnv->getCurrentUser();

        // Periksa apakah user memiliki role Warga (dalam format apapun)
        if (!$this->globalEnv->hasRole('Warga')) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access denied';
            exit;
        }

        try {
            $apiClient = $this->globalEnv->getAPIClient();

            $recentLaporan = [];
            $bmkgAlerts = [];
            $userStats = [
                'total_laporan' => 0,
                'pending_laporan' => 0,
                'verified_laporan' => 0
            ];

            try {
                // Ambil laporan milik pengguna
                $recentLaporan = $apiClient->get('laporan', ['user_id' => $currentUser['sub'], 'limit' => 6, 'sort' => 'created_at', 'order' => 'desc'])['data'] ?? [];
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
                'page_title' => 'Dashboard Warga'
            ];

            include __DIR__ . '/../views/beranda/index.php';
        } catch (Exception $e) {
            $error = 'Gagal memuat data dashboard warga: ' . $e->getMessage();
            include __DIR__ . '/../views/errors/error.php';
        }
    }

    private function showLaporanForm() {
        $currentUser = $this->globalEnv->getCurrentUser();
        $apiClient = $this->globalEnv->getAPIClient();

        $kategoriBencana = $apiClient->get('kategori-bencana')['data'] ?? [];

        $data = [
            'user' => $currentUser,
            'kategori_bencana' => $kategoriBencana,
            'page_title' => 'Buat Laporan Bencana'
        ];

        include __DIR__ . '/../views/beranda/buat-laporan.php';
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
?>