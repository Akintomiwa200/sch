<?php
require '../../includes/auth.php';

if (!isset($_SESSION['instructor'])) {
    header('Location: ../../index.php');
    exit();
}

// Get instructor's courses
$stmt = $pdo->prepare("
    SELECT c.*, COUNT(e.enrollment_id) AS enrollments 
    FROM courses c
    LEFT JOIN enrollments e ON c.course_id = e.course_id
    WHERE c.instructor_id = ?
    GROUP BY c.course_id
");
$stmt->execute([$_SESSION['instructor']['id']]);
$courses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Instructor Dashboard</title>
    <?php include '../../includes/header.php'; ?>
</head>
<body>
    <?php include '../../partials/navbar.php'; ?>
    
    <div class="container">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['instructor']['name']) ?></h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Create New Course</div>
                    <div class="panel-body">
                        <form id="create-course-form">
                            <div class="form-group">
                                <input type="text" class="form-control" name="course_name" placeholder="Course Name" required>
                            </div>
                            <button type="submit" class="btn btn-success">Create Course</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <h3>Your Courses</h3>
                <div id="courses-list">
                    <?php foreach ($courses as $course): ?>
                    <div class="course-card">
                        <h4><?= htmlspecialchars($course['course_name']) ?></h4>
                        <p>Enrollments: <?= $course['enrollments'] ?></p>
                        <div class="course-actions">
                            <a href="edit-course.php?id=<?= $course['course_id'] ?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../../partials/footer.php'; ?>
</body>
</html>