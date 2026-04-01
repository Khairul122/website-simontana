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

    private function userRole(): string
    {
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            return '';
        }

        $data = is_array($currentUser['data'] ?? null) ? $currentUser['data'] : [];
        $role = $data['role'] ?? '';
        return is_string($role) ? $role : '';
    }

    private function canAccessBmkgProtected(): bool
    {
        return in_array($this->userRole(), ['Admin', 'PetugasBPBD'], true);
    }

    private function extractGempaEntity($payload): array
    {
        if (!is_array($payload)) {
            return [];
        }

        if (isset($payload['Infogempa']['gempa']) && is_array($payload['Infogempa']['gempa'])) {
            return $payload['Infogempa']['gempa'];
        }

        if (isset($payload['gempa']) && is_array($payload['gempa'])) {
            return $payload['gempa'];
        }

        if (isset($payload['data']) && is_array($payload['data'])) {
            return $this->extractGempaEntity($payload['data']);
        }

        if (isset($payload['Tanggal']) || isset($payload['Magnitude']) || isset($payload['Wilayah'])) {
            return $payload;
        }

        return [];
    }

    private function extractGempaList($payload): array
    {
        if (!is_array($payload)) {
            return [];
        }

        if (isset($payload['Infogempa']['gempa']) && is_array($payload['Infogempa']['gempa'])) {
            $gempa = $payload['Infogempa']['gempa'];
            $first = $gempa[0] ?? null;
            return is_array($first) ? $gempa : [];
        }

        if (isset($payload['gempa']) && is_array($payload['gempa'])) {
            $gempa = $payload['gempa'];
            $first = $gempa[0] ?? null;
            return is_array($first) ? $gempa : [];
        }

        if (isset($payload['data']) && is_array($payload['data'])) {
            return $this->extractGempaList($payload['data']);
        }

        $first = $payload[0] ?? null;
        if (is_array($first) && (isset($first['Tanggal']) || isset($first['Magnitude']))) {
            return $payload;
        }

        return [];
    }

    public function index() {
        $currentUserResp = $this->authService->getCurrentUser();
        $currentUser = is_array($currentUserResp['data'] ?? null) ? $currentUserResp['data'] : [];
        
        
        $terbaruCall = $this->bmkgService->getGempaTerbaru();
        $terkiniCall = $this->bmkgService->getGempaTerkini();
        $dirasakanCall = $this->bmkgService->getGempaDirasakan();
        $diniCuacaCall = $this->weatherService->getPeringatanDiniCuaca();

        $summaryCall = ['success' => false, 'data' => null];
        if ($this->canAccessBmkgProtected()) {
            $summaryCall = $this->bmkgService->getSummary();
        }

        $summary = $summaryCall['success'] ? apiDataEntity($summaryCall['data']) : [];

        $gempaTerbaru = [];
        if (!empty($summary['gempa_terbaru'])) {
            $gempaTerbaru = $this->extractGempaEntity($summary['gempa_terbaru']);
        }
        if (empty($gempaTerbaru) && $terbaruCall['success']) {
            $gempaTerbaru = $this->extractGempaEntity($terbaruCall['data'] ?? []);
        }
        if (!empty($gempaTerbaru)) {
            $summary['gempa_terbaru'] = $gempaTerbaru;
        }

        $gempaTerkini = [];
        if (!empty($summary['daftar_gempa'])) {
            $gempaTerkini = $this->extractGempaList($summary['daftar_gempa']);
        }
        if (empty($gempaTerkini) && $terkiniCall['success']) {
            $gempaTerkini = $this->extractGempaList($terkiniCall['data'] ?? []);
        }

        $gempaDirasakan = [];
        if (!empty($summary['gempa_dirasakan'])) {
            $gempaDirasakan = $this->extractGempaList($summary['gempa_dirasakan']);
        }
        if (empty($gempaDirasakan) && $dirasakanCall['success']) {
            $gempaDirasakan = $this->extractGempaList($dirasakanCall['data'] ?? []);
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

        $peringatanDiniCuaca = $diniCuacaCall['success'] ? apiDataEntity($diniCuacaCall['data']) : null;
        $cacheStatus = is_array($summary['cache_status'] ?? null) ? $summary['cache_status'] : null;

        $title = "Pusat Data Gempa BMKG - SIMONTA";
        include 'views/bmkg/index.php';
    }

    public function cuaca() {
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
                $httpCode = (int)($cuacaCall['http_code'] ?? 0);
                if ($httpCode === 422) {
                    $error_message = 'Kode wilayah tidak valid. Pilih provinsi, kabupaten, kecamatan, lalu desa dari daftar.';
                } else {
                    $error_message = $cuacaCall['message'] ?? "Gagal mengambil data prakiraan cuaca atau wilayah_id tidak valid.";
                }
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
        if (!$this->canAccessBmkgProtected()) {
            header('Location: index.php?controller=Bmkg&action=index');
            exit;
        }

        $statusCall = $this->bmkgService->getCacheStatus();
        $cacheStatus = $statusCall['success'] ? apiDataEntity($statusCall['data']) : null;

        $title = "Manajemen Cache BMKG - SIMONTA";
        include 'views/bmkg/cache.php';
    }

    public function clearCache() {
        if (!$this->canAccessBmkgProtected()) {
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
