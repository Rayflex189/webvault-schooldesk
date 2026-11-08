<?php
// routes/web.php

use App\Controllers\AuthController;
use App\Controllers\StudentController;
use App\Controllers\TeacherController;
use App\Controllers\SubjectController;
use App\Controllers\ClassController;
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
    }
];
