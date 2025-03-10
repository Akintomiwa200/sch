<style>
    /* Ensure that the body and HTML take up the full height of the viewport */
    html, body {
        height: 100%;
        margin: 0;
    }

    /* Sidebar to take full height */
    .sidebar {
        height: 100vh; /* 100% of the viewport height */
        position: sticky; /* Optional: this makes the sidebar stay on screen while scrolling */
    }
</style>

<div class="col-md-3 col-lg-2 p-4 bg-light sidebar">
    <h4 class="mb-4">Student Menu</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-dark" href="/pages/student/dashboard.php">
                <i class="fa fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/pages/student/mycourses.php">
                <i class="fa fa-book"></i> My Courses
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/pages/student/assignments.php">
                <i class="fa fa-tasks"></i> Assignments
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/pages/student/grades.php">
                <i class="fa fa-graduation-cap"></i> Grades
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="/pages/student/profile.php">
                <i class="fa fa-user"></i> Profile
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="logout.php">
                <i class="fa fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>
