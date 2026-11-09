<?php
// app/Controllers/ParentDashboardController.php

namespace App\Controllers;

use App\Middleware\ParentMiddleware;
use Database;

class ParentDashboardController {
    
    /**
     * Show the Parent Dashboard with linked children and announcements
     */
    public function index() {
        ParentMiddleware::handle();
        
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

        // 1. Get the Guardian Profile
        $stmt = $pdo->prepare("SELECT * FROM guardians WHERE user_id = ?");
        $stmt->execute([$userId]);
        $guardian = $stmt->fetch();

        // 2. Get linked children
        $children = [];
        if ($guardian) {
            $stmt = $pdo->prepare("
                SELECT s.*, c.name AS class_name 
                FROM students s
                JOIN student_guardians sg ON s.id = sg.student_id
                JOIN classes c ON s.class_id = c.id
                WHERE sg.guardian_id = ?
            ");
            $stmt->execute([$guardian['id']]);
            $children = $stmt->fetchAll();
        }

        // 3. Get recent announcements for parents
        $stmt = $pdo->query("SELECT * FROM announcements WHERE target_audience = 'parents' OR target_audience = 'all' ORDER BY created_at DESC LIMIT 3");
        $announcements = $stmt->fetchAll();

        view('parent.dashboard', [
            'guardian' => $guardian,
            'children' => $children,
            'announcements' => $announcements
        ]);
    }

    /**
     * Securely generate a report card for a linked child
     */
    public function reportCard() {
        ParentMiddleware::handle();
        
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];
        $studentId = $_GET['student_id'] ?? null;
        
        $settings = get_settings();
        $session = $_GET['session'] ?? $settings['current_session'] ?? '2024/2025';
        $term = $_GET['term'] ?? $settings['current_term'] ?? 'First Term';

        if (!$studentId) {
            redirect('parent/dashboard');
        }

        // 1. Get Guardian ID
        $stmt = $pdo->prepare("SELECT id FROM guardians WHERE user_id = ?");
        $stmt->execute([$userId]);
        $guardian = $stmt->fetch();

        if (!$guardian) {
            http_response_code(403);
            die("403 - Unauthorized.");
        }

        // 2. SECURITY CHECK: Is this student linked to this guardian?
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM student_guardians WHERE guardian_id = ? AND student_id = ?");
        $stmt->execute([$guardian['id'], $studentId]);
        
        if ($stmt->fetchColumn() == 0) {
            http_response_code(403);
            die("403 - Unauthorized. You are not authorized to view this student's records.");
        }

        // 3. Fetch Data using the ReportCard model
        $reportModel = new \App\Models\ReportCard();
        $student = $reportModel->getStudentDetails($studentId);
        $results = $reportModel->getStudentResults($studentId, $session, $term);
        
        $totalAggregate = 0;
        $totalSubjects = count($results);
        foreach ($results as $r) {
            $totalAggregate += $r['total_score'];
        }
        
        $position = "N/A";
        if ($totalSubjects > 0) {
            $position = $reportModel->calculatePosition($studentId, $student['class_id'], $session, $term);
        }

        // 4. Render the standalone print view
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

    /**
     * View fee status for a linked child
     */
    public function fees() {
        ParentMiddleware::handle();
        
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];
        $studentId = $_GET['student_id'] ?? null;

        if (!$studentId) {
            redirect('parent/dashboard');
        }

        // 1. Verify Guardian Link (Security)
        $stmt = $pdo->prepare("SELECT id FROM guardians WHERE user_id = ?");
        $stmt->execute([$userId]);
        $guardian = $stmt->fetch();

        if (!$guardian) die("403 - Unauthorized.");

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM student_guardians WHERE guardian_id = ? AND student_id = ?");
        $stmt->execute([$guardian['id'], $studentId]);
        if ($stmt->fetchColumn() == 0) {
            http_response_code(403);
            die("403 - Unauthorized. You are not authorized to view this student's fees.");
        }

        // 2. Fetch Student Details
        $stmt = $pdo->prepare("SELECT s.*, c.name AS class_name FROM students s JOIN classes c ON s.class_id = c.id WHERE s.id = ?");
        $stmt->execute([$studentId]);
        $student = $stmt->fetch();

        // 3. Fetch Fee Summary using our Finance model
        $financeModel = new \App\Models\Finance();
        $settings = get_settings();
        $session = $settings['current_session'] ?? '2024/2025';
        $term = $settings['current_term'] ?? 'First Term';
        
        $balanceInfo = $financeModel->getStudentBalance($studentId, $session, $term);

        // 4. Fetch Payment History
        $stmt = $pdo->prepare("SELECT * FROM payments WHERE student_id = ? AND session = ? AND term = ? ORDER BY created_at DESC");
        $stmt->execute([$studentId, $session, $term]);
        $payments = $stmt->fetchAll();

        view('parent.fees', [
            'student' => $student,
            'balanceInfo' => $balanceInfo,
            'payments' => $payments,
            'session' => $session,
            'term' => $term
        ]);
    }

    /**
     * View booklists for linked children
     */
    public function books() {
        ParentMiddleware::handle();
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

        // Get linked children
        $stmt = $pdo->prepare("
            SELECT s.id, s.first_name, s.last_name, s.class_id, c.name AS class_name
            FROM students s
            JOIN student_guardians sg ON s.id = sg.student_id
            JOIN guardians g ON sg.guardian_id = g.id
            JOIN classes c ON s.class_id = c.id
            WHERE g.user_id = ?
        ");
        $stmt->execute([$userId]);
        $children = $stmt->fetchAll();

        $bookModel = new \App\Models\Book();
        $childrenBooks = [];
        foreach($children as $child) {
            $childrenBooks[] = [
                'child_name' => $child['first_name'] . ' ' . $child['last_name'],
                'class_name' => $child['class_name'],
                'books' => $bookModel->getByClass($child['class_id'])
            ];
        }

        view('parent.books', ['childrenBooks' => $childrenBooks]);
    }
}
