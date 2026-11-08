<?php
// resources/views/admin/subjects/index.php
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

<?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between text-sm shadow-sm">
        <div class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-4 h-4"></i><?= e($_SESSION['error']) ?></div>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Subjects</h1>
        <p class="text-sm text-gray-500 mt-1">Manage academic subjects offered by the school.</p>
    </div>
    
    <a href="/admin/subjects/create" class="bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors w-full sm:w-auto justify-center">
        <i data-lucide="plus" class="w-4 h-4"></i> Add Subject
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-medium">Subject Code</th>
                    <th class="px-6 py-4 font-medium">Subject Name</th>
                    <th class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <?php if(empty($subjects)): ?>
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                            <i data-lucide="book" class="w-10 h-10 mx-auto text-gray-300 mb-3"></i>
                            <p>No subjects found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($subjects as $subject): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-md text-xs font-bold border border-blue-100">
                                    <?= e($subject['code']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800"><?= e($subject['name']) ?></td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button class="text-gray-400 hover:text-primary transition-colors"><i data-lucide="edit" class="w-4 h-4"></i></button>
                                <button class="text-gray-400 hover:text-red-500 transition-colors"><i data-lucide="trash" class="w-4 h-4"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
