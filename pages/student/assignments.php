<?php
session_start();  // Always start the session at the beginning

// Check if the user is logged in and if they are an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: /login.php');
    exit();
}
require_once __DIR__ . '/../../config.php';  // Include database connection

// Get the logged-in user's ID (student)
$user_id = $_SESSION['id'];  // Get the user ID from the session

// Get all assignments for the logged-in student
$stmt = $link->prepare("SELECT a.assignment_id, a.title, a.description, a.due_date, a.status, c.course_name
                        FROM assignments a
                        JOIN courses c ON a.course_id = c.course_id
                        WHERE a.user_id = ?");  // Assuming 'user_id' is used in assignments table
$stmt->bind_param("i", $user_id);  // Bind the user ID to the query
$stmt->execute();
$result = $stmt->get_result();

// Fetch all the assignments for the student
$assignments = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
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
            <h3>Your Assignments</h3>

            <?php if (count($assignments) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Assignment</th>
                                <th>Description</th>
                                <th>Course</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($assignments as $assignment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($assignment['title']) ?></td>
                                    <td><?= htmlspecialchars($assignment['description']) ?></td>
                                    <td><?= htmlspecialchars($assignment['course_name']) ?></td>
                                    <td><?= date('F j, Y', strtotime($assignment['due_date'])) ?></td>
                                    <td><?= ucfirst($assignment['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>You do not have any assignments at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include '../../partials/footer.php'; ?>

<!-- Include JS libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
