<?php
// app/Controllers/ParentController.php

namespace App\Controllers;

use App\Models\Guardian;
use App\Middleware\AuthMiddleware;

class ParentController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new Guardian();
        $parents = $model->all();
        view('admin.parents.index', ['parents' => $parents]);
    }

    public function create() {
        AuthMiddleware::adminOnly();
        $model = new Guardian();
        $students = $model->getStudents();
        view('admin.parents.create', ['students' => $students]);
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $required = ['first_name', 'last_name', 'email', 'phone', 'relationship'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = "All fields except linking a student are required.";
                redirect('admin/parents/create');
            }
        }

        $model = new Guardian();
        $success = $model->create($_POST);

        if ($success) {
            $_SESSION['success'] = "Parent registered successfully! Default password is 'password123'.";
            redirect('admin/parents');
        } else {
            $_SESSION['error'] = "Failed to register parent. Email might already exist.";
            redirect('admin/parents/create');
        }
    }
}
