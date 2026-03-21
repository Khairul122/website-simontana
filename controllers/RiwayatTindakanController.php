<?php
require_once 'services/AuthService.php';
require_once 'services/RiwayatTindakanService.php';

class RiwayatTindakanController {
    private $authService;
    private $riwayatTindakanService;

    public function __construct() {
        $this->authService = new AuthService();

        
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        
        $userRole = $currentUser['data']['role'] ?? '';
        if (!in_array($userRole, ['Admin', 'PetugasBPBD', 'OperatorDesa'], true)) {
            setDialog('Akses Ditolak', 'Anda tidak memiliki akses ke fitur riwayat tindakan.', 'error');
            header('Location: index.php?controller=Dashboard&action=warga');
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
            $riwayat = is_array($response['data']) ? $response['data'] : [];
        } else {
            $riwayat = [];
            $error_message = $response['message'] ?? 'Gagal mengambil data riwayat tindakan';
        }

        $title = "Daftar Riwayat Tindakan - SIMONTA BENCANA";
        include 'views/riwayat-tindakan/index.php';
    }

    public function create() {
        $currentUser = $this->authService->getCurrentUser();

        
        $response = $this->riwayatTindakanService->getAllTindakLanjut();
        $tindakLanjutList = [];
        if ($response['success']) {
            $tindakLanjutList = is_array($response['data']) ? $response['data'] : [];
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

        
        $tindakLanjutId = $_POST['tindaklanjut_id'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        $waktuTindakan = $_POST['waktu_tindakan'] ?? '';
        $idPetugas = $_SESSION['user']['id'] ?? 0;

        
        if (empty($tindakLanjutId) || empty($keterangan) || empty($waktuTindakan)) {
            setDialog('Gagal', 'Tindak lanjut, keterangan, dan waktu tindakan harus diisi', 'error');
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
            setDialog('Berhasil', 'Riwayat tindakan berhasil ditambahkan', 'success');
            header('Location: index.php?controller=RiwayatTindakan&action=index');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal menambahkan riwayat tindakan', 'error');
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

        
        $response = $this->riwayatTindakanService->getAllTindakLanjut();
        $tindakLanjutList = [];
        if ($response['success']) {
            $tindakLanjutList = is_array($response['data']) ? $response['data'] : [];
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

        
        $tindakLanjutId = $_POST['tindaklanjut_id'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        $waktuTindakan = $_POST['waktu_tindakan'] ?? '';

        
        if (empty($tindakLanjutId) || empty($keterangan) || empty($waktuTindakan)) {
            setDialog('Gagal', 'Tindak lanjut, keterangan, dan waktu tindakan harus diisi', 'error');
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
            setDialog('Berhasil', 'Riwayat tindakan berhasil diperbarui', 'success');
            header('Location: index.php?controller=RiwayatTindakan&action=detail&id=' . $id);
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal memperbarui riwayat tindakan', 'error');
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
            setDialog('Berhasil', 'Riwayat tindakan berhasil dihapus', 'success');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal menghapus riwayat tindakan', 'error');
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
