<?php
namespace App\Models;

use Database;
use PDO;

class Book {
    public function getByClass($classId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM class_books WHERE class_id = ? ORDER BY title ASC");
        $stmt->execute([$classId]);
        return $stmt->fetchAll();
    }

    public function add($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO class_books (class_id, title, author, is_compulsory) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$data['class_id'], $data['title'], $data['author'], $data['is_compulsory']]);
    }

    public function delete($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM class_books WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }
}
