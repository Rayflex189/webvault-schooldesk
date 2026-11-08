<?php
// app/Controllers/DashboardController.php

namespace App\Controllers;

use App\Models\Dashboard;
use App\Middleware\AuthMiddleware;

class DashboardController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        
        $model = new Dashboard();
        
        // Use global settings for the current term
        $settings = get_settings();
        $session = $settings['current_session'] ?? '2024/2025';
        $term = $settings['current_term'] ?? 'First Term';
        
        $stats = $model->getStats($session, $term);
        $recentStudents = $model->getRecentStudents();

        view('admin.dashboard', [
            'stats' => $stats,
            'recentStudents' => $recentStudents,
            'active_session' => $session,
            'active_term' => $term
        ]);
    }
}
