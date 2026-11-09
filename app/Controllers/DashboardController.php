<?php
// app/Controllers/DashboardController.php

namespace App\Controllers;

use App\Models\Dashboard;
use App\Middleware\AuthMiddleware;

class DashboardController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        
        $model = new Dashboard();
        
        // Global settings
        $settings = get_settings();
        $session = $settings['current_session'] ?? '2024/2025';
        $term = $settings['current_term'] ?? 'First Term';
        
        // Stats & Analysis
        $stats = $model->getStats($session, $term);
        $feesAnalysis = $model->getFeesAnalysis($session, $term);
        $recentStudents = $model->getRecentStudents();
        
        // Chart Data
        $studentDistribution = $model->getStudentDistribution();
        $attendanceTrend = $model->getAttendanceTrend();

        view('admin.dashboard', [
            'stats' => $stats,
            'feesAnalysis' => $feesAnalysis,
            'recentStudents' => $recentStudents,
            'active_session' => $session,
            'active_term' => $term,
            // Convert arrays to JSON for Chart.js
            'chart_students_labels' => json_encode(array_column($studentDistribution, 'class_name')),
            'chart_students_data' => json_encode(array_column($studentDistribution, 'student_count')),
            'chart_attendance_labels' => json_encode(array_column($attendanceTrend, 'date')),
            'chart_attendance_present' => json_encode(array_column($attendanceTrend, 'present_count')),
            'chart_attendance_absent' => json_encode(array_column($attendanceTrend, 'absent_count')),
        ]);
    }
}
