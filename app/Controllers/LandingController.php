<?php
// app/Controllers/LandingController.php

namespace App\Controllers;

use Database;

class LandingController {
    
    public function index() {
        $pdo = Database::getInstance();
        
        // 1. Get Stats
        $students = $pdo->query("SELECT COUNT(*) FROM students WHERE status = 'active'")->fetchColumn();
        $teachers = $pdo->query("SELECT COUNT(*) FROM teachers WHERE status = 'active'")->fetchColumn();
        
        // 2. Get Testimonials
        $testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 3")->fetchAll();
        
        // 3. Get Settings
        $settings = get_settings();

        // 4. Load the View directly (no layout)
        view('landing', [
            'stats' => ['students' => $students, 'teachers' => $teachers],
            'testimonials' => $testimonials,
            'settings' => $settings
        ]);
    }

    public function submitTestimonial() {
        verify_csrf($_POST['csrf_token'] ?? '');
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("INSERT INTO testimonials (name, role, content, rating) VALUES (?, ?, ?, 5)");
        $stmt->execute([$_POST['name'], $_POST['role'], $_POST['content']]);
        
        $_SESSION['success'] = "Thank you! Your review has been published.";
        redirect('/');
    }

    public function submitContact() {
        verify_csrf($_POST['csrf_token'] ?? '');
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['email'], $_POST['message']]);
        
        // In a real app, you would use PHP's mail() or PHPMailer here to send an email to $settings['contact_email']
        
        $_SESSION['success'] = "Message sent! We will get back to you shortly.";
        redirect('/');
    }
}
