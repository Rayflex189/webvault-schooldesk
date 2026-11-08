<?php
// app/Middleware/TeacherMiddleware.php

namespace App\Middleware;

class TeacherMiddleware {
    
    public static function handle() {
        // Check if logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        
        // Check if role is Teacher (Role ID: 2)
        if ($_SESSION['role_id'] !== 2) {
            http_response_code(403);
            die("403 - Unauthorized Access. You are not a teacher.");
        }
    }
}
