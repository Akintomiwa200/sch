<?php
session_start();

// Include necessary files
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../lib/Validator.php';

// Validate input
$validator = new Validator();
$email = $validator->validateEmail($_POST['email'] ?? '');

if (!$email) {
    $_SESSION['error'] = 'Invalid email.';
    header('Location: /pages/public/courses.php');
    exit();
}

// Check if the email exists in the database
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Email not found.';
    header('Location: /login.php');
    exit();
}

// Generate a reset token
$resetToken = bin2hex(random_bytes(32));

// Save the reset token in the database (set an expiration time for the token, e.g., 1 hour)
$expiryTime = date("Y-m-d H:i:s", strtotime('+1 hour'));
$stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
$stmt->bind_param("sss", $resetToken, $expiryTime, $email);
$stmt->execute();

// Send the reset link via email (pseudo-code)
// Assuming you have a mail function ready, like PHPMailer or similar
$resetLink = "https://yourwebsite.com/reset_password.php?token=$resetToken";

// Email subject and body
$subject = "Password Reset Request";
$message = "Hello,\n\nTo reset your password, click the link below:\n\n$resetLink\n\nThis link will expire in 1 hour.\n\nBest regards,\nYour Website";

// Send the email (this is a simple example, you might want to use a library like PHPMailer)
mail($email, $subject, $message);

$_SESSION['success'] = 'Password reset link sent to your email.';
header('Location: /login.php');
exit();
?>
