<?php
require_once 'services/AuthService.php';
require_once 'services/BmkgService.php';
require_once 'services/WeatherService.php';
require_once 'services/CuacaWilayahDatasetService.php';

class BmkgController {
    private $authService;
    private $bmkgService;
    private $weatherService;
    private $cuacaWilayahService;

    public function __construct() {
        $this->authService = new AuthService();
        $this->bmkgService = new BmkgService();
        $this->weatherService = new WeatherService();
        $this->cuacaWilayahService = new CuacaWilayahDatasetService();

        
        
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function index() {
        $currentUser = $this->authService->getCurrentUser();
        
        
        $summaryCall = $this->bmkgService->getSummary();
        $terbaruCall = $this->bmkgService->getGempaTerbaru();
        $terkiniCall = $this->bmkgService->getGempaTerkini();
        $dirasakanCall = $this->bmkgService->getGempaDirasakan();
        $diniCuacaCall = $this->weatherService->getPeringatanDiniCuaca();

        
        $summary = $summaryCall['success'] ? $summaryCall['data'] : null;
        if (!$summary && $terbaruCall['success']) {
            
            $gtRaw = $terbaruCall['data']['Infogempa']['gempa'] ?? null;
            if ($gtRaw) {
                $summary = ['gempa_terbaru' => $gtRaw];
            }
        } elseif ($summary && isset($summary['gempa_terbaru']['Infogempa'])) {
            
            $summary['gempa_terbaru'] = $summary['gempa_terbaru']['Infogempa']['gempa'] ?? $summary['gempa_terbaru'];
        }

        
        $gempaTerkini = [];
        if ($terkiniCall['success']) {
            $gempaTerkini = $terkiniCall['data']['Infogempa']['gempa'] ?? [];
        }

        $gempaDirasakan = [];
        if ($dirasakanCall['success']) {
            $gempaDirasakan = $dirasakanCall['data']['Infogempa']['gempa'] ?? [];
        }

        
        $peringatanTsunami = null;
        if (!empty($summary['gempa_terbaru'])) {
            $potensi = $summary['gempa_terbaru']['Potensi'] ?? '';
            if (stripos($potensi, 'tsunami') !== false && stripos($potensi, 'tidak') === false) {
                $peringatanTsunami = [
                    'status' => 'Waspada/Awas',
                    'keterangan' => $potensi
                ];
            }
        }

        $peringatanDiniCuaca = $diniCuacaCall['success'] ? $diniCuacaCall['data'] : null;

        $title = "Pusat Data Gempa BMKG - SIMONTA";
        include 'views/bmkg/index.php';
    }

    public function cuaca() {
        $currentUser = $this->authService->getCurrentUser();
        $wilayahId = isset($_GET['wilayah_id']) ? $_GET['wilayah_id'] : null;
        
        
        $provinsiCall = $this->cuacaWilayahService->getProvinsi();
        $provinsiList = $provinsiCall['success'] ? $provinsiCall['data'] : [];

        $cuacaData = null;
        $error_message = null;

        if ($wilayahId) {
            $cuacaCall = $this->weatherService->getPrakiraanCuaca($wilayahId);
            if ($cuacaCall['success']) {
                $cuacaData = $cuacaCall['data'];
            } else {
                $error_message = $cuacaCall['message'] ?? "Gagal mengambil data prakiraan cuaca atau wilayah_id tidak valid.";
            }
        }

        $title = "Prakiraan Cuaca BMKG - SIMONTA";
        include 'views/bmkg/cuaca.php';
    }

    public function getCuacaProvinsi() {
        $response = $this->cuacaWilayahService->getProvinsi();
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $response['success'],
            'message' => $response['message'] ?? '',
            'data' => $response['data'] ?? []
        ]);
        exit;
    }

    public function getCuacaKabupatenByProvinsi() {
        $provinsiId = trim((string) ($_GET['id'] ?? ''));
        $response = $this->cuacaWilayahService->getKabupatenByProvinsi($provinsiId);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $response['success'],
            'message' => $response['message'] ?? '',
            'data' => $response['data'] ?? []
        ]);
        exit;
    }

    public function getCuacaKecamatanByKabupaten() {
        $kabupatenId = trim((string) ($_GET['id'] ?? ''));
        $response = $this->cuacaWilayahService->getKecamatanByKabupaten($kabupatenId);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $response['success'],
            'message' => $response['message'] ?? '',
            'data' => $response['data'] ?? []
        ]);
        exit;
    }

    public function getCuacaDesaByKecamatan() {
        $kecamatanId = trim((string) ($_GET['id'] ?? ''));
        $response = $this->cuacaWilayahService->getDesaByKecamatan($kecamatanId);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $response['success'],
            'message' => $response['message'] ?? '',
            'data' => $response['data'] ?? []
        ]);
        exit;
    }

    public function cache() {
        $currentUser = $this->authService->getCurrentUser();
        if ($currentUser['data']['role'] !== 'Admin' && $currentUser['data']['role'] !== 'PetugasBPBD') {
            header('Location: index.php?controller=Bmkg&action=index');
            exit;
        }

        $statusCall = $this->bmkgService->getCacheStatus();
        $cacheStatus = $statusCall['success'] ? $statusCall['data'] : null;

        $title = "Manajemen Cache BMKG - SIMONTA";
        include 'views/bmkg/cache.php';
    }

    public function clearCache() {
        $currentUser = $this->authService->getCurrentUser();
        if ($currentUser['data']['role'] !== 'Admin' && $currentUser['data']['role'] !== 'PetugasBPBD') {
            header('Location: index.php?controller=Bmkg&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clearCall = $this->bmkgService->clearCache();
            if ($clearCall['success']) {
                $_SESSION['flash_success'] = "Cache BMKG berhasil dibersihkan!";
            } else {
                $_SESSION['flash_error'] = "Gagal membersihkan cache BMKG: " . ($clearCall['message'] ?? '');
            }
        }

        header('Location: index.php?controller=Bmkg&action=cache');
        exit;
    }
}
