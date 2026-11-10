<?php
// app/Controllers/TeacherDashboardController.php

namespace App\Controllers;

use App\Middleware\TeacherMiddleware;
use App\Models\TeacherAssignment;
use App\Models\Timetable;
use Database; // <-- This was missing!

class TeacherDashboardController {
    
    public function index() {
        TeacherMiddleware::handle();
        
        $model = new TeacherAssignment();
        $assignments = $model->getAssignmentsByUserId($_SESSION['user_id']);

        view('teacher.dashboard', [
            'assignments' => $assignments
        ]);
    }

    public function timetable() {
        TeacherMiddleware::handle();
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $teacher = $stmt->fetch();

        $assignmentModel = new TeacherAssignment();
        $assignments = $assignmentModel->getAssignmentsByUserId($_SESSION['user_id']);
        
        $classes = [];
        foreach($assignments as $a) {
            $classes[$a['class_id']] = $a['class_name'];
        }

        $settings = get_settings();
        $session = $settings['current_session'] ?? '2024/2025';
        $term = $settings['current_term'] ?? 'First Term';
        
        $selectedClass = $_GET['class_id'] ?? array_key_first($classes);
        
        $timetableModel = new Timetable();
        $slots = $selectedClass ? $timetableModel->getSlots($selectedClass, $session, $term) : [];

        view('teacher.timetable', [
            'classes' => $classes,
            'slots' => $slots,
            'selectedClass' => $selectedClass,
            'session' => $session,
            'term' => $term
        ]);
    }
}
