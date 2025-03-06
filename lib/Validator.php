<?php
class Validator {
    public static function email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function password($password) {
        return strlen($password) >= 8;
    }

    public static function sanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}