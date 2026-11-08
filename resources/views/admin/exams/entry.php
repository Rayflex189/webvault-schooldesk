<?php
// resources/views/admin/exams/entry.php
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
    <div class="flex items-center gap-4">
        <a href="/admin/exams" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Enter Scores</h1>
            <p class="text-sm text-gray-500 mt-1">Session: <strong><?= e($session) ?></strong> | Term: <strong><?= e($term) ?></strong></p>
        </div>
    </div>
</div>

<form action="/admin/exams/store" method="POST">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
    <input type="hidden" name="class_id" value="<?= e($class_id) ?>">
    <input type="hidden" name="subject_id" value="<?= e($subject_id) ?>">
    <input type="hidden" name="session" value="<?= e($session) ?>">
    <input type="hidden" name="term" value="<?= e($term) ?>">

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="px-4 py-4 font-medium w-1/3">Student</th>
                        <th class="px-4 py-4 font-medium text-center">CA (Max 30)</th>
                        <th class="px-4 py-4 font-medium text-center">Exam (Max 70)</th>
                        <th class="px-4 py-4 font-medium text-center">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php if(empty($students)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <p>No active students found in this class.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($students as $student): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4">
                                    <p class="font-medium text-gray-900"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></p>
                                    <p class="text-xs text-gray-500"><?= e($student['admission_number']) ?></p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <input type="number" name="results[<?= $student['id'] ?>][ca]" 
                                        value="<?= e($student['ca_score'] ?? '') ?>" 
                                        min="0" max="30" step="0.01" placeholder="0"
                                        class="w-24 px-3 py-2 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <input type="number" name="results[<?= $student['id'] ?>][exam]" 
                                        value="<?= e($student['exam_score'] ?? '') ?>" 
                                        min="0" max="70" step="0.01" placeholder="0"
                                        class="w-24 px-3 py-2 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                                </td>
                                <td class="px-4 py-4 text-center font-bold text-gray-700">
                                    <?= e($student['total_score'] ?? '0.00') ?>
                                    <?php if(!empty($student['grade'])): ?>
                                        <span class="ml-2 text-xs px-2 py-1 rounded bg-gray-100 border text-gray-600"><?= e($student['grade']) ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end gap-3 mb-10">
        <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-6 py-3 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2 w-full sm:w-auto justify-center">
            <i data-lucide="save" class="w-4 h-4"></i> Save Results
        </button>
    </div>
</form>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
