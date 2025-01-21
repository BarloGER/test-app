<?php
declare(strict_types=1);

// CORS headers for local dev (Vite: http://localhost:5173 -> PHP: http://localhost:8080)
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle OPTIONS request (preflight) immediately
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once './db/db.php';
require_once './validator.php';

$data = json_decode(file_get_contents('php://input'), true) ?? [];

$validator = new Validator();

// Validate: email & password are required
$validator->required($data, 'email', 'Email must not be empty.');
$validator->email($data, 'email', 'Email format is invalid.');

$validator->required($data, 'password', 'Password must not be empty.');
$validator->length($data, 'password', 8, 100, 'Password must be 8-100 chars.');

// If any validation fails, log internal, return generic error
if ($validator->fails()) {
    // Log the detailed messages internally
    error_log("Login validation failed: " . json_encode($validator->errors()));

    http_response_code(400);
    echo json_encode([
        'error' => 'features.authentication.login.failed'
    ]);
    exit;
}

// Extract data
$email = trim($data['email']);
$password = trim($data['password']);

try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'features.authentication.login.errors.wrongCredentials']);
        exit;
    }

    if (!password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode(['error' => 'features.authentication.login.errors.wrongCredentials']);
        exit;
    }

    echo json_encode(true);
} catch (PDOException $e) {
    // Log the internal DB error
    error_log("Login DB error: " . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'error' => 'features.authentication.login.failed'
    ]);
}
