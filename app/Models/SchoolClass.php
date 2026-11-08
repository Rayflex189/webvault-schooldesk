<?php
// app/Models/SchoolClass.php

namespace App\Models;

use Database;
use PDO;

class SchoolClass {
    
    public function all() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM classes ORDER BY name ASC")->fetchAll();
    }

    public function create($data) {
        $pdo = Database::getInstance();
        
        $sql = "INSERT INTO classes (name, capacity) VALUES (:name, :capacity)";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':capacity' => $data['capacity']
        ]);
    }
}
