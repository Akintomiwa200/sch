<?php
// Ensure that the session is started
session_start();
?>

<!-- Navigation Bar for Instructor Dashboard -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Instructor Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="dashboard.php">
                        <i class="fa fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="courses.php">
                        <i class="fa fa-book"></i> Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="students.php">
                        <i class="fa fa-users"></i> Students
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="profile.php">
                        <i class="fa fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
