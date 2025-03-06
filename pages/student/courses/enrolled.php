<?php
// Include necessary files
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/navbar.php';

// Check if the user is logged in and is a student
if (!isStudentLoggedIn()) {
    header('Location: /pages/public/courses.php');
    exit();
}

// Fetch enrolled courses for the student (example)
$enrolledCourses = [
    ['id' => 1, 'name' => 'Introduction to PHP', 'progress' => 50],
    ['id' => 2, 'name' => 'Advanced JavaScript', 'progress' => 30]
]; // Replace with actual database query
?>

<!-- Enrolled Courses Content -->
<div class="container">
    <h1>Your Enrolled Courses</h1>
    <div class="row">
        <?php foreach ($enrolledCourses as $course): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($course['name']); ?></h5>
                        <p><strong>Progress:</strong> <?php echo htmlspecialchars($course['progress']); ?>%</p>
                        <a href="/pages/public/course-view.php?id=<?php echo $course['id']; ?>" class="btn btn-primary">Continue Learning</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>