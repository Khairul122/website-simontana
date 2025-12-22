<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

define('BASE_PATH', __DIR__);
define('CONTROLLER_PATH', BASE_PATH . '/controllers/');
define('MODEL_PATH', BASE_PATH . '/models/');
define('VIEW_PATH', BASE_PATH . '/views/');
define('ASSET_PATH', BASE_PATH . '/assets/');
require_once 'config/koneksi.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Pastikan $controller adalah string, bukan objek
if (!is_string($controller)) {
    header('HTTP/1.1 400 Bad Request');
    echo '400 - Controller harus berupa string';
    exit;
}

$controller = preg_replace('/[^a-zA-Z0-9_]/', '', $controller);
$action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

$controllerFile = CONTROLLER_PATH . $controller . 'Controller.php';

if (file_exists($controllerFile)) {
    // Simpan nilai $controller sebelum require untuk mencegah override
    $controllerName = $controller;

    require_once $controllerFile;

    $controllerClass = ucfirst($controllerName) . 'Controller';

    if (class_exists($controllerClass)) {
        $controllerObj = new $controllerClass();

        if (method_exists($controllerObj, $action)) {
            // Tangani parameter untuk method yang memerlukan parameter
            $id = $_GET['id'] ?? null;

            // Jika method memerlukan parameter, kita sesuaikan
            if ($action === 'edit' && $id !== null) {
                $controllerObj->$action($id);
            } else if ($action === 'update' && $id !== null) {
                $controllerObj->$action($id);
            } else if ($action === 'delete' && $id !== null) {
                $controllerObj->$action($id);
            } else if ($action === 'edit' || $action === 'update' || $action === 'delete') {
                // Jika method memerlukan id tapi tidak diberikan
                header('HTTP/1.1 400 Bad Request');
                echo '400 - ID parameter diperlukan untuk action ini';
            } else {
                // Untuk method tanpa parameter
                $controllerObj->$action();
            }
        } else {
            header('HTTP/1.1 404 Not Found');
            echo '404 - Action tidak ditemukan';
        }
    } else {
        header('HTTP/1.1 404 Not Found');
        echo '404 - Controller class tidak ditemukan';
    }
} else {
    header('HTTP/1.1 404 Not Found');
    echo '404 - Controller tidak ditemukan';
}