<?php
require_once 'config/koneksi.php';
require_once 'services/LaporanOperatorService.php';

class LaporanOperatorController
{
    private $service;

    public function __construct()
    {
        $this->service = new LaporanOperatorService();
    }

    


    public function index()
    {
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=Auth&action=login');
            exit();
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            
            if (!$id_desa) {
                setDialog('Gagal', 'Operator Desa harus memiliki wilayah kerja yang terdefinisi!', 'error');
                header('Location: index.php?controller=Auth&action=login');
                exit;
            }

            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $response = $this->service->getAll($page, $id_desa);

            if ($response['success']) {
                $reports = $response['data'] ?? [];
                $pagination = $response['pagination'] ?? [];
            } else {
                $reports = [];
                $pagination = [];
                
                $error_message = $response['message'] ?? 'Gagal mengambil data laporan';
            }

            
            include 'views/laporan-operator/index.php';
        } catch (Exception $e) {
            $error_message = 'Terjadi kesalahan: ' . $e->getMessage();
            include 'views/laporan-operator/index.php';
        }
    }

    


    public function detail()
    {
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            
            if (!$id_desa) {
                header('Location: index.php?controller=Auth&action=login');
                exit;
            }

            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

            if ($id <= 0) {
                header('Location: index.php?controller=LaporanOperator&action=index');
                exit;
            }

            $response = $this->service->getById($id);

            if ($response['success']) {
                $report = $response['data'];
            } else {
                $report = null;
                $error_message = $response['message'] ?? 'Gagal mengambil detail laporan';

                
                if (strpos($error_message, 'tidak memiliki akses') !== false) {
                    header('Location: index.php?controller=LaporanOperator&action=index');
                    exit;
                }
            }

            
            include 'views/laporan-operator/detail.php';
        } catch (Exception $e) {
            $error_message = 'Terjadi kesalahan: ' . $e->getMessage();
            include 'views/laporan-operator/detail.php';
        }
    }

    


    public function editStatus()
    {
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            
            if (!$id_desa) {
                header('Location: index.php?controller=Auth&action=login');
                exit;
            }

            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

            if ($id <= 0) {
                header('Location: index.php?controller=LaporanOperator&action=index');
                exit;
            }

            $response = $this->service->getById($id);

            if ($response['success']) {
                $report = $response['data'];
            } else {
                $report = null;
                $error_message = $response['message'] ?? 'Gagal mengambil detail laporan';

                
                if (strpos($error_message, 'tidak memiliki akses') !== false) {
                    header('Location: index.php?controller=LaporanOperator&action=index');
                    exit;
                }
            }

            
            include 'views/laporan-operator/edit-status.php';
        } catch (Exception $e) {
            $error_message = 'Terjadi kesalahan: ' . $e->getMessage();
            include 'views/laporan-operator/edit-status.php';
        }
    }

    


    public function update()
    {
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            
            if (!$id_desa) {
                header('Location: index.php?controller=Auth&action=login');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?controller=LaporanOperator&action=index');
                exit;
            }

            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $status = isset($_POST['status']) ? trim($_POST['status']) : '';
            $catatan_verifikasi = isset($_POST['catatan_verifikasi']) ? trim($_POST['catatan_verifikasi']) : '';

            
            if (empty($status)) {
                setDialog('Gagal', 'Status wajib diisi!', 'error');
                header('Location: index.php?controller=LaporanOperator&action=edit-status&id=' . $id);
                exit;
            }

            
            $data = [
                'status' => $status,
                'catatan_verifikasi' => $catatan_verifikasi
            ];

            $response = $this->service->updateStatus($id, $data);

            if ($response['success']) {
                setDialog('Berhasil', 'Status laporan berhasil diperbarui!', 'success');
                header('Location: index.php?controller=LaporanOperator&action=index');
            } else {
                $error_message = $response['message'] ?? 'Gagal memperbarui status laporan';
                setDialog('Gagal', $error_message, 'error');
                header('Location: index.php?controller=LaporanOperator&action=edit-status&id=' . $id);
            }
        } catch (Exception $e) {
            setDialog('Gagal', 'Terjadi kesalahan: ' . $e->getMessage(), 'error');
            header('Location: index.php?controller=LaporanOperator&action=index');
        }
    }

    


    public function handleRequest()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        switch ($action) {
            case 'detail':
                $this->detail();
                break;
            case 'edit-status':
                $this->editStatus();
                break;
            case 'update':
                $this->update();
                break;
            default:
                $this->index();
                break;
        }
    }
}
