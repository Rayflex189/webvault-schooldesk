<?php
// app/Controllers/StudentDashboardController.php

namespace App\Controllers;

use App\Middleware\StudentMiddleware;
use App\Models\ReportCard;
use Database;

class StudentDashboardController {
    
    public function index() {
        StudentMiddleware::handle();
        
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

        // 1. Get Student Profile
        $stmt = $pdo->prepare("
            SELECT s.*, c.name AS class_name 
            FROM students s
            JOIN classes c ON s.class_id = c.id
            WHERE s.user_id = ?
        ");
        $stmt->execute([$userId]);
        $student = $stmt->fetch();

        if (!$student) {
            die("Student profile not found. Please contact the administrator.");
        }

        // 2. Get Announcements for Students
        $stmt = $pdo->query("SELECT * FROM announcements WHERE target_audience = 'students' OR target_audience = 'all' ORDER BY created_at DESC LIMIT 3");
        $announcements = $stmt->fetchAll();

        view('student.dashboard', [
            'student' => $student,
            'announcements' => $announcements
        ]);
    }

    public function reportCard() {
        StudentMiddleware::handle();
        
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];
        $session = $_GET['session'] ?? '2024/2025';
        $term = $_GET['term'] ?? 'First Term';

        // 1. Get Student Profile securely
        $stmt = $pdo->prepare("SELECT id, class_id FROM students WHERE user_id = ?");
        $stmt->execute([$userId]);
        $studentData = $stmt->fetch();

        if (!$studentData) {
            die("Student profile not found.");
        }

        $studentId = $studentData['id'];
        $classId = $studentData['class_id'];

        // 2. Fetch Results
        $reportModel = new ReportCard();
        $student = $reportModel->getStudentDetails($studentId);
        $results = $reportModel->getStudentResults($studentId, $session, $term);
        
        $totalAggregate = 0;
        foreach ($results as $r) { $totalAggregate += $r['total_score']; }
        
        $position = count($results) > 0 ? $reportModel->calculatePosition($studentId, $classId, $session, $term) : "N/A";

        view('admin.reports.print', [
            'student' => $student,
            'results' => $results,
            'session' => $session,
            'term' => $term,
            'totalAggregate' => $totalAggregate,
            'totalSubjects' => count($results),
            'position' => $position
        ]);
    }
}
