<?php
// resources/views/student/dashboard.php
ob_start();
?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Student Dashboard</h1>
    <p class="text-sm text-gray-500 mt-1">Welcome back, <?= htmlspecialchars($student['first_name']) ?>!</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Profile & Quick Actions -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Profile Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 flex flex-col sm:flex-row items-center gap-6">
            <div class="w-20 h-20 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-2xl shrink-0">
                <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
            </div>
            <div class="text-center sm:text-left">
                <h2 class="text-xl font-bold text-gray-900"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></h2>
                <p class="text-sm text-gray-500 font-medium"><?= e($student['admission_number']) ?></p>
                <div class="mt-2 inline-flex items-center gap-2 bg-gray-50 px-3 py-1 rounded-lg border border-gray-200 text-sm">
                    <i data-lucide="school" class="w-4 h-4 text-gray-500"></i>
                    <span class="font-medium text-gray-700"><?= e($student['class_name']) ?></span>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Academic Results</h3>
            
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div>
                    <p class="text-sm font-medium text-gray-800">View your latest report card</p>
                    <p class="text-xs text-gray-500 mt-1">Session: 2024/2025 | Term: First Term</p>
                </div>
                <a href="/student/report-card?session=2024/2025&term=First Term" class="w-full sm:w-auto bg-primary hover:bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="printer" class="w-4 h-4"></i> View Report Card
                </a>
            </div>
        </div>

    </div>

    <!-- Right Column: Announcements -->
    <div class="space-y-6">
        <h2 class="text-lg font-bold text-gray-800">Announcements</h2>
        
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 space-y-4">
            <?php if(empty($announcements)): ?>
                <p class="text-sm text-gray-500">No announcements at this time.</p>
            <?php else: ?>
                <?php foreach($announcements as $a): ?>
                    <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <h4 class="font-medium text-gray-900 text-sm"><?= e($a['title']) ?></h4>
                        <p class="text-xs text-gray-500 mt-1"><?= date('M j, Y', strtotime($a['created_at'])) ?></p>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-3"><?= e($a['content']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>
