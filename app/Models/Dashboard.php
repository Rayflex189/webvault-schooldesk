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
        
        // 3. Total Classes
        $classes = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
        
        // 4. Attendance Today
        $today = date('Y-m-d');
        $presentToday = $pdo->query("SELECT COUNT(*) FROM attendance WHERE date = '$today' AND status = 'present'")->fetchColumn();
        $attendancePercentage = $students > 0 ? round(($presentToday / $students) * 100) : 0;
        
        // 5. Total Fees Collected (Current Term)
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM payments WHERE session = ? AND term = ?");
        $stmt->execute([$session, $term]);
        $feesCollected = $stmt->fetchColumn() ?? 0;

        return [
            'students' => $students,
            'teachers' => $teachers,
            'classes' => $classes,
            'attendance_percentage' => $attendancePercentage,
            'fees_collected' => $feesCollected
        ];
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
}
