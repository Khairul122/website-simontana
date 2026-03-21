<?php
require_once 'services/AuthService.php';
require_once 'services/BmkgService.php';
require_once 'services/WilayahService.php';

class BmkgController {
    private $authService;
    private $bmkgService;
    private $wilayahService;

    public function __construct() {
        $this->authService = new AuthService();
        $this->bmkgService = new BmkgService();
        $this->wilayahService = new WilayahService();

        // Allow public access for viewing data?
        // Let's protect it just for internal users for now (Admin, Petugas, Operator)
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function index() {
        $currentUser = $this->authService->getCurrentUser();
        
        $tsunamiCall = $this->bmkgService->getPeringatanTsunami();
        $summaryCall = $this->bmkgService->getSummary();
        $terkiniCall = $this->bmkgService->getGempaTerkini();
        $dirasakanCall = $this->bmkgService->getGempaDirasakan();

        $peringatanTsunami = $tsunamiCall['success'] ? $tsunamiCall['data'] : null;
        $summary = $summaryCall['success'] ? $summaryCall['data'] : null;
        $gempaTerkini = $terkiniCall['success'] ? $terkiniCall['data'] : [];
        $gempaDirasakan = $dirasakanCall['success'] ? $dirasakanCall['data'] : [];

        // In case API returns direct arrays or nested 'data' objects
        if (isset($gempaTerkini['data'])) $gempaTerkini = $gempaTerkini['data'];
        if (isset($gempaDirasakan['data'])) $gempaDirasakan = $gempaDirasakan['data'];

        $title = "Pusat Data Gempa BMKG - SIMONTA";
        include 'views/bmkg/index.php';
    }

    public function cuaca() {
        $currentUser = $this->authService->getCurrentUser();
        $wilayahId = isset($_GET['wilayah_id']) ? (int)$_GET['wilayah_id'] : null;
        
        // Fetch all provinces for dropdown
        $provinsiCall = $this->wilayahService->getAllProvinsi();
        $provinsiList = $provinsiCall['success'] ? $provinsiCall['data'] : [];

        $cuacaData = null;
        $error_message = null;

        if ($wilayahId) {
            $cuacaCall = $this->bmkgService->getPrakiraanCuaca($wilayahId);
            if ($cuacaCall['success']) {
                $cuacaData = $cuacaCall['data'];
            } else {
                $error_message = $cuacaCall['message'] ?? "Gagal mengambil data prakiraan cuaca atau wilayah_id tidak valid.";
            }
        }

        $title = "Prakiraan Cuaca BMKG - SIMONTA";
        include 'views/bmkg/cuaca.php';
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
