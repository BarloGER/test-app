<?php
declare(strict_types=1);

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once './db/db.php';
require_once './validator.php';

$data = json_decode(file_get_contents('php://input'), true) ?? [];

$validator = new Validator();

// Validate: username, email, password
$validator->required($data, 'username', 'Username must not be empty.');
$validator->length($data, 'username', 3, 50, 'Username must be 3-50 characters.');

$validator->required($data, 'email', 'Email must not be empty.');
$validator->email($data, 'email', 'Email format is invalid.');

$validator->required($data, 'password', 'Password must not be empty.');
$validator->length($data, 'password', 8, 100, 'Password must be 8-100 chars.');

// Check if validation failed
if ($validator->fails()) {
    error_log("Register validation failed: " . json_encode($validator->errors()));

    http_response_code(400);
    echo json_encode([
        'error' => 'features.authentication.register.failed'
    ]);
    exit;
}

$username = trim($data['username']);
$email    = trim($data['email']);
$password = trim($data['password']);

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password)
                           VALUES (:username, :email, :password)");
    $stmt->execute([
        ':username' => $username,
        ':email'    => $email,
        ':password' => $hashedPassword
    ]);

    echo json_encode(['message' => 'features.authentication.register.success']);
} catch (PDOException $e) {
    // Possibly a UNIQUE constraint violation
    error_log("Register DB error: " . $e->getMessage());

    http_response_code(409);
    echo json_encode([
        'error' => 'features.authentication.register.failed'
    ]);
}
