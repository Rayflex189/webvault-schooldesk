<?php
// resources/views/teacher/dashboard.php
ob_start();
?>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center max-w-2xl mx-auto mt-10">
    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
        <i data-lucide="graduation-cap" class="w-10 h-10"></i>
    </div>
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Teacher Portal</h1>
    <p class="text-gray-500 mb-8">Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Teacher') ?>. This is your dedicated workspace.</p>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="#" class="p-6 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors flex flex-col items-center gap-3 text-gray-700 hover:text-primary">
            <i data-lucide="clipboard-check" class="w-8 h-8"></i>
            <span class="font-medium">Take Attendance</span>
        </a>
        <a href="#" class="p-6 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors flex flex-col items-center gap-3 text-gray-700 hover:text-primary">
            <i data-lucide="file-edit" class="w-8 h-8"></i>
            <span class="font-medium">Enter Exam Scores</span>
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php'; // Reusing the same layout for now
?>
