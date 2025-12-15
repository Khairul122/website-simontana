<?php
session_start();

// Create mock admin user session
$_SESSION['user'] = [
    'id' => 1,
    'username' => 'admin',
    'nama' => 'Admin User',
    'role' => 'Admin',
    'email' => 'admin@simonta.dev'
];

$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['nama'] = 'Admin User';
$_SESSION['role'] = 'Admin';
$_SESSION['logged_in'] = true;
$_SESSION['login_time'] = time();

// Create mock API token
$mockToken = 'mock_token_1_' . time() . '_admin';
$_SESSION['bencana_api_token'] = $mockToken;
$_SESSION['bencana_api_login_time'] = time();

echo "Session created successfully!<br>";
echo "User: " . $_SESSION['user']['nama'] . " (" . $_SESSION['user']['role'] . ")<br>";
echo "Token: " . substr($mockToken, 0, 20) . "...<br>";
echo "<a href='index.php?controller=dashboard&action=admin'>Go to Dashboard</a>";
?>