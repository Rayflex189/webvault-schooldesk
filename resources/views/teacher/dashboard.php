<?php
// resources/views/teacher/dashboard.php
ob_start();
?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Teacher Portal</h1>
    <p class="text-sm text-gray-500 mt-1">Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Teacher') ?>! Here is your overview.</p>
</div>

<!-- Quick Actions Grid -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <a href="/teacher/attendance" class="p-6 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-primary/30 transition-all shadow-sm flex flex-col items-center gap-3 text-gray-700 hover:text-primary group">
        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
            <i data-lucide="clipboard-check" class="w-6 h-6"></i>
        </div>
        <span class="font-bold">Take Attendance</span>
    </a>
    
    <a href="/teacher/exams" class="p-6 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-primary/30 transition-all shadow-sm flex flex-col items-center gap-3 text-gray-700 hover:text-primary group">
        <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
            <i data-lucide="file-edit" class="w-6 h-6"></i>
        </div>
        <span class="font-bold">Enter Exam Scores</span>
    </a>
    
    <a href="/teacher/behavior" class="p-6 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-primary/30 transition-all shadow-sm flex flex-col items-center gap-3 text-gray-700 hover:text-primary group">
        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
            <i data-lucide="award" class="w-6 h-6"></i>
        </div>
        <span class="font-bold">Behavior Log</span>
    </a>
</div>

<!-- My Assignments -->
<h2 class="text-lg font-bold text-gray-800 mb-4">My Assigned Classes</h2>

<?php if(empty($assignments)): ?>
    <div class="bg-white p-10 rounded-xl border border-gray-200 text-center text-gray-500 shadow-sm">
        <i data-lucide="info" class="w-10 h-10 mx-auto text-gray-300 mb-3"></i>
        <p>You have not been assigned to any classes or subjects yet.</p>
        <p class="text-sm mt-1">Please contact the school administrator.</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php 
        // Group by class to avoid duplicate class cards
        $groupedAssignments = [];
        foreach($assignments as $a) {
            $groupedAssignments[$a['class_id']]['class_name'] = $a['class_name'];
            $groupedAssignments[$a['class_id']]['subjects'][] = $a['subject_name'];
        }
        
        foreach($groupedAssignments as $classId => $data): 
        ?>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow relative overflow-hidden">
                <!-- Decorative accent -->
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-primary flex items-center justify-center">
                            <i data-lucide="school" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900"><?= e($data['class_name']) ?></h3>
                            <p class="text-xs text-gray-500 mt-0.5"><?= count($data['subjects']) ?> Subjects Assigned</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-5 space-y-1">
                    <?php foreach($data['subjects'] as $subject): ?>
                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded border border-gray-200 mr-1 mb-1">
                            <?= e($subject) ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <div class="grid grid-cols-2 gap-2 border-t pt-4">
                    <a href="/teacher/attendance?class_id=<?= $classId ?>" class="flex items-center justify-center gap-2 bg-green-50 text-green-700 hover:bg-green-100 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                        <i data-lucide="clipboard-check" class="w-4 h-4"></i> Attendance
                    </a>
                    <a href="/teacher/exams?class_id=<?= $classId ?>" class="flex items-center justify-center gap-2 bg-blue-50 text-blue-700 hover:bg-blue-100 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                        <i data-lucide="file-edit" class="w-4 h-4"></i> Scores
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>
