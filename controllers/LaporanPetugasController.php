<?php
require_once 'services/AuthService.php';
require_once 'services/LaporanPetugasService.php';

class LaporanPetugasController {
    private $authService;
    private $laporanService;

    public function __construct() {
        $this->authService = new AuthService();
        
        
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        
        $userRole = $currentUser['data']['role'] ?? '';
        if ($userRole !== 'PetugasBPBD') {
            
            $this->redirectToRoleDashboard($userRole);
            exit;
        }

        $this->laporanService = new LaporanPetugasService();
    }

    public function index() {
        $currentUser = $this->authService->getCurrentUser();
        
        
        $filters = [];
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
            $filters['kategori'] = $_GET['kategori'];
        }
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }

        
        $response = $this->laporanService->getAll($filters);

        if ($response['success']) {
            $laporanList = is_array($response['data']) ? $response['data'] : [];
        } else {
            $laporanList = [];
            $error_message = $response['message'] ?? 'Gagal mengambil data laporan';
        }

        $title = "Daftar Laporan - Petugas BPBD";
        include 'views/laporan-petugas/index.php';
    }

    public function detail() {
        $currentUser = $this->authService->getCurrentUser();

        
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=LaporanPetugas&action=index');
            exit;
        }

        
        $response = $this->laporanService->getById($id);

        if ($response['success']) {
            $laporan = $response['data'];
        } else {
            $laporan = null;
            $error_message = $response['message'] ?? 'Gagal mengambil detail laporan';
        }

        $title = "Detail Laporan - Petugas BPBD";
        include 'views/laporan-petugas/detail.php';
    }

    public function edit() {
        $currentUser = $this->authService->getCurrentUser();

        
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=LaporanPetugas&action=index');
            exit;
        }

        
        $response = $this->laporanService->getById($id);

        if ($response['success']) {
            $laporan = $response['data'];
        } else {
            $laporan = null;
            $error_message = $response['message'] ?? 'Gagal mengambil detail laporan';
        }

        $title = "Edit Laporan - Petugas BPBD";
        include 'views/laporan-petugas/edit.php';
    }

    public function update() {
        
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=LaporanPetugas&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();

        
        $status = $_POST['status'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';

        
        if (empty($status)) {
            setDialog('Gagal', 'Status harus dipilih', 'error');
            header('Location: index.php?controller=LaporanPetugas&action=edit&id=' . $id);
            exit;
        }

        
        $data = [
            'status' => $status,
            'keterangan' => $keterangan
        ];

        
        $response = $this->laporanService->updateStatus($id, $data);

        if ($response['success']) {
            setDialog('Berhasil', 'Status laporan berhasil diperbarui', 'success');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal memperbarui status laporan', 'error');
        }

        header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
        exit;
    }

    public function updateToProses() {
        
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=LaporanPetugas&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();

        
        $response = $this->laporanService->updateToProses($id);

        if ($response['success']) {
            setDialog('Berhasil', 'Status laporan berhasil diubah menjadi Diproses', 'success');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal mengubah status laporan', 'error');
        }

        header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
        exit;
    }

    public function updateToSelesai() {
        
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=LaporanPetugas&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();

        
        $keterangan = $_POST['keterangan'] ?? '';

        
        $data = [
            'keterangan' => $keterangan
        ];

        
        $response = $this->laporanService->updateToSelesai($id, $data);

        if ($response['success']) {
            setDialog('Berhasil', 'Status laporan berhasil diubah menjadi Selesai', 'success');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal mengubah status laporan', 'error');
        }

        header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
        exit;
    }

    public function updateToDitolak() {
        
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=LaporanPetugas&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();

        
        $keterangan = $_POST['keterangan'] ?? '';

        
        $data = [
            'keterangan' => $keterangan
        ];

        
        $response = $this->laporanService->updateToDitolak($id, $data);

        if ($response['success']) {
            setDialog('Berhasil', 'Status laporan berhasil diubah menjadi Ditolak', 'success');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal mengubah status laporan', 'error');
        }

        header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
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
