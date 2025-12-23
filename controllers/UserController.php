<?php

require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/UserService.php';

class UserController 
{
    private $service;

    public function __construct() 
    {
        $this->service = new UserService();
    }

    /**
     * Cek role user, hanya Admin yang bisa akses
     */
    private function checkRole() 
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
            header('Location: index.php?controller=dashboard&action=admin');
            exit();
        }
    }

    /**
     * Tampilkan halaman index (daftar pengguna)
     */
    public function index() 
    {
        $this->checkRole();
        
        $response = $this->service->getAll();
        
        // Set session untuk debugging
        $_SESSION['server_response'] = $response;
        
        // Load view
        include dirname(__DIR__) . '/views/user/index.php';
    }

    /**
     * Tampilkan form create
     */
    public function create() 
    {
        $this->checkRole();
        
        $isEdit = false;
        $user = null;
        
        include dirname(__DIR__) . '/views/user/form.php';
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
            header('Location: index.php?controller=User&action=index');
            exit;
        }

        $response = $this->service->getById($id);

        if (!$response['success'] || empty($response['data'])) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Pengguna tidak ditemukan'
            ];
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        $user = $response['data'];
        $isEdit = true;

        // Jika pengguna memiliki id_desa, kita perlu mendapatkan data wilayah lengkap
        if (!empty($user['id_desa'])) {
            // Kita perlu mengambil data wilayah lengkap secara manual karena API mungkin tidak menyediakan nested data
            $user['desa'] = $this->getWilayahDetail($user['id_desa']);
        }

        // Set session untuk debugging saat edit
        $_SESSION['server_response_edit'] = $response;

        include dirname(__DIR__) . '/views/user/form.php';
    }

    /**
     * Fungsi untuk mendapatkan detail wilayah lengkap berdasarkan id_desa
     */
    private function getWilayahDetail($id_desa)
    {
        require_once dirname(__DIR__) . '/services/WilayahService.php';
        $wilayahService = new \WilayahService();

        $response = $wilayahService->getWilayahDetailByDesa($id_desa);

        if (!$response['success'] || empty($response['data'])) {
            return null;
        }

        return $response['data'];
    }

    /**
     * Simpan data baru
     */
    public function store() 
    {
        $this->checkRole();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $no_telepon = trim($_POST['no_telepon'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $id_desa = trim($_POST['id_desa'] ?? '');

        // Validasi input wajib
        if (empty($nama) || empty($username) || empty($role) || empty($password)) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Semua field wajib diisi (kecuali alamat, no_telepon dan id_desa)'
            ];
            header('Location: index.php?controller=User&action=create');
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'username' => $username,
            'email' => $email,
            'no_telepon' => $no_telepon,
            'role' => $role,
            'alamat' => $alamat,
            'id_desa' => $id_desa,
            'password' => $password,
            'password_confirmation' => $password
        ];

        // Panggil service
        $response = $this->service->create($data);

        if ($response['success']) {
            header('Location: index.php?controller=User&action=index&success=' . urlencode('Pengguna berhasil ditambahkan'));
        } else {
            header('Location: index.php?controller=User&action=index&error=' . urlencode($response['message'] ?? 'Gagal menambahkan pengguna'));
        }
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
            header('Location: index.php?controller=User&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $no_telepon = trim($_POST['no_telepon'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $id_desa = trim($_POST['id_desa'] ?? '');

        // Validasi input wajib
        if (empty($nama) || empty($username) || empty($role)) {
            $_SESSION['toast_message'] = [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Nama, username, dan role wajib diisi'
            ];
            header('Location: index.php?controller=User&action=edit&id=' . $id);
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'username' => $username,
            'email' => $email,
            'no_telepon' => $no_telepon,
            'role' => $role,
            'alamat' => $alamat,
            'id_desa' => $id_desa
        ];

        // Tambahkan password ke data hanya jika diisi
        if (!empty($password)) {
            $data['password'] = $password;
            $data['password_confirmation'] = $password;
        }

        // Panggil service
        $response = $this->service->update($id, $data);

        if ($response['success']) {
            header('Location: index.php?controller=User&action=index&success=' . urlencode('Pengguna berhasil diperbarui'));
        } else {
            header('Location: index.php?controller=User&action=index&error=' . urlencode($response['message'] ?? 'Gagal memperbarui pengguna'));
        }
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
            header('Location: index.php?controller=User&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        // Panggil service
        $response = $this->service->delete($id);

        if ($response['success']) {
            header('Location: index.php?controller=User&action=index&success=' . urlencode('Pengguna berhasil dihapus'));
        } else {
            header('Location: index.php?controller=User&action=index&error=' . urlencode($response['message'] ?? 'Gagal menghapus pengguna'));
        }
        exit();
    }
}