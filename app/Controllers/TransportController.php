<?php
// app/Controllers/TransportController.php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\Transport;
use Database;

class TransportController {
    
    // ==========================================
    // ADMIN METHODS
    // ==========================================

    public function index() {
        AuthMiddleware::adminOnly();
        $model = new Transport();
        $routes = $model->getAllRoutes();
        view('admin.transport.index', ['routes' => $routes]);
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');

        $model = new Transport();
        $model->createRoute($_POST);

        $_SESSION['success'] = "Bus route created successfully!";
        redirect('admin/transport');
    }

    public function destroy() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $model = new Transport();
        $model->deleteRoute($_POST['id']);

        $_SESSION['success'] = "Bus route deleted.";
        redirect('admin/transport');
    }

    public function assign() {
        AuthMiddleware::adminOnly();
        $model = new Transport();
        
        $routes = $model->getAllRoutes();
        $students = $model->getAllStudentsWithRoutes();

        view('admin.transport.assign', [
            'routes' => $routes,
            'students' => $students
        ]);
    }

    public function updateAssignment() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $model = new Transport();
        $studentId = $_POST['student_id'];
        $routeId = $_POST['bus_route_id']; // Can be empty string to remove assignment

        $model->assignStudent($studentId, $routeId);

        $_SESSION['success'] = "Student transport assignment updated.";
        redirect('admin/transport/assign');
    }

    // ==========================================
    // PARENT & STUDENT METHODS
    // ==========================================

    public function parentView() {
        \App\Middleware\ParentMiddleware::handle();
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

        $model = new Transport();
        $childrenRoutes = [];
        foreach($children as $child) {
            $childrenRoutes[] = [
                'child' => $child,
                'route' => $model->getStudentRoute($child['id'])
            ];
        }

        view('parent.transport', ['childrenRoutes' => $childrenRoutes]);
    }

    public function studentView() {
        \App\Middleware\StudentMiddleware::handle();
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("SELECT id FROM students WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $student = $stmt->fetch();

        $model = new Transport();
        $route = $model->getStudentRoute($student['id']);

        view('student.transport', ['route' => $route]);
    }
}
