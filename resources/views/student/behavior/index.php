<?php ob_start(); ?>
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Behavior Record</h1>
        <p class="text-sm text-gray-500 mt-1">See what your teachers have logged about you.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-100">
            <?php if(empty($logs)): ?>
                <p class="p-6 text-center text-gray-500">You have a clean slate! No behavior logs yet.</p>
            <?php else: ?>
                <?php foreach($logs as $log): ?>
                    <div class="p-4 flex gap-4 hover:bg-gray-50">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 <?= $log['type'] == 'positive' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>">
                            <i data-lucide="<?= $log['type'] == 'positive' ? 'smile' : 'frown' ?>" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold <?= $log['type'] == 'positive' ? 'text-green-700' : 'text-red-700' ?>"><?= e($log['title']) ?></p>
                            <?php if($log['description']): ?>
                                <p class="text-sm text-gray-600 mt-1"><?= e($log['description']) ?></p>
                            <?php endif; ?>
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-[10px] text-gray-400">By: <?= e($log['first_name'] . ' ' . $log['last_name']) ?></p>
                                <p class="text-xs text-gray-400"><?= date('M j, Y', strtotime($log['date'])) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
