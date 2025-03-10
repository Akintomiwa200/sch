<?php
session_start();
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../lib/Validator.php';

// Validate input
$validator = new Validator();
$name = $validator->validateName($_POST['name'] ?? '');
$email = $validator->validateEmail($_POST['email'] ?? '');
$password = $validator->validatePassword($_POST['password'] ?? '');
$role = $validator->validateRole($_POST['role'] ?? '');

if (!$name || !$email || !$password || !$role) {
    $_SESSION['error'] = 'Invalid input.';
    header('Location: /sign.php');
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


// Check if $link (database connection) is valid
if ($link === null) {
    die("Database connection failed.");
}

// Insert user into the database
$stmt = $link->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Registration successful. Please log in.';
    header('Location: /login.php');  // Redirecting to the login page after successful signup
} else {
    $_SESSION['error'] = 'Registration failed. Please try again.';
    header('Location: /signup.php');  // Or wherever you want to redirect in case of failure
}
exit();
?>
