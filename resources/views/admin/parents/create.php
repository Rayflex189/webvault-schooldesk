<?php
// resources/views/admin/parents/create.php
ob_start();
?>

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="/admin/parents" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Add New Parent</h1>
            <p class="text-sm text-gray-500 mt-1">Register a parent and link them to a student.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/parents/store" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" required placeholder="John"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" required placeholder="Doe"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email (Username) <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required placeholder="john.doe@gmail.com"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" required placeholder="+234 800 000 0000"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Relationship <span class="text-red-500">*</span></label>
                    <select name="relationship" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent bg-white">
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Guardian">Guardian</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="border-t pt-6 mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Link to Student (Optional)</label>
                <select name="student_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent bg-white">
                    <option value="">Do not link a student yet</option>
                    <?php foreach($students as $s): ?>
                        <option value="<?= $s['id'] ?>">
                            <?= e($s['first_name'] . ' ' . $s['last_name'] . ' - ' . $s['class_name'] . ' (' . $s['admission_number'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-xs text-gray-500 mt-2">You can link multiple students to this parent later by adding them as separate records or via the database.</p>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="/admin/parents" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Register Parent
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
