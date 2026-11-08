<?php
// resources/views/admin/exams/index.php
ob_start();
?>

<div class="max-w-3xl mx-auto mt-10">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="file-edit" class="w-8 h-8"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Exams & Results</h1>
        <p class="text-sm text-gray-500 mt-2">Select parameters to enter or edit student scores.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/exams/entry" method="GET" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Class <span class="text-red-500">*</span></label>
                    <select name="class_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent bg-white">
                        <option value="">Choose a class...</option>
                        <?php foreach($classes as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject <span class="text-red-500">*</span></label>
                    <select name="subject_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent bg-white">
                        <option value="">Choose a subject...</option>
                        <?php foreach($subjects as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= e($s['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

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
                Load Score Sheet <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
