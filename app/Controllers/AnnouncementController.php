<?php
// app/Controllers/AnnouncementController.php

namespace App\Controllers;

use App\Models\Announcement;
use App\Middleware\AuthMiddleware;

class AnnouncementController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new Announcement();
        $announcements = $model->all();
        view('admin.announcements.index', ['announcements' => $announcements]);
    }

    public function create() {
        AuthMiddleware::adminOnly();
        view('admin.announcements.create');
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        if (empty($_POST['title']) || empty($_POST['content'])) {
            $_SESSION['error'] = "Title and content are required.";
            redirect('admin/announcements/create');
        }

        $data = [
            'title'           => $_POST['title'],
            'content'         => $_POST['content'],
            'target_audience' => $_POST['target_audience'] ?? 'all',
            'created_by'      => $_SESSION['user_id']
        ];

        $model = new Announcement();
        $success = $model->create($data);

        if ($success) {
            $_SESSION['success'] = "Announcement published successfully!";
            redirect('admin/announcements');
        } else {
            $_SESSION['error'] = "Failed to publish announcement.";
            redirect('admin/announcements/create');
        }
    }
}
