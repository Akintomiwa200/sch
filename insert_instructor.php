<?php
require 'config.php'; // Ensure your database connection is included

// Instructor details
$name = "John Doe";
$email = "user@gmail.com";
$password = "user123"; // Plain text password
$hashed_password = password_hash($password, PASSWORD_BCRYPT); // Securely hash password

// SQL Query to insert data
$query = "INSERT INTO instructors (name, email, password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($link, $query);

// Bind parameters and execute
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo "Instructor added successfully!";
} else {
    echo "Error: " . mysqli_error($link);
}

// Close connection
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
