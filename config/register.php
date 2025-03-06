<?php
session_start();
require '../config/database.php';

header('Content-Type: application/json');

try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        throw new Exception('All fields are required');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    if ($password !== $confirm_password) {
        throw new Exception('Passwords do not match');
    }

    if (strlen($password) < 8) {
        throw new Exception('Password must be at least 8 characters');
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM instructors WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        throw new Exception('Email already registered');
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    // Create instructor
    $stmt = $pdo->prepare("INSERT INTO instructors (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashedPassword]);

    // Automatically log in after registration
    $instructorId = $pdo->lastInsertId();
    $_SESSION['instructor'] = [
        'id' => $instructorId,
        'name' => $name,
        'email' => $email
    ];

    echo json_encode([
        'success' => true,
        'message' => 'Registration successful! Redirecting...'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}