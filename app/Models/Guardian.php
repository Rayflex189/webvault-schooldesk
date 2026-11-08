<?php
// app/Models/Guardian.php

namespace App\Models;

use Database;
use PDO;

class Guardian {
    
    /**
     * Fetch all parents with their linked students
     */
    public function all() {
        $pdo = Database::getInstance();
        
        $sql = "SELECT g.*, u.email, u.status,
                GROUP_CONCAT(CONCAT(s.first_name, ' ', s.last_name) SEPARATOR ', ') AS children
                FROM guardians g
                JOIN users u ON g.user_id = u.id
                LEFT JOIN student_guardians sg ON g.id = sg.guardian_id
                LEFT JOIN students s ON sg.student_id = s.id
                GROUP BY g.id
                ORDER BY g.created_at DESC";
                
        return $pdo->query($sql)->fetchAll();
    }

    /**
     * Fetch all students for the linking dropdown
     */
    public function getStudents() {
        $pdo = Database::getInstance();
        return $pdo->query("
            SELECT s.id, s.first_name, s.last_name, s.admission_number, c.name AS class_name 
            FROM students s 
            JOIN classes c ON s.class_id = c.id 
            WHERE s.status = 'active' 
            ORDER BY s.first_name ASC
        ")->fetchAll();
    }

    /**
     * Create a Parent account and link them to a student
     */
    public function create($data) {
        $pdo = Database::getInstance();
        
        try {
            $pdo->beginTransaction();

            // 1. Create the User Account (Role ID 3 = Parent)
            $passwordHash = password_hash('password123', PASSWORD_DEFAULT);
            
            $userSql = "INSERT INTO users (role_id, username, email, password_hash) 
                        VALUES (3, :username, :email, :password_hash)";
            $userStmt = $pdo->prepare($userSql);
            $userStmt->execute([
                ':username' => $data['email'], // Using email as username
                ':email'    => $data['email'],
                ':password_hash' => $passwordHash
            ]);
            
            $userId = $pdo->lastInsertId();

            // 2. Create the Guardian Profile
            $guardianSql = "INSERT INTO guardians (user_id, first_name, last_name, phone, relationship) 
                            VALUES (:user_id, :first_name, :last_name, :phone, :relationship)";
            
            $guardianStmt = $pdo->prepare($guardianSql);
            $guardianStmt->execute([
                ':user_id'      => $userId,
                ':first_name'   => $data['first_name'],
                ':last_name'    => $data['last_name'],
                ':phone'        => $data['phone'],
                ':relationship' => $data['relationship']
            ]);
            
            $guardianId = $pdo->lastInsertId();

            // 3. Link the Guardian to the Student
            if (!empty($data['student_id'])) {
                $linkSql = "INSERT INTO student_guardians (student_id, guardian_id) VALUES (?, ?)";
                $linkStmt = $pdo->prepare($linkSql);
                $linkStmt->execute([$data['student_id'], $guardianId]);
            }

            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}
