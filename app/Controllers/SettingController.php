<?php
// app/Controllers/SettingController.php

namespace App\Controllers;

use App\Models\Setting;
use App\Middleware\AuthMiddleware;

class SettingController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new Setting();
        
        view('admin.settings.index', [
            'settings' => $model->getSettings(),
            'sessions' => $model->getSessions()
        ]);
    }

    public function updateSchoolInfo() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $model = new Setting();
        if ($model->updateSchoolInfo($_POST)) {
            $_SESSION['success'] = "School information updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update school information.";
        }
        redirect('admin/settings');
    }

    public function updateCurrentSession() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $session = $_POST['session'] ?? '';
        $term = $_POST['term'] ?? '';
        
        if (empty($session) || empty($term)) {
            $_SESSION['error'] = "Session and Term are required.";
            redirect('admin/settings');
        }

        $model = new Setting();
        if ($model->updateCurrentSession($session, $term)) {
            $_SESSION['success'] = "Global Session updated to {$session} - {$term}!";
        } else {
            $_SESSION['error'] = "Failed to update session.";
        }
        redirect('admin/settings');
    }

    public function createSession() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $name = $_POST['session_name'] ?? '';
        if (empty($name)) {
            $_SESSION['error'] = "Session name is required.";
            redirect('admin/settings');
        }

        $model = new Setting();
        $model->createSession($name);
        $_SESSION['success'] = "Academic session added successfully!";
        redirect('admin/settings');
    }
}
