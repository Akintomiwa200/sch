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

// Check if course ID is provided
if (!isset($_GET['id'])) {
    header('Location: /pages/instructor/courses/manage.php');
    exit();
}

$courseId = $_GET['id'];

// Fetch course details from the database (example)
$course = [
    'id' => $courseId,
    'name' => 'Introduction to PHP',
    'description' => 'Learn the basics of PHP programming.'
]; // Replace with actual database query

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and update course data (example)
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    // Update course in the database (pseudo-code)
    // updateCourse($courseId, $name, $description);

    // Redirect to course management page
    header('Location: /pages/instructor/courses/manage.php');
    exit();
}
?>

<!-- Course Edit Form -->
<div class="container">
    <h1>Edit Course</h1>
    <form method="POST" action="/pages/instructor/courses/edit.php?id=<?php echo $courseId; ?>">
        <div class="form-group">
            <label for="name">Course Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($course['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Course Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required><?php echo htmlspecialchars($course['description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>