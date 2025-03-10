<?php
session_start();  // Ensure session is started

// Check if the user is logged in and if they are a student
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: /login.php');  // Redirect to login if not logged in or not a student
    exit();
}

require_once __DIR__ . '/../../config.php';  // Include the database connection

// Get student's enrolled courses and statistics
$stmt = $link->prepare("SELECT c.*, e.enrollment_date, e.status
                        FROM courses c
                        JOIN enrollments e ON c.course_id = e.course_id
                        WHERE e.student_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get total enrollments and courses
$totalEnrollments = count($courses);
$totalCourses = $totalEnrollments; // Since this is the number of courses they are enrolled in

// Get upcoming course information (if any)
$upcomingCourse = null;
foreach ($courses as $course) {
    if ($course['status'] === 'enrolled' && (empty($upcomingCourse) || strtotime($course['enrollment_date']) < strtotime($upcomingCourse['enrollment_date']))) {
        $upcomingCourse = $course;  // Find the first upcoming course
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<!-- Navbar -->
<?php include '../../partials/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/studentsidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h3>Welcome, <?= htmlspecialchars($_SESSION['user_role']) ?>!</h3>
            <div class="row">
                <!-- Total Courses Card -->
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Enrolled Courses</h5>
                            <p class="card-text"><?= $totalCourses ?></p>
                        </div>
                    </div>
                </div>
                <!-- Upcoming Course Card -->
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Upcoming Course</h5>
                            <p class="card-text"><?= $upcomingCourse ? htmlspecialchars($upcomingCourse['course_name']) : 'No upcoming courses' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h4>Your Enrolled Courses</h4>
            <div class="row">
                <?php if ($totalCourses > 0): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['course_name']) ?></h5>
                                    <p class="card-text">Enrollment Status: <?= htmlspecialchars($course['status']) ?></p>
                                    <p class="card-text">Enrolled on: <?= date('F j, Y', strtotime($course['enrollment_date'])) ?></p>
                                    <a href="view-course.php?id=<?= $course['course_id'] ?>" class="btn btn-info">View Course</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You are not enrolled in any courses yet. Browse and enroll in your courses!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include '../../partials/footer.php'; ?>

<!-- Include JS libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

