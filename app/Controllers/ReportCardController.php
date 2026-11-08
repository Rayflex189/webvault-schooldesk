<?php
// app/Controllers/ReportCardController.php

namespace App\Controllers;

use App\Models\ReportCard;
use App\Middleware\AuthMiddleware;

class ReportCardController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new ReportCard();
        
        view('admin.reports.index', [
            'students' => $model->getStudents()
        ]);
    }

    public function generate() {
        AuthMiddleware::adminOnly();
        
        $studentId = $_GET['student_id'] ?? null;
        $session = $_GET['session'] ?? '2024/2025';
        $term = $_GET['term'] ?? 'First Term';

        if (!$studentId) {
            redirect('admin/reports');
        }

        $model = new ReportCard();
        $student = $model->getStudentDetails($studentId);
        $results = $model->getStudentResults($studentId, $session, $term);
        
        // Calculate total aggregate
        $totalAggregate = 0;
        $totalSubjects = count($results);
        foreach ($results as $r) {
            $totalAggregate += $r['total_score'];
        }
        
        // Calculate position (only if they have results)
        $position = "N/A";
        if ($totalSubjects > 0) {
            $position = $model->calculatePosition($studentId, $student['class_id'], $session, $term);
        }

        view('admin.reports.print', [
            'student' => $student,
            'results' => $results,
            'session' => $session,
            'term' => $term,
            'totalAggregate' => $totalAggregate,
            'totalSubjects' => $totalSubjects,
            'position' => $position
        ]);
    }
}
