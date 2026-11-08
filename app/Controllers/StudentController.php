<?php
// app/Controllers/StudentController.php

namespace App\Controllers;

use App\Models\Student;
use App\Middleware\AuthMiddleware;

class StudentController {
    
    public function index() {
        // Security: Ensure only admins can view this page
        AuthMiddleware::adminOnly();

        // Fetch data from the Model
        $studentModel = new Student();
        $students = $studentModel->all();

        // Pass the data to the View
        view('admin.students.index', [
            'students' => $students
        ]);
    }
}
