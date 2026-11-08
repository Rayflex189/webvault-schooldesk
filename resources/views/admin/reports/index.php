<?php
// resources/views/admin/reports/index.php
ob_start();
?>

<div class="max-w-2xl mx-auto mt-10">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="printer" class="w-8 h-8"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Generate Report Card</h1>
        <p class="text-sm text-gray-500 mt-2">Select a student and term to generate their report sheet.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/reports/generate" method="GET" target="_blank" class="space-y-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Student <span class="text-red-500">*</span></label>
                <select name="student_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent bg-white">
                    <option value="">Choose a student...</option>
                    <?php foreach($students as $s): ?>
                        <option value="<?= $s['id'] ?>">
                            <?= e($s['first_name'] . ' ' . $s['last_name'] . ' (' . $s['class_name'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Session <span class="text-red-500">*</span></label>
                    <select name="session" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent bg-white">
                        <option value="2023/2024">2023/2024</option>
                        <option value="2024/2025" selected>2024/2025</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Term <span class="text-red-500">*</span></label>
                    <select name="term" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent bg-white">
                        <option value="First Term">First Term</option>
                        <option value="Second Term">Second Term</option>
                        <option value="Third Term">Third Term</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-5 py-3 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center justify-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4"></i> Generate Report Card
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
