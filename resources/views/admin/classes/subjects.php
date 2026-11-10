<?php
// resources/views/admin/classes/subjects.php
ob_start();
?>

<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="/admin/classes" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manage Subjects</h1>
            <p class="text-sm text-gray-500 mt-1">Select the subjects offered by <strong class="text-primary"><?= e($class['name']) ?></strong>.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/classes/subjects/update?id=<?= $class['id'] ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <div class="mb-4 flex justify-between items-center border-b pb-4">
                <h2 class="text-lg font-bold text-gray-800">Available Subjects</h2>
                <span class="text-xs font-medium bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full border border-blue-100">
                    <?= count($allSubjects) ?> Total
                </span>
            </div>

            <?php if(empty($allSubjects)): ?>
                <div class="text-center py-8 text-gray-500">
                    <p>No subjects exist yet. Please create subjects first.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <?php foreach($allSubjects as $subject): ?>
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="checkbox" name="subjects[]" value="<?= $subject['id'] ?>" 
                                class="w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent"
                                <?= in_array($subject['id'], $assignedSubjects) ? 'checked' : '' ?>>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?= e($subject['name']) ?></p>
                                <p class="text-xs text-gray-500"><?= e($subject['code']) ?></p>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="/admin/classes" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Save Assignments
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
