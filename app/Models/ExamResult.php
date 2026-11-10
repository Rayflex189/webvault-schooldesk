<?php
// app/Models/ExamResult.php

namespace App\Models;

use Database;
use PDO;

class ExamResult {
    
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }

    public function getSubjects() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name, code FROM subjects ORDER BY name ASC")->fetchAll();
    }

    public function getStudentsWithScores($classId, $subjectId, $session, $term) {
        $pdo = Database::getInstance();
        $sql = "SELECT s.id, s.first_name, s.last_name, s.admission_number, 
                       r.ca_score, r.exam_score, r.total_score, r.grade
                FROM students s 
                LEFT JOIN exam_results r ON s.id = r.student_id 
                    AND r.subject_id = :subject_id 
                    AND r.session = :session 
                    AND r.term = :term
                WHERE s.class_id = :class_id AND s.status = 'active'
                ORDER BY s.first_name ASC";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':class_id' => $classId,
            ':subject_id' => $subjectId,
            ':session' => $session,
            ':term' => $term
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Calculate grade and remark based on the grading scheme
     */
    public function calculateGrade($total, $scheme = 'standard') {
        if ($scheme === 'waec') {
            if ($total >= 75) return ['grade' => 'A1', 'remark' => 'Excellent'];
            if ($total >= 70) return ['grade' => 'B2', 'remark' => 'Very Good'];
            if ($total >= 65) return ['grade' => 'B3', 'remark' => 'Good'];
            if ($total >= 60) return ['grade' => 'C4', 'remark' => 'Credit'];
            if ($total >= 55) return ['grade' => 'C5', 'remark' => 'Credit'];
            if ($total >= 50) return ['grade' => 'C6', 'remark' => 'Credit'];
            if ($total >= 45) return ['grade' => 'D7', 'remark' => 'Pass'];
            if ($total >= 40) return ['grade' => 'E8', 'remark' => 'Pass'];
            return ['grade' => 'F9', 'remark' => 'Fail'];
        } else {
            // Standard A-F
            if ($total >= 70) return ['grade' => 'A', 'remark' => 'Excellent'];
            if ($total >= 60) return ['grade' => 'B', 'remark' => 'Very Good'];
            if ($total >= 50) return ['grade' => 'C', 'remark' => 'Good'];
            if ($total >= 45) return ['grade' => 'D', 'remark' => 'Fair'];
            if ($total >= 40) return ['grade' => 'E', 'remark' => 'Pass'];
            return ['grade' => 'F', 'remark' => 'Fail'];
        }
    }

    public function saveResults($classId, $subjectId, $session, $term, $resultsData) {
        $pdo = Database::getInstance();
        
        // 1. Fetch the class's grading scheme
        $stmt = $pdo->prepare("SELECT grading_scheme FROM classes WHERE id = ?");
        $stmt->execute([$classId]);
        $scheme = $stmt->fetchColumn() ?: 'standard';

        $pdo->beginTransaction();
        
        try {
            $sql = "INSERT INTO exam_results (student_id, class_id, subject_id, session, term, ca_score, exam_score, total_score, grade) 
                    VALUES (:student_id, :class_id, :subject_id, :session, :term, :ca_score, :exam_score, :total_score, :grade)
                    ON DUPLICATE KEY UPDATE 
                        ca_score = VALUES(ca_score), 
                        exam_score = VALUES(exam_score), 
                        total_score = VALUES(total_score), 
                        grade = VALUES(grade)";
            
            $stmt = $pdo->prepare($sql);
            
            foreach ($resultsData as $studentId => $scores) {
                $ca = (float) $scores['ca'];
                $exam = (float) $scores['exam'];
                
                // Validation: Cap scores at max limits (CA=30, Exam=70)
                $ca = min($ca, 30);
                $exam = min($exam, 70);
                
                $total = $ca + $exam;
                $gradeData = $this->calculateGrade($total, $scheme);

                $stmt->execute([
                    ':student_id' => $studentId,
                    ':class_id'   => $classId,
                    ':subject_id' => $subjectId,
                    ':session'    => $session,
                    ':term'       => $term,
                    ':ca_score'   => $ca,
                    ':exam_score' => $exam,
                    ':total_score'=> $total,
                    ':grade'      => $gradeData['grade']
                ]);
            }
            
            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}
