<?php
// resources/views/parent/fees.php
ob_start();
?>

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="/parent/dashboard" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Fee Status: <?= e($student['first_name'] . ' ' . $student['last_name']) ?></h1>
            <p class="text-sm text-gray-500 mt-1"><?= e($student['class_name']) ?> | <?= e($session) ?> - <?= e($term) ?></p>
        </div>
    </div>

    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Expected</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">₦<?= number_format($balanceInfo['expected'], 2) ?></h3>
        </div>
        
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Paid</p>
            <h3 class="text-2xl font-bold text-green-600 mt-1">₦<?= number_format($balanceInfo['paid'], 2) ?></h3>
        </div>
        
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm <?= $balanceInfo['balance'] > 0 ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-green-500' ?>">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Outstanding Balance</p>
            <h3 class="text-2xl font-bold <?= $balanceInfo['balance'] > 0 ? 'text-red-600' : 'text-gray-800' ?> mt-1">
                ₦<?= number_format($balanceInfo['balance'], 2) ?>
            </h3>
        </div>
    </div>

    <!-- Payment History Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Payment History</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4 font-medium">Date</th>
                        <th class="px-6 py-4 font-medium">Reference</th>
                        <th class="px-6 py-4 font-medium">Method</th>
                        <th class="px-6 py-4 font-medium text-right">Amount Paid</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php if(empty($payments)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <i data-lucide="receipt" class="w-10 h-10 mx-auto text-gray-300 mb-3"></i>
                                <p>No payments recorded for this term yet.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($payments as $p): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-600"><?= date('M j, Y - g:i A', strtotime($p['created_at'])) ?></td>
                                <td class="px-6 py-4 font-medium text-gray-900"><?= e($p['reference']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= e($p['payment_method']) ?></td>
                                <td class="px-6 py-4 text-right font-bold text-green-600">₦<?= number_format($p['amount'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>
