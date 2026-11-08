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
     * Find a class by ID
     */
    public function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
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
     * Update a class
     */
    public function update($id, $data) {
        $pdo = Database::getInstance();
        $sql = "UPDATE classes SET name = :name, capacity = :capacity WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':name'     => $data['name'],
            ':capacity' => $data['capacity'],
            ':id'       => $id
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
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Save the assigned subjects for a class (Syncs the pivot table)
     */
    public function syncSubjects($classId, $subjectIds) {
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("DELETE FROM class_subjects WHERE class_id = ?");
        $stmt->execute([$classId]);

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
