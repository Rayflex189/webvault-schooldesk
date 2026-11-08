<?php
// app/Controllers/TeacherDashboardController.php

namespace App\Controllers;

use App\Middleware\TeacherMiddleware;
use App\Models\TeacherAssignment;

class TeacherDashboardController {
    
    public function index() {
        TeacherMiddleware::handle();
        
        $model = new TeacherAssignment();
        $assignments = $model->getAssignmentsByUserId($_SESSION['user_id']);

        view('teacher.dashboard', [
            'assignments' => $assignments
        ]);
    }
}
