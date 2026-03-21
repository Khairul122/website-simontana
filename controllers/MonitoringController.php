<?php
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../services/MonitoringService.php';

class MonitoringController
{
    private $authService;
    private $service;

    public function __construct()
    {
        $this->authService = new AuthService();
        $currentUser = $this->authService->getCurrentUser();

        if (!$currentUser['success']) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        $role = $currentUser['data']['role'] ?? '';
        if (!in_array($role, ['Admin', 'PetugasBPBD', 'OperatorDesa'], true)) {
            setDialog('Akses Ditolak', 'Anda tidak memiliki akses ke modul monitoring.', 'error');
            header('Location: index.php?controller=Dashboard&action=warga');
            exit;
        }

        $this->service = new MonitoringService();
    }

    public function index()
    {
        $filters = [];
        if (!empty($_GET['id_laporan'])) {
            $filters['id_laporan'] = (int)$_GET['id_laporan'];
        }
        if (!empty($_GET['id_operator'])) {
            $filters['id_operator'] = (int)$_GET['id_operator'];
        }

        $response = $this->service->getAll($filters);
        if ($response['success']) {
            $monitoringList = is_array($response['data']) ? $response['data'] : [];
        } else {
            $monitoringList = [];
            $error_message = $response['message'] ?? 'Gagal mengambil data monitoring';
        }

        include __DIR__ . '/../views/monitoring/index.php';
    }

    public function detail()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            setDialog('Gagal', 'ID monitoring tidak valid.', 'error');
            header('Location: index.php?controller=Monitoring&action=index');
            exit;
        }

        $response = $this->service->getById($id);
        if ($response['success']) {
            $monitoring = is_array($response['data']) ? $response['data'] : null;
        } else {
            $monitoring = null;
            $error_message = $response['message'] ?? 'Gagal mengambil detail monitoring';
        }

        include __DIR__ . '/../views/monitoring/detail.php';
    }

    public function create()
    {
        $monitoring = null;
        $laporanResponse = $this->service->getAllLaporan();
        $operatorResponse = $this->service->getAllOperator();

        $laporanList = is_array($laporanResponse['data'] ?? null) ? $laporanResponse['data'] : [];
        $operatorList = is_array($operatorResponse['data'] ?? null) ? $operatorResponse['data'] : [];

        if (!$laporanResponse['success'] || !$operatorResponse['success']) {
            $error_message = (!$laporanResponse['success'] ? ($laporanResponse['message'] ?? '') : '')
                ?: (!$operatorResponse['success'] ? ($operatorResponse['message'] ?? '') : '')
                ?: 'Gagal memuat data referensi monitoring.';
        }

        include __DIR__ . '/../views/monitoring/form.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Monitoring&action=index');
            exit;
        }

        $idLaporan = (int)($_POST['id_laporan'] ?? 0);
        $hasil = trim($_POST['hasil_monitoring'] ?? '');
        $koordinat = trim($_POST['koordinat_gps'] ?? '');
        $waktu = trim($_POST['waktu_monitoring'] ?? '');
        $idOperator = (int)($_POST['id_operator'] ?? ($_SESSION['user']['id'] ?? 0));

        if ($idLaporan <= 0 || $idOperator <= 0 || $hasil === '' || $waktu === '') {
            setDialog('Gagal', 'ID laporan, ID operator, waktu, dan hasil monitoring wajib diisi.', 'error');
            header('Location: index.php?controller=Monitoring&action=create');
            exit;
        }

        $payload = [
            'id_laporan' => $idLaporan,
            'id_operator' => $idOperator,
            'waktu_monitoring' => date('Y-m-d H:i:s', strtotime($waktu)),
            'hasil_monitoring' => $hasil,
            'koordinat_gps' => $koordinat
        ];

        $response = $this->service->create($payload);
        if ($response['success']) {
            setDialog('Berhasil', 'Data monitoring berhasil ditambahkan.', 'success');
            header('Location: index.php?controller=Monitoring&action=index');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal menambahkan monitoring.', 'error');
            header('Location: index.php?controller=Monitoring&action=create');
        }
        exit;
    }

    public function edit()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            setDialog('Gagal', 'ID monitoring tidak valid.', 'error');
            header('Location: index.php?controller=Monitoring&action=index');
            exit;
        }

        $response = $this->service->getById($id);
        if ($response['success']) {
            $monitoring = is_array($response['data']) ? $response['data'] : null;
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal mengambil data monitoring.', 'error');
            header('Location: index.php?controller=Monitoring&action=index');
            exit;
        }

        include __DIR__ . '/../views/monitoring/form.php';
    }

    public function update()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Monitoring&action=index');
            exit;
        }

        $hasil = trim($_POST['hasil_monitoring'] ?? '');
        $koordinat = trim($_POST['koordinat_gps'] ?? '');
        $waktu = trim($_POST['waktu_monitoring'] ?? '');

        if ($hasil === '' || $waktu === '') {
            setDialog('Gagal', 'Waktu dan hasil monitoring wajib diisi.', 'error');
            header('Location: index.php?controller=Monitoring&action=edit&id=' . $id);
            exit;
        }

        $payload = [
            'waktu_monitoring' => date('Y-m-d H:i:s', strtotime($waktu)),
            'hasil_monitoring' => $hasil,
            'koordinat_gps' => $koordinat
        ];

        $response = $this->service->update($id, $payload);
        if ($response['success']) {
            setDialog('Berhasil', 'Data monitoring berhasil diperbarui.', 'success');
            header('Location: index.php?controller=Monitoring&action=detail&id=' . $id);
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal memperbarui monitoring.', 'error');
            header('Location: index.php?controller=Monitoring&action=edit&id=' . $id);
        }
        exit;
    }

    public function delete()
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=Monitoring&action=index');
            exit;
        }

        $response = $this->service->delete($id);
        if ($response['success']) {
            setDialog('Berhasil', 'Data monitoring berhasil dihapus.', 'success');
        } else {
            setDialog('Gagal', $response['message'] ?? 'Gagal menghapus monitoring.', 'error');
        }

        header('Location: index.php?controller=Monitoring&action=index');
        exit;
    }
}
