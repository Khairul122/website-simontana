<?php
require_once 'services/AuthService.php';
require_once 'services/LaporanPetugasService.php';

class LaporanPetugasController {
    private $authService;
    private $laporanService;

    public function __construct() {
        $this->authService = new AuthService();
        
        // Pastikan pengguna sudah login
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        // Pastikan role adalah PetugasBPBD
        $userRole = $currentUser['data']['role'] ?? '';
        if ($userRole !== 'PetugasBPBD') {
            // Jika bukan PetugasBPBD, redirect ke halaman sesuai role
            $this->redirectToRoleDashboard($userRole);
            exit;
        }

        $this->laporanService = new LaporanPetugasService();
    }

    public function index() {
        $currentUser = $this->authService->getCurrentUser();
        
        // Ambil filter dari query string
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

        // Ambil data laporan dari service
        $response = $this->laporanService->getAll($filters);

        if ($response['success']) {
            $laporanList = $response['data'];
        } else {
            $laporanList = [];
            $error_message = $response['message'] ?? 'Gagal mengambil data laporan';
        }

        $title = "Daftar Laporan - Petugas BPBD";
        include 'views/laporan-petugas/index.php';
    }

    public function detail() {
        $currentUser = $this->authService->getCurrentUser();

        // Ambil ID dari parameter GET
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=LaporanPetugas&action=index');
            exit;
        }

        // Ambil detail laporan dari service
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

        // Ambil ID dari parameter GET
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?controller=LaporanPetugas&action=index');
            exit;
        }

        // Ambil detail laporan dari service
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
        // Ambil ID dari parameter GET
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

        // Ambil data dari form
        $status = $_POST['status'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';

        // Validasi input
        if (empty($status)) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => 'Status harus dipilih'
            ];
            header('Location: index.php?controller=LaporanPetugas&action=edit&id=' . $id);
            exit;
        }

        // Data untuk update
        $data = [
            'status' => $status,
            'keterangan' => $keterangan
        ];

        // Update status laporan
        $response = $this->laporanService->updateStatus($id, $data);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Status laporan berhasil diperbarui'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal memperbarui status laporan'
            ];
        }

        header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
        exit;
    }

    public function updateToProses() {
        // Ambil ID dari parameter GET
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

        // Update status laporan ke Diproses
        $response = $this->laporanService->updateToProses($id);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Status laporan berhasil diubah menjadi Diproses'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal mengubah status laporan'
            ];
        }

        header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
        exit;
    }

    public function updateToSelesai() {
        // Ambil ID dari parameter GET
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

        // Ambil data dari form
        $keterangan = $_POST['keterangan'] ?? '';

        // Data untuk update
        $data = [
            'keterangan' => $keterangan
        ];

        // Update status laporan ke Selesai
        $response = $this->laporanService->updateToSelesai($id, $data);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Status laporan berhasil diubah menjadi Selesai'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal mengubah status laporan'
            ];
        }

        header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
        exit;
    }

    public function updateToDitolak() {
        // Ambil ID dari parameter GET
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

        // Ambil data dari form
        $keterangan = $_POST['keterangan'] ?? '';

        // Data untuk update
        $data = [
            'keterangan' => $keterangan
        ];

        // Update status laporan ke Ditolak
        $response = $this->laporanService->updateToDitolak($id, $data);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Status laporan berhasil diubah menjadi Ditolak'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal mengubah status laporan'
            ];
        }

        header('Location: index.php?controller=LaporanPetugas&action=detail&id=' . $id);
        exit;
    }

    // Fungsi umum untuk redirect berdasarkan role (untuk validasi akses)
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
                header('Location: index.php?controller=Beranda&action=index');
                break;
            default:
                header('Location: index.php?controller=Auth&action=login');
                break;
        }
    }
}