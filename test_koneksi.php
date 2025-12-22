<?php
// Test script untuk koneksi.php yang sudah diupdate
require_once 'config/koneksi.php';

echo "Testing API endpoints yang sudah diupdate...\n\n";

// Test BMKG Endpoints
echo "=== BMKG Integration Test ===\n";

echo "1. Testing Gempa Terbaru:\n";
$result = apiRequest(API_BMKG_GEMPA_TERBARU);
echo "Status: " . ($result['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "HTTP Code: " . $result['http_code'] . "\n";
if ($result['success']) {
    echo "Data: " . json_encode($result['data']['Infogempa']['gempa']['Tanggal'] . ' - M' . $result['data']['Infogempa']['gempa']['Magnitude']) . "\n";
} else {
    echo "Error: " . $result['message'] . "\n";
}
echo "\n";

echo "2. Testing Gempa Terkini:\n";
$result = apiRequest(API_BMKG_GEMPA_TERKINI);
echo "Status: " . ($result['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "HTTP Code: " . $result['http_code'] . "\n";
if ($result['success']) {
    echo "Total Gempa: " . count($result['data']['Infogempa']['gempa']) . " data\n";
}
echo "\n";

echo "3. Testing Peringatan Tsunami:\n";
$result = apiRequest(API_BMKG_PERINGATAN_TSUNAMI);
echo "Status: " . ($result['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "HTTP Code: " . $result['http_code'] . "\n";
echo "\n";

// Test Laporan Endpoints (plural)
echo "=== Laporan Endpoints Test (Plural) ===\n";

echo "1. Testing Laporans List:\n";
$result = apiRequest(API_REPORTS);
echo "Status: " . ($result['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "HTTP Code: " . $result['http_code'] . "\n";
echo "\n";

echo "2. Testing Laporans Statistics:\n";
$result = apiRequest(API_REPORTS_STATISTICS);
echo "Status: " . ($result['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "HTTP Code: " . $result['http_code'] . "\n";
echo "\n";

// Test Wilayah Endpoints
echo "=== Wilayah Endpoints Test ===\n";

echo "1. Testing Provinsi:\n";
$result = apiRequest(API_PROVINSI);
echo "Status: " . ($result['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "HTTP Code: " . $result['http_code'] . "\n";
if ($result['success']) {
    echo "Total Provinsi: " . count($result['data']) . " data\n";
}
echo "\n";

echo "=== Test Completed ===\n";
?>