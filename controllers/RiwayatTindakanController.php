<?php
require_once 'services/AuthService.php';
require_once 'services/RiwayatTindakanService.php';

class RiwayatTindakanController {
    private $authService;
    private $riwayatTindakanService;

    public function __construct() {
        $this->authService = new AuthService();

        // Check if user is logged in
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        // Only allow roles: 'Admin', 'PetugasBPBD'
        $userRole = $currentUser['data']['role'] ?? '';
        if ($userRole !== 'Admin' && $userRole !== 'PetugasBPBD') {
            header('Location: index.php?controller=Dashboard&action=' . strtolower($userRole));
            exit;
        }

        $this->riwayatTindakanService = new RiwayatTindakanService();
    }

    public function index() {
        $currentUser = $this->authService->getCurrentUser();

        $filters = [];
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }

        $response = $this->riwayatTindakanService->getAll($filters);

        if ($response['success']) {
            // CRITICAL: Extract the array correctly: $riwayat = $response['data']['data'] ?? [];
            $riwayat = $response['data']['data'] ?? [];
        } else {
            $riwayat = [];
            $error_message = $response['message'] ?? 'Gagal mengambil data riwayat tindakan';
        }

        $title = "Daftar Riwayat Tindakan - SIMONTA BENCANA";
        include 'views/riwayat-tindakan/index.php';
    }

    public function create() {
        $currentUser = $this->authService->getCurrentUser();

        // Fetch $tindakLanjutList from service
        $response = $this->riwayatTindakanService->getAllTindakLanjut();
        $tindakLanjutList = [];
        if ($response['success']) {
            // Handle both Paginated and Non-Paginated responses for safety
            $tindakLanjutList = $response['data']['data'] ?? $response['data'] ?? [];
        }

        $title = "Tambah Riwayat Tindakan - SIMONTA BENCANA";
        include 'views/riwayat-tindakan/form.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=RiwayatTindakan&action=create');
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();

        // Payload: tindaklanjut_id, keterangan, waktu_tindakan (formatted Y-m-d H:i:s), id_petugas (from session)
        $tindakLanjutId = $_POST['tindaklanjut_id'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        $waktuTindakan = $_POST['waktu_tindakan'] ?? '';
        $idPetugas = $_SESSION['user']['id'] ?? 0;

        // Validation
        if (empty($tindakLanjutId) || empty($keterangan) || empty($waktuTindakan)) {
            $_SESSION['toast'] = [
                'title' => 'Gagal',
                'message' => 'Tindak lanjut, keterangan, dan waktu tindakan harus diisi'
            ];
            header('Location: index.php?controller=RiwayatTindakan&action=create');
            exit;
        }

        $data = [
            'tindaklanjut_id' => $tindakLanjutId,
            'keterangan' => $keterangan,
            'waktu_tindakan' => date('Y-m-d H:i:s', strtotime($waktuTindakan)),
            'id_petugas' => $idPetugas
        ];

        $response = $this->riwayatTindakanService->create($data);

        if ($response['success']) {
            // On Success: Set $_SESSION['toast'] = ['title'=>'Berhasil', 'message'=>'...']. Redirect to index
            $_SESSION['toast'] = [
                'title' => 'Berhasil',
                'message' => 'Riwayat tindakan berhasil ditambahkan'
            ];
            header('Location: index.php?controller=RiwayatTindakan&action=index');
        } else {
            // On Fail: Set error toast. Redirect to create
            $_SESSION['toast'] = [
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal menambahkan riwayat tindakan'
            ];
            header('Location: index.php?controller=RiwayatTindakan&action=create');
        }
        exit;
    }

    public function edit() {
        $currentUser = $this->authService->getCurrentUser();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=RiwayatTindakan&action=index');
            exit;
        }

        $response = $this->riwayatTindakanService->getById($id);
        if ($response['success']) {
            $riwayatTindakan = $response['data'];
        } else {
            $riwayatTindakan = null;
            $error_message = $response['message'] ?? 'Gagal mengambil data riwayat tindakan';
        }

        // Fetch $tindakLanjutList from service
        $response = $this->riwayatTindakanService->getAllTindakLanjut();
        $tindakLanjutList = [];
        if ($response['success']) {
            // Handle both Paginated and Non-Paginated responses for safety
            $tindakLanjutList = $response['data']['data'] ?? $response['data'] ?? [];
        }

        $title = "Edit Riwayat Tindakan - SIMONTA BENCANA";
        include 'views/riwayat-tindakan/form.php';
    }

    public function update() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=RiwayatTindakan&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=RiwayatTindakan&action=detail&id=' . $id);
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();

        // Payload: tindaklanjut_id, keterangan, waktu_tindakan (formatted Y-m-d H:i:s)
        $tindakLanjutId = $_POST['tindaklanjut_id'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        $waktuTindakan = $_POST['waktu_tindakan'] ?? '';

        // Validation
        if (empty($tindakLanjutId) || empty($keterangan) || empty($waktuTindakan)) {
            $_SESSION['toast'] = [
                'title' => 'Gagal',
                'message' => 'Tindak lanjut, keterangan, dan waktu tindakan harus diisi'
            ];
            header('Location: index.php?controller=RiwayatTindakan&action=edit&id=' . $id);
            exit;
        }

        $data = [
            'tindaklanjut_id' => $tindakLanjutId,
            'keterangan' => $keterangan,
            'waktu_tindakan' => date('Y-m-d H:i:s', strtotime($waktuTindakan))
        ];

        $response = $this->riwayatTindakanService->update($id, $data);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'title' => 'Berhasil',
                'message' => 'Riwayat tindakan berhasil diperbarui'
            ];
            header('Location: index.php?controller=RiwayatTindakan&action=detail&id=' . $id);
        } else {
            $_SESSION['toast'] = [
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal memperbarui riwayat tindakan'
            ];
            header('Location: index.php?controller=RiwayatTindakan&action=edit&id=' . $id);
        }
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=RiwayatTindakan&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=RiwayatTindakan&action=detail&id=' . $id);
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();

        $response = $this->riwayatTindakanService->delete($id);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'title' => 'Berhasil',
                'message' => 'Riwayat tindakan berhasil dihapus'
            ];
        } else {
            $_SESSION['toast'] = [
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal menghapus riwayat tindakan'
            ];
        }

        header('Location: index.php?controller=RiwayatTindakan&action=index');
        exit;
    }

    public function detail() {
        $currentUser = $this->authService->getCurrentUser();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=RiwayatTindakan&action=index');
            exit;
        }

        $response = $this->riwayatTindakanService->getById($id);
        if ($response['success']) {
            $riwayatTindakan = $response['data'];
        } else {
            $riwayatTindakan = null;
            $error_message = $response['message'] ?? 'Gagal mengambil data riwayat tindakan';
        }

        $title = "Detail Riwayat Tindakan - SIMONTA BENCANA";
        include 'views/riwayat-tindakan/detail.php';
    }
}