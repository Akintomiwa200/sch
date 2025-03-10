<?php
session_start();
require_once __DIR__ . '/../../config.php';  // Including the database connection
require_once __DIR__ . '/../../lib/Validator.php';

// Check if form is submitted and process the login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate the email and password using the Validator class
    $validator = new Validator();
    $email = $validator->validateEmail($_POST['email'] ?? '');
    $password = $validator->validatePassword($_POST['password'] ?? '');

    // Check if email or password is empty
    if (!$email || !$password) {
        $_SESSION['error'] = 'Invalid email or password.';
        header('Location: /login.php');
        exit();
    }

    // Check if $link (database connection) is valid
    if ($link === null) {
        die("Database connection failed.");
    }

    // Connect to the database and fetch user data
    $stmt = $link->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows === 0) {
        $_SESSION['error'] = 'User not found.';
        header('Location: /login.php');
        exit();
    }

    // Fetch user details
    $user = $result->fetch_assoc();
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Incorrect password.';
        header('Location: /login.php');
        exit();
    }
    

    // Set session variables upon successful login
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];

   
    if ($user['role'] === 'instructor') {
        header('Location: /pages/instructor/dashboard.php');
        exit(); // Make sure to call exit() after header() to prevent further script execution
    } elseif ($user['role'] === 'student') {
        header('Location: /pages/student/dashboard.php');
        exit(); // Again, make sure to exit() after the header redirect
    } else {
        header('Location: /pages/public/courses.php');
        exit();
    }
} 
     else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: /login.php');
    exit();
}
?>
