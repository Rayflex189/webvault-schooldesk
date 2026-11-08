<?php
// app/Controllers/StudentController.php

namespace App\Controllers;

use App\Models\Student;
use App\Middleware\AuthMiddleware;

class StudentController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $studentModel = new Student();
        $students = $studentModel->all();
        view('admin.students.index', ['students' => $students]);
    }

    public function create() {
        AuthMiddleware::adminOnly();
        $studentModel = new Student();
        $classes = $studentModel->getClasses();
        view('admin.students.create', ['classes' => $classes]);
    }

    public function store() {
        AuthMiddleware::adminOnly();
        
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $required = ['admission_number', 'first_name', 'last_name', 'gender', 'dob', 'class_id'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = "All fields are required.";
                redirect('admin/students/create');
            }
        }

        $studentModel = new Student();
        $success = $studentModel->create($_POST);

        if ($success) {
            $_SESSION['success'] = "Student added successfully!";
            redirect('admin/students');
        } else {
            $_SESSION['error'] = "Failed to add student.";
            redirect('admin/students/create');
        }
    }
}
