<?php
// app/Models/Subject.php

namespace App\Models;

use Database;
use PDO;

class Subject {
    
    public function all() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM subjects ORDER BY name ASC")->fetchAll();
    }

    public function create($data) {
        $pdo = Database::getInstance();
        
        $sql = "INSERT INTO subjects (name, code) VALUES (:name, :code)";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':code' => $data['code']
        ]);
    }
}
