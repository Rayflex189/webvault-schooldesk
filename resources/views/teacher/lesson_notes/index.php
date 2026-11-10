<?php ob_start(); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">My Lesson Notes</h1>
        <p class="text-sm text-gray-500 mt-1">Submit weekly schemes of work for review.</p>
    </div>
    <a href="/teacher/lesson-notes/create" class="bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors">
        <i data-lucide="plus" class="w-4 h-4"></i> Submit New Note
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                <th class="px-6 py-4 font-medium">Week</th>
                <th class="px-6 py-4 font-medium">Title / Topic</th>
                <th class="px-6 py-4 font-medium">Class & Subject</th>
                <th class="px-6 py-4 font-medium text-center">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            <?php if(empty($notes)): ?>
                <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500">You haven't submitted any lesson notes yet.</td></tr>
            <?php else: ?>
                <?php foreach($notes as $n): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-800">Week <?= e($n['week_number']) ?></td>
                        <td class="px-6 py-4 font-medium text-gray-900"><?= e($n['title']) ?></td>
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
                                <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-xs font-bold border border-yellow-200">Pending</span>
                            <?php endif; ?>
                            
                            <?php if(!empty($n['admin_remarks'])): ?>
                                <p class="text-[10px] text-gray-500 mt-1 italic">"<?= e($n['admin_remarks']) ?>"</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
