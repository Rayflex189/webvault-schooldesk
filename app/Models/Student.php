<?php
// app/Models/Student.php

namespace App\Models;

use Database;
use PDO;

class Student {
    
    /**
     * Fetch all students with their associated class names
     */
    public function all() {
        $pdo = Database::getInstance();
        
        // We use a JOIN to get the class name, and sort by newest first
        $stmt = $pdo->query("
            SELECT s.*, c.name as class_name 
            FROM students s 
            LEFT JOIN classes c ON s.class_id = c.id 
            ORDER BY s.created_at DESC
        ");
        
        return $stmt->fetchAll();
    }
}
