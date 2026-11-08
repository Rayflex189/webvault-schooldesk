<?php
// resources/views/parent/dashboard.php
ob_start();
?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Welcome, <?= htmlspecialchars($guardian['first_name'] ?? 'Parent') ?>!</h1>
    <p class="text-sm text-gray-500 mt-1">Here is an overview of your children's progress.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Children -->
    <div class="lg:col-span-2 space-y-6">
        <h2 class="text-lg font-bold text-gray-800">My Children</h2>
        
        <?php if(empty($children)): ?>
            <div class="bg-white p-6 rounded-xl border border-gray-200 text-center text-gray-500">
                <p>No students are linked to your account. Please contact the school admin.</p>
            </div>
        <?php else: ?>
            <?php foreach($children as $child): ?>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0">
                            <?= strtoupper(substr($child['first_name'], 0, 1) . substr($child['last_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900"><?= e($child['first_name'] . ' ' . $child['last_name']) ?></h3>
                            <p class="text-sm text-gray-500"><?= e($child['class_name']) ?> | <?= e($child['admission_number']) ?></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 border-t pt-4">
                        <a href="/parent/report-card?student_id=<?= $child['id'] ?>" class="flex items-center justify-center gap-2 bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-3 rounded-lg text-sm font-medium transition-colors">
                            <i data-lucide="printer" class="w-4 h-4"></i> View Report Card
                        </a>
                        <a href="/parent/fees?student_id=<?= $child['id'] ?>" class="flex items-center justify-center gap-2 bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-3 rounded-lg text-sm font-medium transition-colors">
    <i data-lucide="wallet" class="w-4 h-4"></i> Fee Status
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Right Column: Announcements -->
    <div class="space-y-6">
        <h2 class="text-lg font-bold text-gray-800">School Announcements</h2>
        
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
