<?php
/**
 * Authentication Middleware Handler
 * Provides role-based access control and CSRF protection
 */
class AuthMiddleware {
    /**
     * Verify Instructor Authentication
     * @throws Exception
     */
    public static function verifyInstructor() {
        self::verifyAuth('instructor');
    }

    /**
     * Verify Student Authentication
     * @throws Exception
     */
    public static function verifyStudent() {
        self::verifyAuth('student');
    }

    /**
     * Verify Admin Authentication
     * @throws Exception
     */
    public static function verifyAdmin() {
        self::verifyAuth('admin');
    }

    /**
     * Generic Authentication Check
     * @param string $role
     * @throws Exception
     */
    private static function verifyAuth($role) {
        self::startSession();
        
        if (empty($_SESSION["{$role}_id"]) || empty($_SESSION["{$role}_email"])) {
            self::redirect("/login.php?required_role=$role");
        }
    }

    /**
     * CSRF Token Validation
     * @throws Exception
     */
    public static function checkCSRFToken() {
        self::startSession();
        
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || !hash_equals($_SESSION['csrf_token'], $token)) {
            throw new Exception('CSRF token validation failed');
        }
    }

    /**
     * Generate and Store CSRF Token
     * @return string
     */
    public static function generateCSRFToken() {
        self::startSession();
        
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Initialize Session
     */
    private static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Redirect Helper
     * @param string $url
     */
    private static function redirect($url) {
        header("Location: $url");
        exit();
    }
}