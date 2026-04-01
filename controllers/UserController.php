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

    


    private function checkRole()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
            header('Location: index.php?controller=Dashboard&action=admin');
            exit();
        }
    }

    


    private function handleUnauthorized()
    {
        clearSession();

        setToast('error', 'Sesi Habis', 'Sesi Anda telah berakhir, silakan login kembali.');

        
        header('Location: index.php?controller=Auth&action=login');
        exit();
    }

    


    private function isUnauthorized($response)
    {
        return ($response['http_code'] === 401 ||
                (isset($response['message']) &&
                 (stripos($response['message'], 'unauthorized') !== false ||
                  stripos($response['message'], 'token') !== false)));
    }

    


    public function index()
    {
        $this->checkRole();

        $filters = [];
        if (!empty($_GET['search'])) {
            $filters['search'] = trim((string)$_GET['search']);
        }
        if (!empty($_GET['role'])) {
            $filters['role'] = trim((string)$_GET['role']);
        }
        $perPage = (int)($_GET['per_page'] ?? 20);
        $filters['per_page'] = $perPage > 0 ? $perPage : 20;

        $response = $this->service->getAll($filters);

        
        if ($this->isUnauthorized($response)) {
            $this->handleUnauthorized();
        }

        $users = [];
        $fetchError = null;

        if ($response['success']) {
            $users = is_array($response['data'] ?? null) ? $response['data'] : [];
        } else {
            $fetchError = [
                'message' => $response['message'] ?? 'Terjadi kesalahan saat mengambil data pengguna.',
                'details' => $response['details'] ?? $response['errors'] ?? []
            ];
        }

        
        include dirname(__DIR__) . '/views/user/index.php';
    }

    


    public function create()
    {
        $this->checkRole();

        $isEdit = false;
        $user = null;

        
        $provinsiList = $this->getAllProvinsi();
        $kabupatenList = [];
        $kecamatanList = [];
        $desaList = [];

        include dirname(__DIR__) . '/views/user/form.php';
    }

    


    public function edit()
    {
        $this->checkRole();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=User&action=index');
            exit;
        }

        $response = $this->service->getById($id);

        
        if ($this->isUnauthorized($response)) {
            $this->handleUnauthorized();
        }

        if (!$response['success'] || empty($response['data'])) {
            setDialog('Error', 'Pengguna tidak ditemukan', 'error');
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        $user = $response['data'];
        $isEdit = true;

        
        if (!empty($user['id_desa'])) {
            
            $user['desa'] = $this->getWilayahDetail($user['id_desa']);
        }

        
        $provinsiList = $this->getAllProvinsi();
        $kabupatenList = [];
        $kecamatanList = [];
        $desaList = [];

        
        if (!empty($user['id_desa'])) {
            
            $provinsiList = $this->getAllProvinsi();
        }

        include dirname(__DIR__) . '/views/user/form.php';
    }

    


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

    


    private function getAllProvinsi()
    {
        require_once dirname(__DIR__) . '/services/WilayahService.php';
        $wilayahService = new \WilayahService();

        $response = $wilayahService->getAllProvinsi();

        if (!$response['success'] || empty($response['data'])) {
            return [];
        }

        return $response['data'];
    }

    


    private function getKabupatenByProvinsi($provinsiId)
    {
        require_once dirname(__DIR__) . '/services/WilayahService.php';
        $wilayahService = new \WilayahService();

        $response = $wilayahService->getAllKabupaten($provinsiId);

        if (!$response['success'] || empty($response['data'])) {
            return [];
        }

        return $response['data'];
    }

    


    private function getKecamatanByKabupaten($kabupatenId)
    {
        require_once dirname(__DIR__) . '/services/WilayahService.php';
        $wilayahService = new \WilayahService();

        $response = $wilayahService->getAllKecamatan($kabupatenId);

        if (!$response['success'] || empty($response['data'])) {
            return [];
        }

        return $response['data'];
    }

    


    private function getDesaByKecamatan($kecamatanId)
    {
        require_once dirname(__DIR__) . '/services/WilayahService.php';
        $wilayahService = new \WilayahService();

        $response = $wilayahService->getAllDesa($kecamatanId);

        if (!$response['success'] || empty($response['data'])) {
            return [];
        }

        return $response['data'];
    }

    


    public function store()
    {
        $this->checkRole();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $no_telepon = trim($_POST['no_telepon'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $id_desa = trim($_POST['id_desa'] ?? '');

        
        if (empty($nama) || empty($username) || empty($role) || empty($password)) {
            setDialog('Error', 'Semua field wajib diisi (kecuali alamat, no_telepon dan id_desa)', 'error');
            header('Location: index.php?controller=User&action=create');
            exit();
        }

        
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

        
        $response = $this->service->create($data);

        
        if ($this->isUnauthorized($response)) {
            $this->handleUnauthorized();
        }

        if ($response['success']) {
            header('Location: index.php?controller=User&action=index&success=' . urlencode('Pengguna berhasil ditambahkan'));
        } else {
            header('Location: index.php?controller=User&action=index&error=' . urlencode($response['message'] ?? 'Gagal menambahkan pengguna'));
        }
        exit();
    }

    


    public function update()
    {
        $this->checkRole();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=User&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $no_telepon = trim($_POST['no_telepon'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $id_desa = trim($_POST['id_desa'] ?? '');

        
        if (empty($nama) || empty($username) || empty($role)) {
            setDialog('Error', 'Nama, username, dan role wajib diisi', 'error');
            header('Location: index.php?controller=User&action=edit&id=' . $id);
            exit();
        }

        
        $data = [
            'nama' => $nama,
            'username' => $username,
            'email' => $email,
            'no_telepon' => $no_telepon,
            'role' => $role,
            'alamat' => $alamat,
            'id_desa' => $id_desa
        ];

        
        if (!empty($password)) {
            $data['password'] = $password;
            $data['password_confirmation'] = $password;
        }

        
        $response = $this->service->update($id, $data);

        
        if ($this->isUnauthorized($response)) {
            $this->handleUnauthorized();
        }

        if ($response['success']) {
            header('Location: index.php?controller=User&action=index&success=' . urlencode('Pengguna berhasil diperbarui'));
        } else {
            header('Location: index.php?controller=User&action=index&error=' . urlencode($response['message'] ?? 'Gagal memperbarui pengguna'));
        }
        exit();
    }

    


    public function delete()
    {
        $this->checkRole();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=User&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=User&action=index');
            exit();
        }

        
        $response = $this->service->delete($id);

        
        if ($this->isUnauthorized($response)) {
            $this->handleUnauthorized();
        }

        if ($response['success']) {
            header('Location: index.php?controller=User&action=index&success=' . urlencode('Pengguna berhasil dihapus'));
        } else {
            header('Location: index.php?controller=User&action=index&error=' . urlencode($response['message'] ?? 'Gagal menghapus pengguna'));
        }
        exit();
    }
}
