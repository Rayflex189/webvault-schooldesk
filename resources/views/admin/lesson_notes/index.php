<?php ob_start(); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Lesson Notes Review</h1>
    <p class="text-sm text-gray-500 mt-1">Review weekly schemes submitted by teachers.</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                <th class="px-6 py-4 font-medium">Teacher</th>
                <th class="px-6 py-4 font-medium">Week & Topic</th>
                <th class="px-6 py-4 font-medium">Class & Subject</th>
                <th class="px-6 py-4 font-medium text-center">Status</th>
                <th class="px-6 py-4 font-medium text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            <?php if(empty($notes)): ?>
                <tr><td colspan="5" class="px-6 py-10 text-center text-gray-500">No lesson notes submitted yet.</td></tr>
            <?php else: ?>
                <?php foreach($notes as $n): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900"><?= e($n['first_name'] . ' ' . $n['last_name']) ?></p>
                            <p class="text-xs text-gray-500"><?= date('M j, Y', strtotime($n['created_at'])) ?></p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">Week <?= e($n['week_number']) ?>: <?= e($n['title']) ?></p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800"><?= e($n['subject_name']) ?></p>
                            <p class="text-xs text-gray-500"><?= e($n['class_name']) ?></p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if($n['status'] === 'approved'): ?>
                                <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-bold border border-green-200">Approved</span>
                            <?php elseif($n['status'] === 'rejected'): ?>
                                <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-xs font-bold border border-red-200">Rejected</span>
                            <?php else: ?>
                                <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-xs font-bold border border-yellow-200 animate-pulse">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="/admin/lesson-notes/review?id=<?= $n['id'] ?>" class="inline-flex items-center gap-1 text-sm text-primary hover:text-blue-800 font-medium transition-colors">
                                Review <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
