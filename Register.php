<?php
// ============================================================
//  register.php — User Registration
// ============================================================

header('Content-Type: application/json');
require_once 'config.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Get data from JavaScript fetch
$data       = json_decode(file_get_contents('php://input'), true);
$first_name = trim($data['first_name'] ?? '');
$last_name  = trim($data['last_name']  ?? '');
$email      = trim($data['email']      ?? '');
$password   = $data['password']        ?? '';

// ── Validation ──
if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters.']);
    exit;
}

// ── Check if email already exists ──
$stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'This email is already registered.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// ── Hash password and insert user ──
$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare(
    'INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)'
);
$stmt->bind_param('ssss', $first_name, $last_name, $email, $password_hash);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Registration successful. Please sign in.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
}

$stmt->close();
$conn->close();
?>