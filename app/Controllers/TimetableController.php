<?php
// app/Controllers/TimetableController.php

namespace App\Controllers;

use App\Models\Timetable;
use App\Middleware\AuthMiddleware;

class TimetableController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new Timetable();
        
        $settings = get_settings();
        $session = $_GET['session'] ?? $settings['current_session'] ?? '2024/2025';
        $term = $_GET['term'] ?? $settings['current_term'] ?? 'First Term';
        
        $classes = $model->getClasses();
        $selectedClass = $_GET['class_id'] ?? $classes[0]['id'] ?? null;
        
        $slots = $selectedClass ? $model->getSlots($selectedClass, $session, $term) : [];

        view('admin.timetables.index', [
            'classes' => $classes,
            'subjects' => $model->getSubjects(),
            'teachers' => $model->getTeachers(),
            'slots' => $slots,
            'selectedClass' => $selectedClass,
            'session' => $session,
            'term' => $term
        ]);
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $model = new Timetable();
        $success = $model->addSlot($_POST);

        if ($success) {
            $_SESSION['success'] = "Timetable slot added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add slot.";
        }
        
        redirect("admin/timetables?class_id={$_POST['class_id']}&session={$_POST['session']}&term={$_POST['term']}");
    }

    public function destroy() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $model = new Timetable();
        $model->deleteSlot($_POST['id']);
        
        $_SESSION['success'] = "Timetable slot removed.";
        redirect("admin/timetables?class_id={$_POST['class_id']}&session={$_POST['session']}&term={$_POST['term']}");
    }
}
