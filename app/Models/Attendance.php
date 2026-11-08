<?php
// app/Models/Attendance.php

namespace App\Models;

use Database;
use PDO;

class Attendance {
    
    /**
     * Get all classes for the dropdown
     */
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }

    /**
     * Get all students in a specific class, along with their existing attendance for a specific date (if any)
     */
    public function getStudentsForClass($classId, $date) {
        $pdo = Database::getInstance();
        
        $sql = "SELECT s.id, s.first_name, s.last_name, s.admission_number, 
                       a.status 
                FROM students s 
                LEFT JOIN attendance a ON s.id = a.student_id AND a.date = :date
                WHERE s.class_id = :class_id AND s.status = 'active'
                ORDER BY s.first_name ASC";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':class_id' => $classId, ':date' => $date]);
        
        return $stmt->fetchAll();
    }

    /**
     * Save attendance (Uses INSERT ON DUPLICATE KEY UPDATE to handle both new and edited records safely)
     */
    public function saveAttendance($classId, $date, $attendanceData, $userId) {
        $pdo = Database::getInstance();
        
        // We use a transaction because we are inserting multiple rows at once
        $pdo->beginTransaction();
        
        try {
            $sql = "INSERT INTO attendance (student_id, class_id, date, status, recorded_by) 
                    VALUES (:student_id, :class_id, :date, :status, :recorded_by)
                    ON DUPLICATE KEY UPDATE status = VALUES(status), recorded_by = VALUES(recorded_by)";
            
            $stmt = $pdo->prepare($sql);
            
            foreach ($attendanceData as $studentId => $status) {
                $stmt->execute([
                    ':student_id'  => $studentId,
                    ':class_id'    => $classId,
                    ':date'        => $date,
                    ':status'      => $status,
                    ':recorded_by' => $userId
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
