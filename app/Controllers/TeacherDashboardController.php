<?php
// app/Controllers/TeacherDashboardController.php

namespace App\Controllers;

use App\Middleware\TeacherMiddleware;

class TeacherDashboardController {
    
    public function index() {
        TeacherMiddleware::handle();
        view('teacher.dashboard');
    }
}
