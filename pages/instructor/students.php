<?php
session_start();
require_once __DIR__ . '/../../config.php';

// Check if the user is logged in and if they are an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') {
    header('Location: /login.php');
    exit();
}

// Fetch all students
$stmt = $link->prepare("SELECT id, name, email FROM students");
$stmt->execute();
$students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Handle search query if exists
$search = $_GET['search'] ?? '';
if ($search !== '') {
    $stmt = $link->prepare("SELECT id, name, email FROM students WHERE name LIKE ? OR email LIKE ?");
    $searchParam = '%' . $search . '%';
    $stmt->bind_param("ss", $searchParam, $searchParam);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Handling Add Student
if (isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $link->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Student added successfully.';
    } else {
        $_SESSION['error'] = 'Error adding student.';
    }
    header("Location: students.php");
    exit();
}

// Handling Edit Student
if (isset($_POST['edit_student'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $link->prepare("UPDATE students SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $student_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Student updated successfully.';
    } else {
        $_SESSION['error'] = 'Error updating student.';
    }
    header("Location: students.php");
    exit();
}

// Handling Delete Student
if (isset($_GET['delete_student'])) {
    $student_id = $_GET['delete_student'];

    $stmt = $link->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Student deleted successfully.';
    } else {
        $_SESSION['error'] = 'Error deleting student.';
    }
    header("Location: students.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include '../../partials/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
        
        <?php include '../../includes/sidebar.php'; ?>
        
            <div class="col-md-9 col-lg-10 p-4">
                <h3>Your Students</h3>

                <!-- Add Student Button -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>

                <!-- Search form -->
                <form method="get" action="students.php" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or email">
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

                <!-- Table of students -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($students) > 0): ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['name']) ?></td>
                                    <td><?= htmlspecialchars($student['email']) ?></td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editStudentModal" data-id="<?= $student['id'] ?>" data-name="<?= $student['name'] ?>" data-email="<?= $student['email'] ?>">Edit</button>

                                        <!-- Delete Button -->
                                        <a href="students.php?delete_student=<?= $student['id'] ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No students found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Add Student -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="students.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" name="add_student" class="btn btn-primary">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Student -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="students.php">
                        <input type="hidden" id="editStudentId" name="student_id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <button type="submit" name="edit_student" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fill Edit Modal with student data
        var editModal = document.getElementById('editStudentModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var studentId = button.getAttribute('data-id');
            var studentName = button.getAttribute('data-name');
            var studentEmail = button.getAttribute('data-email');

            var modal = editModal.querySelector('form');
            modal.querySelector('#editStudentId').value = studentId;
            modal.querySelector('#editName').value = studentName;
            modal.querySelector('#editEmail').value = studentEmail;
        });
    </script>
</body>
</html>
