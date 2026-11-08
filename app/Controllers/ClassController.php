<?php
// app/Controllers/ClassController.php

namespace App\Controllers;

use App\Models\SchoolClass;
use App\Middleware\AuthMiddleware;

class ClassController {
    
    /**
     * List all classes
     */
    public function index() {
        AuthMiddleware::adminOnly();
        $classModel = new SchoolClass();
        $classes = $classModel->all();
        view('admin.classes.index', ['classes' => $classes]);
    }

    /**
     * Show the create class form
     */
    public function create() {
        AuthMiddleware::adminOnly();
        view('admin.classes.create');
    }

    /**
     * Store a new class in the database
     */
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

    /**
     * Show the form to manage subjects assigned to a specific class
     */
    public function manageSubjects() {
        AuthMiddleware::adminOnly();
        
        // Get class ID from URL query parameter (?id=1)
        $classId = $_GET['id'] ?? null;
        if (!$classId) {
            redirect('admin/classes');
        }

        $classModel = new SchoolClass();
        
        // Find the specific class details
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

    /**
     * Save the subject assignments to the database
     */
    public function updateSubjects() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $classId = $_GET['id'] ?? null;
        if (!$classId) {
            redirect('admin/classes');
        }

        // If no boxes are checked, $_POST['subjects'] won't exist, so default to empty array
        $subjectIds = $_POST['subjects'] ?? []; 
        
        $classModel = new SchoolClass();
        $classModel->syncSubjects($classId, $subjectIds);

        $_SESSION['success'] = "Subjects updated for this class successfully!";
        redirect('admin/classes');
    }
}
