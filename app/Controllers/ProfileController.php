<?php
namespace App\Controllers;

use Database;

class ProfileController {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) redirect('login');
        
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        view('profile', ['user' => $user]);
    }

    public function updatePassword() {
        if (!isset($_SESSION['user_id'])) redirect('login');
        verify_csrf($_POST['csrf_token'] ?? '');

        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "New passwords do not match.";
            redirect('profile');
        }

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (password_verify($currentPassword, $user['password_hash'])) {
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
            $stmt->execute([$newHash, $_SESSION['user_id']]);
            $_SESSION['success'] = "Password updated successfully!";
        } else {
            $_SESSION['error'] = "Current password is incorrect.";
        }
        
        redirect('profile');
    }
}
