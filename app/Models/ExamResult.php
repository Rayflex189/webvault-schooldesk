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

    /**
     * Get students in a class along with their existing scores for a specific subject/term
     */
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
     * Calculate grade based on total score
     */
    public function calculateGrade($total) {
        if ($total >= 70) return 'A';
        if ($total >= 60) return 'B';
        if ($total >= 50) return 'C';
        if ($total >= 40) return 'D';
        return 'F';
    }

    /**
     * Save results using INSERT ON DUPLICATE KEY UPDATE
     */
    public function saveResults($classId, $subjectId, $session, $term, $resultsData) {
        $pdo = Database::getInstance();
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
                $grade = $this->calculateGrade($total);

                $stmt->execute([
                    ':student_id' => $studentId,
                    ':class_id'   => $classId,
                    ':subject_id' => $subjectId,
                    ':session'    => $session,
                    ':term'       => $term,
                    ':ca_score'   => $ca,
                    ':exam_score' => $exam,
                    ':total_score'=> $total,
                    ':grade'      => $grade
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
