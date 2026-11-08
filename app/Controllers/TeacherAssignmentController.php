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

    public function edit() {
        AuthMiddleware::adminOnly();
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('admin/assignments');

        $model = new TeacherAssignment();
        $assignment = $model->find($id);

        if (!$assignment) redirect('admin/assignments');

        view('admin.assignments.edit', [
            'assignment' => $assignment,
            'teachers'   => $model->getTeachers(),
            'classes'    => $model->getClasses(),
            'subjects'   => $model->getSubjects()
        ]);
    }

    public function update() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('admin/assignments');

        $model = new TeacherAssignment();
        $success = $model->update($id, $_POST);

        if ($success) {
            $_SESSION['success'] = "Assignment updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update assignment.";
        }
        redirect('admin/assignments');
    }

    public function destroy() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('admin/assignments');

        $model = new TeacherAssignment();
        $success = $model->delete($id);

        if ($success) {
            $_SESSION['success'] = "Assignment deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete assignment.";
        }
        redirect('admin/assignments');
    }
}
