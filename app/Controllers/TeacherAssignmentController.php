<?php
// app/Controllers/TeacherAssignmentController.php

namespace App\Controllers;

use App\Models\TeacherAssignment;
use App\Middleware\AuthMiddleware;

class TeacherAssignmentController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new TeacherAssignment();
        $assignments = $model->all();
        view('admin.assignments.index', ['assignments' => $assignments]);
    }

    public function create() {
        AuthMiddleware::adminOnly();
        $model = new TeacherAssignment();
        
        view('admin.assignments.create', [
            'teachers' => $model->getTeachers(),
            'classes'  => $model->getClasses(),
            'subjects' => $model->getSubjects()
        ]);
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $required = ['teacher_id', 'class_id', 'subject_id'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = "All fields are required.";
                redirect('admin/assignments/create');
            }
        }

        $model = new TeacherAssignment();
        $success = $model->create($_POST);

        if ($success) {
            $_SESSION['success'] = "Teacher assigned successfully!";
            redirect('admin/assignments');
        } else {
            $_SESSION['error'] = "Failed to assign teacher. This exact assignment might already exist.";
            redirect('admin/assignments/create');
        }
    }
}
