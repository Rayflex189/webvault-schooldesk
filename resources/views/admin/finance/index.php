<?php
// resources/views/admin/finance/index.php
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

<!-- Page Header with New Buttons -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Finance & Fees</h1>
        <p class="text-sm text-gray-500 mt-1">Track fee payments and outstanding balances.</p>
    </div>
    
    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
        <a href="/admin/finance/manage-fees" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors w-full sm:w-auto justify-center">
            <i data-lucide="settings" class="w-4 h-4"></i> Manage Fees
        </a>
        <a href="/admin/finance/create" class="bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors w-full sm:w-auto justify-center">
            <i data-lucide="plus" class="w-4 h-4"></i> Record Payment
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
    <form action="/admin/finance" method="GET" class="flex flex-col sm:flex-row gap-4">
        <select name="session" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent bg-white text-gray-700">
            <option value="2023/2024" <?= $session == '2023/2024' ? 'selected' : '' ?>>2023/2024</option>
            <option value="2024/2025" <?= $session == '2024/2025' ? 'selected' : '' ?>>2024/2025</option>
        </select>
        <select name="term" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent bg-white text-gray-700">
            <option value="First Term" <?= $term == 'First Term' ? 'selected' : '' ?>>First Term</option>
            <option value="Second Term" <?= $term == 'Second Term' ? 'selected' : '' ?>>Second Term</option>
            <option value="Third Term" <?= $term == 'Third Term' ? 'selected' : '' ?>>Third Term</option>
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium transition-colors border border-gray-200">
            Apply Filter
        </button>
    </form>
</div>

<!-- Data Table -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-medium">Student</th>
                    <th class="px-6 py-4 font-medium">Class</th>
                    <th class="px-6 py-4 font-medium text-right">Expected Fee</th>
                    <th class="px-6 py-4 font-medium text-right">Total Paid</th>
                    <th class="px-6 py-4 font-medium text-right">Balance</th>
                    <th class="px-6 py-4 font-medium text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <?php if(empty($ledger)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i data-lucide="wallet" class="w-10 h-10 mx-auto text-gray-300 mb-3"></i>
                            <p>No fee records found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($ledger as $row): 
                        $balance = $row['expected_fee'] - $row['total_paid'];
                    ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900"><?= e($row['first_name'] . ' ' . $row['last_name']) ?></p>
                                <p class="text-xs text-gray-500"><?= e($row['admission_number']) ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-md text-xs font-medium border border-gray-200">
                                    <?= e($row['class_name']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-600">₦<?= number_format($row['expected_fee'], 2) ?></td>
                            <td class="px-6 py-4 text-right text-green-600 font-medium">₦<?= number_format($row['total_paid'], 2) ?></td>
                            <td class="px-6 py-4 text-right font-bold <?= $balance > 0 ? 'text-red-600' : 'text-gray-900' ?>">
                                ₦<?= number_format($balance, 2) ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if($row['expected_fee'] == 0): ?>
                                    <span class="text-xs text-gray-400">No Fee Set</span>
                                <?php elseif($balance <= 0): ?>
                                    <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-bold border border-green-200">Paid</span>
                                <?php elseif($row['total_paid'] > 0): ?>
                                    <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-xs font-bold border border-yellow-200">Partial</span>
                                <?php else: ?>
                                    <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-xs font-bold border border-red-200">Unpaid</span>
                                <?php endif; ?>
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
