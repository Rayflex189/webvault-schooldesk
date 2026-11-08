<?php
// resources/views/admin/announcements/index.php
ob_start();
?>

<!-- Flash Messages -->
<?php if(isset($_SESSION['success'])): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between text-sm shadow-sm">
        <div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i><?= e($_SESSION['success']) ?></div>
        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Announcements</h1>
        <p class="text-sm text-gray-500 mt-1">Broadcast messages to the school community.</p>
    </div>
    
    <a href="/admin/announcements/create" class="bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors w-full sm:w-auto justify-center">
        <i data-lucide="plus" class="w-4 h-4"></i> New Announcement
    </a>
</div>

<div class="space-y-4">
    <?php if(empty($announcements)): ?>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-10 text-center text-gray-500">
            <i data-lucide="megaphone" class="w-12 h-12 mx-auto text-gray-300 mb-3"></i>
            <p>No announcements have been posted yet.</p>
        </div>
    <?php else: ?>
        <?php foreach($announcements as $a): ?>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 relative overflow-hidden">
                <!-- Colored strip based on audience -->
                <div class="absolute top-0 left-0 w-1 h-full <?= $a['target_audience'] == 'all' ? 'bg-primary' : ($a['target_audience'] == 'teachers' ? 'bg-green-500' : ($a['target_audience'] == 'parents' ? 'bg-purple-500' : 'bg-blue-400')) ?>"></div>
                
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900"><?= e($a['title']) ?></h3>
                        <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                            <span class="flex items-center gap-1"><i data-lucide="user" class="w-3 h-3"></i> <?= e($a['username']) ?></span>
                            <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3"></i> <?= date('M j, Y - g:i A', strtotime($a['created_at'])) ?></span>
                        </div>
                    </div>
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border border-gray-200">
                        To: <?= e($a['target_audience']) ?>
                    </span>
                </div>
                
                <p class="text-sm text-gray-700 leading-relaxed mt-4">
                    <?= nl2br(e($a['content'])) ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
