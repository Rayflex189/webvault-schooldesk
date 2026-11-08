<?php
// app/Controllers/SubjectController.php

namespace App\Controllers;

use App\Models\Subject;
use App\Middleware\AuthMiddleware;

class SubjectController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $subjectModel = new Subject();
        $subjects = $subjectModel->all();
        view('admin.subjects.index', ['subjects' => $subjects]);
    }

    public function create() {
        AuthMiddleware::adminOnly();
        view('admin.subjects.create');
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        if (empty($_POST['name']) || empty($_POST['code'])) {
            $_SESSION['error'] = "Subject name and code are required.";
            redirect('admin/subjects/create');
        }

        $subjectModel = new Subject();
        $success = $subjectModel->create($_POST);

        if ($success) {
            $_SESSION['success'] = "Subject added successfully!";
            redirect('admin/subjects');
        } else {
            $_SESSION['error'] = "Failed to add subject. It might already exist.";
            redirect('admin/subjects/create');
        }
    }
}
