<?php
// app/Models/Announcement.php

namespace App\Models;

use Database;
use PDO;

class Announcement {
    
    public function all() {
        $pdo = Database::getInstance();
        
        $sql = "SELECT a.*, u.username 
                FROM announcements a 
                JOIN users u ON a.created_by = u.id 
                ORDER BY a.created_at DESC";
                
        return $pdo->query($sql)->fetchAll();
    }

    public function create($data) {
        $pdo = Database::getInstance();
        
        $sql = "INSERT INTO announcements (title, content, target_audience, created_by) 
                VALUES (:title, :content, :target_audience, :created_by)";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':title'           => $data['title'],
            ':content'         => $data['content'],
            ':target_audience' => $data['target_audience'],
            ':created_by'      => $data['created_by']
        ]);
    }
}
