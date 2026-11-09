<?php
// app/Models/Student.php

namespace App\Models;

use Database;
use PDO;

class Student {
    
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

    public function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $pdo = Database::getInstance();
        try {
            $pdo->beginTransaction();
            $passwordHash = password_hash('password123', PASSWORD_DEFAULT);
            $username = strtolower(str_replace('/', '', $data['admission_number'])); 
            
            $userSql = "INSERT INTO users (role_id, username, email, password_hash) VALUES (4, :username, :email, :password_hash)";
            $userStmt = $pdo->prepare($userSql);
            $userStmt->execute([
                ':username' => $username,
                ':email'    => $username . '@student.school.com',
                ':password_hash' => $passwordHash
            ]);
            $userId = $pdo->lastInsertId();

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

    public function update($id, $data) {
        $pdo = Database::getInstance();
        $sql = "UPDATE students 
                SET first_name = :first_name, last_name = :last_name, gender = :gender, dob = :dob, class_id = :class_id, status = :status 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name'  => $data['last_name'],
            ':gender'     => $data['gender'],
            ':dob'        => $data['dob'],
            ':class_id'   => $data['class_id'],
            ':status'     => $data['status'],
            ':id'         => $id
        ]);
    }

    /**
     * Delete a student and their associated user account
     */
    public function delete($id) {
        $pdo = Database::getInstance();
        
        // Find the user_id linked to this student
        $stmt = $pdo->prepare("SELECT user_id FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch();
        
        if ($student && $student['user_id']) {
            // Deleting the user cascades and deletes the student profile, 
            // attendance, results, and payments due to foreign keys.
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$student['user_id']]);
        }
        
        // Fallback
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }
}
