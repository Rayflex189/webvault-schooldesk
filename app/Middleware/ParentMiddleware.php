<?php
// app/Middleware/ParentMiddleware.php

namespace App\Middleware;

class ParentMiddleware {
    
    public static function handle() {
        // Check if logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        
        // Check if role is Parent (Role ID: 3)
        if ($_SESSION['role_id'] !== 3) {
            http_response_code(403);
            die("403 - Unauthorized Access. This area is for parents only.");
        }
    }
}
