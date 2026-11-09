<?php
// app/Models/Book.php

namespace App\Models;

use Database;
use PDO;

class Book {
    
    /**
     * Get all books for a specific class
     */
    public function getByClass($classId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM class_books WHERE class_id = ? ORDER BY title ASC");
        $stmt->execute([$classId]);
        return $stmt->fetchAll();
    }

    /**
     * Add a new book to the official class booklist
     */
    public function add($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO class_books (class_id, title, author, is_compulsory) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $data['class_id'], 
            $data['title'], 
            $data['author'], 
            $data['is_compulsory']
        ]);
    }

    /**
     * Delete a book from the official class booklist
     */
    public function delete($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM class_books WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Get all classes for dropdowns
     */
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }

    /**
     * Teacher recommends a book
     */
    public function recommend($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO book_recommendations (teacher_id, class_id, title, author, reason) 
                VALUES (:teacher_id, :class_id, :title, :author, :reason)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':teacher_id' => $data['teacher_id'],
            ':class_id'   => $data['class_id'],
            ':title'      => $data['title'],
            ':author'     => $data['author'],
            ':reason'     => $data['reason']
        ]);
    }

    /**
     * Admin fetches all pending recommendations
     */
    public function getPendingRecommendations() {
        $pdo = Database::getInstance();
        $sql = "SELECT r.*, t.first_name, t.last_name, c.name AS class_name 
                FROM book_recommendations r
                JOIN teachers t ON r.teacher_id = t.id
                JOIN classes c ON r.class_id = c.id
                WHERE r.status = 'pending'
                ORDER BY r.created_at DESC";
        return $pdo->query($sql)->fetchAll();
    }

    /**
     * Admin approves a recommendation (Moves it to official class_books)
     */
    public function approveRecommendation($id) {
        $pdo = Database::getInstance();
        
        try {
            $pdo->beginTransaction();
            
            // 1. Get the recommendation details
            $stmt = $pdo->prepare("SELECT * FROM book_recommendations WHERE id = ?");
            $stmt->execute([$id]);
            $rec = $stmt->fetch();

            if ($rec) {
                // 2. Insert into official class_books
                $this->add([
                    'class_id' => $rec['class_id'],
                    'title' => $rec['title'],
                    'author' => $rec['author'],
                    'is_compulsory' => 0 // Recommendations default to optional
                ]);

                // 3. Update status to approved
                $stmt = $pdo->prepare("UPDATE book_recommendations SET status = 'approved' WHERE id = ?");
                $stmt->execute([$id]);
            }
            
            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}
