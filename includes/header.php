<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'OpenLearn - Free Online Courses' ?></title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/main.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">OpenLearn</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if(isset($_SESSION['instructor'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/instructor/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/processes/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <button class="btn btn-outline-light" onclick="Auth.showAuthModal('login')">Instructor Login</button>
                        </li>
                        <li class="nav-item ml-2">
                            <button class="btn btn-primary" onclick="Auth.showAuthModal('register')">Become Instructor</button>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Auth Modal (Same as previous implementation) -->
    <?php include 'auth_modal.php'; ?>

    <!-- Add jQuery and Bootstrap JS here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> <!-- Ensure Bootstrap JS is loaded -->
    <script src="/js/auth.js"></script> <!-- Your custom JS -->
</body>
</html>
