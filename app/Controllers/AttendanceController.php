<?php
// app/Controllers/AttendanceController.php

namespace App\Controllers;

use App\Models\Attendance;
use App\Middleware\AuthMiddleware;

class AttendanceController {
    
    /**
     * Show the form to select class and date
     */
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new Attendance();
        $classes = $model->getClasses();
        
        view('admin.attendance.index', ['classes' => $classes]);
    }

    /**
     * Show the marking sheet for a specific class and date
     */
    public function mark() {
        AuthMiddleware::adminOnly();
        
        $classId = $_GET['class_id'] ?? null;
        $date = $_GET['date'] ?? date('Y-m-d'); // Default to today

        if (!$classId) {
            redirect('admin/attendance');
        }

        $model = new Attendance();
        $classes = $model->getClasses();
        $students = $model->getStudentsForClass($classId, $date);

        // Find the current class name for the UI
        $currentClass = null;
        foreach ($classes as $c) {
            if ($c['id'] == $classId) {
                $currentClass = $c;
                break;
            }
        }

        view('admin.attendance.mark', [
            'classes' => $classes,
            'students' => $students,
            'class_id' => $classId,
            'class_name' => $currentClass['name'] ?? 'Unknown',
            'date' => $date
        ]);
    }

    /**
     * Save the marked attendance
     */
    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $classId = $_POST['class_id'] ?? null;
        $date = $_POST['date'] ?? null;
        $attendance = $_POST['attendance'] ?? []; // Array of [student_id => status]

        if (!$classId || !$date) {
            redirect('admin/attendance');
        }

        $model = new Attendance();
        $userId = $_SESSION['user_id'];

        $success = $model->saveAttendance($classId, $date, $attendance, $userId);

        if ($success) {
            $_SESSION['success'] = "Attendance saved successfully for " . count($attendance) . " students!";
        } else {
            $_SESSION['error'] = "Failed to save attendance. Please try again.";
        }

        // Redirect back to the same marking sheet
        redirect("admin/attendance/mark?class_id={$classId}&date={$date}");
    }
}
