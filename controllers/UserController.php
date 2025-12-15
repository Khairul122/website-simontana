<?php
/**
 * User Controller for SIMONTA BENCANA Web Application
 * Handles user management operations including CRUD, filtering, and statistics
 */

class UserController {
    private $userService;

    public function __construct() {
        require_once __DIR__ . '/../services/UserService.php';
        $this->userService = new UserService();
    }

    /**
     * Display user listing page
     */
    public function index() {
        // Check if user is logged in and is Admin
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'Admin') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        // Get API token
        require_once __DIR__ . '/../config/koneksi.php';
        $apiClient = getAPIClient();
        $token = $apiClient->getStoredApiToken();

        // Handle search and filter parameters
        $params = [];
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $params['search'] = $_GET['search'];
        }
        if (isset($_GET['role']) && !empty($_GET['role'])) {
            $params['role'] = $_GET['role'];
        }
        if (isset($_GET['id_desa']) && !empty($_GET['id_desa'])) {
            $params['id_desa'] = $_GET['id_desa'];
        }
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $params['page'] = (int)$_GET['page'];
        }
        if (isset($_GET['per_page']) && !empty($_GET['per_page'])) {
            $params['per_page'] = (int)$_GET['per_page'];
        }

        // Get users data
        $usersResponse = $this->userService->getAllUsers($token, $params);
        $statisticsResponse = $this->userService->getUserStatistics($token);
        $villagesResponse = $this->userService->getVillages($token);

        // Get messages from session
        $success_message = $_SESSION['success_message'] ?? '';
        $error_message = $_SESSION['error_message'] ?? '';

        // Clear session messages
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);

        // Prepare data for view
        $data = [
            'users' => $usersResponse['data']['data'] ?? [],
            'pagination' => [
                'total' => $usersResponse['data']['total'] ?? 0,
                'per_page' => $usersResponse['data']['per_page'] ?? 10,
                'current_page' => $usersResponse['data']['current_page'] ?? 1,
                'last_page' => $usersResponse['data']['last_page'] ?? 1,
                'from' => $usersResponse['data']['from'] ?? 0,
                'to' => $usersResponse['data']['to'] ?? 0
            ],
            'statistics' => $statisticsResponse['data'] ?? [],
            'villages' => $villagesResponse['data'] ?? [],
            'filters' => $params,
            'success_message' => $success_message,
            'error_message' => $error_message,
            'user_role' => $_SESSION['user_role'],
            'user_nama' => $_SESSION['user_nama']
        ];

        // Load view
        include __DIR__ . '/../views/user/index.php';
    }

    /**
     * Display user create/edit form
     */
    public function form($id = null) {
        // Check if user is logged in and is Admin
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'Admin') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        // Get API token
        require_once __DIR__ . '/../config/koneksi.php';
        $apiClient = getAPIClient();
        $token = $apiClient->getStoredApiToken();

        // Get user data if editing
        $user = null;
        if ($id) {
            $userResponse = $this->userService->getUserById($token, $id);
            if ($userResponse && $userResponse['success']) {
                $user = $userResponse['data'];
            } else {
                $_SESSION['error_message'] = 'User tidak ditemukan';
                header('Location: index.php?controller=user&action=index');
                exit;
            }
        }

        // Get villages for dropdown
        $villagesResponse = $this->userService->getVillages($token);

        // Get messages from session
        $success_message = $_SESSION['success_message'] ?? '';
        $error_message = $_SESSION['error_message'] ?? '';
        $old_input = $_SESSION['old_input'] ?? [];

        // Clear session messages
        unset($_SESSION['success_message']);
        unset($_SESSION['error_message']);
        unset($_SESSION['old_input']);

        // Prepare data for view
        $data = [
            'user' => $user,
            'villages' => $villagesResponse['data'] ?? [],
            'is_edit' => $id ? true : false,
            'success_message' => $success_message,
            'error_message' => $error_message,
            'old_input' => $old_input,
            'user_role' => $_SESSION['user_role'],
            'user_nama' => $_SESSION['user_nama']
        ];

        // Load view
        include __DIR__ . '/../views/user/form.php';
    }

    /**
     * Handle user creation
     */
    public function store() {
        // Check if user is logged in and is Admin
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'Admin') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=user&action=index');
            exit;
        }

        // Get API token
        require_once __DIR__ . '/../config/koneksi.php';
        $apiClient = getAPIClient();
        $token = $apiClient->getStoredApiToken();

        // Format user data
        $userData = $this->userService->formatUserData($_POST, false);

        // Validate user data
        $errors = $this->userService->validateUserData($userData, false);

        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            $_SESSION['old_input'] = $_POST;
            header('Location: index.php?controller=user&action=form');
            exit;
        }

        // Create user
        $response = $this->userService->createUser($token, $userData);

        if ($response['success']) {
            $_SESSION['success_message'] = 'User berhasil ditambahkan';
        } else {
            $_SESSION['error_message'] = $response['message'];
            $_SESSION['old_input'] = $_POST;
            header('Location: index.php?controller=user&action=form');
            exit;
        }

        header('Location: index.php?controller=user&action=index');
        exit;
    }

    /**
     * Handle user update
     */
    public function update($id) {
        // Check if user is logged in and is Admin
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'Admin') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=user&action=index');
            exit;
        }

        // Get API token
        require_once __DIR__ . '/../config/koneksi.php';
        $apiClient = getAPIClient();
        $token = $apiClient->getStoredApiToken();

        // Format user data
        $userData = $this->userService->formatUserData($_POST, true);

        // Validate user data
        $errors = $this->userService->validateUserData($userData, true);

        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            $_SESSION['old_input'] = $_POST;
            header("Location: index.php?controller=user&action=form&id=$id");
            exit;
        }

        // Update user
        $response = $this->userService->updateUser($token, $id, $userData);

        if ($response['success']) {
            $_SESSION['success_message'] = 'User berhasil diperbarui';
        } else {
            $_SESSION['error_message'] = $response['message'];
            $_SESSION['old_input'] = $_POST;
            header("Location: index.php?controller=user&action=form&id=$id");
            exit;
        }

        header('Location: index.php?controller=user&action=index');
        exit;
    }

    /**
     * Handle user deletion
     */
    public function delete($id) {
        // Check if user is logged in and is Admin
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'Admin') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        // Get API token
        require_once __DIR__ . '/../config/koneksi.php';
        $apiClient = getAPIClient();
        $token = $apiClient->getStoredApiToken();

        // Delete user
        $response = $this->userService->deleteUser($token, $id);

        if ($response['success']) {
            $_SESSION['success_message'] = 'User berhasil dihapus';
        } else {
            $_SESSION['error_message'] = $response['message'];
        }

        header('Location: index.php?controller=user&action=index');
        exit;
    }

    /**
     * Display user details (AJAX endpoint)
     */
    public function show($id) {
        // Check if user is logged in and is Admin
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'Admin') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        // Get API token
        require_once __DIR__ . '/../config/koneksi.php';
        $apiClient = getAPIClient();
        $token = $apiClient->getStoredApiToken();

        // Get user data
        $response = $this->userService->getUserById($token, $id);

        header('Content-Type: application/json');
        if ($response && $response['success']) {
            echo json_encode(['success' => true, 'data' => $response['data']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
        exit;
    }
}
?>