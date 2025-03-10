<?php
session_start();  // Always start the session at the beginning

// Check if the user is logged in and if they are a student
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: /login.php');
    exit();
}

require_once __DIR__ . '/../../config.php';  // Include database connection

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Get all assignments and their corresponding grades for the logged-in student
$stmt = $link->prepare("SELECT a.assignment_id, a.title, a.description, a.due_date, a.status, c.course_name, g.grade 
                       FROM assignments a
                       JOIN courses c ON a.course_id = c.course_id
                       LEFT JOIN grades g ON a.assignment_id = g.assignment_id AND g.user_id = ?
                       WHERE a.user_id = ?");
$stmt->bind_param("ii", $user_id, $user_id);  // Bind the user_id to the query
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
    <title>Your Assignments and Grades</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table-responsive {
            margin-top: 20px;
        }
        .filter-container {
            margin-bottom: 20px;
        }
        .filter-container label {
            font-weight: bold;
        }
        .filter-container select {
            width: auto;
            max-width: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row ">
            <!-- Sidebar -->
            <?php include '../../includes/studentsidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card p-4">
                    <h2 class="mb-4 text-center">Your Assignments and Grades</h2>
                    
                    <!-- Filter by Status -->
                    <div class="filter-container mb-4">
                        <label for="statusFilter">Filter by Status:</label>
                        <select id="statusFilter" class="form-control d-inline-block">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <!-- Assignments Table -->
                    <div id="assignments-table" class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Assignment</th>
                                    <th>Course</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignments as $assignment): ?>
                                    <tr data-status="<?= strtolower($assignment['status']); ?>">
                                        <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                                        <td><?php echo htmlspecialchars($assignment['course_name']); ?></td>
                                        <td><?php echo date('F j, Y', strtotime($assignment['due_date'])); ?></td>
                                        <td><span class="badge badge-<?= strtolower($assignment['status']) === 'completed' ? 'success' : 'warning' ?>"><?= ucfirst($assignment['status']); ?></span></td>
                                        <td><?php echo $assignment['grade'] ?: 'N/A'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // AJAX polling every 5 seconds to update the assignments and grades
        function fetchAssignmentsAndGrades() {
            $.ajax({
                url: 'grades.php',
                method: 'GET',
                success: function(response) {
                    $('#assignments-table').html($(response).find('#assignments-table').html());
                }
            });
        }

        // Set interval to call the function every 5 seconds
        setInterval(fetchAssignmentsAndGrades, 5000);  // Refresh every 5 seconds

        // Handle filter by status
        $('#statusFilter').change(function() {
            var statusFilter = $(this).val().toLowerCase();

            // Show or hide rows based on status
            $('#assignments-table tbody tr').each(function() {
                var rowStatus = $(this).data('status');
                if (statusFilter === '' || rowStatus === statusFilter) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    </script>
</body>
</html>
