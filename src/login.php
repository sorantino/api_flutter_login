<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

$stmt = (new PDO('sqlite:/var/www/db.sqlite'))->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$input['email'] ?? '']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($input['password'] ?? '', $user['password'])) {
    http_response_code(400);
    echo json_encode(['status' => 400, 'message' => 'Invalid email or password']);
    exit;
}

echo json_encode([
    'status' => 200,
    'message' => 'Success',
    'id' => $user['id'],
    'firstName' => $user['first_name'],
    'lastName' => $user['last_name'],
    'email' => $user['email'],
    'role' => $user['role'],
]);
