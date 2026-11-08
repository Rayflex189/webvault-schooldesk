<?php
// resources/views/teacher/exams/index.php
ob_start();
?>

<div class="max-w-4xl mx-auto mt-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="/teacher/dashboard" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Enter Exam Scores</h1>
            <p class="text-sm text-gray-500 mt-1">Select a class and subject to begin grading.</p>
        </div>
    </div>

    <?php if(empty($assignments)): ?>
        <div class="bg-white p-10 rounded-xl border border-gray-200 text-center text-gray-500">
            <p>You have not been assigned to any subjects yet.</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="px-6 py-4 font-medium">Class</th>
                            <th class="px-6 py-4 font-medium">Subject</th>
                            <th class="px-6 py-4 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        <?php foreach($assignments as $a): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900"><?= e($a['class_name']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-md text-xs font-bold border border-blue-100">
                                        <?= e($a['subject_name']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="/teacher/exams/entry?class_id=<?= $a['class_id'] ?>&subject_id=<?= $a['subject_id'] ?>" class="inline-flex items-center gap-1 text-sm text-primary hover:text-blue-800 font-medium transition-colors">
                                        Enter Scores <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
