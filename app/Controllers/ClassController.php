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

    public function edit() {
        AuthMiddleware::adminOnly();
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('admin/classes');

        $model = new SchoolClass();
        $class = $model->find($id);

        if (!$class) redirect('admin/classes');

        view('admin.classes.edit', ['class' => $class]);
    }

    public function update() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('admin/classes');

        $model = new SchoolClass();
        $success = $model->update($id, $_POST);

        if ($success) {
            $_SESSION['success'] = "Class updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update class.";
        }
        redirect('admin/classes');
    }

    public function manageSubjects() {
        AuthMiddleware::adminOnly();
        
        $classId = $_GET['id'] ?? null;
        if (!$classId) {
            redirect('admin/classes');
        }

        $classModel = new SchoolClass();
        
        $classes = $classModel->all();
        $currentClass = null;
        foreach ($classes as $c) {
            if ($c['id'] == $classId) {
                $currentClass = $c;
                break;
            }
        }

        if (!$currentClass) {
            redirect('admin/classes');
        }

        $allSubjects = $classModel->getAllSubjects();
        $assignedSubjects = $classModel->getAssignedSubjects($classId);

        view('admin.classes.subjects', [
            'class' => $currentClass,
            'allSubjects' => $allSubjects,
            'assignedSubjects' => $assignedSubjects
        ]);
    }

    public function updateSubjects() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $classId = $_GET['id'] ?? null;
        if (!$classId) {
            redirect('admin/classes');
        }

        $subjectIds = $_POST['subjects'] ?? []; 
        
        $classModel = new SchoolClass();
        $classModel->syncSubjects($classId, $subjectIds);

        $_SESSION['success'] = "Subjects updated for this class successfully!";
        redirect('admin/classes');
    }
}
