<?php
// resources/views/admin/finance/audit_trail.php
ob_start();
?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Transaction Audit Trail</h1>
        <p class="text-sm text-gray-500 mt-1">Immutable log of all payments received in the system.</p>
    </div>
    
    <a href="/admin/finance" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors w-full sm:w-auto justify-center">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Ledger
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i> Secure Transaction Log
        </h2>
        <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded font-bold">Total: <?= count($transactions) ?></span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-medium">Date & Time</th>
                    <th class="px-6 py-4 font-medium">Student</th>
                    <th class="px-6 py-4 font-medium">Reference</th>
                    <th class="px-6 py-4 font-medium">Session / Term</th>
                    <th class="px-6 py-4 font-medium">Method</th>
                    <th class="px-6 py-4 font-medium">Recorded By</th>
                    <th class="px-6 py-4 font-medium text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <?php if(empty($transactions)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            <i data-lucide="receipt" class="w-10 h-10 mx-auto text-gray-300 mb-3"></i>
                            <p>No transactions have been recorded yet.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($transactions as $tx): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                <?= date('M j, Y', strtotime($tx['created_at'])) ?>
                                <span class="text-xs text-gray-400 block"><?= date('g:i A', strtotime($tx['created_at'])) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900"><?= e($tx['first_name'] . ' ' . $tx['last_name']) ?></p>
                                <p class="text-xs text-gray-500"><?= e($tx['admission_number']) ?></p>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-700">
                                <?= e($tx['reference']) ?>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-xs">
                                <?= e($tx['session']) ?> <br> <?= e($tx['term']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if($tx['payment_method'] === 'Paystack'): ?>
                                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-bold border border-blue-100 flex items-center gap-1 w-fit">
                                        <i data-lucide="credit-card" class="w-3 h-3"></i> Paystack
                                    </span>
                                <?php else: ?>
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium border border-gray-200 w-fit block">
                                        <?= e($tx['payment_method']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="flex items-center gap-1 text-gray-600 text-xs">
                                    <i data-lucide="user" class="w-3 h-3 text-gray-400"></i>
                                    <?= e($tx['recorded_by_name']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-green-600">
                                ₦<?= number_format($tx['amount'], 2) ?>
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
