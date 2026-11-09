<?php
// app/Models/Dashboard.php

namespace App\Models;

use Database;
use PDO;

class Dashboard {
    
    public function getStats($session = '2024/2025', $term = 'First Term') {
        $pdo = Database::getInstance();
        
        // 1. Total Students
        $students = $pdo->query("SELECT COUNT(*) FROM students WHERE status = 'active'")->fetchColumn();
        
        // 2. Total Teachers
        $teachers = $pdo->query("SELECT COUNT(*) FROM teachers WHERE status = 'active'")->fetchColumn();
        
        // 3. Total Parents
        $parents = $pdo->query("SELECT COUNT(*) FROM users WHERE role_id = 3 AND status = 'active'")->fetchColumn();
        
        // 4. Attendance Today
        $today = date('Y-m-d');
        $presentToday = $pdo->query("SELECT COUNT(*) FROM attendance WHERE date = '$today' AND status = 'present'")->fetchColumn();
        $attendancePercentage = $students > 0 ? round(($presentToday / $students) * 100) : 0;
        
        // 5. Finance Stats
        // Total Collected
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM payments WHERE session = ? AND term = ?");
        $stmt->execute([$session, $term]);
        $feesCollected = $stmt->fetchColumn() ?: 0;

        // Total Expected
        $stmt = $pdo->prepare("
            SELECT SUM(f.amount) 
            FROM students s 
            JOIN fee_structures f ON s.class_id = f.class_id 
            WHERE f.session = ? AND f.term = ? AND s.status = 'active'
        ");
        $stmt->execute([$session, $term]);
        $totalExpected = $stmt->fetchColumn() ?: 0;

        // Outstanding Balance
        $totalOutstanding = $totalExpected - $feesCollected;

        return [
            'students' => $students,
            'teachers' => $teachers,
            'parents' => $parents,
            'attendance_percentage' => $attendancePercentage,
            'fees_collected' => $feesCollected,
            'total_expected' => $totalExpected,
            'total_outstanding' => $totalOutstanding
        ];
    }

    /**
     * Get detailed fee analysis for every active student
     */
    public function getFeesAnalysis($session = '2024/2025', $term = 'First Term') {
        $pdo = Database::getInstance();
        
        $sql = "SELECT s.id, s.first_name, s.last_name, s.admission_number, c.name AS class_name,
                       COALESCE(f.amount, 0) AS expected_fee,
                       COALESCE(SUM(p.amount), 0) AS total_paid
                FROM students s
                JOIN classes c ON s.class_id = c.id
                LEFT JOIN fee_structures f ON s.class_id = f.class_id AND f.session = :session1 AND f.term = :term1
                LEFT JOIN payments p ON s.id = p.student_id AND p.session = :session2 AND p.term = :term2
                WHERE s.status = 'active'
                GROUP BY s.id
                HAVING expected_fee > 0 OR total_paid > 0
                ORDER BY c.name ASC, s.first_name ASC";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':session1' => $session, 
            ':term1'    => $term,
            ':session2' => $session,
            ':term2'    => $term
        ]);
        
        return $stmt->fetchAll();
    }

    public function getRecentStudents() {
        $pdo = Database::getInstance();
        return $pdo->query("
            SELECT s.first_name, s.last_name, s.created_at, c.name as class_name 
            FROM students s 
            LEFT JOIN classes c ON s.class_id = c.id 
            ORDER BY s.created_at DESC 
            LIMIT 4
        ")->fetchAll();
    }

    public function getStudentDistribution() {
        $pdo = Database::getInstance();
        $sql = "SELECT c.name AS class_name, COUNT(s.id) AS student_count 
                FROM classes c 
                LEFT JOIN students s ON c.id = s.class_id AND s.status = 'active'
                GROUP BY c.id 
                ORDER BY c.name ASC";
        return $pdo->query($sql)->fetchAll();
    }

    public function getAttendanceTrend() {
        $pdo = Database::getInstance();
        $sql = "SELECT date, 
                       SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_count,
                       SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_count
                FROM attendance 
                WHERE date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                GROUP BY date 
                ORDER BY date ASC";
        return $pdo->query($sql)->fetchAll();
    }
}
