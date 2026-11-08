<?php
// app/Controllers/ClassController.php

namespace App\Controllers;

use App\Models\SchoolClass;
use App\Middleware\AuthMiddleware;

class ClassController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $classModel = new SchoolClass();
        $classes = $classModel->all();
        view('admin.classes.index', ['classes' => $classes]);
    }

    public function create() {
        AuthMiddleware::adminOnly();
        view('admin.classes.create');
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        if (empty($_POST['name']) || empty($_POST['capacity'])) {
            $_SESSION['error'] = "Class name and capacity are required.";
            redirect('admin/classes/create');
        }

        $classModel = new SchoolClass();
        $success = $classModel->create($_POST);

        if ($success) {
            $_SESSION['success'] = "Class created successfully!";
            redirect('admin/classes');
        } else {
            $_SESSION['error'] = "Failed to create class. The name might already exist.";
            redirect('admin/classes/create');
        }
    }
}
