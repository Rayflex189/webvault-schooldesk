<?php
// app/Controllers/TeacherExamController.php

namespace App\Controllers;

use App\Middleware\TeacherMiddleware;
use App\Models\TeacherAssignment;
use App\Models\ExamResult;

class TeacherExamController {
    
    public function index() {
        TeacherMiddleware::handle();
        
        $model = new TeacherAssignment();
        $assignments = $model->getAssignmentsByUserId($_SESSION['user_id']);

        // Pass settings to view if needed, but mainly used in entry()
        $settings = get_settings();

        view('teacher.exams.index', [
            'assignments' => $assignments,
            'active_session' => $settings['current_session'] ?? '2024/2025',
            'active_term' => $settings['current_term'] ?? 'First Term'
        ]);
    }

    public function entry() {
        TeacherMiddleware::handle();
        
        $classId = $_GET['class_id'] ?? null;
        $subjectId = $_GET['subject_id'] ?? null;
        
        $settings = get_settings();
        $session = $settings['current_session'] ?? '2024/2025';
        $term = $_GET['term'] ?? $settings['current_term'] ?? 'First Term';

        if (!$classId || !$subjectId) {
            redirect('teacher/exams');
        }

        // SECURITY CHECK
        $assignmentModel = new TeacherAssignment();
        if (!$assignmentModel->isTeacherAssigned($_SESSION['user_id'], $classId, $subjectId)) {
            http_response_code(403);
            die("403 - Unauthorized. You are not assigned to grade this subject.");
        }

        $model = new ExamResult();
        $students = $model->getStudentsWithScores($classId, $subjectId, $session, $term);

        view('teacher.exams.entry', [
            'students' => $students,
            'class_id' => $classId,
            'subject_id' => $subjectId,
            'session' => $session,
            'term' => $term
        ]);
    }

    public function store() {
        TeacherMiddleware::handle();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $classId = $_POST['class_id'] ?? null;
        $subjectId = $_POST['subject_id'] ?? null;
        $session = $_POST['session'] ?? null;
        $term = $_POST['term'] ?? null;
        $results = $_POST['results'] ?? []; 

        if (!$classId || !$subjectId || empty($results)) {
            redirect('teacher/exams');
        }

        // SECURITY CHECK
        $assignmentModel = new TeacherAssignment();
        if (!$assignmentModel->isTeacherAssigned($_SESSION['user_id'], $classId, $subjectId)) {
            http_response_code(403);
            die("403 - Unauthorized.");
        }

        $model = new ExamResult();
        $success = $model->saveResults($classId, $subjectId, $session, $term, $results);

        if ($success) {
            $_SESSION['success'] = "Results saved successfully!";
        } else {
            $_SESSION['error'] = "Failed to save results. Please try again.";
        }

        redirect("teacher/exams/entry?class_id={$classId}&subject_id={$subjectId}&term=" . urlencode($term));
    }
}
