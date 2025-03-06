<?php
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';
require_once __DIR__ . '/../../lib/Validator.php';

// Check if the user is logged in and is an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') {
    header('Location: /pages/public/courses.php');
    exit();
}

// Validate input
$validator = new Validator();
$courseId = $validator->validateNumber($_POST['course_id'] ?? '');
$name = $validator->validateName($_POST['name'] ?? '');
$description = $validator->validateText($_POST['description'] ?? '');

if (!$courseId || !$name || !$description) {
    $_SESSION['error'] = 'Invalid input.';
    header('Location: /pages/instructor/courses/edit.php?id=' . $courseId);
    exit();
}

// Update course in the database
$stmt = $conn->prepare("UPDATE courses SET name = ?, description = ? WHERE id = ? AND instructor_id = ?");
$stmt->bind_param("ssii", $name, $description, $courseId, $_SESSION['user_id']);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Course updated successfully.';
    header('Location: /pages/instructor/courses/manage.php');
} else {
    $_SESSION['error'] = 'Course update failed.';
    header('Location: /pages/instructor/courses/edit.php?id=' . $courseId);
}
exit();
?>