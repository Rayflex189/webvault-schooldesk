<?php
// app/Controllers/TeacherAttendanceController.php

namespace App\Controllers;

use App\Middleware\TeacherMiddleware;
use App\Models\TeacherAssignment;
use App\Models\Attendance;

class TeacherAttendanceController {
    
    public function mark() {
        TeacherMiddleware::handle();
        
        $classId = $_GET['class_id'] ?? null;
        $date = $_GET['date'] ?? date('Y-m-d');

        if (!$classId) {
            redirect('teacher/dashboard');
        }

        // SECURITY CHECK: Is this teacher assigned to this class?
        $assignmentModel = new TeacherAssignment();
        if (!$assignmentModel->isTeacherAssignedToClass($_SESSION['user_id'], $classId)) {
            http_response_code(403);
            die("403 - Unauthorized. You are not assigned to this class.");
        }

        $attendanceModel = new Attendance();
        $students = $attendanceModel->getStudentsForClass($classId, $date);
        
        // Get class name for the UI
        $classes = $attendanceModel->getClasses();
        $className = 'Unknown';
        foreach($classes as $c) {
            if($c['id'] == $classId) {
                $className = $c['name'];
                break;
            }
        }

        view('teacher.attendance.mark', [
            'students' => $students,
            'class_id' => $classId,
            'class_name' => $className,
            'date' => $date
        ]);
    }

    public function store() {
        TeacherMiddleware::handle();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $classId = $_POST['class_id'] ?? null;
        $date = $_POST['date'] ?? null;
        $attendance = $_POST['attendance'] ?? [];

        if (!$classId || !$date) {
            redirect('teacher/dashboard');
        }

        // SECURITY CHECK: Is this teacher assigned to this class?
        $assignmentModel = new TeacherAssignment();
        if (!$assignmentModel->isTeacherAssignedToClass($_SESSION['user_id'], $classId)) {
            http_response_code(403);
            die("403 - Unauthorized.");
        }

        $attendanceModel = new Attendance();
        $success = $attendanceModel->saveAttendance($classId, $date, $attendance, $_SESSION['user_id']);

        if ($success) {
            $_SESSION['success'] = "Attendance saved successfully!";
        } else {
            $_SESSION['error'] = "Failed to save attendance.";
        }

        redirect("teacher/attendance?class_id={$classId}&date={$date}");
    }
}
