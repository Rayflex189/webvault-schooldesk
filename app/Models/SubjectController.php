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
            $_SESSION['success'] = "Student added successfully! Default password is 'password123'.";
            redirect('admin/students');
        } else {
            $_SESSION['error'] = "Failed to add student. Admission number might already exist.";
            redirect('admin/students/create');
        }
    }

    public function edit() {
        AuthMiddleware::adminOnly();
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('admin/students');

        $model = new Student();
        $student = $model->find($id);
        $classes = $model->getClasses();

        view('admin.students.edit', ['student' => $student, 'classes' => $classes]);
    }

    public function update() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('admin/students');

        $model = new Student();
        $success = $model->update($id, $_POST);

        if ($success) {
            $_SESSION['success'] = "Student updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update student.";
        }
        redirect('admin/students');
    }

    public function destroy() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('admin/students');

        $model = new Student();
        $success = $model->delete($id);

        if ($success) {
            $_SESSION['success'] = "Student deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete student.";
        }
        redirect('admin/students');
    }
}
