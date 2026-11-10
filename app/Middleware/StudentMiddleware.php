<?php
// app/Middleware/StudentMiddleware.php

namespace App\Middleware;

class StudentMiddleware {
    
    public static function handle() {
        // Check if logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        
        // Check if role is Student (Role ID: 4)
        if ($_SESSION['role_id'] !== 4) {
            http_response_code(403);
            require_once __DIR__ . '/../../resources/views/errors/403.php';
            exit;
        }
    }
}
