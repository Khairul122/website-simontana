<?php

require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/KategoriBencanaService.php';

class KategoriBencanaController
{

    private $service;

    public function __construct()
    {
        $this->service = new KategoriBencanaService();
    }

    /**
     * Cek role user, hanya Admin yang bisa akses
     */
    private function checkRole()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
            header('Location: ../login.php');
            exit();
        }
    }

    /**
     * Tampilkan halaman index (daftar kategori bencana)
     */
    public function index()
    {
        $this->checkRole();

        $response = $this->service->getAll();

        // Set session untuk debugging
        $_SESSION['server_response'] = $response;

        // Load view
        include __DIR__ . '/../views/kategori-bencana/index.php';
    }

    /**
     * Tampilkan form create
     */
    public function create()
    {
        $this->checkRole();

        $isEdit = false;
        $kategori = null;

        include __DIR__ . '/../views/kategori-bencana/form.php';
    }

    /**
     * Tampilkan form edit
     */
    public function edit()
    {
        $this->checkRole();

        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'ID tidak ditemukan'
            ];
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit;
        }

        $response = $this->service->getById($id);

        if (!$response['success']) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => $response['message'] ?? 'Gagal mengambil data kategori bencana'
            ];
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        // Cek struktur data yang dikembalikan API - bisa saja langsung berisi data atau dalam nested array
        if (isset($response['data']['data'])) {
            // Format biasanya untuk response list, tapi mungkin juga untuk single
            $kategori = $response['data']['data'];
        } elseif (isset($response['data']) && !empty($response['data'])) {
            // Format untuk response single item
            $kategori = $response['data'];
        } else {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Kategori bencana tidak ditemukan'
            ];
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        $isEdit = true;

        // Set session untuk debugging saat edit
        $_SESSION['server_response_edit'] = $response;

        include __DIR__ . '/../views/kategori-bencana/form.php';
    }

    /**
     * Simpan data baru
     */
    public function store()
    {
        $this->checkRole();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        // Ambil data dari form
        $nama_kategori = trim($_POST['nama_kategori'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $icon = trim($_POST['icon'] ?? '');

        // Validasi
        if (empty($nama_kategori)) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Nama kategori wajib diisi'
            ];
            header('Location: index.php?controller=KategoriBencana&action=create');
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama_kategori' => $nama_kategori,
            'deskripsi' => $deskripsi,
            'icon' => $icon
        ];

        // Panggil service
        $response = $this->service->create($data);

        if ($response['success']) {
            $_SESSION['toast_message'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Kategori bencana berhasil ditambahkan'
            ];
        } else {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => $response['message'] ?? 'Gagal menambahkan kategori bencana'
            ];
        }

        header('Location: index.php?controller=KategoriBencana&action=index');
        exit();
    }

    /**
     * Update data
     */
    public function update()
    {
        $this->checkRole();

        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        // Ambil data dari form
        $nama_kategori = trim($_POST['nama_kategori'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $icon = trim($_POST['icon'] ?? '');

        // Validasi
        if (empty($nama_kategori)) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Nama kategori wajib diisi'
            ];
            header('Location: index.php?controller=KategoriBencana&action=edit&id=' . $id);
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama_kategori' => $nama_kategori,
            'deskripsi' => $deskripsi,
            'icon' => $icon
        ];

        // Panggil service
        $response = $this->service->update($id, $data);

        if ($response['success']) {
            $_SESSION['toast_message'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Kategori bencana berhasil diperbarui'
            ];
        } else {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => $response['message'] ?? 'Gagal memperbarui kategori bencana'
            ];
        }

        header('Location: index.php?controller=KategoriBencana&action=index');
        exit();
    }

    /**
     * Hapus data
     */
    public function delete()
    {
        $this->checkRole();

        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        // Panggil service
        $response = $this->service->delete($id);

        if ($response['success']) {
            $_SESSION['toast_message'] = [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Kategori bencana berhasil dihapus'
            ];
        } else {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => $response['message'] ?? 'Gagal menghapus kategori bencana'
            ];
        }

        header('Location: index.php?controller=KategoriBencana&action=index');
        exit();
    }
}
