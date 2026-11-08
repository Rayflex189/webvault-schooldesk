<?php
// resources/views/admin/assignments/edit.php
ob_start();
?>
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="/admin/assignments" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Assignment</h1>
            <p class="text-sm text-gray-500 mt-1">Update the teacher, class, or subject.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/assignments/update" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="id" value="<?= $assignment['id'] ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Teacher</label>
                <select name="teacher_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent bg-white">
                    <?php foreach($teachers as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $assignment['teacher_id'] == $t['id'] ? 'selected' : '' ?>>
                            <?= e($t['first_name'] . ' ' . $t['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Subject</label>
                <select name="subject_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent bg-white">
                    <?php foreach($subjects as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= $assignment['subject_id'] == $s['id'] ? 'selected' : '' ?>>
                            <?= e($s['name'] . ' (' . $s['code'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Class</label>
                <select name="class_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent bg-white">
                    <?php foreach($classes as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $assignment['class_id'] == $c['id'] ? 'selected' : '' ?>>
                            <?= e($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="/admin/assignments" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Update Assignment
                </button>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
