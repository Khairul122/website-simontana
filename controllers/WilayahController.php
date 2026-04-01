<?php

require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/WilayahService.php';

class WilayahController
{
    private $service;

    private function redirectWithDialog(string $title, string $message, string $url, string $type = 'info'): void
    {
        setDialog($title, $message, $type);
        header('Location: ' . $url);
        exit;
    }

    private function blockEditDelete(string $redirectUrl): void
    {
        $this->redirectWithDialog(
            'Fitur Dinonaktifkan',
            'Fitur edit dan hapus wilayah saat ini dinonaktifkan.',
            $redirectUrl,
            'info'
        );
    }

    public function __construct()
    {
        
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit();
        }
        
        $this->service = new WilayahService();
    }

    


    public function index()
    {
        include __DIR__ . '/../views/wilayah/index.php';
    }

    



    


    public function indexProvinsi()
    {
        $response = $this->service->getAllProvinsi();

        if (!$response['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $response['data'] ?? [];
        }

        include __DIR__ . '/../views/wilayah/index-provinsi.php';
    }

    


    public function createProvinsi()
    {
        $isEdit = false;
        $provinsi = null;

        include __DIR__ . '/../views/wilayah/form-provinsi.php';
    }

    


    public function storeProvinsi()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');

        
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama provinsi wajib diisi', 'index.php?controller=Wilayah&action=createProvinsi', 'error');
        }

        
        $data = [
            'nama' => $nama
        ];

        
        $response = $this->service->store($data, 'provinsi');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Provinsi berhasil ditambahkan', 'index.php?controller=Wilayah&action=indexProvinsi', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menambahkan provinsi: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }
        exit();
    }

    


    public function editProvinsi()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexProvinsi');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            $this->redirectWithDialog('Gagal', 'ID tidak ditemukan', 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }

        $response = $this->service->getById($id, 'provinsi');

        if (!$response['success']) {
            $this->redirectWithDialog('Gagal', 'Gagal mengambil data provinsi: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }

        if (empty($response['data']) || !is_array($response['data'])) {
            $this->redirectWithDialog('Gagal', 'Provinsi tidak ditemukan', 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }

        $provinsi = $response['data'];

        $isEdit = true;

        include __DIR__ . '/../views/wilayah/form-provinsi.php';
    }

    


    public function updateProvinsi()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexProvinsi');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');

        
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama provinsi wajib diisi', 'index.php?controller=Wilayah&action=editProvinsi&id=' . $id, 'error');
        }

        
        $data = [
            'nama' => $nama
        ];

        
        $response = $this->service->update($id, $data, 'provinsi');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Provinsi berhasil diperbarui', 'index.php?controller=Wilayah&action=indexProvinsi', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal memperbarui provinsi: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }
        exit();
    }

    


    public function deleteProvinsi()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexProvinsi');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit();
        }

        
        $response = $this->service->delete($id, 'provinsi');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Provinsi berhasil dihapus', 'index.php?controller=Wilayah&action=indexProvinsi', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menghapus provinsi: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }
        exit();
    }

    



    


    public function indexKabupaten()
    {
        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        
        $provinsi_id = trim((string)($_GET['provinsi_id'] ?? ''));

        
        if ($provinsi_id !== '') {
            $response = $this->service->getAllKabupaten($provinsi_id);
        } else {
            
            $response = ['success' => true, 'data' => []];
        }

        if (!$response['success']) {
            $kabupatenList = [];
        } else {
            $kabupatenList = $response['data'] ?? [];
        }

        include __DIR__ . '/../views/wilayah/index-kabupaten.php';
    }

    


    public function createKabupaten()
    {
        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        $isEdit = false;
        $kabupaten = null;

        include __DIR__ . '/../views/wilayah/form-kabupaten.php';
    }

    


    public function storeKabupaten()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');
        $id_provinsi = $_POST['id_provinsi'] ?? null;

        
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama kabupaten wajib diisi', 'index.php?controller=Wilayah&action=createKabupaten', 'error');
        }

        if (empty($id_provinsi)) {
            $this->redirectWithDialog('Gagal', 'Provinsi wajib dipilih', 'index.php?controller=Wilayah&action=createKabupaten', 'error');
        }

        
        $data = [
            'nama' => $nama,
            'id_parent' => $id_provinsi
        ];

        
        $response = $this->service->store($data, 'kabupaten');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kabupaten berhasil ditambahkan', 'index.php?controller=Wilayah&action=indexKabupaten', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menambahkan kabupaten: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }
        exit();
    }

    


    public function editKabupaten()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexKabupaten');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            $this->redirectWithDialog('Gagal', 'ID tidak ditemukan', 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }

        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        $response = $this->service->getById($id, 'kabupaten');

        if (!$response['success']) {
            $this->redirectWithDialog('Gagal', 'Gagal mengambil data kabupaten: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }

        if (empty($response['data']) || !is_array($response['data'])) {
            $this->redirectWithDialog('Gagal', 'Kabupaten tidak ditemukan', 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }

        $kabupaten = $response['data'];

        $isEdit = true;

        include __DIR__ . '/../views/wilayah/form-kabupaten.php';
    }

    


    public function updateKabupaten()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexKabupaten');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');
        $id_provinsi = $_POST['id_provinsi'] ?? null;

        
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama kabupaten wajib diisi', 'index.php?controller=Wilayah&action=editKabupaten&id=' . $id, 'error');
        }

        if (empty($id_provinsi)) {
            $this->redirectWithDialog('Gagal', 'Provinsi wajib dipilih', 'index.php?controller=Wilayah&action=editKabupaten&id=' . $id, 'error');
        }

        
        $data = [
            'nama' => $nama,
            'id_parent' => $id_provinsi
        ];

        
        $response = $this->service->update($id, $data, 'kabupaten');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kabupaten berhasil diperbarui', 'index.php?controller=Wilayah&action=indexKabupaten', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal memperbarui kabupaten: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }
        exit();
    }

    


    public function deleteKabupaten()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexKabupaten');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit();
        }

        
        $response = $this->service->delete($id, 'kabupaten');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kabupaten berhasil dihapus', 'index.php?controller=Wilayah&action=indexKabupaten', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menghapus kabupaten: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }
        exit();
    }

    



    


    public function indexKecamatan()
    {
        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        
        $provinsi_id = trim((string)($_GET['provinsi_id'] ?? ''));
        $kabupatenList = [];
        if ($provinsi_id !== '') {
            $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
            if ($kabupatenResponse['success']) {
                $kabupatenList = $kabupatenResponse['data'] ?? [];
            }
        }

        
        $kabupaten_id = trim((string)($_GET['kabupaten_id'] ?? ''));
        $kecamatanList = [];
        if ($kabupaten_id !== '') {
            $kecamatanResponse = $this->service->getAllKecamatan($kabupaten_id);
            if ($kecamatanResponse['success']) {
                $kecamatanList = $kecamatanResponse['data'] ?? [];
            }
        }

        
        $response = $kabupaten_id !== ''
            ? $this->service->getAllKecamatan($kabupaten_id)
            : ['success' => true, 'data' => []];

        if (!$response['success']) {
            $kecamatanList = [];
        } else {
            $kecamatanList = $response['data'] ?? [];
        }

        include __DIR__ . '/../views/wilayah/index-kecamatan.php';
    }

    


    public function createKecamatan()
    {
        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        
        $provinsi_id = trim((string)($_GET['provinsi_id'] ?? ''));
        $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
        if (!$kabupatenResponse['success']) {
            $kabupatenList = [];
        } else {
            $kabupatenList = $kabupatenResponse['data'] ?? [];
        }

        $isEdit = false;
        $kecamatan = null;

        include __DIR__ . '/../views/wilayah/form-kecamatan.php';
    }

    


    public function storeKecamatan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');
        $id_kabupaten = $_POST['id_kabupaten'] ?? null;

        
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama kecamatan wajib diisi', 'index.php?controller=Wilayah&action=createKecamatan', 'error');
        }

        if (empty($id_kabupaten)) {
            $this->redirectWithDialog('Gagal', 'Kabupaten wajib dipilih', 'index.php?controller=Wilayah&action=createKecamatan', 'error');
        }

        
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kabupaten
        ];

        
        $response = $this->service->store($data, 'kecamatan');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kecamatan berhasil ditambahkan', 'index.php?controller=Wilayah&action=indexKecamatan', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menambahkan kecamatan: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }
        exit();
    }

    


    public function editKecamatan()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexKecamatan');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            $this->redirectWithDialog('Gagal', 'ID tidak ditemukan', 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }

        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        
        
        $kabupaten_id = $_GET['kabupaten_id'] ?? 0;
        $provinsi_id = $_GET['provinsi_id'] ?? 0;

        
        if ($provinsi_id === '' && $kabupaten_id !== '') {
            $kabupatenResponse = $this->service->getById($kabupaten_id, 'kabupaten');
            if ($kabupatenResponse['success'] && isset($kabupatenResponse['data'])) {
                $kabupatenDetail = $kabupatenResponse['data'];
                if (isset($kabupatenDetail['id_provinsi'])) {
                    $provinsi_id = $kabupatenDetail['id_provinsi'];
                } elseif (isset($kabupatenDetail['id_parent'])) {
                    $provinsi_id = $kabupatenDetail['id_parent'];
                }
            }
        }

        
        if ($provinsi_id !== '') {
            $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
            if (!$kabupatenResponse['success']) {
                $kabupatenList = [];
            } else {
                $kabupatenList = $kabupatenResponse['data'] ?? [];
            }
        } else {
            $kabupatenList = [];
        }

        $response = $this->service->getById($id, 'kecamatan');

        if (!$response['success']) {
            $this->redirectWithDialog('Gagal', 'Gagal mengambil data kecamatan: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }

        if (empty($response['data']) || !is_array($response['data'])) {
            $this->redirectWithDialog('Gagal', 'Kecamatan tidak ditemukan', 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }

        $kecamatan = $response['data'];

        $isEdit = true;

        include __DIR__ . '/../views/wilayah/form-kecamatan.php';
    }

    


    public function updateKecamatan()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexKecamatan');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');
        $id_kabupaten = $_POST['id_kabupaten'] ?? null;

        
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama kecamatan wajib diisi', 'index.php?controller=Wilayah&action=editKecamatan&id=' . $id, 'error');
        }

        if (empty($id_kabupaten)) {
            $this->redirectWithDialog('Gagal', 'Kabupaten wajib dipilih', 'index.php?controller=Wilayah&action=editKecamatan&id=' . $id, 'error');
        }

        
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kabupaten
        ];

        
        $response = $this->service->update($id, $data, 'kecamatan');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kecamatan berhasil diperbarui', 'index.php?controller=Wilayah&action=indexKecamatan', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal memperbarui kecamatan: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }
        exit();
    }

    


    public function deleteKecamatan()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexKecamatan');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit();
        }

        
        $response = $this->service->delete($id, 'kecamatan');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kecamatan berhasil dihapus', 'index.php?controller=Wilayah&action=indexKecamatan', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menghapus kecamatan: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }
        exit();
    }

    



    


    public function indexDesa()
    {
        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        
        $provinsi_id = trim((string)($_GET['provinsi_id'] ?? ''));
        $kabupatenList = [];
        if ($provinsi_id !== '') {
            $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
            if ($kabupatenResponse['success']) {
                $kabupatenList = $kabupatenResponse['data'] ?? [];
            }
        }

        
        $kabupaten_id = trim((string)($_GET['kabupaten_id'] ?? ''));
        $kecamatanList = [];
        if ($kabupaten_id !== '') {
            $kecamatanResponse = $this->service->getAllKecamatan($kabupaten_id);
            if ($kecamatanResponse['success']) {
                $kecamatanList = $kecamatanResponse['data'] ?? [];
            }
        }

        
        $kecamatan_id = trim((string)($_GET['kecamatan_id'] ?? ''));

        
        if ($kecamatan_id !== '') {
            $response = $this->service->getAllDesa($kecamatan_id);
        } else {
            
            $response = ['success' => true, 'data' => []];
        }

        if (!$response['success']) {
            $desaList = [];
        } else {
            $desaList = $response['data'] ?? [];
        }

        include __DIR__ . '/../views/wilayah/index-desa.php';
    }

    


    public function createDesa()
    {
        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        
        $provinsi_id = $_GET['provinsi_id'] ?? 0;
        $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
        if (!$kabupatenResponse['success']) {
            $kabupatenList = [];
        } else {
            $kabupatenList = $kabupatenResponse['data'] ?? [];
        }

        
        $kabupaten_id = $_GET['kabupaten_id'] ?? 0;
        $kecamatanResponse = $this->service->getAllKecamatan($kabupaten_id);
        if (!$kecamatanResponse['success']) {
            $kecamatanList = [];
        } else {
            $kecamatanList = $kecamatanResponse['data'] ?? [];
        }

        $isEdit = false;
        $desa = null;

        include __DIR__ . '/../views/wilayah/form-desa.php';
    }

    


    public function storeDesa()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');
        $id_kecamatan = $_POST['id_kecamatan'] ?? null;

        
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama desa wajib diisi', 'index.php?controller=Wilayah&action=createDesa', 'error');
        }

        if (empty($id_kecamatan)) {
            $this->redirectWithDialog('Gagal', 'Kecamatan wajib dipilih', 'index.php?controller=Wilayah&action=createDesa', 'error');
        }

        
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kecamatan
        ];

        
        $response = $this->service->store($data, 'desa');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Desa berhasil ditambahkan', 'index.php?controller=Wilayah&action=indexDesa', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menambahkan desa: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }
        exit();
    }

    


    public function editDesa()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexDesa');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            $this->redirectWithDialog('Gagal', 'ID tidak ditemukan', 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }

        
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        
        $provinsi_id = $_GET['provinsi_id'] ?? 0;
        $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
        if (!$kabupatenResponse['success']) {
            $kabupatenList = [];
        } else {
            $kabupatenList = $kabupatenResponse['data'] ?? [];
        }

        
        $kabupaten_id = $_GET['kabupaten_id'] ?? 0;
        $kecamatanResponse = $this->service->getAllKecamatan($kabupaten_id);
        if (!$kecamatanResponse['success']) {
            $kecamatanList = [];
        } else {
            $kecamatanList = $kecamatanResponse['data'] ?? [];
        }

        $response = $this->service->getById($id, 'desa');

        if (!$response['success']) {
            $this->redirectWithDialog('Gagal', 'Gagal mengambil data desa: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }

        if (empty($response['data']) || !is_array($response['data'])) {
            $this->redirectWithDialog('Gagal', 'Desa tidak ditemukan', 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }

        $desa = $response['data'];

        $isEdit = true;

        include __DIR__ . '/../views/wilayah/form-desa.php';
    }

    


    public function updateDesa()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexDesa');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit();
        }

        
        $nama = trim($_POST['nama'] ?? '');
        $id_kecamatan = $_POST['id_kecamatan'] ?? null;

        
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama desa wajib diisi', 'index.php?controller=Wilayah&action=editDesa&id=' . $id, 'error');
        }

        if (empty($id_kecamatan)) {
            $this->redirectWithDialog('Gagal', 'Kecamatan wajib dipilih', 'index.php?controller=Wilayah&action=editDesa&id=' . $id, 'error');
        }

        
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kecamatan
        ];

        
        $response = $this->service->update($id, $data, 'desa');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Desa berhasil diperbarui', 'index.php?controller=Wilayah&action=indexDesa', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal memperbarui desa: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }
        exit();
    }

    


    public function deleteDesa()
    {
        $this->blockEditDelete('index.php?controller=Wilayah&action=indexDesa');

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit();
        }

        
        $response = $this->service->delete($id, 'desa');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Desa berhasil dihapus', 'index.php?controller=Wilayah&action=indexDesa', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menghapus desa: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }
        exit();
    }

    


    public function getKabupatenByProvinsi()
    {
        $provinsiId = $_GET['id'] ?? 0;

        if (!$provinsiId) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Provinsi ID tidak valid', 'data' => null]);
            exit;
        }

        $response = $this->service->getAllKabupaten($provinsiId);

        header('Content-Type: application/json');
        if ($response['success']) {
            echo json_encode(['success' => true, 'data' => $response['data']]);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Gagal mengambil data kabupaten', 'data' => null]);
        }
        exit;
    }

    


    public function getKecamatanByKabupaten()
    {
        $kabupatenId = $_GET['id'] ?? 0;

        if (!$kabupatenId) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Kabupaten ID tidak valid', 'data' => null]);
            exit;
        }

        $response = $this->service->getAllKecamatan($kabupatenId);

        header('Content-Type: application/json');
        if ($response['success']) {
            echo json_encode(['success' => true, 'data' => $response['data']]);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Gagal mengambil data kecamatan', 'data' => null]);
        }
        exit;
    }

    


    public function getAllProvinsi()
    {
        $response = $this->service->getAllProvinsi();

        header('Content-Type: application/json');
        if ($response['success']) {
            echo json_encode(['success' => true, 'data' => $response['data']]);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Gagal mengambil data provinsi', 'data' => null]);
        }
        exit;
    }

    


    public function getDesaByKecamatan()
    {
        $kecamatanId = $_GET['id'] ?? 0;

        if (!$kecamatanId) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Kecamatan ID tidak valid', 'data' => null]);
            exit;
        }

        $response = $this->service->getAllDesa($kecamatanId);

        header('Content-Type: application/json');
        if ($response['success']) {
            echo json_encode(['success' => true, 'data' => $response['data']]);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Gagal mengambil data desa', 'data' => null]);
        }
        exit;
    }

    


    public function search()
    {
        $query = $_GET['q'] ?? '';

        if (empty($query)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Query pencarian kosong', 'data' => []]);
            exit;
        }

        $response = $this->service->searchWilayah($query);

        header('Content-Type: application/json');
        if ($response['success']) {
            $raw = $response['data'];
            $flat = [];
            
            
            foreach (['desa', 'kecamatan', 'kabupaten', 'provinsi'] as $level) {
                if (!empty($raw[$level]) && is_array($raw[$level])) {
                    foreach ($raw[$level] as $item) {
                        $item['level'] = $level;
                        $flat[] = $item;
                    }
                }
            }
            
            echo json_encode(['success' => true, 'data' => $flat]);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Gagal mencari wilayah', 'data' => []]);
        }
        exit;
    }

    


    public function getWilayahDetailByDesa()
    {
        $desaId = $_GET['desa_id'] ?? 0;

        if (!$desaId) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Desa ID tidak valid', 'data' => null]);
            exit;
        }

        require_once dirname(__DIR__) . '/services/WilayahService.php';
        $wilayahService = new \WilayahService();

        $response = $wilayahService->getById($desaId, 'desa');

        header('Content-Type: application/json');
        if ($response['success']) {
            echo json_encode(['success' => true, 'data' => $response['data']]);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Gagal mengambil detail wilayah', 'data' => null]);
        }
        exit;
    }
}
