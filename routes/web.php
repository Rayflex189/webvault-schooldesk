<?php
// routes/web.php

use App\Controllers\AuthController;
use App\Middleware\AuthMiddleware;

return [
    // Public Routes
    '/' => function() {
        redirect('login');
    },
    'login' => function() {
        $auth = new AuthController();
        $auth->login();
    },
    'logout' => function() {
        $auth = new AuthController();
        $auth->logout();
    },

    // Protected Admin Routes
    'admin/dashboard' => function() {
        // Enforce authentication and admin role
        AuthMiddleware::adminOnly();
        
        // Render dashboard
        view('admin.dashboard');
    }
];
