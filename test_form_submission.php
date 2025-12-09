<?php
// Test script untuk simulasi form submission
session_start();

echo "=== Testing Registration API Call ===\n\n";

// Load API Client langsung
require_once 'config/koneksi.php';

try {
    $apiClient = getAPIClient();
    echo "✓ API Client loaded successfully\n";

    $testData = [
        'username' => 'testuser_form_' . time(),
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'nama' => 'Test Form User',
        'email' => 'testform_' . time() . '@example.com',
        'role' => 'PetugasBPBD',
        'no_telepon' => '08123456789'
    ];

    echo "Test data:\n";
    print_r($testData);
    echo "\n";

    echo "Calling API register...\n";
    $response = $apiClient->register($testData);

    echo "API Response:\n";
    print_r($response);

} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== End Test ===\n";
?>