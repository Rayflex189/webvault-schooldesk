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
            require_once __DIR__ . '/../../resources/views/errors/403.php';
            exit;
        }
    }
}
