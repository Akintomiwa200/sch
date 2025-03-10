<?php
session_start();
require_once __DIR__ . '/../../config.php'; // Make sure this file contains the correct database connection setup

// Ensure the user is logged in and is an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') {
    header('Location: /login.php');
    exit();
}

// Establish database connection (Make sure $link is initialized correctly in your config.php)
if (!$link) {
    die("Connection failed: " . mysqli_connect_error()); // Ensure the $link variable holds a valid MySQLi connection
}

// Function to fetch courses and statistics for all instructors
function getAllInstructorsCourses($link) {
    // Prepare SQL statement
    $stmt = $link->prepare("SELECT c.*, u.name AS instructor_name, COUNT(e.enrollment_id) AS enrollments 
                            FROM courses c
                            LEFT JOIN enrollments e ON c.course_id = e.course_id
                            LEFT JOIN users u ON c.instructor_id = u.id
                            GROUP BY c.course_id");

    // Check if the statement was prepared correctly
    if (!$stmt) {
        die("SQL error: " . $link->error);
    }

    // Execute the prepared statement
    $stmt->execute();

    // Check if execution was successful
    if ($stmt->error) {
        die("Execute error: " . $stmt->error);
    }

    // Fetch the result and return it
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Fetch the data
$courses = getAllInstructorsCourses($link);

// If no courses were found, handle gracefully
if (empty($courses)) {
    echo json_encode([
        'totalCourses' => 0,
        'totalEnrollments' => 0,
        'upcomingCourse' => 'No upcoming courses',
        'courses' => []
    ]);
    exit();
}

// Calculate the total enrollments and the total number of courses
$totalEnrollments = array_sum(array_column($courses, 'enrollments'));
$totalCourses = count($courses);

// Get the upcoming course, or return a default message if no courses
$upcomingCourse = !empty($courses) ? $courses[0]['course_name'] : 'No upcoming courses';

// Return data as JSON
echo json_encode([
    'totalCourses' => $totalCourses,
    'totalEnrollments' => $totalEnrollments,
    'upcomingCourse' => $upcomingCourse,
    'courses' => $courses
]);

?>
