<?php
// ============================================================
//  logout.php — Destroy Session & Redirect to Login
// ============================================================
require_once 'config.php';

// Clear all session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: index.html');
exit;
?>