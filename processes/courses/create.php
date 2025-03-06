<?php
require_once __DIR__.'/../../config/config.php';
require_once __DIR__.'/../../lib/AuthMiddleware.php';
require_once __DIR__.'/../../lib/CourseManager.php';

// Verify authentication
AuthMiddleware::verifyInstructor();

$courseManager = new CourseManager();
$response = ['success' => false, 'message' => ''];

try {
    $courseData = [
        'title' => Validator::sanitizeInput($_POST['title']),
        'description' => Validator::sanitizeInput($_POST['description']),
        'category' => Validator::sanitizeInput($_POST['category']),
        'instructor_id' => $_SESSION['instructor_id']
    ];

    if ($courseManager->createCourse($courseData)) {
        $response['success'] = true;
        $response['message'] = 'Course created successfully';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);