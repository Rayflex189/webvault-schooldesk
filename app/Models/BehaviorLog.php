<?php
// app/Models/BehaviorLog.php

namespace App\Models;

use Database;
use PDO;

class BehaviorLog {
    
    public function create($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO behavior_logs (student_id, teacher_id, type, title, description, date) 
                VALUES (:student_id, :teacher_id, :type, :title, :description, :date)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':student_id' => $data['student_id'],
            ':teacher_id' => $data['teacher_id'],
            ':type'       => $data['type'],
            ':title'      => $data['title'],
            ':description'=> $data['description'],
            ':date'       => $data['date']
        ]);
    }

    public function getByStudent($studentId) {
        $pdo = Database::getInstance();
        $sql = "SELECT b.*, t.first_name, t.last_name 
                FROM behavior_logs b
                JOIN teachers t ON b.teacher_id = t.id
                WHERE b.student_id = ?
                ORDER BY b.date DESC, b.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public function getRecentByTeacher($teacherId) {
        $pdo = Database::getInstance();
        $sql = "SELECT b.*, s.first_name, s.last_name 
                FROM behavior_logs b
                JOIN students s ON b.student_id = s.id
                WHERE b.teacher_id = ?
                ORDER BY b.created_at DESC LIMIT 10";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll();
    }
}
