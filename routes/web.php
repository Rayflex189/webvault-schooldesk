<?php
// routes/web.php

// Return an array of routes
return [
    // URI => [Controller, Method] or Closure
    '/' => function() {
        if (isset($_SESSION['user_id'])) {
            redirect('admin/dashboard');
        }
        redirect('login');
    },
    'login' => function() {
        view('auth.login');
    },
    'admin/dashboard' => function() {
        // This will eventually be handled by an AdminController
        view('admin.dashboard');
    }
];
