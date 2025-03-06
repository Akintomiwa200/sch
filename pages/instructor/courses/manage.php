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

// Fetch courses created by the instructor (example)
$courses = [
    ['id' => 1, 'name' => 'Introduction to PHP', 'description' => 'Learn the basics of PHP programming.'],
    ['id' => 2, 'name' => 'Advanced JavaScript', 'description' => 'Master advanced JavaScript concepts.']
]; // Replace with actual database query
?>

<!-- Course Management Content -->
<div class="container">
    <h1>Manage Your Courses</h1>
    <a href="/pages/instructor/courses/create.php" class="btn btn-primary mb-3">Create New Course</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['id']); ?></td>
                    <td><?php echo htmlspecialchars($course['name']); ?></td>
                    <td><?php echo htmlspecialchars($course['description']); ?></td>
                    <td>
                        <a href="/pages/instructor/courses/edit.php?id=<?php echo $course['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/processes/courses/delete.php?id=<?php echo $course['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>