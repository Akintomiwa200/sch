<?php
session_start();
require '../config/database.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        throw new Exception('All fields are required');
    }

    // Check instructor
    $stmt = $pdo->prepare("SELECT * FROM instructors WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        throw new Exception('Invalid credentials');
    }

    // Set session
    $_SESSION['instructor'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email']
    ];

    // Set remember me cookie
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        setcookie('remember_token', $token, time() + 86400 * 30, '/');
        
        // Store token in database
        $stmt = $pdo->prepare("UPDATE instructors SET remember_token = ? WHERE id = ?");
        $stmt->execute([$token, $user['id']]);
    }

    echo json_encode(['success' => true, 'message' => 'Login successful']);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}