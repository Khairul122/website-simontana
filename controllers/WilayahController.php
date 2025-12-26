<?php

require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/WilayahService.php';

class WilayahController
{
    private $service;

    public function __construct()
    {
        // Cek otentikasi pengguna
        if (!isset($_SESSION['user'])) {
            header('Location: ../login.php');
            exit();
        }
        
        $this->service = new WilayahService();
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
            echo '<script>alert("Nama provinsi wajib diisi"); window.location.href="index.php?controller=Wilayah&action=createProvinsi";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama
        ];

        // Panggil service
        $response = $this->service->store($data, 'provinsi');

        if ($response['success']) {
            echo '<script>alert("Provinsi berhasil ditambahkan"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
        } else {
            echo '<script>alert("Gagal menambahkan provinsi: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
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
            echo '<script>alert("ID tidak ditemukan"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
            exit;
        }

        $response = $this->service->getById($id, 'provinsi');

        if (!$response['success']) {
            echo '<script>alert("Gagal mengambil data provinsi: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
            exit();
        }

        // Cek struktur data yang dikembalikan API
        if (isset($response['data']['data'])) {
            $provinsi = $response['data']['data'];
        } elseif (isset($response['data']) && !empty($response['data'])) {
            $provinsi = $response['data'];
        } else {
            echo '<script>alert("Provinsi tidak ditemukan"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
            exit();
        }

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
            echo '<script>alert("Nama provinsi wajib diisi"); window.location.href="index.php?controller=Wilayah&action=editProvinsi&id=' . $id . '";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama
        ];

        // Panggil service
        $response = $this->service->update($id, $data, 'provinsi');

        if ($response['success']) {
            echo '<script>alert("Provinsi berhasil diperbarui"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
        } else {
            echo '<script>alert("Gagal memperbarui provinsi: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
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
            echo '<script>alert("Provinsi berhasil dihapus"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
        } else {
            echo '<script>alert("Gagal menghapus provinsi: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexProvinsi";</script>';
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
            echo '<script>alert("Nama kabupaten wajib diisi"); window.location.href="index.php?controller=Wilayah&action=createKabupaten";</script>';
            exit();
        }

        if (empty($id_provinsi)) {
            echo '<script>alert("Provinsi wajib dipilih"); window.location.href="index.php?controller=Wilayah&action=createKabupaten";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_provinsi
        ];

        // Panggil service
        $response = $this->service->store($data, 'kabupaten');

        if ($response['success']) {
            echo '<script>alert("Kabupaten berhasil ditambahkan"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
        } else {
            echo '<script>alert("Gagal menambahkan kabupaten: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
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
            echo '<script>alert("ID tidak ditemukan"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
            exit;
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
            echo '<script>alert("Gagal mengambil data kabupaten: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
            exit();
        }

        // Cek struktur data yang dikembalikan API
        if (isset($response['data']['data'])) {
            $kabupaten = $response['data']['data'];
        } elseif (isset($response['data']) && !empty($response['data'])) {
            $kabupaten = $response['data'];
        } else {
            echo '<script>alert("Kabupaten tidak ditemukan"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
            exit();
        }

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
            echo '<script>alert("Nama kabupaten wajib diisi"); window.location.href="index.php?controller=Wilayah&action=editKabupaten&id=' . $id . '";</script>';
            exit();
        }

        if (empty($id_provinsi)) {
            echo '<script>alert("Provinsi wajib dipilih"); window.location.href="index.php?controller=Wilayah&action=editKabupaten&id=' . $id . '";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_provinsi
        ];

        // Panggil service
        $response = $this->service->update($id, $data, 'kabupaten');

        if ($response['success']) {
            echo '<script>alert("Kabupaten berhasil diperbarui"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
        } else {
            echo '<script>alert("Gagal memperbarui kabupaten: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
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
            echo '<script>alert("Kabupaten berhasil dihapus"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
        } else {
            echo '<script>alert("Gagal menghapus kabupaten: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexKabupaten";</script>';
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
            echo '<script>alert("Nama kecamatan wajib diisi"); window.location.href="index.php?controller=Wilayah&action=createKecamatan";</script>';
            exit();
        }

        if (empty($id_kabupaten)) {
            echo '<script>alert("Kabupaten wajib dipilih"); window.location.href="index.php?controller=Wilayah&action=createKecamatan";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kabupaten
        ];

        // Panggil service
        $response = $this->service->store($data, 'kecamatan');

        if ($response['success']) {
            echo '<script>alert("Kecamatan berhasil ditambahkan"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
        } else {
            echo '<script>alert("Gagal menambahkan kecamatan: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
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
            echo '<script>alert("ID tidak ditemukan"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
            exit;
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
            echo '<script>alert("Gagal mengambil data kecamatan: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
            exit();
        }

        // Cek struktur data yang dikembalikan API
        if (isset($response['data']['data'])) {
            $kecamatan = $response['data']['data'];
        } elseif (isset($response['data']) && !empty($response['data'])) {
            $kecamatan = $response['data'];
        } else {
            echo '<script>alert("Kecamatan tidak ditemukan"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
            exit();
        }

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
            echo '<script>alert("Nama kecamatan wajib diisi"); window.location.href="index.php?controller=Wilayah&action=editKecamatan&id=' . $id . '";</script>';
            exit();
        }

        if (empty($id_kabupaten)) {
            echo '<script>alert("Kabupaten wajib dipilih"); window.location.href="index.php?controller=Wilayah&action=editKecamatan&id=' . $id . '";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kabupaten
        ];

        // Panggil service
        $response = $this->service->update($id, $data, 'kecamatan');

        if ($response['success']) {
            echo '<script>alert("Kecamatan berhasil diperbarui"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
        } else {
            echo '<script>alert("Gagal memperbarui kecamatan: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
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
            echo '<script>alert("Kecamatan berhasil dihapus"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
        } else {
            echo '<script>alert("Gagal menghapus kecamatan: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexKecamatan";</script>';
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
            echo '<script>alert("Nama desa wajib diisi"); window.location.href="index.php?controller=Wilayah&action=createDesa";</script>';
            exit();
        }

        if (empty($id_kecamatan)) {
            echo '<script>alert("Kecamatan wajib dipilih"); window.location.href="index.php?controller=Wilayah&action=createDesa";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kecamatan
        ];

        // Panggil service
        $response = $this->service->store($data, 'desa');

        if ($response['success']) {
            echo '<script>alert("Desa berhasil ditambahkan"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
        } else {
            echo '<script>alert("Gagal menambahkan desa: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
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
            echo '<script>alert("ID tidak ditemukan"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
            exit;
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
            echo '<script>alert("Gagal mengambil data desa: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
            exit();
        }

        // Cek struktur data yang dikembalikan API
        if (isset($response['data']['data'])) {
            $desa = $response['data']['data'];
        } elseif (isset($response['data']) && !empty($response['data'])) {
            $desa = $response['data'];
        } else {
            echo '<script>alert("Desa tidak ditemukan"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
            exit();
        }

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
            echo '<script>alert("Nama desa wajib diisi"); window.location.href="index.php?controller=Wilayah&action=editDesa&id=' . $id . '";</script>';
            exit();
        }

        if (empty($id_kecamatan)) {
            echo '<script>alert("Kecamatan wajib dipilih"); window.location.href="index.php?controller=Wilayah&action=editDesa&id=' . $id . '";</script>';
            exit();
        }

        // Data untuk dikirim ke API
        $data = [
            'nama' => $nama,
            'id_parent' => $id_kecamatan
        ];

        // Panggil service
        $response = $this->service->update($id, $data, 'desa');

        if ($response['success']) {
            echo '<script>alert("Desa berhasil diperbarui"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
        } else {
            echo '<script>alert("Gagal memperbarui desa: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
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
            echo '<script>alert("Desa berhasil dihapus"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
        } else {
            echo '<script>alert("Gagal menghapus desa: ' . addslashes($response['message'] ?? 'Terjadi kesalahan') . '"); window.location.href="index.php?controller=Wilayah&action=indexDesa";</script>';
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