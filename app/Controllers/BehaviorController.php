<?php
// app/Controllers/BehaviorController.php

namespace App\Controllers;

use App\Middleware\TeacherMiddleware;
use App\Middleware\ParentMiddleware;
use App\Middleware\StudentMiddleware;
use App\Models\BehaviorLog;
use App\Models\TeacherAssignment;
use Database;

class BehaviorController {
    
    // ==========================================
    // TEACHER METHODS
    // ==========================================
    
    public function teacherIndex() {
        TeacherMiddleware::handle();
        $pdo = Database::getInstance();
        
        // Get teacher ID
        $stmt = $pdo->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $teacher = $stmt->fetch();

        // Get students in classes assigned to this teacher
        $assignmentModel = new TeacherAssignment();
        $assignments = $assignmentModel->getAssignmentsByUserId($_SESSION['user_id']);
        
        $classes = [];
        foreach($assignments as $a) {
            $classes[$a['class_id']] = $a['class_name'];
        }

        // Fetch students in those classes
        $students = [];
        if(!empty($classes)) {
            $inQuery = implode(',', array_fill(0, count($classes), '?'));
            $stmt = $pdo->prepare("SELECT id, first_name, last_name, class_id FROM students WHERE class_id IN ($inQuery) AND status = 'active' ORDER BY first_name ASC");
            $stmt->execute(array_keys($classes));
            $students = $stmt->fetchAll();
        }

        $logModel = new BehaviorLog();
        $recentLogs = $logModel->getRecentByTeacher($teacher['id']);

        view('teacher.behavior.index', [
            'students' => $students,
            'recentLogs' => $recentLogs,
            'teacher_id' => $teacher['id']
        ]);
    }

    public function store() {
        TeacherMiddleware::handle();
        verify_csrf($_POST['csrf_token'] ?? '');

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $teacher = $stmt->fetch();

        $model = new BehaviorLog();
        $model->create([
            'student_id'  => $_POST['student_id'],
            'teacher_id'  => $teacher['id'],
            'type'        => $_POST['type'],
            'title'       => $_POST['title'],
            'description' => $_POST['description'],
            'date'        => date('Y-m-d')
        ]);

        $_SESSION['success'] = "Behavior log recorded successfully!";
        redirect('teacher/behavior');
    }

    // ==========================================
    // PARENT METHODS
    // ==========================================

    public function parentIndex() {
        ParentMiddleware::handle();
        $pdo = Database::getInstance();
        $userId = $_SESSION['user_id'];

        $stmt = $pdo->prepare("
            SELECT s.id, s.first_name, s.last_name, c.name AS class_name
            FROM students s
            JOIN student_guardians sg ON s.id = sg.student_id
            JOIN guardians g ON sg.guardian_id = g.id
            JOIN classes c ON s.class_id = c.id
            WHERE g.user_id = ?
        ");
        $stmt->execute([$userId]);
        $children = $stmt->fetchAll();

        $logModel = new BehaviorLog();
        $childrenLogs = [];
        foreach($children as $child) {
            $childrenLogs[] = [
                'child' => $child,
                'logs' => $logModel->getByStudent($child['id'])
            ];
        }

        view('parent.behavior.index', ['childrenLogs' => $childrenLogs]);
    }

    // ==========================================
    // STUDENT METHODS
    // ==========================================

    public function studentIndex() {
        StudentMiddleware::handle();
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("SELECT id FROM students WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $student = $stmt->fetch();

        $logModel = new BehaviorLog();
        $logs = $logModel->getByStudent($student['id']);

        view('student.behavior.index', ['logs' => $logs]);
    }
}
