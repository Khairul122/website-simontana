<?php
// Debug script untuk testing registration
require_once 'config/koneksi.php';

echo "=== Debug Registration Script ===\n\n";

// 1. Test API Client initialization
echo "1. Testing API Client initialization...\n";
try {
    $apiClient = getAPIClient();
    echo "✓ API Client initialized successfully\n";
} catch (Exception $e) {
    echo "✗ API Client initialization failed: " . $e->getMessage() . "\n";
    exit;
}

// 2. Test API connectivity
echo "\n2. Testing API connectivity...\n";
try {
    $testData = [
        'username' => 'debug_user_' . time(),
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'nama' => 'Debug User',
        'email' => 'debug_' . time() . '@example.com',
        'role' => 'PetugasBPBD',
        'no_telepon' => '08123456789'
    ];

    echo "Sending registration request with data:\n";
    print_r($testData);

    $response = $apiClient->register($testData);

    echo "\nAPI Response:\n";
    print_r($response);

} catch (Exception $e) {
    echo "✗ API registration failed: " . $e->getMessage() . "\n";
    echo "Error details: " . $e->getTraceAsString() . "\n";
}

echo "\n=== End Debug Script ===\n";
?>