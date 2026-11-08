<?php
// resources/views/admin/classes/create.php
ob_start();
?>

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="/admin/classes" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Add New Class</h1>
            <p class="text-sm text-gray-500 mt-1">Create a new class or arm for the school.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/classes/store" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Class Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. JSS 3A or Primary 5"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Capacity <span class="text-red-500">*</span></label>
                <input type="number" name="capacity" required placeholder="e.g. 40" min="1" max="100"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="/admin/classes" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Save Class
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
