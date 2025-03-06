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

// Fetch list of students (example)
$students = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com']
]; // Replace with actual database query
?>

<!-- Student List Content -->
<div class="container">
    <h1>Student List</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['id']); ?></td>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>