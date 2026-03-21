<?php
require_once 'services/AuthService.php';
require_once 'services/TindakLanjutService.php';

class TindakLanjutController {
    private $authService;
    private $tindakLanjutService;

    public function __construct() {
        $this->authService = new AuthService();
        
        
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        
        $userRole = $currentUser['data']['role'] ?? '';
        if (!in_array($userRole, ['Admin', 'PetugasBPBD', 'OperatorDesa'], true)) {
            
            $this->redirectToRoleDashboard($userRole);
            exit;
        }

        $this->tindakLanjutService = new TindakLanjutService();
    }

    public function index() {
        $currentUser = $this->authService->getCurrentUser();
        
        
        $filters = [];
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        if (isset($_GET['laporan_id']) && !empty($_GET['laporan_id'])) {
            $filters['laporan_id'] = $_GET['laporan_id'];
        }
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }

        
        $response = $this->tindakLanjutService->getAll($filters);

        if ($response['success']) {
            $tindakLanjutList = is_array($response['data']) ? $response['data'] : [];
        } else {
            $tindakLanjutList = [];
            $error_message = $response['message'] ?? 'Gagal mengambil data tindak lanjut';
        }

        $title = "Daftar Tindak Lanjut - SIMONTA BENCANA";
        include 'views/tindak-lanjut/index.php';
    }

    public function detail() {
        $currentUser = $this->authService->getCurrentUser();
        
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: index.php?controller=TindakLanjut&action=index');
            exit;
        }
        
        
        $response = $this->tindakLanjutService->getById($id);

        if ($response['success']) {
            $tindakLanjut = $response['data'];
        } else {
            $tindakLanjut = null;
            $error_message = $response['message'] ?? 'Gagal mengambil detail tindak lanjut';
        }

        $title = "Detail Tindak Lanjut - SIMONTA BENCANA";
        include 'views/tindak-lanjut/detail.php';
    }

    public function create() {
        $currentUser = $this->authService->getCurrentUser();

        
        $laporanResponse = $this->tindakLanjutService->getAllLaporan();
        $petugasResponse = $this->tindakLanjutService->getAllPetugas();

        $laporanList = is_array($laporanResponse['data']) ? $laporanResponse['data'] : [];
        $petugasList = is_array($petugasResponse['data']) ? $petugasResponse['data'] : [];

        $title = "Tambah Tindak Lanjut - SIMONTA BENCANA";
        include 'views/tindak-lanjut/form.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=TindakLanjut&action=index');
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();
        
        
        $laporanId = $_POST['laporan_id'] ?? '';
        $tanggalTanggapan = $_POST['tanggal_tanggapan'] ?? '';
        $status = $_POST['status'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        
        
        if (empty($laporanId) || empty($tanggalTanggapan) || empty($status)) {
            setDialog('Gagal', 'Laporan, tanggal tanggapan, dan status harus diisi', 'error');
            header('Location: index.php?controller=TindakLanjut&action=create');
            exit;
        }

        
        $data = [
            'laporan_id' => $laporanId,
            'id_petugas' => $_SESSION['user']['id'] ?? 0, 
            'tanggal_tanggapan' => date('Y-m-d H:i:s', strtotime($tanggalTanggapan)),
            'status' => $status
        ];

        
        $files = [];
        if (isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] === UPLOAD_ERR_OK) {
            $files['foto_kegiatan'] = $_FILES['foto_kegiatan'];
        }

        
        $response = $this->tindakLanjutService->create($data, $files);

        if ($response['success']) {
            setDialog('Berhasil', 'Tindak lanjut berhasil ditambahkan', 'success');
            header('Location: index.php?controller=TindakLanjut&action=index');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal menambahkan tindak lanjut', 'error');
            header('Location: index.php?controller=TindakLanjut&action=create');
        }
        exit;
    }

    public function edit() {
        $currentUser = $this->authService->getCurrentUser();
        
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: index.php?controller=TindakLanjut&action=index');
            exit;
        }
        
        
        $response = $this->tindakLanjutService->getById($id);

        if ($response['success']) {
            $tindakLanjut = $response['data'];
        } else {
            $tindakLanjut = null;
            $error_message = $response['message'] ?? 'Gagal mengambil detail tindak lanjut';
        }

        
        $laporanResponse = $this->tindakLanjutService->getAllLaporan();
        $petugasResponse = $this->tindakLanjutService->getAllPetugas();

        $laporanList = is_array($laporanResponse['data']) ? $laporanResponse['data'] : [];
        $petugasList = is_array($petugasResponse['data']) ? $petugasResponse['data'] : [];

        $title = "Edit Tindak Lanjut - SIMONTA BENCANA";
        include 'views/tindak-lanjut/form.php';
    }

    public function update() {
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: index.php?controller=TindakLanjut&action=index');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=TindakLanjut&action=detail&id=' . $id);
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();
        
        
        $laporanId = $_POST['laporan_id'] ?? '';
        $tanggalTanggapan = $_POST['tanggal_tanggapan'] ?? '';
        $status = $_POST['status'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        
        
        if (empty($tanggalTanggapan) || empty($status)) {
            setDialog('Gagal', 'Tanggal tanggapan dan status harus diisi', 'error');
            header('Location: index.php?controller=TindakLanjut&action=edit&id=' . $id);
            exit;
        }

        
        $data = [
            'tanggal_tanggapan' => date('Y-m-d H:i:s', strtotime($tanggalTanggapan)),
            'status' => $status
        ];

        
        $files = [];
        if (isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] === UPLOAD_ERR_OK) {
            $files['foto_kegiatan'] = $_FILES['foto_kegiatan'];
        }

        
        $response = $this->tindakLanjutService->update($id, $data, $files);

        if ($response['success']) {
            setDialog('Berhasil', 'Tindak lanjut berhasil diperbarui', 'success');
            header('Location: index.php?controller=TindakLanjut&action=detail&id=' . $id);
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal memperbarui tindak lanjut', 'error');
            header('Location: index.php?controller=TindakLanjut&action=edit&id=' . $id);
        }
        exit;
    }

    public function delete() {
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: index.php?controller=TindakLanjut&action=index');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=TindakLanjut&action=detail&id=' . $id);
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();
        
        
        $response = $this->tindakLanjutService->delete($id);

        if ($response['success']) {
            setDialog('Berhasil', 'Tindak lanjut berhasil dihapus', 'success');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal menghapus tindak lanjut', 'error');
        }

        header('Location: index.php?controller=TindakLanjut&action=index');
        exit;
    }

    
    private function redirectToRoleDashboard($role) {
        switch ($role) {
            case 'Admin':
                header('Location: index.php?controller=Dashboard&action=admin');
                break;
            case 'PetugasBPBD':
                header('Location: index.php?controller=Dashboard&action=petugas');
                break;
            case 'OperatorDesa':
                header('Location: index.php?controller=Dashboard&action=operator');
                break;
            case 'Warga':
                header('Location: index.php?controller=Dashboard&action=warga');
                break;
            default:
                header('Location: index.php?controller=Auth&action=login');
                break;
        }
    }
}
