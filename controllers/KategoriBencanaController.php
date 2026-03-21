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

    


    private function checkRole()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
            header('Location: index.php?controller=Auth&action=login');
            exit();
        }
    }

    


    public function index()
    {
        $this->checkRole();

        $response = $this->service->getAll();

        $kategoriRows = [];
        $fetchError = null;

        if ($response['success']) {
            $kategoriRows = is_array($response['data'] ?? null) ? $response['data'] : [];
        } else {
            $fetchError = $response['message'] ?? 'Terjadi kesalahan pada server.';
        }

        
        include __DIR__ . '/../views/kategori-bencana/index.php';
    }

    


    public function create()
    {
        $this->checkRole();

        $isEdit = false;
        $kategori = null;

        include __DIR__ . '/../views/kategori-bencana/form.php';
    }

    


    public function edit()
    {
        $this->checkRole();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            setDialog('Error', 'ID tidak ditemukan', 'error');
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit;
        }

        $response = $this->service->getById($id);

        if (!$response['success']) {
            setDialog('Error', $response['message'] ?? 'Gagal mengambil data kategori bencana', 'error');
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        if (empty($response['data']) || !is_array($response['data'])) {
            setDialog('Error', 'Kategori bencana tidak ditemukan', 'error');
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        $kategori = $response['data'];

        $isEdit = true;

        include __DIR__ . '/../views/kategori-bencana/form.php';
    }

    


    public function store()
    {
        $this->checkRole();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        
        $nama_kategori = trim($_POST['nama_kategori'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $icon = trim($_POST['icon'] ?? '');

        
        if (empty($nama_kategori)) {
            setDialog('Error', 'Nama kategori wajib diisi', 'error');
            header('Location: index.php?controller=KategoriBencana&action=create');
            exit();
        }

        
        $data = [
            'nama_kategori' => $nama_kategori,
            'deskripsi' => $deskripsi,
            'icon' => $icon
        ];

        
        $response = $this->service->create($data);

        if ($response['success']) {
            header('Location: index.php?controller=KategoriBencana&action=index&success=' . urlencode('Kategori bencana berhasil ditambahkan'));
        } else {
            header('Location: index.php?controller=KategoriBencana&action=index&error=' . urlencode($response['message'] ?? 'Gagal menambahkan kategori bencana'));
        }
        exit();
    }

    


    public function update()
    {
        $this->checkRole();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        
        $nama_kategori = trim($_POST['nama_kategori'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $icon = trim($_POST['icon'] ?? '');

        
        if (empty($nama_kategori)) {
            setDialog('Error', 'Nama kategori wajib diisi', 'error');
            header('Location: index.php?controller=KategoriBencana&action=edit&id=' . $id);
            exit();
        }

        
        $data = [
            'nama_kategori' => $nama_kategori,
            'deskripsi' => $deskripsi,
            'icon' => $icon
        ];

        
        $response = $this->service->update($id, $data);

        if ($response['success']) {
            header('Location: index.php?controller=KategoriBencana&action=index&success=' . urlencode('Kategori bencana berhasil diperbarui'));
        } else {
            header('Location: index.php?controller=KategoriBencana&action=index&error=' . urlencode($response['message'] ?? 'Gagal memperbarui kategori bencana'));
        }
        exit();
    }

    


    public function delete()
    {
        $this->checkRole();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=KategoriBencana&action=index');
            exit();
        }

        
        $response = $this->service->delete($id);

        if ($response['success']) {
            header('Location: index.php?controller=KategoriBencana&action=index&success=' . urlencode('Kategori bencana berhasil dihapus'));
        } else {
            header('Location: index.php?controller=KategoriBencana&action=index&error=' . urlencode($response['message'] ?? 'Gagal menghapus kategori bencana'));
        }
        exit();
    }
}
