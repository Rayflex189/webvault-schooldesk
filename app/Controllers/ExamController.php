<?php
// app/Controllers/ExamController.php

namespace App\Controllers;

use App\Models\ExamResult;
use App\Middleware\AuthMiddleware;

class ExamController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new ExamResult();
        
        // Get active session/term for default selection
        $settings = get_settings();
        $defaultSession = $settings['current_session'] ?? '2024/2025';
        $defaultTerm = $settings['current_term'] ?? 'First Term';

        view('admin.exams.index', [
            'classes'  => $model->getClasses(),
            'subjects' => $model->getSubjects(),
            'default_session' => $defaultSession,
            'default_term' => $defaultTerm
        ]);
    }

    public function entry() {
        AuthMiddleware::adminOnly();
        
        $classId = $_GET['class_id'] ?? null;
        $subjectId = $_GET['subject_id'] ?? null;
        
        // Fallback to global settings if not provided
        $settings = get_settings();
        $session = $_GET['session'] ?? $settings['current_session'] ?? '2024/2025';
        $term = $_GET['term'] ?? $settings['current_term'] ?? 'First Term';

        if (!$classId || !$subjectId) {
            redirect('admin/exams');
        }

        $model = new ExamResult();
        $students = $model->getStudentsWithScores($classId, $subjectId, $session, $term);

        view('admin.exams.entry', [
            'students' => $students,
            'class_id' => $classId,
            'subject_id' => $subjectId,
            'session' => $session,
            'term' => $term
        ]);
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $classId = $_POST['class_id'] ?? null;
        $subjectId = $_POST['subject_id'] ?? null;
        $session = $_POST['session'] ?? null;
        $term = $_POST['term'] ?? null;
        $results = $_POST['results'] ?? []; 

        if (!$classId || !$subjectId || empty($results)) {
            redirect('admin/exams');
        }

        $model = new ExamResult();
        $success = $model->saveResults($classId, $subjectId, $session, $term, $results);

        if ($success) {
            $_SESSION['success'] = "Results saved successfully!";
        } else {
            $_SESSION['error'] = "Failed to save results. Please try again.";
        }

        redirect("admin/exams/entry?class_id={$classId}&subject_id={$subjectId}&session={$session}&term=" . urlencode($term));
    }
}
