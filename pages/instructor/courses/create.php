<?php
// Include necessary files
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/navbar.php';

// Check if the user is logged in and is an instructor
if (!isInstructorLoggedIn()) {
    header('Location: /pages/public/courses.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and save course data (example)
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    // Save course to the database (pseudo-code)
    // saveCourse($name, $description);

    // Redirect to course management page
    header('Location: /pages/instructor/courses/manage.php');
    exit();
}
?>

<!-- Course Creation Form -->
<div class="container">
    <h1>Create a New Course</h1>
    <form method="POST" action="/pages/instructor/courses/create.php">
        <div class="form-group">
            <label for="name">Course Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Course Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Course</button>
    </form>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>