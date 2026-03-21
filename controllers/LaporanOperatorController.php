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
            header('Location: index.php?controller=Auth&action=login');
            exit();
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            // Validasi: Jika id_desa tidak ada, tampilkan alert error atau redirect
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
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            // Validasi: Jika id_desa tidak ada, redirect ke login
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
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            // Validasi: Jika id_desa tidak ada, redirect ke login
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
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        try {
            $id_desa = $_SESSION['user']['id_desa'] ?? null;

            // Validasi: Jika id_desa tidak ada, redirect ke login
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

            // Validate required fields
            if (empty($status)) {
                setDialog('Gagal', 'Status wajib diisi!', 'error');
                header('Location: index.php?controller=LaporanOperator&action=edit-status&id=' . $id);
                exit;
            }

            // Prepare update data
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
