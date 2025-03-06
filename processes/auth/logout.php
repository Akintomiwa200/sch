<?php
session_start();

// Destroy the session
session_destroy();

// Redirect to the homepage
header('Location: /pages/public/courses.php');
exit();
?>