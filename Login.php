<?php
// ============================================================
//  login.php — User Login & Session
// ============================================================

header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Get data from JavaScript fetch
$data     = json_decode(file_get_contents('php://input'), true);
$email    = trim($data['email']    ?? '');
$password = $data['password']      ?? '';

// ── Validation ──
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

// ── Find user by email ──
$stmt = $conn->prepare('SELECT id, first_name, last_name, email, password FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// ── Verify password ──
if (!password_verify($password, $user['password'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    $conn->close();
    exit;
}

// ── Create session ──
$_SESSION['user_id']    = $user['id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name']  = $user['last_name'];
$_SESSION['email']      = $user['email'];
$_SESSION['logged_in']  = true;

echo json_encode([
    'success'    => true,
    'message'    => 'Login successful.',
    'first_name' => $user['first_name'],
    'redirect'   => 'Dashboard.php'
]);

$conn->close();
?>