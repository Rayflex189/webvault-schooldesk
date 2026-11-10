<?php
// app/Models/ReportCard.php

namespace App\Models;

use Database;
use PDO;

class ReportCard {
    
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }

    public function getStudents() {
        $pdo = Database::getInstance();
        return $pdo->query("
            SELECT s.id, s.first_name, s.last_name, s.admission_number, c.name AS class_name 
            FROM students s 
            JOIN classes c ON s.class_id = c.id 
            WHERE s.status = 'active' 
            ORDER BY c.name ASC, s.first_name ASC
        ")->fetchAll();
    }

    public function getStudentDetails($studentId) {
        $pdo = Database::getInstance();
        // Fetches the grading scheme from classes
        $stmt = $pdo->prepare("
            SELECT s.*, c.name AS class_name, c.grading_scheme
            FROM students s 
            LEFT JOIN classes c ON s.class_id = c.id 
            WHERE s.id = ?
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetch();
    }

    public function getStudentResults($studentId, $session, $term) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT r.*, sub.name AS subject_name, sub.code AS subject_code 
            FROM exam_results r
            JOIN subjects sub ON r.subject_id = sub.id
            WHERE r.student_id = ? AND r.session = ? AND r.term = ?
            ORDER BY sub.name ASC
        ");
        $stmt->execute([$studentId, $session, $term]);
        return $stmt->fetchAll();
    }

    public function calculatePosition($studentId, $classId, $session, $term) {
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("
            SELECT student_id, SUM(total_score) as aggregate 
            FROM exam_results 
            WHERE class_id = ? AND session = ? AND term = ?
            GROUP BY student_id 
            ORDER BY aggregate DESC
        ");
        $stmt->execute([$classId, $session, $term]);
        $results = $stmt->fetchAll();

        $position = 0;
        $totalStudents = count($results);

        foreach ($results as $index => $row) {
            if ($row['student_id'] == $studentId) {
                $position = $index + 1;
                break;
            }
        }

        if ($position === 0) return "N/A";

        $suffix = 'th';
        if ($position % 10 == 1 && $position % 100 != 11) $suffix = 'st';
        elseif ($position % 10 == 2 && $position % 100 != 12) $suffix = 'nd';
        elseif ($position % 10 == 3 && $position % 100 != 13) $suffix = 'rd';

        return $position . $suffix . " out of " . $totalStudents;
    }
}
