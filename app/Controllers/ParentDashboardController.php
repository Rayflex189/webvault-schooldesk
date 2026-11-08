<?php
// app/Controllers/ParentDashboardController.php

namespace App\Controllers;

use App\Middleware\ParentMiddleware;
use Database;

class ParentDashboardController {
    
    public function index() {
        ParentMiddleware::handle();
        
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

        // 1. Get the Guardian Profile
        $stmt = $pdo->prepare("SELECT * FROM guardians WHERE user_id = ?");
        $stmt->execute([$userId]);
        $guardian = $stmt->fetch();

        // 2. Get linked children
        $children = [];
        if ($guardian) {
            $stmt = $pdo->prepare("
                SELECT s.*, c.name AS class_name 
                FROM students s
                JOIN student_guardians sg ON s.id = sg.student_id
                JOIN classes c ON s.class_id = c.id
                WHERE sg.guardian_id = ?
            ");
            $stmt->execute([$guardian['id']]);
            $children = $stmt->fetchAll();
        }

        // 3. Get recent announcements for parents
        $stmt = $pdo->query("SELECT * FROM announcements WHERE target_audience = 'parents' OR target_audience = 'all' ORDER BY created_at DESC LIMIT 3");
        $announcements = $stmt->fetchAll();

        view('parent.dashboard', [
            'guardian' => $guardian,
            'children' => $children,
            'announcements' => $announcements
        ]);
    }
}

