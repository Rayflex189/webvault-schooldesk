<?php
// resources/views/admin/finance/manage_fees.php
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

<div class="max-w-3xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manage Fee Structures</h1>
            <p class="text-sm text-gray-500 mt-1">Set the expected school fees for each class.</p>
        </div>
        <a href="/admin/finance" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-200">
            Back to Ledger
        </a>
    </div>

    <!-- Filter by Session/Term -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
        <form action="/admin/finance/manage-fees" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Session</label>
                <select name="session" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent bg-white text-gray-700">
                    <option value="2023/2024" <?= $session == '2023/2024' ? 'selected' : '' ?>>2023/2024</option>
                    <option value="2024/2025" <?= $session == '2024/2025' ? 'selected' : '' ?>>2024/2025</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Term</label>
                <select name="term" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent bg-white text-gray-700">
                    <option value="First Term" <?= $term == 'First Term' ? 'selected' : '' ?>>First Term</option>
                    <option value="Second Term" <?= $term == 'Second Term' ? 'selected' : '' ?>>Second Term</option>
                    <option value="Third Term" <?= $term == 'Third Term' ? 'selected' : '' ?>>Third Term</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors w-full">
                    Load
                </button>
            </div>
        </form>
    </div>

    <!-- Fee Setting Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Fees for <?= e($session) ?> - <?= e($term) ?></h2>
        </div>
        <form action="/admin/finance/save-fees" method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="session" value="<?= e($session) ?>">
            <input type="hidden" name="term" value="<?= e($term) ?>">
            
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4 font-medium">Class</th>
                        <th class="px-6 py-4 font-medium text-right">Expected Fee (₦)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach($classes as $class): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= e($class['name']) ?></td>
                            <td class="px-6 py-4 text-right">
                                <input type="number" name="amounts[<?= $class['id'] ?>]" 
                                       value="<?= number_format($feeMap[$class['id']] ?? 0, 2, '.', '') ?>" 
                                       min="0" step="0.01" required
                                       class="w-32 px-3 py-2 text-right border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-6 py-2.5 rounded-lg font-medium shadow-sm flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Save Fee Structures
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
