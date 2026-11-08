<?php
// app/Models/Teacher.php

namespace App\Models;

use Database;
use PDO;

class Teacher {
    
    /**
     * Fetch all teachers
     */
    public function all() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM teachers ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Find a teacher by ID
     */
    public function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Create a new teacher record and their corresponding user account
     */
    public function create($data) {
        $pdo = Database::getInstance();
        
        try {
            $pdo->beginTransaction();

            // 1. Create the User Account
            $passwordHash = password_hash('password123', PASSWORD_DEFAULT);
            
            $userSql = "INSERT INTO users (role_id, username, email, password_hash) 
                        VALUES (2, :username, :email, :password_hash)";
            $userStmt = $pdo->prepare($userSql);
            $userStmt->execute([
                ':username' => $data['email'], // Using email as username
                ':email'    => $data['email'],
                ':password_hash' => $passwordHash
            ]);
            
            $userId = $pdo->lastInsertId();

            // 2. Create the Teacher Profile
            $teacherSql = "INSERT INTO teachers (user_id, staff_id, first_name, last_name, email, phone, gender, qualification) 
                           VALUES (:user_id, :staff_id, :first_name, :last_name, :email, :phone, :gender, :qualification)";
            
            $teacherStmt = $pdo->prepare($teacherSql);
            $teacherStmt->execute([
                ':user_id'       => $userId,
                ':staff_id'      => $data['staff_id'],
                ':first_name'    => $data['first_name'],
                ':last_name'     => $data['last_name'],
                ':email'         => $data['email'],
                ':phone'         => $data['phone'],
                ':gender'        => $data['gender'],
                ':qualification' => $data['qualification']
            ]);

            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }

    /**
     * Update a teacher's profile
     */
    public function update($id, $data) {
        $pdo = Database::getInstance();
        $sql = "UPDATE teachers 
                SET first_name = :first_name, last_name = :last_name, phone = :phone, 
                    gender = :gender, qualification = :qualification, status = :status 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':first_name'    => $data['first_name'],
            ':last_name'     => $data['last_name'],
            ':phone'         => $data['phone'],
            ':gender'        => $data['gender'],
            ':qualification' => $data['qualification'],
            ':status'        => $data['status'],
            ':id'            => $id
        ]);
    }
}
