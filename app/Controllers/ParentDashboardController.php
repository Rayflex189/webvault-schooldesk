<?php
// app/Controllers/ParentDashboardController.php

namespace App\Controllers;

use App\Middleware\ParentMiddleware;
use App\Models\Timetable;
use Database;

class ParentDashboardController {
    
    public function index() {
        ParentMiddleware::handle();
        
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

        $stmt = $pdo->prepare("SELECT * FROM guardians WHERE user_id = ?");
        $stmt->execute([$userId]);
        $guardian = $stmt->fetch();

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

        $stmt = $pdo->query("SELECT * FROM announcements WHERE target_audience = 'parents' OR target_audience = 'all' ORDER BY created_at DESC LIMIT 3");
        $announcements = $stmt->fetchAll();

        view('parent.dashboard', [
            'guardian' => $guardian,
            'children' => $children,
            'announcements' => $announcements
        ]);
    }

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

        $stmt = $pdo->prepare("SELECT id FROM guardians WHERE user_id = ?");
        $stmt->execute([$userId]);
        $guardian = $stmt->fetch();

        if (!$guardian) {
            http_response_code(403);
            die("403 - Unauthorized.");
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM student_guardians WHERE guardian_id = ? AND student_id = ?");
        $stmt->execute([$guardian['id'], $studentId]);
        
        if ($stmt->fetchColumn() == 0) {
            http_response_code(403);
            die("403 - Unauthorized. You are not authorized to view this student's records.");
        }

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

    public function fees() {
        ParentMiddleware::handle();
        
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];
        $studentId = $_GET['student_id'] ?? null;

        if (!$studentId) {
            redirect('parent/dashboard');
        }

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

        $stmt = $pdo->prepare("SELECT s.*, c.name AS class_name FROM students s JOIN classes c ON s.class_id = c.id WHERE s.id = ?");
        $stmt->execute([$studentId]);
        $student = $stmt->fetch();

        $financeModel = new \App\Models\Finance();
        $settings = get_settings();
        $session = $settings['current_session'] ?? '2024/2025';
        $term = $settings['current_term'] ?? 'First Term';
        
        $balanceInfo = $financeModel->getStudentBalance($studentId, $session, $term);

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

    public function books() {
        ParentMiddleware::handle();
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

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

    public function initiatePayment() {
        ParentMiddleware::handle();
        verify_csrf($_POST['csrf_token'] ?? '');

        $studentId = $_POST['student_id'];
        $amount = (float)$_POST['amount'];
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM student_guardians sg JOIN guardians g ON sg.guardian_id = g.id WHERE g.user_id = ? AND sg.student_id = ?");
        $stmt->execute([$userId, $studentId]);
        if ($stmt->fetchColumn() == 0) die("403 - Unauthorized.");

        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        $reference = 'WVS-' . strtoupper(bin2hex(random_bytes(4))) . '-' . time();
        
        $paystack = new \App\Services\PaystackService();
        $callbackUrl = env('APP_URL') . "/parent/payment/callback?student_id={$studentId}";
        
        $response = $paystack->initialize($user['email'], $amount, $reference, $callbackUrl);

        if ($response && $response['status']) {
            header("Location: " . $response['data']['authorization_url']);
            exit;
        } else {
            $_SESSION['error'] = "Payment initialization failed. Check API keys.";
            redirect('parent/fees?student_id=' . $studentId);
        }
    }

    public function verifyPayment() {
        ParentMiddleware::handle();
        
        $reference = $_GET['reference'] ?? null;
        $studentId = $_GET['student_id'] ?? null;

        if (!$reference || !$studentId) {
            redirect('parent/dashboard');
        }

        $paystack = new \App\Services\PaystackService();
        $response = $paystack->verify($reference);

        if ($response && $response['status'] && $response['data']['status'] === 'success') {
            $verifiedAmount = $response['data']['amount'] / 100; 

            $pdo = Database::getInstance();
            $settings = get_settings();
            
            try {
                $pdo->beginTransaction();
                
                $stmt = $pdo->prepare("INSERT INTO payments (student_id, amount, payment_method, reference, term, session, recorded_by) VALUES (?, ?, 'Paystack', ?, ?, ?, ?)");
                
                $stmt->execute([
                    $studentId, 
                    $verifiedAmount, 
                    $reference, 
                    $settings['current_term'], 
                    $settings['current_session'], 
                    $_SESSION['user_id']
                ]);
                
                $pdo->commit();
                $_SESSION['success'] = "Payment of ₦" . number_format($verifiedAmount, 2) . " was successful!";
            } catch (\Exception $e) {
                $pdo->rollBack();
                $_SESSION['error'] = "DB Error: " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "Payment verification failed or was cancelled.";
        }

        redirect('parent/fees?student_id=' . $studentId);
    }

    public function timetable() {
        ParentMiddleware::handle();
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

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

        $settings = get_settings();
        $session = $settings['current_session'] ?? '2024/2025';
        $term = $settings['current_term'] ?? 'First Term';
        
        $selectedChildId = $_GET['student_id'] ?? ($children[0]['id'] ?? null);
        
        $selectedChild = null;
        foreach($children as $c) {
            if($c['id'] == $selectedChildId) {
                $selectedChild = $c;
                break;
            }
        }

        $slots = [];
        if($selectedChild) {
            $timetableModel = new Timetable();
            $slots = $timetableModel->getSlots($selectedChild['class_id'], $session, $term);
        }

        view('parent.timetable', [
            'children' => $children,
            'slots' => $slots,
            'selectedChild' => $selectedChild,
            'session' => $session,
            'term' => $term
        ]);
    }
}
