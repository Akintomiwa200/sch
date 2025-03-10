<?php
// index.php - The new homepage of your website
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to OpenLearn</title>

    <!-- Add any CSS libraries or custom styles for the homepage -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation bar for the homepage -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">OpenLearn</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="courses.php">Courses</a>
                    </li>
                    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Account
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- If the user is logged in -->
            <li><a class="dropdown-item" href="profile.php">Profile</a></li> <!-- Profile link -->
            <li><a class="dropdown-item" href="logout.php">Logout</a></li> <!-- Logout link -->
        <?php else: ?>
            <!-- If the user is not logged in -->
            <li><a class="dropdown-item" href="login.php">Login</a></li> <!-- Login link -->
            <li><a class="dropdown-item" href="signup.php">Sign Up</a></li> <!-- Sign up link -->
        <?php endif; ?>
    </ul>
</li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content area for the homepage -->
    <div class="container mt-5">
        <div class="text-center">
            <h1>Welcome to OpenLearn!</h1>
            <p>Your path to free online courses. Explore thousands of courses and become an expert!</p>
            <a href="courses.php" class="btn btn-primary">Browse Courses</a>
        </div>

        <!-- Featured Courses Section -->
        <div class="mt-5">
            <h2 class="text-center">Featured Courses</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/course1.jpg" class="card-img-top" alt="Course 1">
                        <div class="card-body">
                            <h5 class="card-title">Course Title 1</h5>
                            <p class="card-text">Short description of Course 1.</p>
                            <a href="view-course.php?course_id=1" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/course2.jpg" class="card-img-top" alt="Course 2">
                        <div class="card-body">
                            <h5 class="card-title">Course Title 2</h5>
                            <p class="card-text">Short description of Course 2.</p>
                            <a href="view-course.php?course_id=2" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/course3.jpg" class="card-img-top" alt="Course 3">
                        <div class="card-body">
                            <h5 class="card-title">Course Title 3</h5>
                            <p class="card-text">Short description of Course 3.</p>
                            <a href="view-course.php?course_id=3" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Categories Section -->
        <div class="mt-5">
            <h2 class="text-center">Browse by Course Category</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <img src="images/category1.jpg" class="card-img-top" alt="Category 1">
                        <div class="card-body">
                            <h5 class="card-title">Technology</h5>
                            <a href="courses.php?category=technology" class="btn btn-secondary">View Courses</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="images/category2.jpg" class="card-img-top" alt="Category 2">
                        <div class="card-body">
                            <h5 class="card-title">Business</h5>
                            <a href="courses.php?category=business" class="btn btn-secondary">View Courses</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="images/category3.jpg" class="card-img-top" alt="Category 3">
                        <div class="card-body">
                            <h5 class="card-title">Health</h5>
                            <a href="courses.php?category=health" class="btn btn-secondary">View Courses</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="images/category4.jpg" class="card-img-top" alt="Category 4">
                        <div class="card-body">
                            <h5 class="card-title">Arts</h5>
                            <a href="courses.php?category=arts" class="btn btn-secondary">View Courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div class="mt-5">
            <h2 class="text-center">What Our Students Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">"OpenLearn has transformed my learning experience!"</p>
                            <footer class="blockquote-footer">Student Name 1</footer>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">"I love the variety of courses available!"</p>
                            <footer class="blockquote-footer">Student Name 2</footer>
                        </div>                
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">"The instructors are knowledgeable and supportive!"</p>
                            <footer class="blockquote-footer">Student Name 3</footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-5">
            <h2 class="text-center">Frequently Asked Questions (FAQ)</h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                            What courses are available on OpenLearn?
                        </button>
                    </h2>
                    <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            OpenLearn offers courses in various categories, including Technology, Business, Health, Arts, and more.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                            How can I sign up for a course?
                        </button>
                    </h2>
                    <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You can sign up for any course by clicking on the "Enroll Now" button on the course page.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqThree">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                            Are the courses free?
                        </button>
                    </h2>
                    <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, all courses on OpenLearn are completely free to access and complete.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="mt-5 text-center">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Stay updated with new courses and news by subscribing to our newsletter.</p>
            <form class="form-inline justify-content-center">
                <input type="email" class="form-control mb-2 mr-sm-2" id="newsletterEmail" placeholder="Enter your email">
                <button type="submit" class="btn btn-info mb-2">Subscribe</button>
            </form>
        </div>

        <!-- Call to Action Section -->
        <div class="mt-5 text-center">
            <h2>Join Us Today!</h2>
            <p>Sign up now to start your learning journey with OpenLearn.</p>
            <a href="signup.php" class="btn btn-success btn-lg">Create an Account</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-3">
        <div class="container text-center">
            <p>&copy; 2025 OpenLearn. All Rights Reserved.</p>
            <p>
                <a href="privacy.php" class="text-white">Privacy Policy</a> | 
                <a href="terms.php" class="text-white">Terms of Service</a>
            </p>
        </div>
    </footer>

    <!-- Add Bootstrap JS and any other scripts you need -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
