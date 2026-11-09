<?php
// app/Controllers/TeacherController.php

namespace App\Controllers;

use App\Models\Teacher;
use App\Middleware\AuthMiddleware;

class TeacherController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $teacherModel = new Teacher();
        $teachers = $teacherModel->all();
        view('admin.teachers.index', ['teachers' => $teachers]);
    }

    public function create() {
        AuthMiddleware::adminOnly();
        view('admin.teachers.create');
    }

    public function store() {
        AuthMiddleware::adminOnly();
        
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $required = ['staff_id', 'first_name', 'last_name', 'email', 'phone', 'gender', 'qualification'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = "All fields are required.";
                redirect('admin/teachers/create');
            }
        }

        $teacherModel = new Teacher();
        $success = $teacherModel->create($_POST);

        if ($success) {
            $_SESSION['success'] = "Teacher registered successfully! Default password is 'password123'.";
            redirect('admin/teachers');
        } else {
            $_SESSION['error'] = "Failed to register teacher. Email or Staff ID might already exist.";
            redirect('admin/teachers/create');
        }
    }

    public function edit() {
        AuthMiddleware::adminOnly();
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('admin/teachers');

        $model = new Teacher();
        $teacher = $model->find($id);

        if (!$teacher) redirect('admin/teachers');

        view('admin.teachers.edit', ['teacher' => $teacher]);
    }

    public function update() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('admin/teachers');

        $model = new Teacher();
        $success = $model->update($id, $_POST);

        if ($success) {
            $_SESSION['success'] = "Teacher updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update teacher.";
        }
        redirect('admin/teachers');
    }

    public function destroy() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('admin/teachers');

        $model = new Teacher();
        $success = $model->delete($id);

        if ($success) {
            $_SESSION['success'] = "Teacher deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete teacher.";
        }
        redirect('admin/teachers');
    }
}
