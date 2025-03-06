<?php
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';
require_once __DIR__ . '/../../lib/Validator.php';

// Validate input
$validator = new Validator();
$email = $validator->validateEmail($_POST['email'] ?? '');
$password = $validator->validatePassword($_POST['password'] ?? '');

if (!$email || !$password) {
    $_SESSION['error'] = 'Invalid email or password.';
    header('Location: /pages/public/courses.php');
    exit();
}

// Fetch user from the database
$stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'User not found.';
    header('Location: /pages/public/courses.php');
    exit();
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Incorrect password.';
    header('Location: /pages/public/courses.php');
    exit();
}

// Set session variables
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_role'] = $user['role'];

// Redirect based on role
if ($user['role'] === 'instructor') {
    header('Location: /pages/instructor/dashboard.php');
} elseif ($user['role'] === 'student') {
    header('Location: /pages/student/dashboard.php');
} else {
    header('Location: /pages/public/courses.php');
}
exit();
?>