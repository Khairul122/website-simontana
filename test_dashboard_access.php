<?php
/**
 * Test Dashboard Access - Simulate browser access to dashboard
 */

// Simulate session dan GET parameters
session_start();
$_GET['controller'] = 'dashboard';
$_GET['action'] = 'admin';

// Mock user session for testing
$_SESSION['user'] = [
    'id' => 1,
    'nama' => 'Admin User',
    'username' => 'admin',
    'role' => 'Admin',
    'email' => 'admin@example.com'
];

// Mock API token
$_SESSION['bencana_api_token'] = 'test_token_123';

echo "<h1>Testing Dashboard Access</h1>";

try {
    echo "<h2>✅ Session Setup Complete</h2>";
    echo "<p><strong>User:</strong> " . $_SESSION['user']['nama'] . " (" . $_SESSION['user']['role'] . ")</p>";
    echo "<p><strong>Token:</strong> " . substr($_SESSION['bencana_api_token'], 0, 20) . "...</p>";

    // Load and test controller directly
    require_once 'controllers/DashboardController.php';

    echo "<h2>✅ DashboardController Loaded</h2>";

    $controller = new DashboardController();
    echo "<h2>✅ DashboardController Instantiated</h2>";

    echo "<h2>🚀 Testing Admin Method</h2>";

    // Capture output
    ob_start();
    $controller->admin();
    $output = ob_get_clean();

    echo "<h2>✅ Admin Method Executed</h2>";
    echo "<p><strong>Output Length:</strong> " . strlen($output) . " characters</p>";

    // Check for dashboard elements in output
    if (strpos($output, 'Dashboard Admin') !== false) {
        echo "<p>✅ Dashboard title found</p>";
    }

    if (strpos($output, 'bmkg-total') !== false) {
        echo "<p>✅ BMKG stats element found</p>";
    }

    if (strpos($output, 'desa-total') !== false) {
        echo "<p>✅ Desa stats element found</p>";
    }

    echo "<h2>🎯 Dashboard is Working!</h2>";
    echo "<p>The dashboard can be accessed via: <strong>index.php?controller=dashboard&action=admin</strong></p>";

    // Show first 1000 characters of output
    echo "<h3>📋 Dashboard Output (First 1000 chars):</h3>";
    echo "<div style='border: 1px solid #ccc; padding: 10px; max-height: 300px; overflow-y: auto;'>";
    echo "<pre>" . htmlspecialchars(substr($output, 0, 1000)) . "</pre>";
    echo "</div>";

} catch (Exception $e) {
    echo "<h2>❌ Error</h2>";
    echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . ":" . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
} catch (Error $e) {
    echo "<h2>❌ Fatal Error</h2>";
    echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . ":" . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<p><small>Test completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>