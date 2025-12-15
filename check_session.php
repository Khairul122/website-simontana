<?php
session_start();

echo "<h2>Session Check</h2>";
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? "ACTIVE" : "NOT ACTIVE") . "<br>";
echo "Session ID: " . session_id() . "<br>";

echo "<h3>Session Data:</h3>";
if (!empty($_SESSION)) {
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
} else {
    echo "No session data found<br>";
}

echo "<h3>Token Info:</h3>";
if (isset($_SESSION['bencana_api_token'])) {
    echo "Token found: " . substr($_SESSION['bencana_api_token'], 0, 30) . "...<br>";
    echo "Token length: " . strlen($_SESSION['bencana_api_token']) . " chars<br>";
} else {
    echo "No token found in session<br>";
}

echo "<br><a href='create_session.php'>Create Session</a> | ";
echo "<a href='index.php?controller=dashboard&action=admin'>Go to Dashboard</a>";
?>