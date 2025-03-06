<?php
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';
require_once __DIR__ . '/../../lib/Validator.php';

// Validate input
$validator = new Validator();
$email = $validator->validateEmail($_POST['email'] ?? '');

if (!$email) {
    $_SESSION['error'] = 'Invalid email.';
    header('Location: /pages/public/courses.php');
    exit();
}

// Generate a reset token
$resetToken = bin2hex(random_bytes(32));

// Save the reset token in the database
$stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
$stmt->bind_param("ss", $resetToken, $email);
$stmt->execute();

// Send the reset link via email (pseudo-code)
// sendResetEmail($email, $resetToken);

$_SESSION['success'] = 'Password reset link sent to your email.';
header('Location: /pages/public/courses.php');
exit();
?>