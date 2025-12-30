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

    /**
     * Display list of reports
     */
    public function index()
    {
        // Check if user is logged in and has the correct role
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            // Validasi: Jika id_desa tidak ada, tampilkan alert error atau redirect
            if (!$id_desa) {
                echo '<script>alert("Operator Desa harus memiliki wilayah kerja yang terdefinisi!"); window.location.href="index.php?controller=auth&action=login";</script>';
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
                // Set error message to be displayed
                $error_message = $response['message'] ?? 'Gagal mengambil data laporan';
            }

            // Load the view
            include 'views/laporan-operator/index.php';
        } catch (Exception $e) {
            $error_message = 'Terjadi kesalahan: ' . $e->getMessage();
            include 'views/laporan-operator/index.php';
        }
    }

    /**
     * Display report detail
     */
    public function detail()
    {
        // Check if user is logged in and has the correct role
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            // Validasi: Jika id_desa tidak ada, redirect ke login
            if (!$id_desa) {
                header('Location: index.php?controller=auth&action=login');
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

                // If it's an access error, redirect to index
                if (strpos($error_message, 'tidak memiliki akses') !== false) {
                    header('Location: index.php?controller=LaporanOperator&action=index');
                    exit;
                }
            }

            // Load the view
            include 'views/laporan-operator/detail.php';
        } catch (Exception $e) {
            $error_message = 'Terjadi kesalahan: ' . $e->getMessage();
            include 'views/laporan-operator/detail.php';
        }
    }

    /**
     * Display form to edit status
     */
    public function editStatus()
    {
        // Check if user is logged in and has the correct role
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            // Validasi: Jika id_desa tidak ada, redirect ke login
            if (!$id_desa) {
                header('Location: index.php?controller=auth&action=login');
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

                // If it's an access error, redirect to index
                if (strpos($error_message, 'tidak memiliki akses') !== false) {
                    header('Location: index.php?controller=LaporanOperator&action=index');
                    exit;
                }
            }

            // Load the view
            include 'views/laporan-operator/edit-status.php';
        } catch (Exception $e) {
            $error_message = 'Terjadi kesalahan: ' . $e->getMessage();
            include 'views/laporan-operator/edit-status.php';
        }
    }

    /**
     * Update report status
     */
    public function update()
    {
        // Check if user is logged in and has the correct role
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'OperatorDesa') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            // Validasi: Jika id_desa tidak ada, redirect ke login
            if (!$id_desa) {
                header('Location: index.php?controller=auth&action=login');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?controller=LaporanOperator&action=index');
                exit;
            }

            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $status = isset($_POST['status']) ? trim($_POST['status']) : '';
            $catatan_verifikasi = isset($_POST['catatan_verifikasi']) ? trim($_POST['catatan_verifikasi']) : '';

            // Validate required fields
            if (empty($status)) {
                echo '<script>alert("Status wajib diisi!"); window.location.href="index.php?controller=LaporanOperator&action=edit-status&id=' . $id . '";</script>';
                exit;
            }

            // Prepare update data
            $data = [
                'status' => $status,
                'catatan_verifikasi' => $catatan_verifikasi
            ];

            $response = $this->service->updateStatus($id, $data);

            if ($response['success']) {
                echo '<script>alert("Status laporan berhasil diperbarui!"); window.location.href="index.php?controller=LaporanOperator&action=index";</script>';
            } else {
                $error_message = $response['message'] ?? 'Gagal memperbarui status laporan';
                echo '<script>alert("' . addslashes($error_message) . '"); window.location.href="index.php?controller=LaporanOperator&action=edit-status&id=' . $id . '";</script>';
            }
        } catch (Exception $e) {
            echo '<script>alert("Terjadi kesalahan: ' . addslashes($e->getMessage()) . '"); window.location.href="index.php?controller=LaporanOperator&action=index";</script>';
        }
    }

    /**
     * Handle the routing for different actions
     */
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