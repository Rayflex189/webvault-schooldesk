<?php ob_start(); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Behavior Tracker</h1>
        <p class="text-sm text-gray-500 mt-1">Log positive and negative behaviors for your students.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Log Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-fit">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Log New Behavior</h2>
        <form action="/teacher/behavior/store" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                <select name="student_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white">
                    <option value="">-- Choose Student --</option>
                    <?php foreach($students as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= e($s['first_name'] . ' ' . $s['last_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <label class="cursor-pointer">
                    <input type="radio" name="type" value="positive" class="peer sr-only" checked>
                    <div class="p-3 border-2 rounded-lg text-center peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 font-bold transition-all text-sm">
                        <i data-lucide="thumbs-up" class="w-5 h-5 mx-auto mb-1"></i> Positive
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="type" value="negative" class="peer sr-only">
                    <div class="p-3 border-2 rounded-lg text-center peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 font-bold transition-all text-sm">
                        <i data-lucide="thumbs-down" class="w-5 h-5 mx-auto mb-1"></i> Negative
                    </div>
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Short Title</label>
                <input type="text" name="title" required placeholder="e.g. Late to assembly" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Details (Optional)</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent"></textarea>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg font-bold transition">Save Behavior Log</button>
        </form>
    </div>

    <!-- Recent Logs -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Recently Logged</h2>
        </div>
        <div class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto">
            <?php if(empty($recentLogs)): ?>
                <p class="p-6 text-center text-gray-500">No logs recorded yet.</p>
            <?php else: ?>
                <?php foreach($recentLogs as $log): ?>
                    <div class="p-4 flex gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 <?= $log['type'] == 'positive' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>">
                            <i data-lucide="<?= $log['type'] == 'positive' ? 'thumbs-up' : 'thumbs-down' ?>" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900"><?= e($log['first_name'] . ' ' . $log['last_name']) ?></p>
                            <p class="text-sm text-gray-700"><?= e($log['title']) ?></p>
                            <?php if($log['description']): ?>
                                <p class="text-xs text-gray-500 mt-1"><?= e($log['description']) ?></p>
                            <?php endif; ?>
                            <p class="text-[10px] text-gray-400 mt-1"><?= date('M j, Y', strtotime($log['date'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
