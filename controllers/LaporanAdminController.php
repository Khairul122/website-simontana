<?php

require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/LaporanAdminService.php';

class LaporanAdminController
{
    private $service;

    public function __construct()
    {
        // Cek otentikasi pengguna
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
            header('Location: ../login.php');
            exit();
        }
        
        $this->service = new LaporanAdminService();
    }

    /**
     * Tampilkan halaman index (daftar laporan bencana)
     */
    public function index()
    {
        // Ambil filter dari query string
        $filters = [
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? '',
            'limit' => $_GET['limit'] ?? 15,
            'page' => $_GET['page'] ?? 1
        ];

        // Hapus filter kosong
        $filters = array_filter($filters, function($value) {
            return $value !== '';
        });

        $response = $this->service->getAll($filters);

        if (!$response['success']) {
            echo '<script>alert("Gagal mengambil data laporan bencana: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '");</script>';
            $laporanList = [];
            $pagination = null;
        } else {
            $data = $response['data'];
            $laporanList = $data['data'] ?? $data ?? [];
            $pagination = isset($data['current_page']) ? [
                'current_page' => $data['current_page'],
                'last_page' => $data['last_page'],
                'per_page' => $data['per_page'],
                'total' => $data['total']
            ] : null;
        }

        include __DIR__ . '/../views/laporan-admin/index.php';
    }

    /**
     * Tampilkan halaman detail laporan
     */
    public function detail()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'ID laporan tidak ditemukan'
            ];
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit;
        }

        $response = $this->service->getById($id);

        if (!$response['success']) {
            echo '<script>alert("Gagal mengambil detail laporan bencana: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=LaporanAdmin&action=index";</script>';
            exit();
        }

        // Cek struktur data yang dikembalikan API
        if (isset($response['data']['data'])) {
            $laporan = $response['data']['data'];
        } elseif (isset($response['data']) && !empty($response['data'])) {
            $laporan = $response['data'];
        } else {
            echo '<script>alert("Laporan bencana tidak ditemukan"); window.location.href="index.php?controller=LaporanAdmin&action=index";</script>';
            exit();
        }

        include __DIR__ . '/../views/laporan-admin/detail.php';
    }

    /**
     * Tampilkan form edit laporan
     */
    public function edit()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'ID laporan tidak ditemukan'
            ];
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit;
        }

        $response = $this->service->getById($id);

        if (!$response['success']) {
            echo '<script>alert("Gagal mengambil data laporan bencana: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=LaporanAdmin&action=index";</script>';
            exit();
        }

        // Cek struktur data yang dikembalikan API
        if (isset($response['data']['data'])) {
            $laporan = $response['data']['data'];
        } elseif (isset($response['data']) && !empty($response['data'])) {
            $laporan = $response['data'];
        } else {
            echo '<script>alert("Laporan bencana tidak ditemukan"); window.location.href="index.php?controller=LaporanAdmin&action=index";</script>';
            exit();
        }

        include __DIR__ . '/../views/laporan-admin/update.php';
    }

    /**
     * Update data laporan
     */
    public function update()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit();
        }

        // Ambil data dari form
        $judul = trim($_POST['judul'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $tingkat_kedaruratan = trim($_POST['tingkat_kedaruratan'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');

        // Validasi
        if (empty($judul) || empty($deskripsi) || empty($tingkat_kedaruratan)) {
            echo '<script>alert("Judul, deskripsi, dan tingkat kedaruratan wajib diisi"); window.location.href="index.php?controller=LaporanAdmin&action=edit&id=' . $id . '";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'tingkat_kedaruratan' => $tingkat_kedaruratan,
            'alamat' => $alamat
        ];

        // Cek apakah ada file yang diupload
        $files = [];
        $fileFields = ['foto_bukti_1', 'foto_bukti_2', 'foto_bukti_3', 'video_bukti'];

        foreach ($fileFields as $field) {
            if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
                $files[$field] = $_FILES[$field];
            }
        }

        // Panggil service
        $response = $this->service->update($id, $data, $files);

        if ($response['success']) {
            echo '<script>alert("Laporan bencana berhasil diperbarui"); window.location.href="index.php?controller=LaporanAdmin&action=detail&id=' . $id . '";</script>';
        } else {
            echo '<script>alert("Gagal memperbarui laporan bencana: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=LaporanAdmin&action=edit&id=' . $id . '";</script>';
        }
        exit();
    }

    /**
     * Hapus data laporan
     */
    public function delete()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit();
        }

        // Panggil service
        $response = $this->service->delete($id);

        if ($response['success']) {
            echo '<script>alert("Laporan bencana berhasil dihapus"); window.location.href="index.php?controller=LaporanAdmin&action=index";</script>';
        } else {
            echo '<script>alert("Gagal menghapus laporan bencana: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=LaporanAdmin&action=index";</script>';
        }
        exit();
    }
}