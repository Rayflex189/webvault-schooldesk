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
     * Update school information
     */
    public function updateSchoolInfo($data) {
        $pdo = Database::getInstance();
        
        $sql = "UPDATE school_settings 
                SET school_name = :name, motto = :motto, address = :address, phone = :phone, email = :email 
                WHERE id = 1";
                
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':name'    => $data['school_name'],
            ':motto'   => $data['motto'],
            ':address' => $data['address'],
            ':phone'   => $data['phone'],
            ':email'   => $data['email']
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
