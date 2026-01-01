<?php
require_once 'services/AuthService.php';
require_once 'services/TindakLanjutService.php';

class TindakLanjutController {
    private $authService;
    private $tindakLanjutService;

    public function __construct() {
        $this->authService = new AuthService();
        
        // Pastikan pengguna sudah login
        $currentUser = $this->authService->getCurrentUser();
        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        // Pastikan role adalah Admin atau PetugasBPBD
        $userRole = $currentUser['data']['role'] ?? '';
        if ($userRole !== 'Admin' && $userRole !== 'PetugasBPBD') {
            // Jika bukan Admin atau PetugasBPBD, redirect ke halaman sesuai role
            $this->redirectToRoleDashboard($userRole);
            exit;
        }

        $this->tindakLanjutService = new TindakLanjutService();
    }

    public function index() {
        $currentUser = $this->authService->getCurrentUser();
        
        // Ambil filter dari query string
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

        // Ambil data tindak lanjut dari service
        $response = $this->tindakLanjutService->getAll($filters);

        if ($response['success']) {
            $tindakLanjutList = $response['data'];
        } else {
            $tindakLanjutList = [];
            $error_message = $response['message'] ?? 'Gagal mengambil data tindak lanjut';
        }

        $title = "Daftar Tindak Lanjut - SIMONTA BENCANA";
        include 'views/tindak-lanjut/index.php';
    }

    public function detail() {
        $currentUser = $this->authService->getCurrentUser();
        
        // Ambil ID dari parameter GET
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: index.php?controller=TindakLanjut&action=index');
            exit;
        }
        
        // Ambil detail tindak lanjut dari service
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

        // Ambil data laporan dan petugas untuk dropdown
        $laporanResponse = $this->tindakLanjutService->getAllLaporan();
        $petugasResponse = $this->tindakLanjutService->getAllPetugas();

        // Extract data handling pagination structure
        $laporanList = $laporanResponse['data']['data'] ?? $laporanResponse['data'] ?? [];
        $petugasList = $petugasResponse['data']['data'] ?? $petugasResponse['data'] ?? [];

        $title = "Tambah Tindak Lanjut - SIMONTA BENCANA";
        include 'views/tindak-lanjut/form.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=TindakLanjut&action=index');
            exit;
        }

        $currentUser = $this->authService->getCurrentUser();
        
        // Ambil data dari form
        $laporanId = $_POST['laporan_id'] ?? '';
        $tanggalTanggapan = $_POST['tanggal_tanggapan'] ?? '';
        $status = $_POST['status'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        
        // Validasi input
        if (empty($laporanId) || empty($tanggalTanggapan) || empty($status)) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => 'Laporan, tanggal tanggapan, dan status harus diisi'
            ];
            header('Location: index.php?controller=TindakLanjut&action=create');
            exit;
        }

        // Data untuk disimpan
        $data = [
            'laporan_id' => $laporanId,
            'tanggal_tanggapan' => $tanggalTanggapan,
            'status' => $status,
            'keterangan' => $keterangan,
            'id_petugas' => $currentUser['data']['id'] // Gunakan ID petugas yang sedang login
        ];

        // Upload file jika ada
        $files = [];
        if (isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] === UPLOAD_ERR_OK) {
            $files['foto_kegiatan'] = $_FILES['foto_kegiatan'];
        }

        // Simpan tindak lanjut
        $response = $this->tindakLanjutService->create($data, $files);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Tindak lanjut berhasil ditambahkan'
            ];
            header('Location: index.php?controller=TindakLanjut&action=index');
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal menambahkan tindak lanjut'
            ];
            header('Location: index.php?controller=TindakLanjut&action=create');
        }
        exit;
    }

    public function edit() {
        $currentUser = $this->authService->getCurrentUser();
        
        // Ambil ID dari parameter GET
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: index.php?controller=TindakLanjut&action=index');
            exit;
        }
        
        // Ambil detail tindak lanjut dari service
        $response = $this->tindakLanjutService->getById($id);

        if ($response['success']) {
            $tindakLanjut = $response['data'];
        } else {
            $tindakLanjut = null;
            $error_message = $response['message'] ?? 'Gagal mengambil detail tindak lanjut';
        }

        // Ambil data laporan dan petugas untuk dropdown
        $laporanResponse = $this->tindakLanjutService->getAllLaporan();
        $petugasResponse = $this->tindakLanjutService->getAllPetugas();

        // Extract data handling pagination structure
        $laporanList = $laporanResponse['data']['data'] ?? $laporanResponse['data'] ?? [];
        $petugasList = $petugasResponse['data']['data'] ?? $petugasResponse['data'] ?? [];

        $title = "Edit Tindak Lanjut - SIMONTA BENCANA";
        include 'views/tindak-lanjut/form.php';
    }

    public function update() {
        // Ambil ID dari parameter GET
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
        
        // Ambil data dari form
        $laporanId = $_POST['laporan_id'] ?? '';
        $tanggalTanggapan = $_POST['tanggal_tanggapan'] ?? '';
        $status = $_POST['status'] ?? '';
        $keterangan = $_POST['keterangan'] ?? '';
        
        // Validasi input
        if (empty($tanggalTanggapan) || empty($status)) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => 'Tanggal tanggapan dan status harus diisi'
            ];
            header('Location: index.php?controller=TindakLanjut&action=edit&id=' . $id);
            exit;
        }

        // Data untuk update
        $data = [
            'laporan_id' => $laporanId,
            'tanggal_tanggapan' => $tanggalTanggapan,
            'status' => $status,
            'keterangan' => $keterangan,
            'id_petugas' => $currentUser['data']['id'] // Gunakan ID petugas yang sedang login
        ];

        // Upload file jika ada
        $files = [];
        if (isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] === UPLOAD_ERR_OK) {
            $files['foto_kegiatan'] = $_FILES['foto_kegiatan'];
        }

        // Update tindak lanjut
        $response = $this->tindakLanjutService->update($id, $data, $files);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Tindak lanjut berhasil diperbarui'
            ];
            header('Location: index.php?controller=TindakLanjut&action=detail&id=' . $id);
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal memperbarui tindak lanjut'
            ];
            header('Location: index.php?controller=TindakLanjut&action=edit&id=' . $id);
        }
        exit;
    }

    public function delete() {
        // Ambil ID dari parameter GET
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
        
        // Hapus tindak lanjut
        $response = $this->tindakLanjutService->delete($id);

        if ($response['success']) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Tindak lanjut berhasil dihapus'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'title' => 'Gagal',
                'message' => $response['message'] ?? 'Gagal menghapus tindak lanjut'
            ];
        }

        header('Location: index.php?controller=TindakLanjut&action=index');
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