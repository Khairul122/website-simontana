<?php
// Mulai session
session_start();

// Memuat konfigurasi Global Environment
require_once 'config/globals.php';

// Menentukan controller dan action default
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Fungsi untuk mencari file controller dengan berbagai format penamaan
function findControllerFile($controllerName) {
    $controllerDir = 'controllers/';
    $serviceDir = 'services/';

    // Berbagai format penamaan yang mungkin untuk controllers
    $possibleNames = [
        // Format PascalCase/CamelCase - yang paling umum
        ucfirst($controllerName) . 'Controller.php',
        // Format as-is (tanpa perubahan case)
        $controllerName . 'Controller.php',
        // Format lowercase
        strtolower($controllerName) . 'Controller.php',
        // Format UPPERCASE
        strtoupper($controllerName) . 'Controller.php',
        // Handle multi-kata: ubah "permohonanadmin" menjadi "PermohonanAdmin"
        ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $controllerName)) . 'Controller.php',
        // Handle tanpa spasi: ubah "permohonanadmin" menjadi "Permohonan Admin" lalu gabung
        str_replace(' ', '', ucwords(strtolower(preg_replace('/([A-Z])/', ' $1', $controllerName)))) . 'Controller.php',
        // Format dengan underscore
        strtolower(preg_replace('/([A-Z])/', '_$1', $controllerName)) . 'Controller.php'
    ];

    // Berbagai format penamaan yang mungkin untuk services
    $possibleServiceNames = [
        ucfirst($controllerName) . 'Service.php',
        $controllerName . 'Service.php',
        strtolower($controllerName) . 'Service.php',
        str_replace(' ', '', ucwords(strtolower(preg_replace('/([A-Z])/', ' $1', $controllerName)))) . 'Service.php'
    ];

    // Cek di folder controllers terlebih dahulu
    foreach ($possibleNames as $fileName) {
        $filePath = $controllerDir . $fileName;
        if (file_exists($filePath)) {
            return [
                'type' => 'controller',
                'file' => $filePath,
                'class' => pathinfo($filePath, PATHINFO_FILENAME)
            ];
        }
    }

    // Jika tidak ditemukan di controllers, cek di services
    foreach ($possibleServiceNames as $fileName) {
        $filePath = $serviceDir . $fileName;
        if (file_exists($filePath)) {
            return [
                'type' => 'service',
                'file' => $filePath,
                'class' => pathinfo($filePath, PATHINFO_FILENAME)
            ];
        }
    }

    // Special handling untuk kasus yang sering digunakan
    $specialCases = [
        'beranda' => 'BerandaController.php',
        'home' => 'HomeController.php',
        'auth' => 'AuthController.php',
        'dashboard' => 'DashboardController.php',
        'user' => 'UserController.php',
        'profile' => 'ProfileController.php',
        'download' => 'DownloadController.php',
        'sosialmedia' => 'SosialMediaController.php',
        'informasipublik' => 'InformasiPublikController.php',
        'layananketerangan' => 'LayananKeteranganController.php',
        'petugas' => 'PetugasController.php',
        'wagateway' => 'WAGatewayController.php',
        'skpd' => 'SKPDController.php',
        'banner' => 'BannerController.php',
        'kategori' => 'KategoriController.php',
        'dokumen' => 'DokumenController.php',
        'tatakelola' => 'TataKelolaController.php',
        'album' => 'AlbumController.php',
        'faq' => 'FAQController.php',
        'pesanmasuk' => 'PesanMasukController.php',
        'layananinformasi' => 'LayananInformasiController.php',
        'ajukanpermohonan' => 'AjukanPermohonanController.php',
        'keberatan' => 'KeberatanController.php',
        'sengketa' => 'SengketaController.php',
        'layanankepuasan' => 'LayananKepuasanController.php'
    ];

    if (isset($specialCases[strtolower($controllerName)])) {
        $fileName = $specialCases[strtolower($controllerName)];
        $filePath = $controllerDir . $fileName;
        if (file_exists($filePath)) {
            return [
                'type' => 'controller',
                'file' => $filePath,
                'class' => pathinfo($filePath, PATHINFO_FILENAME)
            ];
        }
    }

    return null;
}

// Fungsi untuk autoloading services dan controllers
function loadServiceOrController($fileInfo) {
    if ($fileInfo['type'] === 'service') {
        require_once $fileInfo['file'];

        // Initialize service dengan API client
        $apiClient = getAPIClient();
        $serviceClass = $fileInfo['class'];

        if (class_exists($serviceClass)) {
            return new $serviceClass($apiClient);
        }
    } elseif ($fileInfo['type'] === 'controller') {
        require_once $fileInfo['file'];

        // Initialize controller (controllers yang sudah ada mungkin menggunakan DB lama)
        // Untuk kompatibilitas, kita coba dengan parameter lama terlebih dahulu
        $controllerClass = $fileInfo['class'];

        if (class_exists($controllerClass)) {
            // Coba constructor lama (dengan DB parameter)
            try {
                // Cek apakah controller mengharapkan parameter database
                $reflection = new ReflectionClass($controllerClass);
                $constructor = $reflection->getConstructor();

                if ($constructor && $constructor->getNumberOfParameters() > 0) {
                    // Constructor lama dengan parameter database
                    $db = new stdClass(); // Placeholder untuk compatibility
                    return new $controllerClass($db);
                } else {
                    // Constructor tanpa parameter
                    return new $controllerClass();
                }
            } catch (Exception $e) {
                // Fallback ke constructor tanpa parameter
                return new $controllerClass();
            }
        }
    }

    return null;
}

// Debug router
error_log("=== ROUTER DEBUG ===");
error_log("Controller: " . $controller);
error_log("Action: " . $action);

// Cari file controller atau service
$fileInfo = findControllerFile($controller);

error_log("File Info: " . ($fileInfo ? json_encode($fileInfo) : 'NULL'));

if ($fileInfo && file_exists($fileInfo['file'])) {
    error_log("File found: " . $fileInfo['file']);

    // Load dan instantiate class
    $instance = loadServiceOrController($fileInfo);

    if ($instance) {
        error_log("Class instantiated: " . get_class($instance));

        // Cek apakah method ada
        if (method_exists($instance, $action)) {
            error_log("Method found: " . $action);
            // Panggil method
            try {
                $instance->$action();
            } catch (Exception $e) {
                // Tangkap error dan tampilkan pesan yang informatif
                http_response_code(500);
                echo "<h1>500 - Internal Server Error</h1>";
                echo "<p>Terjadi kesalahan saat menjalankan method '<strong>" . htmlspecialchars($action) . "</strong>' pada '<strong>" . htmlspecialchars($fileInfo['class']) . "</strong>'</p>";
                echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
                echo "<p><a href='index.php'>Kembali ke Beranda</a></p>";

                // Log error untuk debugging
                error_log("Controller Error: " . $e->getMessage());
            }
        } else {
            // Method tidak ditemukan, coba method index
            if (method_exists($instance, 'index')) {
                $instance->index();
            } else {
                // Tampilkan halaman error
                http_response_code(404);
                echo "<h1>404 - Method Not Found</h1>";
                echo "<p>Method '<strong>" . htmlspecialchars($action) . "</strong>' tidak ditemukan di '<strong>" . htmlspecialchars($fileInfo['class']) . "</strong>'</p>";
                echo "<p><a href='index.php'>Kembali ke Beranda</a></p>";
            }
        }
    } else {
        // Class tidak dapat di-instantiate
        http_response_code(500);
        echo "<h1>500 - Class Instantiation Error</h1>";
        echo "<p>Class '<strong>" . htmlspecialchars($fileInfo['class']) . "</strong>' tidak dapat di-instantiate dari file '<strong>" . htmlspecialchars($fileInfo['file']) . "</strong>'</p>";
        echo "<p><a href='index.php'>Kembali ke Beranda</a></p>";
    }
} else {
    // Controller/Service tidak ditemukan
    http_response_code(404);
    echo "<h1>404 - Controller/Service Not Found</h1>";
    echo "<p>Controller/Service '<strong>" . htmlspecialchars($controller) . "</strong>' tidak ditemukan.</p>";
    echo "<p>Tipe yang dicari: <strong>Controller</strong> atau <strong>Service</strong></p>";

    // Debug: tampilkan controller dan service yang tersedia
    $controllerDir = 'controllers/';
    $serviceDir = 'services/';

    echo "<h3>Folder Structure:</h3>";

    if (is_dir($controllerDir)) {
        $availableControllers = scandir($controllerDir);
        $availableControllers = array_diff($availableControllers, ['.', '..']);

        if (!empty($availableControllers)) {
            echo "<h4>Controllers yang tersedia:</h4>";
            echo "<ul>";
            foreach ($availableControllers as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    echo "<li>" . htmlspecialchars($file) . "</li>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p><em>Folder controllers kosong</em></p>";
        }
    }

    if (is_dir($serviceDir)) {
        $availableServices = scandir($serviceDir);
        $availableServices = array_diff($availableServices, ['.', '..']);

        if (!empty($availableServices)) {
            echo "<h4>Services yang tersedia:</h4>";
            echo "<ul>";
            foreach ($availableServices as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    echo "<li>" . htmlspecialchars($file) . "</li>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p><em>Folder services kosong</em></p>";
        }
    }

    echo "<p><a href='index.php'>Kembali ke Beranda</a></p>";
}
?>