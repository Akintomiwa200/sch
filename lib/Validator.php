<?php
// lib/Validator.php

class Validator {



 // Validate name (e.g., only allow alphabetic characters and spaces)
 public function validateName($name) {
    // Check if name is not empty and contains only letters and spaces
    if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
        return false; // Invalid name
    }
    return $name; // Return validated name
}

    // Validate email format
    public function validateEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        } else {
            return false; // Invalid email
        }
    }

    // Validate password (simple length check for example)
    public function validatePassword($password) {
        if (strlen($password) >= 6) {
            return $password;
        } else {
            return false; // Invalid password
        }
    }


    public function validateRole($role) {
        $validRoles = ['student', 'instructor']; // Define valid roles
        if (empty($role) || !in_array($role, $validRoles)) {
            return false; // Invalid role
        }
        return $role; // Return validated role
    }
    
}
?>
