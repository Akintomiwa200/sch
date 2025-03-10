<?php
session_start();
require_once __DIR__ . '/../../config.php';  // Include the database connection

// Check if the user is logged in and if they are a student
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    // If not a student, redirect to login or error page
    header('Location: /login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user id

// Fetch the student's courses only (if applicable)
$search = $_GET['search'] ?? ''; // Search term for courses

// If there is a search term, search for courses based on name or description
if ($search !== '') {
    $stmt = $link->prepare("SELECT * FROM courses WHERE (course_name LIKE ? OR course_info LIKE ?) AND course_id IN (SELECT course_id FROM enrollments WHERE student_id = ?)");
    $searchParam = '%' . $search . '%';
    $stmt->bind_param("ssi", $searchParam, $searchParam, $user_id); // Use $user_id to filter the enrolled courses
} else {
    $stmt = $link->prepare("SELECT * FROM courses WHERE course_id IN (SELECT course_id FROM enrollments WHERE student_id = ?)");
    $stmt->bind_param("i", $user_id); // Use $user_id to filter the enrolled courses
}

$stmt->execute();
$courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include '../../partials/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include '../../includes/studentsidebar.php'; ?>
            <div class="col-md-9 col-lg-10 p-4">
                <h3>Your Courses</h3>

                <!-- Search form -->
                <form method="get" action="mycourse.php" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by course name or description">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>

                <!-- Display success or error messages -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <!-- Courses List -->
                <div class="row">
                    <?php if (count($courses) > 0): ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($course['course_name']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($course['course_info']) ?></p>
                                        <p class="card-text">Enrollments: <?= $course['enrollments'] ?></p>
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewCourseModal" data-id="<?= $course['course_id'] ?>" data-name="<?= htmlspecialchars($course['course_name']) ?>" data-description="<?= htmlspecialchars($course['course_info']) ?>">View</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>You are not enrolled in any courses. Please contact your instructor or administrator.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for View Course -->
    <div class="modal fade" id="viewCourseModal" tabindex="-1" aria-labelledby="viewCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCourseModalLabel">View Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="viewCourseName" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="viewCourseName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="viewCourseDescription" class="form-label">Course Description</label>
                        <textarea class="form-control" id="viewCourseDescription" disabled></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fill View Modal with course data
        const viewModal = document.getElementById('viewCourseModal');
        viewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const courseName = button.getAttribute('data-name');
            const courseDescription = button.getAttribute('data-description');
            
            document.getElementById('viewCourseName').value = courseName;
            document.getElementById('viewCourseDescription').value = courseDescription;
        });
    </script>
</body>
</html>
