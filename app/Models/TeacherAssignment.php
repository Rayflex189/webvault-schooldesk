<?php
// app/Models/TeacherAssignment.php

namespace App\Models;

use Database;
use PDO;

class TeacherAssignment {
    
    /**
     * Get all assignments with joined names for display (Admin View)
     */
    public function all() {
        $pdo = Database::getInstance();
        $sql = "SELECT ta.id, 
                       t.first_name AS teacher_fname, t.last_name AS teacher_lname,
                       c.name AS class_name, 
                       s.name AS subject_name, s.code AS subject_code
                FROM teacher_assignments ta
                JOIN teachers t ON ta.teacher_id = t.id
                JOIN classes c ON ta.class_id = c.id
                JOIN subjects s ON ta.subject_id = s.id
                ORDER BY c.name ASC, s.name ASC";
        
        return $pdo->query($sql)->fetchAll();
    }

    /**
     * Create a new assignment
     */
    public function create($data) {
        $pdo = Database::getInstance();
        
        $sql = "INSERT INTO teacher_assignments (teacher_id, class_id, subject_id) 
                VALUES (:teacher_id, :class_id, :subject_id)";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':teacher_id' => $data['teacher_id'],
            ':class_id'   => $data['class_id'],
            ':subject_id' => $data['subject_id']
        ]);
    }

    /**
     * Fetch all teachers for the dropdown
     */
    public function getTeachers() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, first_name, last_name FROM teachers ORDER BY first_name ASC")->fetchAll();
    }

    /**
     * Fetch all classes for the dropdown
     */
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }

    /**
     * Fetch all subjects for the dropdown
     */
    public function getSubjects() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name, code FROM subjects ORDER BY name ASC")->fetchAll();
    }

    /**
     * Get assignments for a specific teacher based on their User ID (Teacher Portal)
     */
    public function getAssignmentsByUserId($userId) {
        $pdo = Database::getInstance();
        
        $sql = "SELECT ta.id, c.id AS class_id, c.name AS class_name, s.name AS subject_name, s.id AS subject_id
                FROM teacher_assignments ta
                JOIN teachers t ON ta.teacher_id = t.id
                JOIN classes c ON ta.class_id = c.id
                JOIN subjects s ON ta.subject_id = s.id
                WHERE t.user_id = ?";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
