<?php
// app/Controllers/CommunicationController.php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Services\SmsService;
use Database;

class CommunicationController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $pdo = Database::getInstance();
        
        $logs = $pdo->query("SELECT * FROM message_logs ORDER BY created_at DESC LIMIT 10")->fetchAll();
        $classes = $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();

        view('admin.communication.index', [
            'logs' => $logs,
            'classes' => $classes
        ]);
    }

    public function send() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');

        $audience = $_POST['audience']; 
        $classId = $_POST['class_id'] ?? null;
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);

        if (empty($message) || empty($subject)) {
            $_SESSION['error'] = "Subject and Message are required.";
            redirect('admin/communication');
        }

        $pdo = Database::getInstance();
        $recipients = [];

        // Determine who gets the email
        if ($audience === 'all_parents') {
            $stmt = $pdo->query("
                SELECT DISTINCT u.email, g.first_name, g.last_name 
                FROM guardians g
                JOIN users u ON g.user_id = u.id
                WHERE u.status = 'active'
            ");
            $recipients = $stmt->fetchAll();
        } elseif ($audience === 'class_parents' && $classId) {
            $stmt = $pdo->prepare("
                SELECT DISTINCT u.email, g.first_name, g.last_name, s.first_name as student_name
                FROM guardians g
                JOIN users u ON g.user_id = u.id
                JOIN student_guardians sg ON g.id = sg.guardian_id
                JOIN students s ON sg.student_id = s.id
                WHERE s.class_id = ? AND s.status = 'active'
            ");
            $stmt->execute([$classId]);
            $recipients = $stmt->fetchAll();
        } elseif ($audience === 'all_teachers') {
            $stmt = $pdo->query("
                SELECT t.email, t.first_name, t.last_name 
                FROM teachers t
                JOIN users u ON t.user_id = u.id
                WHERE u.status = 'active'
            ");
            $recipients = $stmt->fetchAll();
        }

        if (empty($recipients)) {
            $_SESSION['error'] = "No recipients found for this audience.";
            redirect('admin/communication');
        }

        $mailer = new SmsService();
        $successCount = 0;
        $settings = get_settings();
        $schoolName = $settings['school_name'] ?? 'SchoolDesk';

        foreach ($recipients as $r) {
            $personalizedMsg = str_replace(
                ['{name}', '{student}'], 
                [$r['first_name'], $r['student_name'] ?? ''], 
                $message
            );
            
            // Wrap in a nice HTML email template
            $htmlBody = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;'>
                    <h2 style='color: #1E3A8A; border-bottom: 2px solid #0EA5E9; padding-bottom: 10px;'>{$schoolName}</h2>
                    <p style='font-size: 16px; color: #333; line-height: 1.6;'>$personalizedMsg</p>
                    <br>
                    <hr style='border: none; border-top: 1px solid #eee;'>
                    <p style='font-size: 12px; color: #888;'>This email was sent from the {$schoolName} Administration Portal.</p>
                </div>
            ";

            if ($mailer->send($r['email'], $subject, $htmlBody)) {
                $successCount++;
            }
        }

        if ($successCount > 0) {
            $_SESSION['success'] = "Email sent successfully to {$successCount} recipients!";
        } else {
            $_SESSION['error'] = "Failed to send emails. Please check your SMTP credentials in the .env file.";
        }
        
        redirect('admin/communication');
    }
}
