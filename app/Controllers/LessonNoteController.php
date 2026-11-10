<?php
// app/Controllers/LessonNoteController.php

namespace App\Controllers;

use App\Middleware\TeacherMiddleware;
use App\Middleware\AuthMiddleware;
use App\Models\LessonNote;
use App\Models\TeacherAssignment;
use Database;

class LessonNoteController {
    
    // ==========================================
    // TEACHER METHODS
    // ==========================================
    
    public function index() {
        TeacherMiddleware::handle();
        $pdo = Database::getInstance();
        
        // Get teacher ID
        $stmt = $pdo->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $teacher = $stmt->fetch();

        $model = new LessonNote();
        $notes = $model->getByTeacher($teacher['id']);

        view('teacher.lesson_notes.index', ['notes' => $notes]);
    }

    public function create() {
        TeacherMiddleware::handle();
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $teacher = $stmt->fetch();

        // Get classes and subjects assigned to this teacher
        $assignmentModel = new TeacherAssignment();
        $assignments = $assignmentModel->getAssignmentsByUserId($_SESSION['user_id']);

        view('teacher.lesson_notes.create', [
            'assignments' => $assignments,
            'teacher_id' => $teacher['id']
        ]);
    }

    public function store() {
        TeacherMiddleware::handle();
        verify_csrf($_POST['csrf_token'] ?? '');

        $settings = get_settings();
        $data = [
            'teacher_id' => $_POST['teacher_id'],
            'class_id'   => $_POST['class_id'],
            'subject_id' => $_POST['subject_id'],
            'term'       => $settings['current_term'],
            'session'    => $settings['current_session'],
            'week_number'=> $_POST['week_number'],
            'title'      => $_POST['title'],
            'content'    => $_POST['content']
        ];

        $model = new LessonNote();
        $model->create($data);

        $_SESSION['success'] = "Lesson note submitted successfully!";
        redirect('teacher/lesson-notes');
    }

    // ==========================================
    // ADMIN METHODS
    // ==========================================

    public function adminIndex() {
        AuthMiddleware::adminOnly();
        $model = new LessonNote();
        $notes = $model->getAll();
        view('admin.lesson_notes.index', ['notes' => $notes]);
    }

    public function review() {
        AuthMiddleware::adminOnly();
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('admin/lesson-notes');

        $model = new LessonNote();
        $note = $model->find($id);

        if (!$note) redirect('admin/lesson-notes');

        // Fetch teacher name for display
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT first_name, last_name FROM teachers WHERE id = ?");
        $stmt->execute([$note['teacher_id']]);
        $teacher = $stmt->fetch();

        view('admin.lesson_notes.review', ['note' => $note, 'teacher' => $teacher]);
    }

    public function updateStatus() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');

        $id = $_POST['id'];
        $status = $_POST['status'];
        $remarks = $_POST['admin_remarks'] ?? '';

        $model = new LessonNote();
        $model->updateStatus($id, $status, $remarks);

        $_SESSION['success'] = "Lesson note marked as {$status}.";
        redirect('admin/lesson-notes');
    }
}
