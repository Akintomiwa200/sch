<?php
session_start();

// Destroy session and logout the user
session_unset();
session_destroy();

// Redirect to login page
header("Location: /login.php");
exit();
