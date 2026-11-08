<?php
// app/Models/Teacher.php

namespace App\Models;

use Database;
use PDO;

class Teacher {
    
    public function all() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM teachers ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function create($data) {
        $pdo = Database::getInstance();
        
        $sql = "INSERT INTO teachers (staff_id, first_name, last_name, email, phone, gender, qualification) 
                VALUES (:staff_id, :first_name, :last_name, :email, :phone, :gender, :qualification)";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':staff_id'      => $data['staff_id'],
            ':first_name'    => $data['first_name'],
            ':last_name'     => $data['last_name'],
            ':email'         => $data['email'],
            ':phone'         => $data['phone'],
            ':gender'        => $data['gender'],
            ':qualification' => $data['qualification']
        ]);
    }
}
