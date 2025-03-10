<?php
session_start();  // Ensure session is started

// Check if the user is logged in and if they are an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') {
    header('Location: /login.php');  // Redirect to login if not logged in or not an instructor
    exit();
}

require_once __DIR__ . '/../../config.php';  // Include the database connection

// Function to fetch instructor's courses and statistics
function getInstructorCourses($link, $user_id) {
    $stmt = $link->prepare("SELECT c.*, COUNT(e.enrollment_id) AS enrollments 
                            FROM courses c
                            LEFT JOIN enrollments e ON c.course_id = e.course_id
                            WHERE c.instructor_id = ?
                            GROUP BY c.course_id");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Fetch the data on initial load
$courses = getInstructorCourses($link, $_SESSION['user_id']);

// Get total enrollments and courses
$totalEnrollments = array_sum(array_column($courses, 'enrollments'));
$totalCourses = count($courses);

// Upcoming course logic (optional)
$upcomingCourse = !empty($courses) ? $courses[0]['course_name'] : 'No upcoming courses';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<!-- Navbar -->
<?php include '../../partials/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h3>Welcome, <?= htmlspecialchars($_SESSION['user_role']) ?>!</h3>
            <div class="row" id="dashboard-cards">
                <!-- Total Courses Card -->
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Courses</h5>
                            <p class="card-text" id="total-courses"><?= $totalCourses ?></p>
                        </div>
                    </div>
                </div>
                <!-- Total Enrollments Card -->
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Enrollments</h5>
                            <p class="card-text" id="total-enrollments"><?= $totalEnrollments ?></p>
                        </div>
                    </div>
                </div>
                <!-- Upcoming Course Card -->
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Upcoming Course</h5>
                            <p class="card-text" id="upcoming-course"><?= $upcomingCourse ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h4>Your Courses</h4>
            <div class="row" id="courses-list">
                <?php if ($totalCourses > 0): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['course_name']) ?></h5>
                                    <p class="card-text">Enrollments: <?= $course['enrollments'] ?></p>
                                    <a href="edit-course.php?id=<?= $course['course_id'] ?>" class="btn btn-primary">Edit</a>
                                    <a href="view-course.php?id=<?= $course['course_id'] ?>" class="btn btn-info">View</a>
                                    <a href="delete-course.php?id=<?= $course['course_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No courses available yet. Create your first course!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include '../../partials/footer.php'; ?>

<!-- Include JS libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>
// JavaScript to fetch real-time data via AJAX
// JavaScript to fetch real-time data via AJAX
function fetchDashboardData() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "get_instructor_data.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);

            // Update dashboard cards
            document.getElementById('total-courses').innerText = data.totalCourses;
            document.getElementById('total-enrollments').innerText = data.totalEnrollments;
            document.getElementById('upcoming-course').innerText = data.upcomingCourse;

            // Update courses list
            const coursesList = document.getElementById('courses-list');
            coursesList.innerHTML = '';
            data.courses.forEach(course => {
                const courseCard = `
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">${course.course_name}</h5>
                                <p class="card-text">Instructor: ${course.instructor_name}</p>
                                <p class="card-text">Enrollments: ${course.enrollments}</p>
                                <a href="edit-course.php?id=${course.course_id}" class="btn btn-primary">Edit</a>
                                <a href="view-course.php?id=${course.course_id}" class="btn btn-info">View</a>
                                <a href="delete-course.php?id=${course.course_id}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                            </div>
                        </div>
                    </div>
                `;
                coursesList.innerHTML += courseCard;
            });
        }
    };
    xhr.send();
}

// Fetch data every 30 seconds
setInterval(fetchDashboardData, 30000); // 30000ms = 30 seconds
fetchDashboardData(); // Initial fetch on page load
</script>

</body>
</html>
