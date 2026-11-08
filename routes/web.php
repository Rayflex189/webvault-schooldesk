<?php
// routes/web.php

use App\Controllers\AuthController;
use App\Controllers\StudentController;
use App\Controllers\TeacherController;
use App\Controllers\SubjectController;
use App\Controllers\ClassController;
use App\Controllers\TeacherAssignmentController;
use App\Controllers\AttendanceController;
use App\Controllers\ExamController;
use App\Controllers\ReportCardController;
use App\Controllers\FinanceController;
use App\Middleware\AuthMiddleware;

return [
    // ==========================================
    // Public Routes
    // ==========================================
    '/' => function() {
        redirect('login');
    },
    'login' => function() {
        $auth = new AuthController();
        $auth->login();
    },
    'logout' => function() {
        $auth = new AuthController();
        $auth->logout();
    },

    // ==========================================
    // Protected Admin Routes
    // ==========================================
    'admin/dashboard' => function() {
        AuthMiddleware::adminOnly();
        view('admin.dashboard');
    },
    
    // ==========================================
    // Student Management
    // ==========================================
    'admin/students' => function() {
        $controller = new StudentController();
        $controller->index();
    },
    'admin/students/create' => function() {
        $controller = new StudentController();
        $controller->create();
    },
    'admin/students/store' => function() {
        $controller = new StudentController();
        $controller->store();
    },

    // ==========================================
    // Teacher Management
    // ==========================================
    'admin/teachers' => function() {
        $controller = new TeacherController();
        $controller->index();
    },
    'admin/teachers/create' => function() {
        $controller = new TeacherController();
        $controller->create();
    },
    'admin/teachers/store' => function() {
        $controller = new TeacherController();
        $controller->store();
    },

    // ==========================================
    // Subject Management
    // ==========================================
    'admin/subjects' => function() {
        $controller = new SubjectController();
        $controller->index();
    },
    'admin/subjects/create' => function() {
        $controller = new SubjectController();
        $controller->create();
    },
    'admin/subjects/store' => function() {
        $controller = new SubjectController();
        $controller->store();
    },

    // ==========================================
    // Class Management
    // ==========================================
    'admin/classes' => function() {
        $controller = new ClassController();
        $controller->index();
    },
    'admin/classes/create' => function() {
        $controller = new ClassController();
        $controller->create();
    },
    'admin/classes/store' => function() {
        $controller = new ClassController();
        $controller->store();
    },
    'admin/classes/subjects' => function() {
        $controller = new ClassController();
        $controller->manageSubjects();
    },
    'admin/classes/subjects/update' => function() {
        $controller = new ClassController();
        $controller->updateSubjects();
    },

    // ==========================================
    // Teacher Assignments
    // ==========================================
    'admin/assignments' => function() {
        $controller = new TeacherAssignmentController();
        $controller->index();
    },
    'admin/assignments/create' => function() {
        $controller = new TeacherAssignmentController();
        $controller->create();
    },
    'admin/assignments/store' => function() {
        $controller = new TeacherAssignmentController();
        $controller->store();
    },

    // ==========================================
    // Attendance Management
    // ==========================================
    'admin/attendance' => function() {
        $controller = new AttendanceController();
        $controller->index();
    },
    'admin/attendance/mark' => function() {
        $controller = new AttendanceController();
        $controller->mark();
    },
    'admin/attendance/store' => function() {
        $controller = new AttendanceController();
        $controller->store();
    },

    // ==========================================
    // Exams & Results
    // ==========================================
    'admin/exams' => function() {
        $controller = new ExamController();
        $controller->index();
    },
    'admin/exams/entry' => function() {
        $controller = new ExamController();
        $controller->entry();
    },
    'admin/exams/store' => function() {
        $controller = new ExamController();
        $controller->store();
    },

    // ==========================================
    // Report Cards
    // ==========================================
    'admin/reports' => function() {
        $controller = new ReportCardController();
        $controller->index();
    },
    'admin/reports/generate' => function() {
        $controller = new ReportCardController();
        $controller->generate();
    },

    // ==========================================
    // Finance & Fees
    // ==========================================
    'admin/finance' => function() {
        $controller = new FinanceController();
        $controller->index();
    },
    'admin/finance/create' => function() {
        $controller = new FinanceController();
        $controller->create();
    },
    'admin/finance/store' => function() {
        $controller = new FinanceController();
        $controller->store();
    }
];
