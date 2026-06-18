<?php
// ============================================================
//  config.php — Database Connection
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // XAMPP default username
define('DB_PASS', '');           // XAMPP default password is empty
define('DB_NAME', 'jeweljothi_db');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Set charset
$conn->set_charset('utf8mb4');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>