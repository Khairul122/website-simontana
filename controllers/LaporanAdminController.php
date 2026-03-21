<?php

require_once dirname(__DIR__) . '/config/koneksi.php';
require_once dirname(__DIR__) . '/services/LaporanAdminService.php';

class LaporanAdminController
{
    private $service;

    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit();
        }

        $this->service = new LaporanAdminService();
    }

    private function requireAdmin(): void
    {
        if (($_SESSION['user']['role'] ?? '') !== 'Admin') {
            setDialog('Akses Ditolak', 'Fitur ini hanya untuk Admin.', 'error');
            header('Location: index.php?controller=Dashboard&action=warga');
            exit;
        }
    }

    


    public function index()
    {
        
        $filters = [
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? '',
            'limit' => $_GET['limit'] ?? 15,
            'page' => $_GET['page'] ?? 1
        ];

        
        $filters = array_filter($filters, function($value) {
            return $value !== '';
        });

        $response = $this->service->getAll($filters);

        if (!$response['success']) {
            setDialog('Gagal', 'Gagal mengambil data laporan bencana: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'error');
            $laporanList = [];
            $pagination = null;
        } else {
            $laporanList = is_array($response['data']) ? $response['data'] : [];
            $pagination = $response['meta']['pagination'] ?? null;
        }

        include __DIR__ . '/../views/laporan-admin/index.php';
    }

    


    public function detail()
    {
        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            setDialog('Error', 'ID laporan tidak ditemukan', 'error');
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit;
        }

        $response = $this->service->getById($id);

        if (!$response['success']) {
            setDialog('Gagal', 'Gagal mengambil detail laporan bencana: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'error');
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit();
        }

        if (empty($response['data']) || !is_array($response['data'])) {
            setDialog('Gagal', 'Laporan bencana tidak ditemukan', 'error');
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit();
        }

        $laporan = $response['data'];

        include __DIR__ . '/../views/laporan-admin/detail.php';
    }

    


    public function edit()
    {
        $this->requireAdmin();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            setDialog('Error', 'ID laporan tidak ditemukan', 'error');
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit;
        }

        $response = $this->service->getById($id);

        if (!$response['success']) {
            setDialog('Gagal', 'Gagal mengambil data laporan bencana: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'error');
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit();
        }

        if (empty($response['data']) || !is_array($response['data'])) {
            setDialog('Gagal', 'Laporan bencana tidak ditemukan', 'error');
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit();
        }

        $laporan = $response['data'];

        $provinsiList = [];
        $kabupatenList = [];
        $kecamatanList = [];
        $desaList = [];

        $selectedProvinsiId = (int)($_GET['provinsi_id'] ?? ($laporan['desa']['kecamatan']['kabupaten']['provinsi']['id'] ?? ($laporan['desa']['id_provinsi'] ?? 0)));
        $selectedKabupatenId = (int)($_GET['kabupaten_id'] ?? ($laporan['desa']['kecamatan']['kabupaten']['id'] ?? ($laporan['desa']['id_kabupaten'] ?? 0)));
        $selectedKecamatanId = (int)($_GET['kecamatan_id'] ?? ($laporan['desa']['kecamatan']['id'] ?? ($laporan['id_kecamatan'] ?? 0)));
        $selectedDesaId = (int)($_GET['desa_id'] ?? ($laporan['id_desa'] ?? ($laporan['desa']['id'] ?? 0)));

        $provinsiResponse = apiRequest(API_WILAYAH_PROVINSI, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
        if ($provinsiResponse['success']) {
            $provinsiList = apiDataList($provinsiResponse['data']);
        } else {
            $error_message = $provinsiResponse['message'] ?? 'Gagal memuat data provinsi.';
        }

        if ($selectedProvinsiId > 0) {
            $kabupatenResponse = apiRequest(
                str_replace('{provinsi_id}', (string)$selectedProvinsiId, API_WILAYAH_KABUPATEN),
                'GET',
                null,
                getAuthHeaders($_SESSION['token'] ?? null)
            );
            if ($kabupatenResponse['success']) {
                $kabupatenList = apiDataList($kabupatenResponse['data']);
            }
        }

        if ($selectedKabupatenId > 0) {
            $kecamatanResponse = apiRequest(
                str_replace('{kabupaten_id}', (string)$selectedKabupatenId, API_WILAYAH_KECAMATAN),
                'GET',
                null,
                getAuthHeaders($_SESSION['token'] ?? null)
            );
            if ($kecamatanResponse['success']) {
                $kecamatanList = apiDataList($kecamatanResponse['data']);
            }
        }

        if ($selectedKecamatanId > 0) {
            $desaResponse = apiRequest(
                str_replace('{kecamatan_id}', (string)$selectedKecamatanId, API_WILAYAH_DESA),
                'GET',
                null,
                getAuthHeaders($_SESSION['token'] ?? null)
            );
            if ($desaResponse['success']) {
                $desaList = apiDataList($desaResponse['data']);
            }
        }

        include __DIR__ . '/../views/laporan-admin/update.php';
    }

    


    public function update()
    {
        $this->requireAdmin();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit();
        }

        
        $judul = trim($_POST['judul_laporan'] ?? $_POST['judul'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $tingkat_kedaruratan = trim($_POST['tingkat_keparahan'] ?? $_POST['tingkat_kedaruratan'] ?? '');
        $alamat = trim($_POST['alamat_lengkap'] ?? $_POST['alamat'] ?? '');

        
        if (empty($judul) || empty($deskripsi) || empty($tingkat_kedaruratan)) {
            setDialog('Gagal', 'Judul, deskripsi, dan tingkat kedaruratan wajib diisi', 'error');
            header('Location: index.php?controller=LaporanAdmin&action=edit&id=' . $id);
            exit();
        }

        
        $data = [
            'judul_laporan' => $judul,
            'deskripsi' => $deskripsi,
            'tingkat_keparahan' => $tingkat_kedaruratan,
            'alamat_lengkap' => $alamat,
            'id_desa' => trim($_POST['id_desa'] ?? '')
        ];

        
        $files = [];
        $fileFields = ['foto_bukti_1', 'foto_bukti_2', 'foto_bukti_3', 'video_bukti'];

        foreach ($fileFields as $field) {
            if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
                $files[$field] = $_FILES[$field];
            }
        }

        
        $response = $this->service->update($id, $data, $files);

        if ($response['success']) {
            setDialog('Berhasil', 'Laporan bencana berhasil diperbarui', 'success');
            header('Location: index.php?controller=LaporanAdmin&action=detail&id=' . $id);
        } else {
            setDialog('Gagal', 'Gagal memperbarui laporan bencana: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'error');
            header('Location: index.php?controller=LaporanAdmin&action=edit&id=' . $id);
        }
        exit();
    }

    


    public function delete()
    {
        $this->requireAdmin();

        
        $id = $_GET['id'] ?? null;

        
        if (!$id) {
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanAdmin&action=index');
            exit();
        }

        
        $response = $this->service->delete($id);

        if ($response['success']) {
            setDialog('Berhasil', 'Laporan bencana berhasil dihapus', 'success');
        } else {
            setDialog('Gagal', 'Gagal menghapus laporan bencana: ' . ($response['message'] ?? 'Terjadi kesalahan'), 'error');
        }
        header('Location: index.php?controller=LaporanAdmin&action=index');
        exit();
    }

    public function create()
    {
        $userRole = $_SESSION['user']['role'] ?? '';

        if (!in_array($userRole, ['Admin', 'Warga'], true)) {
            setDialog('Akses Ditolak', 'Anda tidak memiliki akses membuat laporan.', 'error');
            header('Location: index.php?controller=Dashboard&action=warga');
            exit;
        }

        $desaList = [];
        $desaResponse = apiRequest(API_DESA, 'GET', null, getAuthHeaders($_SESSION['token'] ?? null));
        if ($desaResponse['success']) {
            $desaList = is_array($desaResponse['data'] ?? null)
                ? apiDataList($desaResponse['data'])
                : [];
        } else {
            $error_message = $desaResponse['message'] ?? 'Gagal memuat daftar desa.';
        }

        include __DIR__ . '/../views/laporan-admin/create.php';
    }

    public function store()
    {
        $userRole = $_SESSION['user']['role'] ?? '';

        if (!in_array($userRole, ['Admin', 'Warga'], true)) {
            setDialog('Akses Ditolak', 'Anda tidak memiliki akses membuat laporan.', 'error');
            header('Location: index.php?controller=Dashboard&action=warga');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=LaporanAdmin&action=create');
            exit;
        }

        $judul = trim($_POST['judul_laporan'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $tingkat = trim($_POST['tingkat_keparahan'] ?? '');
        $idDesa = trim($_POST['id_desa'] ?? '');
        $alamat = trim($_POST['alamat_lengkap'] ?? '');

        if ($judul === '' || $deskripsi === '' || $tingkat === '' || $idDesa === '') {
            setDialog('Gagal', 'Judul, deskripsi, tingkat keparahan, dan kode desa wajib diisi.', 'error');
            header('Location: index.php?controller=LaporanAdmin&action=create');
            exit;
        }

        $data = [
            'judul_laporan' => $judul,
            'deskripsi' => $deskripsi,
            'tingkat_keparahan' => $tingkat,
            'id_desa' => (int)$idDesa,
            'alamat_lengkap' => $alamat,
            'latitude' => trim($_POST['latitude'] ?? ''),
            'longitude' => trim($_POST['longitude'] ?? ''),
            'jumlah_korban' => (int)($_POST['jumlah_korban'] ?? 0),
            'jumlah_rumah_rusak' => (int)($_POST['jumlah_rumah_rusak'] ?? 0)
        ];

        $files = [];
        foreach (['foto_bukti_1', 'foto_bukti_2', 'foto_bukti_3', 'video_bukti'] as $field) {
            if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
                $files[$field] = $_FILES[$field];
            }
        }

        $response = createLaporan($data, $files);

        if ($response['success']) {
            setDialog('Berhasil', 'Laporan bencana berhasil dibuat.', 'success');
            header('Location: index.php?controller=LaporanAdmin&action=index');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal membuat laporan bencana.', 'error');
            header('Location: index.php?controller=LaporanAdmin&action=create');
        }
        exit;
    }
}
