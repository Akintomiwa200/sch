<?php
session_start();

// Include necessary files
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../lib/Validator.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    header('Location: /pages/public/courses.php');
    exit();
}

// Generate a reset token
$resetToken = bin2hex(random_bytes(32));

// Save the reset token and expiration in the database
$expiryTime = date("Y-m-d H:i:s", strtotime('+1 hour'));
$stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
$stmt->bind_param("sss", $resetToken, $expiryTime, $email);
$stmt->execute();

// Create a reset link with the generated token
$resetLink = "https://yourwebsite.com/pages/public/reset_password.php?token=$resetToken";

// Send the reset link via email using PHPMailer
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.yourdomain.com'; // Set the SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@domain.com'; // SMTP username
    $mail->Password = 'your_password'; // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('your_email@domain.com', 'Your Website');
    $mail->addAddress($email); // Add the user's email address

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body    = "Hello,<br><br>To reset your password, click the link below:<br><br><a href='$resetLink'>$resetLink</a><br><br>This link will expire in 1 hour.<br><br>Best regards,<br>Your Website";

    // Send the email
    $mail->send();

    $_SESSION['success'] = 'Password reset link sent to your email.';
    header('Location: /pages/public/courses.php');
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    header('Location: /pages/public/courses.php');
    exit();
}
?>
