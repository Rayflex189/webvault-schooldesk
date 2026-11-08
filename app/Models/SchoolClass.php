<?php
// app/Models/SchoolClass.php

namespace App\Models;

use Database;
use PDO;

class SchoolClass {
    
    /**
     * Get all classes
     */
    public function all() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM classes ORDER BY name ASC")->fetchAll();
    }

    /**
     * Create a new class
     */
    public function create($data) {
        $pdo = Database::getInstance();
        
        $sql = "INSERT INTO classes (name, capacity) VALUES (:name, :capacity)";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':capacity' => $data['capacity']
        ]);
    }

    /**
     * Get all available subjects in the school
     */
    public function getAllSubjects() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM subjects ORDER BY name ASC")->fetchAll();
    }

    /**
     * Get the IDs of subjects currently assigned to a specific class
     */
    public function getAssignedSubjects($classId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT subject_id FROM class_subjects WHERE class_id = ?");
        $stmt->execute([$classId]);
        
        // Returns a simple array like [1, 3, 4] instead of a multidimensional array
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Save the assigned subjects for a class (Syncs the pivot table)
     */
    public function syncSubjects($classId, $subjectIds) {
        $pdo = Database::getInstance();
        
        // 1. Delete existing assignments for this class
        $stmt = $pdo->prepare("DELETE FROM class_subjects WHERE class_id = ?");
        $stmt->execute([$classId]);

        // 2. Insert new assignments if any were selected
        if (!empty($subjectIds)) {
            $sql = "INSERT INTO class_subjects (class_id, subject_id) VALUES ";
            $values = [];
            $params = [];
            
            foreach ($subjectIds as $subId) {
                $values[] = "(?, ?)";
                $params[] = $classId;
                $params[] = $subId;
            }
            
            $sql .= implode(", ", $values);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        }
        return true;
    }
}
