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
     * Create a new student record and their corresponding user account
     */
    public function create($data) {
        $pdo = Database::getInstance();
        
        try {
            $pdo->beginTransaction();

            // 1. Create the User Account (Role ID 4 = Student)
            $passwordHash = password_hash('password123', PASSWORD_DEFAULT);
            // Use admission number as the username/email for login
            $username = strtolower(str_replace('/', '', $data['admission_number'])); 
            
            $userSql = "INSERT INTO users (role_id, username, email, password_hash) 
                        VALUES (4, :username, :email, :password_hash)";
            $userStmt = $pdo->prepare($userSql);
            $userStmt->execute([
                ':username' => $username,
                ':email'    => $username . '@student.school.com', // Dummy email
                ':password_hash' => $passwordHash
            ]);
            
            $userId = $pdo->lastInsertId();

            // 2. Create the Student Profile
            $sql = "INSERT INTO students (user_id, admission_number, first_name, last_name, gender, dob, class_id) 
                    VALUES (:user_id, :admission_number, :first_name, :last_name, :gender, :dob, :class_id)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id'          => $userId,
                ':admission_number' => $data['admission_number'],
                ':first_name'       => $data['first_name'],
                ':last_name'        => $data['last_name'],
                ':gender'           => $data['gender'],
                ':dob'              => $data['dob'],
                ':class_id'         => $data['class_id']
            ]);

            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
    
    /**
     * Get all classes for the dropdown
     */
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }
}
