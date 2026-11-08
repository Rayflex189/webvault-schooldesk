<?php
// app/Controllers/TeacherExamController.php

namespace App\Controllers;

use App\Middleware\TeacherMiddleware;
use App\Models\TeacherAssignment;
use App\Models\ExamResult;

class TeacherExamController {
    
    /**
     * Show a list of the teacher's assigned classes/subjects to enter scores
     */
    public function index() {
        TeacherMiddleware::handle();
        
        $model = new TeacherAssignment();
        $assignments = $model->getAssignmentsByUserId($_SESSION['user_id']);

        view('teacher.exams.index', ['assignments' => $assignments]);
    }

    /**
     * Show the score entry sheet
     */
    public function entry() {
        TeacherMiddleware::handle();
        
        $classId = $_GET['class_id'] ?? null;
        $subjectId = $_GET['subject_id'] ?? null;
        $session = '2024/2025'; // Hardcoded for now, can be dynamic later
        $term = $_GET['term'] ?? 'First Term';

        if (!$classId || !$subjectId) {
            redirect('teacher/exams');
        }

        // SECURITY CHECK: Is this teacher assigned to this class AND subject?
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

    /**
     * Save the scores
     */
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
