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

    public function __construct()
    {
        // Cek otentikasi pengguna
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit();
        }
        
        $this->service = new WilayahService();
    }

    /**
     * Halaman ringkasan manajemen wilayah
     */
    public function index()
    {
        include __DIR__ . '/../views/wilayah/index.php';
    }

    /**
     * Provinsi Methods
     */

    /**
     * Tampilkan halaman index provinsi
     */
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

    /**
     * Tampilkan form create provinsi
     */
    public function createProvinsi()
    {
        $isEdit = false;
        $provinsi = null;

        include __DIR__ . '/../views/wilayah/form-provinsi.php';
    }

    /**
     * Simpan data provinsi baru
     */
    public function storeProvinsi()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');

        // Validasi
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama provinsi wajib diisi', 'index.php?controller=Wilayah&action=createProvinsi', 'error');
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama
        ];

        // Panggil service
        $response = $this->service->store($data, 'provinsi');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Provinsi berhasil ditambahkan', 'index.php?controller=Wilayah&action=indexProvinsi', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menambahkan provinsi: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }
        exit();
    }

    /**
     * Tampilkan form edit provinsi
     */
    public function editProvinsi()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
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

    /**
     * Update data provinsi
     */
    public function updateProvinsi()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');

        // Validasi
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama provinsi wajib diisi', 'index.php?controller=Wilayah&action=editProvinsi&id=' . $id, 'error');
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama
        ];

        // Panggil service
        $response = $this->service->update($id, $data, 'provinsi');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Provinsi berhasil diperbarui', 'index.php?controller=Wilayah&action=indexProvinsi', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal memperbarui provinsi: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }
        exit();
    }

    /**
     * Hapus data provinsi
     */
    public function deleteProvinsi()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexProvinsi');
            exit();
        }

        // Panggil service
        $response = $this->service->delete($id, 'provinsi');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Provinsi berhasil dihapus', 'index.php?controller=Wilayah&action=indexProvinsi', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menghapus provinsi: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexProvinsi', 'error');
        }
        exit();
    }

    /**
     * Kabupaten Methods
     */

    /**
     * Tampilkan halaman index kabupaten
     */
    public function indexKabupaten()
    {
        // Ambil semua provinsi untuk dropdown
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        // Ambil kabupaten berdasarkan provinsi_id yang dipilih
        $provinsi_id = $_GET['provinsi_id'] ?? 0;

        // Jika provinsi_id tidak dipilih, set kabupatenList menjadi array kosong
        if ($provinsi_id > 0) {
            $response = $this->service->getAllKabupaten($provinsi_id);
        } else {
            // Jika tidak ada provinsi yang dipilih, set kabupatenList menjadi array kosong
            $response = ['success' => true, 'data' => []];
        }

        if (!$response['success']) {
            $kabupatenList = [];
        } else {
            $kabupatenList = $response['data'] ?? [];
        }

        include __DIR__ . '/../views/wilayah/index-kabupaten.php';
    }

    /**
     * Tampilkan form create kabupaten
     */
    public function createKabupaten()
    {
        // Ambil semua provinsi untuk dropdown
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

    /**
     * Simpan data kabupaten baru
     */
    public function storeKabupaten()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');
        $id_provinsi = $_POST['id_provinsi'] ?? null;

        // Validasi
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama kabupaten wajib diisi', 'index.php?controller=Wilayah&action=createKabupaten', 'error');
        }

        if (empty($id_provinsi)) {
            $this->redirectWithDialog('Gagal', 'Provinsi wajib dipilih', 'index.php?controller=Wilayah&action=createKabupaten', 'error');
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_provinsi
        ];

        // Panggil service
        $response = $this->service->store($data, 'kabupaten');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kabupaten berhasil ditambahkan', 'index.php?controller=Wilayah&action=indexKabupaten', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menambahkan kabupaten: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }
        exit();
    }

    /**
     * Tampilkan form edit kabupaten
     */
    public function editKabupaten()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            $this->redirectWithDialog('Gagal', 'ID tidak ditemukan', 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }

        // Ambil semua provinsi untuk dropdown
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

    /**
     * Update data kabupaten
     */
    public function updateKabupaten()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');
        $id_provinsi = $_POST['id_provinsi'] ?? null;

        // Validasi
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama kabupaten wajib diisi', 'index.php?controller=Wilayah&action=editKabupaten&id=' . $id, 'error');
        }

        if (empty($id_provinsi)) {
            $this->redirectWithDialog('Gagal', 'Provinsi wajib dipilih', 'index.php?controller=Wilayah&action=editKabupaten&id=' . $id, 'error');
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_provinsi
        ];

        // Panggil service
        $response = $this->service->update($id, $data, 'kabupaten');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kabupaten berhasil diperbarui', 'index.php?controller=Wilayah&action=indexKabupaten', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal memperbarui kabupaten: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }
        exit();
    }

    /**
     * Hapus data kabupaten
     */
    public function deleteKabupaten()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKabupaten');
            exit();
        }

        // Panggil service
        $response = $this->service->delete($id, 'kabupaten');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kabupaten berhasil dihapus', 'index.php?controller=Wilayah&action=indexKabupaten', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menghapus kabupaten: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKabupaten', 'error');
        }
        exit();
    }

    /**
     * Kecamatan Methods
     */

    /**
     * Tampilkan halaman index kecamatan
     */
    public function indexKecamatan()
    {
        // Ambil semua provinsi untuk dropdown
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        // Ambil semua kabupaten untuk dropdown (diperlukan ID provinsi untuk mengambil kabupaten)
        $provinsi_id = $_GET['provinsi_id'] ?? 0;
        $kabupatenList = [];
        if ($provinsi_id > 0) {
            $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
            if ($kabupatenResponse['success']) {
                $kabupatenList = $kabupatenResponse['data'] ?? [];
            }
        }

        // Ambil semua kecamatan untuk dropdown (diperlukan ID kabupaten untuk mengambil kecamatan)
        $kabupaten_id = $_GET['kabupaten_id'] ?? 0;
        $kecamatanList = [];
        if ($kabupaten_id > 0) {
            $kecamatanResponse = $this->service->getAllKecamatan($kabupaten_id);
            if ($kecamatanResponse['success']) {
                $kecamatanList = $kecamatanResponse['data'] ?? [];
            }
        }

        // Ambil kecamatan berdasarkan kabupaten_id yang dipilih
        $response = $this->service->getAllKecamatan($_GET['kabupaten_id'] ?? 0);

        if (!$response['success']) {
            $kecamatanList = [];
        } else {
            $kecamatanList = $response['data'] ?? [];
        }

        include __DIR__ . '/../views/wilayah/index-kecamatan.php';
    }

    /**
     * Tampilkan form create kecamatan
     */
    public function createKecamatan()
    {
        // Ambil semua provinsi untuk dropdown
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        // Ambil semua kabupaten untuk dropdown (diperlukan ID provinsi)
        $provinsi_id = $_GET['provinsi_id'] ?? 0;
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

    /**
     * Simpan data kecamatan baru
     */
    public function storeKecamatan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');
        $id_kabupaten = $_POST['id_kabupaten'] ?? null;

        // Validasi
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama kecamatan wajib diisi', 'index.php?controller=Wilayah&action=createKecamatan', 'error');
        }

        if (empty($id_kabupaten)) {
            $this->redirectWithDialog('Gagal', 'Kabupaten wajib dipilih', 'index.php?controller=Wilayah&action=createKecamatan', 'error');
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kabupaten
        ];

        // Panggil service
        $response = $this->service->store($data, 'kecamatan');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kecamatan berhasil ditambahkan', 'index.php?controller=Wilayah&action=indexKecamatan', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menambahkan kecamatan: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }
        exit();
    }

    /**
     * Tampilkan form edit kecamatan
     */
    public function editKecamatan()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            $this->redirectWithDialog('Gagal', 'ID tidak ditemukan', 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }

        // Ambil semua provinsi untuk dropdown
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        // Ambil semua kabupaten untuk dropdown
        // Jika kabupaten_id disediakan di URL, kita perlu menentukan provinsi_id dari kabupaten tersebut
        $kabupaten_id = $_GET['kabupaten_id'] ?? 0;
        $provinsi_id = $_GET['provinsi_id'] ?? 0;

        // Jika tidak ada provinsi_id di URL tapi ada kabupaten_id, kita ambil kabupaten untuk mendapatkan provinsi_id
        if ($provinsi_id == 0 && $kabupaten_id > 0) {
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

        // Ambil kabupaten untuk dropdown berdasarkan provinsi_id
        if ($provinsi_id > 0) {
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

    /**
     * Update data kecamatan
     */
    public function updateKecamatan()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');
        $id_kabupaten = $_POST['id_kabupaten'] ?? null;

        // Validasi
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama kecamatan wajib diisi', 'index.php?controller=Wilayah&action=editKecamatan&id=' . $id, 'error');
        }

        if (empty($id_kabupaten)) {
            $this->redirectWithDialog('Gagal', 'Kabupaten wajib dipilih', 'index.php?controller=Wilayah&action=editKecamatan&id=' . $id, 'error');
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kabupaten
        ];

        // Panggil service
        $response = $this->service->update($id, $data, 'kecamatan');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kecamatan berhasil diperbarui', 'index.php?controller=Wilayah&action=indexKecamatan', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal memperbarui kecamatan: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }
        exit();
    }

    /**
     * Hapus data kecamatan
     */
    public function deleteKecamatan()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexKecamatan');
            exit();
        }

        // Panggil service
        $response = $this->service->delete($id, 'kecamatan');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Kecamatan berhasil dihapus', 'index.php?controller=Wilayah&action=indexKecamatan', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menghapus kecamatan: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexKecamatan', 'error');
        }
        exit();
    }

    /**
     * Desa Methods
     */

    /**
     * Tampilkan halaman index desa
     */
    public function indexDesa()
    {
        // Ambil semua provinsi untuk dropdown
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        // Ambil semua kabupaten untuk dropdown (diperlukan ID provinsi untuk mengambil kabupaten)
        $provinsi_id = $_GET['provinsi_id'] ?? 0;
        $kabupatenList = [];
        if ($provinsi_id > 0) {
            $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
            if ($kabupatenResponse['success']) {
                $kabupatenList = $kabupatenResponse['data'] ?? [];
            }
        }

        // Ambil semua kecamatan untuk dropdown (diperlukan ID kabupaten untuk mengambil kecamatan)
        $kabupaten_id = $_GET['kabupaten_id'] ?? 0;
        $kecamatanList = [];
        if ($kabupaten_id > 0) {
            $kecamatanResponse = $this->service->getAllKecamatan($kabupaten_id);
            if ($kecamatanResponse['success']) {
                $kecamatanList = $kecamatanResponse['data'] ?? [];
            }
        }

        // Ambil desa berdasarkan kecamatan_id yang dipilih
        $kecamatan_id = $_GET['kecamatan_id'] ?? 0;

        // Jika kecamatan_id tidak dipilih, set desaList menjadi array kosong
        if ($kecamatan_id > 0) {
            $response = $this->service->getAllDesa($kecamatan_id);
        } else {
            // Jika tidak ada kecamatan yang dipilih, set desaList menjadi array kosong
            $response = ['success' => true, 'data' => []];
        }

        if (!$response['success']) {
            $desaList = [];
        } else {
            $desaList = $response['data'] ?? [];
        }

        include __DIR__ . '/../views/wilayah/index-desa.php';
    }

    /**
     * Tampilkan form create desa
     */
    public function createDesa()
    {
        // Ambil semua provinsi untuk dropdown
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        // Ambil semua kabupaten untuk dropdown (diperlukan ID provinsi)
        $provinsi_id = $_GET['provinsi_id'] ?? 0;
        $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
        if (!$kabupatenResponse['success']) {
            $kabupatenList = [];
        } else {
            $kabupatenList = $kabupatenResponse['data'] ?? [];
        }

        // Ambil semua kecamatan untuk dropdown (diperlukan ID kabupaten)
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

    /**
     * Simpan data desa baru
     */
    public function storeDesa()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');
        $id_kecamatan = $_POST['id_kecamatan'] ?? null;

        // Validasi
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama desa wajib diisi', 'index.php?controller=Wilayah&action=createDesa', 'error');
        }

        if (empty($id_kecamatan)) {
            $this->redirectWithDialog('Gagal', 'Kecamatan wajib dipilih', 'index.php?controller=Wilayah&action=createDesa', 'error');
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kecamatan
        ];

        // Panggil service
        $response = $this->service->store($data, 'desa');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Desa berhasil ditambahkan', 'index.php?controller=Wilayah&action=indexDesa', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menambahkan desa: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }
        exit();
    }

    /**
     * Tampilkan form edit desa
     */
    public function editDesa()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            $this->redirectWithDialog('Gagal', 'ID tidak ditemukan', 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }

        // Ambil semua provinsi untuk dropdown
        $provinsiResponse = $this->service->getAllProvinsi();
        if (!$provinsiResponse['success']) {
            $provinsiList = [];
        } else {
            $provinsiList = $provinsiResponse['data'] ?? [];
        }

        // Ambil semua kabupaten untuk dropdown (diperlukan ID provinsi)
        $provinsi_id = $_GET['provinsi_id'] ?? 0;
        $kabupatenResponse = $this->service->getAllKabupaten($provinsi_id);
        if (!$kabupatenResponse['success']) {
            $kabupatenList = [];
        } else {
            $kabupatenList = $kabupatenResponse['data'] ?? [];
        }

        // Ambil semua kecamatan untuk dropdown (diperlukan ID kabupaten)
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

    /**
     * Update data desa
     */
    public function updateDesa()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit();
        }

        // Ambil data dari form
        $nama = trim($_POST['nama'] ?? '');
        $id_kecamatan = $_POST['id_kecamatan'] ?? null;

        // Validasi
        if (empty($nama)) {
            $this->redirectWithDialog('Gagal', 'Nama desa wajib diisi', 'index.php?controller=Wilayah&action=editDesa&id=' . $id, 'error');
        }

        if (empty($id_kecamatan)) {
            $this->redirectWithDialog('Gagal', 'Kecamatan wajib dipilih', 'index.php?controller=Wilayah&action=editDesa&id=' . $id, 'error');
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kecamatan
        ];

        // Panggil service
        $response = $this->service->update($id, $data, 'desa');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Desa berhasil diperbarui', 'index.php?controller=Wilayah&action=indexDesa', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal memperbarui desa: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }
        exit();
    }

    /**
     * Hapus data desa
     */
    public function deleteDesa()
    {
        // Ambil ID dari query string
        $id = $_GET['id'] ?? null;

        // Validasi ID
        if (!$id) {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Wilayah&action=indexDesa');
            exit();
        }

        // Panggil service
        $response = $this->service->delete($id, 'desa');

        if ($response['success']) {
            $this->redirectWithDialog('Berhasil', 'Desa berhasil dihapus', 'index.php?controller=Wilayah&action=indexDesa', 'success');
        } else {
            $this->redirectWithDialog('Gagal', 'Gagal menghapus desa: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'index.php?controller=Wilayah&action=indexDesa', 'error');
        }
        exit();
    }

    /**
     * AJAX endpoint untuk mendapatkan kabupaten berdasarkan provinsi
     */
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

    /**
     * AJAX endpoint untuk mendapatkan kecamatan berdasarkan kabupaten
     */
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

    /**
     * AJAX endpoint untuk mendapatkan semua provinsi
     */
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

    /**
     * AJAX endpoint untuk mendapatkan desa berdasarkan kecamatan
     */
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

    /**
     * AJAX endpoint untuk mendapatkan detail wilayah lengkap berdasarkan ID desa
     */
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
