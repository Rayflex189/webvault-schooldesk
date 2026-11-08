<?php
// app/Models/Subject.php

namespace App\Models;

use Database;
use PDO;

class Subject {
    
    /**
     * Fetch all subjects
     */
    public function all() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM subjects ORDER BY name ASC")->fetchAll();
    }

    /**
     * Create a new subject
     */
    public function create($data) {
        $pdo = Database::getInstance();
        
        $sql = "INSERT INTO subjects (name, code) VALUES (:name, :code)";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':code' => $data['code']
        ]);
    }

    /**
     * Find a subject by ID
     */
    public function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Update a subject
     */
    public function update($id, $data) {
        $pdo = Database::getInstance();
        $sql = "UPDATE subjects SET name = :name, code = :code WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':code' => $data['code'],
            ':id'   => $id
        ]);
    }

    /**
     * Delete a subject
     */
    public function delete($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM subjects WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
