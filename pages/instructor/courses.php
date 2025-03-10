<?php
session_start();
require_once __DIR__ . '/../../config.php';  // Include the database connection

// Check if the user is logged in and if they are an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') {
    header('Location: /login.php');
    exit();
}


if (isset($_POST['add_course'])) {
    $course_name = trim($_POST['course_name']);
    $course_info = trim($_POST['course_info']);

    // Check if course name and description are not empty
    if (!empty($course_name) && !empty($course_info)) {
        $stmt = $link->prepare("INSERT INTO courses (course_name, course_info) VALUES (?, ?)");
        $stmt->bind_param("ss", $course_name, $course_info);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Course added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add course. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Course name and description cannot be empty!";
    }
}

// Fetch all courses (with search if applicable)
$search = $_GET['search'] ?? '';
if ($search !== '') {
    $stmt = $link->prepare("SELECT * FROM courses WHERE course_name LIKE ? OR course_info LIKE ?");
    $searchParam = '%' . $search . '%';
    $stmt->bind_param("ss", $searchParam, $searchParam);
} else {
    $stmt = $link->prepare("SELECT * FROM courses"); // Remove the instructor_id filter
}
$stmt->execute();
$courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include '../../partials/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include '../../includes/sidebar.php'; ?>
            <div class="col-md-9 col-lg-10 p-4">
                <h3>All Courses</h3>

                <!-- Add Course Button -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add Course</button>

                <!-- Search form -->
                <form method="get" action="courses.php" class="mb-3">
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
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCourseModal" data-id="<?= $course['course_id'] ?>" data-name="<?= htmlspecialchars($course['course_name']) ?>" data-description="<?= htmlspecialchars($course['course_info']) ?>">Edit</button>
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewCourseModal" data-id="<?= $course['course_id'] ?>" data-name="<?= htmlspecialchars($course['course_name']) ?>" data-description="<?= htmlspecialchars($course['course_info']) ?>">View</button>
                                        <a href="delete-course.php?id=<?= $course['course_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No courses found. Please create a new course.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal for Add Course -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Course Form -->
                <form method="post" action="courses.php">
                    <div class="mb-3">
                        <label for="courseName" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="courseName" name="course_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="courseDescription" class="form-label">Course Description</label>
                        <textarea class="form-control" id="courseDescription" name="course_info" required></textarea>
                    </div>
                    <button type="submit" name="add_course" class="btn btn-primary">Add Course</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Modal for Edit Course -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="courses.php">
                        <div class="mb-3">
                            <label for="editCourseName" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="editCourseName" name="course_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCourseDescription" class="form-label">Course Description</label>
                            <textarea class="form-control" id="editCourseDescription" name="course_info" required></textarea>
                        </div>
                        <input type="hidden" name="course_id" id="editCourseId">
                        <button type="submit" name="edit_course" class="btn btn-primary">Save Changes</button>
                    </form>
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
        // Fill Edit Modal with course data
        const editModal = document.getElementById('editCourseModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const courseId = button.getAttribute('data-id');
            const courseName = button.getAttribute('data-name');
            const courseDescription = button.getAttribute('data-description');
            
            document.getElementById('editCourseId').value = courseId;
            document.getElementById('editCourseName').value = courseName;
            document.getElementById('editCourseDescription').value = courseDescription;
        });

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
