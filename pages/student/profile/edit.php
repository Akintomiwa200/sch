<?php
// Include necessary files
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

// Check if the user is logged in and is a student
if (!isStudentLoggedIn()) {
    header('Location: /pages/public/courses.php');
    exit();
}

// Fetch student profile data (example)
$studentId = $_SESSION['user_id'];
$studentProfile = [
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'bio' => 'A passionate learner.',
    'avatar' => '/assets/img/uploads/profile/default.png'
]; // Replace with actual database query

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and update profile data (example)
    $name = $_POST['name'] ?? '';
    $bio = $_POST['bio'] ?? '';

    // Update profile in the database (pseudo-code)
    // updateStudentProfile($studentId, $name, $bio);

    // Redirect to profile view page
    header('Location: /pages/student/profile/view.php');
    exit();
}
?>

<!-- Profile Edit Form -->
<div class="container">
    <h1>Edit Your Profile</h1>
    <form method="POST" action="/pages/student/profile/edit.php">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="