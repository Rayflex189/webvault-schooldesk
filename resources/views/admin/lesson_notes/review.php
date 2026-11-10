<?php ob_start(); ?>
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="/admin/lesson-notes" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Review Lesson Note</h1>
            <p class="text-sm text-gray-500 mt-1">Submitted by <?= e($teacher['first_name'] . ' ' . $teacher['last_name']) ?></p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8 mb-6">
        <div class="border-b pb-4 mb-4">
            <h2 class="text-xl font-bold text-primary mb-1">Week <?= e($note['week_number']) ?>: <?= e($note['title']) ?></h2>
            <p class="text-sm text-gray-500"><?= e($note['session']) ?> - <?= e($note['term']) ?></p>
        </div>
        
        <div class="prose max-w-none text-gray-700 whitespace-pre-wrap font-mono text-sm bg-gray-50 p-6 rounded-lg border border-gray-200"><?= e($note['content']) ?></div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/lesson-notes/update-status" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="id" value="<?= $note['id'] ?>">

            <h3 class="text-lg font-bold text-gray-800 mb-2">Admin Decision</h3>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="approved" class="peer sr-only" <?= $note['status'] == 'approved' ? 'checked' : '' ?>>
                    <div class="p-3 border-2 rounded-lg text-center peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 font-bold transition-all">
                        <i data-lucide="check-circle" class="w-5 h-5 mx-auto mb-1"></i> Approve
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="rejected" class="peer sr-only" <?= $note['status'] == 'rejected' ? 'checked' : '' ?>>
                    <div class="p-3 border-2 rounded-lg text-center peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 font-bold transition-all">
                        <i data-lucide="x-circle" class="w-5 h-5 mx-auto mb-1"></i> Reject
                    </div>
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Remarks (Optional)</label>
                <textarea name="admin_remarks" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent" placeholder="e.g. Please add more details on the class activities..."><?= e($note['admin_remarks']) ?></textarea>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg font-bold shadow-sm transition-colors">
                Save Decision
            </button>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
