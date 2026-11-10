<?php
// app/Middleware/AuthMiddleware.php

namespace App\Middleware;

class AuthMiddleware {
    
    /**
     * Ensure the user is logged in
     */
    public static function handle() {
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
    }

    /**
     * Ensure the user is an Admin (Role ID: 1)
     */
    public static function adminOnly() {
        self::handle();
        
        if ($_SESSION['role_id'] !== 1) {
            http_response_code(403);
            require_once __DIR__ . '/../../resources/views/errors/403.php';
            exit;
        }
    }
}
