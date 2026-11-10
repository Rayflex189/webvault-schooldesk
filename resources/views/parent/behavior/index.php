<?php ob_start(); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Behavior Report</h1>
    <p class="text-sm text-gray-500 mt-1">Track your child's behavior and discipline records.</p>
</div>

<div class="space-y-8">
    <?php foreach($childrenLogs as $data): ?>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-primary p-4 text-white flex justify-between items-center">
                <h2 class="font-bold text-lg"><?= e($data['child']['first_name'] . ' ' . $data['child']['last_name']) ?></h2>
                <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium"><?= e($data['child']['class_name']) ?></span>
            </div>
            
            <div class="divide-y divide-gray-100">
                <?php if(empty($data['logs'])): ?>
                    <p class="p-6 text-center text-gray-500">No behavior records for this child.</p>
                <?php else: ?>
                    <?php foreach($data['logs'] as $log): ?>
                        <div class="p-4 flex gap-4 hover:bg-gray-50">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 <?= $log['type'] == 'positive' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>">
                                <i data-lucide="<?= $log['type'] == 'positive' ? 'award' : 'alert-triangle' ?>" class="w-5 h-5"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm font-bold <?= $log['type'] == 'positive' ? 'text-green-700' : 'text-red-700' ?>"><?= e($log['title']) ?></p>
                                    <p class="text-xs text-gray-400"><?= date('M j, Y', strtotime($log['date'])) ?></p>
                                </div>
                                <?php if($log['description']): ?>
                                    <p class="text-sm text-gray-600 mt-1"><?= e($log['description']) ?></p>
                                <?php endif; ?>
                                <p class="text-[10px] text-gray-400 mt-2">Logged by: <?= e($log['first_name'] . ' ' . $log['last_name']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
