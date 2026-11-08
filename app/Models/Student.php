<?php
// app/Models/Student.php

namespace App\Models;

use Database;
use PDO;

class Student {
    
    /**
     * Fetch all students with their associated class names
     */
    public function all() {
        $pdo = Database::getInstance();
        
        $stmt = $pdo->query("
            SELECT s.*, c.name as class_name 
            FROM students s 
            LEFT JOIN classes c ON s.class_id = c.id 
            ORDER BY s.created_at DESC
        ");
        
        return $stmt->fetchAll();
    }

    /**
     * Create a new student record
     */
    public function create($data) {
        $pdo = Database::getInstance();
        
        $sql = "INSERT INTO students (admission_number, first_name, last_name, gender, dob, class_id) 
                VALUES (:admission_number, :first_name, :last_name, :gender, :dob, :class_id)";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':admission_number' => $data['admission_number'],
            ':first_name'       => $data['first_name'],
            ':last_name'        => $data['last_name'],
            ':gender'           => $data['gender'],
            ':dob'              => $data['dob'],
            ':class_id'         => $data['class_id']
        ]);
    }
    
    /**
     * Get all classes for the dropdown
     */
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }
}
