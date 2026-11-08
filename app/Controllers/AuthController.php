<?php
// app/Controllers/AuthController.php

namespace App\Controllers;

use Database;

class AuthController {
    
    public function login() {
        // If already logged in, redirect based on role
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role_id'] == 1) {
                redirect('admin/dashboard');
            } elseif ($_SESSION['role_id'] == 2) {
                redirect('teacher/dashboard');
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Verify CSRF Token
            verify_csrf($_POST['csrf_token'] ?? '');

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Please enter both username and password.';
                redirect('login');
            }

            // 2. Fetch User from Database
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND status = 'active' AND deleted_at IS NULL");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // 3. Verify Password
            if ($user && password_verify($password, $user['password_hash'])) {
                // Prevent Session Fixation
                session_regenerate_id(true);
                
                // Set Session Variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['username'] = $user['username'];

                // 4. Redirect based on role
                if ($user['role_id'] == 1) {
                    redirect('admin/dashboard');
                } elseif ($user['role_id'] == 2) {
                    redirect('teacher/dashboard');
                } else {
                    // Fallback for parents/students if we add their portals later
                    redirect('login'); 
                }
            } else {
                $_SESSION['error'] = 'Invalid username or password.';
                redirect('login');
            }
        }

        // If GET request, show login form
        view('auth.login');
    }

    public function logout() {
        session_unset();
        session_destroy();
        redirect('login');
    }
}
