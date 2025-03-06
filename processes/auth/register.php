<?php
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';
require_once __DIR__ . '/../../lib/Validator.php';

// Validate input
$validator = new Validator();
$name = $validator->validateName($_POST['name'] ?? '');
$email = $validator->validateEmail($_POST['email'] ?? '');
$password = $validator->validatePassword($_POST['password'] ?? '');
$role = $validator->validateRole($_POST['role'] ?? '');

if (!$name || !$email || !$password || !$role) {
    $_SESSION['error'] = 'Invalid input.';
    header('Location: /pages/public/courses.php');
    exit();
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into the database
$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Registration successful. Please log in.';
    header('Location: /pages/public/courses.php');
} else {
    $_SESSION['error'] = 'Registration failed. Please try again.';
    header('Location: /pages/public/courses.php');
}
exit();
?>