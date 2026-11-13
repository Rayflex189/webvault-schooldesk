<?php
// app/Controllers/AuthController.php

namespace App\Controllers;

use Database;
use App\Services\SmsService;

class AuthController {
    
    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole($_SESSION['role_id']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf($_POST['csrf_token'] ?? '');

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Please enter both username and password.';
                redirect('login');
            }

            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND status = 'active' AND deleted_at IS NULL");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['username'] = $user['username'];

                $this->redirectBasedOnRole($user['role_id']);
            } else {
                $_SESSION['error'] = 'Invalid username or password.';
                redirect('login');
            }
        }

        view('auth.login');
    }

    private function redirectBasedOnRole($roleId) {
        if ($roleId == 1) redirect('admin/dashboard');
        elseif ($roleId == 2) redirect('teacher/dashboard');
        elseif ($roleId == 3) redirect('parent/dashboard');
        elseif ($roleId == 4) redirect('student/dashboard');
        else redirect('login');
    }

    public function logout() {
        session_unset();
        session_destroy();
        redirect('login');
    }

    // ==========================================
    // FORGOT PASSWORD METHODS
    // ==========================================

    public function showForgotForm() {
        view('auth.forgot');
    }

    public function sendResetLink() {
        verify_csrf($_POST['csrf_token'] ?? '');
        $email = trim($_POST['email'] ?? '');

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate secure token
            $token = bin2hex(random_bytes(32));
            
            // Save token to database
            $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->execute([$email]);
            
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
            $stmt->execute([$email, $token]);

            // Send Email
            $resetLink = env('APP_URL') . "/reset-password?token=" . $token;
            $subject = "Password Reset Request - " . env('APP_NAME');
            $message = "
                <div style='font-family: Arial, sans-serif; padding: 20px;'>
                    <h2>Password Reset Request</h2>
                    <p>We received a request to reset the password for your account.</p>
                    <p>Click the button below to reset it. This link expires in 1 hour.</p>
                    <a href='{$resetLink}' style='display:inline-block; padding: 10px 20px; background-color: #1E3A8A; color: white; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                    <p>If you did not request this, please ignore this email.</p>
                </div>
            ";

            $mailer = new SmsService(); // We are reusing the SMTP service
            $mailer->send($email, $subject, $message);
        }

        // Always show success to prevent email enumeration
        $_SESSION['success'] = "If your email is registered, you will receive a password reset link shortly.";
        redirect('forgot-password');
    }

    public function showResetForm() {
        $token = $_GET['token'] ?? '';
        
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();

        if (!$reset) {
            $_SESSION['error'] = "Invalid or expired password reset token.";
            redirect('login');
        }

        view('auth.reset', ['token' => $token]);
    }

    public function resetPassword() {
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            redirect('reset-password?token=' . $token);
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = "Password must be at least 6 characters.";
            redirect('reset-password?token=' . $token);
        }

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();

        if ($reset) {
            $email = $reset['email'];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Update password
            $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
            $stmt->execute([$hash, $email]);

            // Delete token
            $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->execute([$email]);

            $_SESSION['success'] = "Password reset successfully! You can now log in.";
            redirect('login');
        } else {
            $_SESSION['error'] = "Invalid or expired password reset token.";
            redirect('login');
        }
    }
}
