<?php
// routes/web.php

use App\Controllers\AuthController;
use App\Controllers\StudentController;
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
        AuthMiddleware::adminOnly();
        view('admin.dashboard');
    },
    
    // Student Management Routes
    'admin/students' => function() {
        $controller = new StudentController();
        $controller->index();
    }
];
