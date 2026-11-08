<?php
// resources/views/admin/attendance/index.php
ob_start();
?>

<div class="max-w-2xl mx-auto mt-10">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="calendar-check" class="w-8 h-8"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Take Attendance</h1>
        <p class="text-sm text-gray-500 mt-2">Select a class and date to begin marking.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/attendance/mark" method="GET" class="space-y-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Class <span class="text-red-500">*</span></label>
                <select name="class_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent bg-white">
                    <option value="">Choose a class...</option>
                    <?php foreach($classes as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-red-500">*</span></label>
                <input type="date" name="date" value="<?= date('Y-m-d') ?>" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-5 py-3 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center justify-center gap-2">
                Proceed to Mark Attendance <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
