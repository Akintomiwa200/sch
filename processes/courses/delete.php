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
$courseId = $validator->validateNumber($_GET['id'] ?? '');

if (!$courseId) {
    $_SESSION['error'] = 'Invalid course ID.';
    header('Location: /pages/instructor/courses/manage.php');
    exit();
}

// Delete course from the database
$stmt = $conn->prepare("DELETE FROM courses WHERE id = ? AND instructor_id = ?");
$stmt->bind_param("ii", $courseId, $_SESSION['user_id']);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Course deleted successfully.';
} else {
    $_SESSION['error'] = 'Course deletion failed.';
}
header('Location: /pages/instructor/courses/manage.php');
exit();
?>