<?php
// app/Controllers/DashboardController.php

namespace App\Controllers;

use App\Models\Dashboard;
use App\Middleware\AuthMiddleware;

class DashboardController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        
        $model = new Dashboard();
        $stats = $model->getStats();
        $recentStudents = $model->getRecentStudents();

        view('admin.dashboard', [
            'stats' => $stats,
            'recentStudents' => $recentStudents
        ]);
    }
}
