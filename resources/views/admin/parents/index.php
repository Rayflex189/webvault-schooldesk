<?php
// resources/views/admin/parents/index.php
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
        <h1 class="text-2xl font-bold text-gray-800">Parents / Guardians</h1>
        <p class="text-sm text-gray-500 mt-1">Manage parent accounts and linked students.</p>
    </div>
    
    <a href="/admin/parents/create" class="bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors w-full sm:w-auto justify-center">
        <i data-lucide="plus" class="w-4 h-4"></i> Add New Parent
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-medium">Name</th>
                    <th class="px-6 py-4 font-medium">Contact</th>
                    <th class="px-6 py-4 font-medium">Relationship</th>
                    <th class="px-6 py-4 font-medium">Linked Student(s)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <?php if(empty($parents)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            <i data-lucide="users" class="w-10 h-10 mx-auto text-gray-300 mb-3"></i>
                            <p>No parents found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($parents as $p): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900"><?= e($p['first_name'] . ' ' . $p['last_name']) ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800"><?= e($p['email']) ?></p>
                                <p class="text-xs text-gray-500"><?= e($p['phone']) ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-purple-50 text-purple-700 px-2.5 py-1 rounded-md text-xs font-medium border border-purple-100">
                                    <?= e($p['relationship']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">
                                <?= $p['children'] ? e($p['children']) : '<span class="text-gray-400 italic">None linked</span>' ?>
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
