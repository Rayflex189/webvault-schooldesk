<?php
// app/Models/Setting.php

namespace App\Models;

use Database;
use PDO;

class Setting {
    
    /**
     * Get the single settings row
     */
    public function getSettings() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM school_settings WHERE id = 1")->fetch();
    }

    /**
     * Update school information and SMTP settings
     */
    public function updateSchoolInfo($data) {
        $pdo = Database::getInstance();
        
        $sql = "UPDATE school_settings 
                SET school_name = :name, motto = :motto, address = :address, phone = :phone, email = :email, contact_email = :contact_email,
                    smtp_host = :smtp_host, smtp_port = :smtp_port, smtp_user = :smtp_user, smtp_pass = :smtp_pass, smtp_encryption = :smtp_encryption,
                    mail_from_email = :mail_from_email, mail_from_name = :mail_from_name
                WHERE id = 1";
                
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':name'            => $data['school_name'],
            ':motto'           => $data['motto'],
            ':address'         => $data['address'],
            ':phone'           => $data['phone'],
            ':email'           => $data['email'],
            ':contact_email'   => $data['contact_email'],
            ':smtp_host'       => $data['smtp_host'] ?? null,
            ':smtp_port'       => $data['smtp_port'] ?? 587,
            ':smtp_user'       => $data['smtp_user'] ?? null,
            ':smtp_pass'       => $data['smtp_pass'] ?? null,
            ':smtp_encryption' => $data['smtp_encryption'] ?? 'tls',
            ':mail_from_email' => $data['mail_from_email'] ?? null,
            ':mail_from_name'  => $data['mail_from_name'] ?? null
        ]);
    }

    /**
     * Get all academic sessions
     */
    public function getSessions() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM academic_sessions ORDER BY session_name DESC")->fetchAll();
    }

    /**
     * Create a new session
     */
    public function createSession($name) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT IGNORE INTO academic_sessions (session_name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    /**
     * Update the currently active session and term globally
     */
    public function updateCurrentSession($session, $term) {
        $pdo = Database::getInstance();
        
        // Begin transaction to ensure both update successfully
        $pdo->beginTransaction();
        try {
            // 1. Update the settings table
            $stmt = $pdo->prepare("UPDATE school_settings SET current_session = ?, current_term = ? WHERE id = 1");
            $stmt->execute([$session, $term]);

            // 2. Mark the session as active in the sessions table
            $pdo->exec("UPDATE academic_sessions SET is_active = FALSE");
            $stmt = $pdo->prepare("UPDATE academic_sessions SET is_active = TRUE WHERE session_name = ?");
            $stmt->execute([$session]);

            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}
