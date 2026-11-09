<?php
// resources/views/parent/fees.php
ob_start();
?>

<div class="max-w-4xl mx-auto">
    
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

    <!-- Paystack Payment Form -->
    <?php if($balanceInfo['balance'] > 0): ?>
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6 flex flex-col md:flex-row justify-between items-center gap-4 border-t-4 border-t-[#0ba4db]">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Pay Outstanding Balance</h3>
                <p class="text-sm text-gray-500">Secure payment powered by Paystack. You will be redirected to complete the payment.</p>
            </div>
            <form action="/parent/payment/initiate" method="POST" class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                
                <div class="relative w-full sm:w-40">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-bold">₦</span>
                    <input type="number" name="amount" value="<?= $balanceInfo['balance'] ?>" max="<?= $balanceInfo['balance'] ?>" min="100" required class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent font-bold text-gray-800">
                </div>
                
                <button type="submit" class="w-full sm:w-auto bg-[#0ba4db] hover:bg-[#098cb9] text-white px-6 py-2.5 rounded-lg font-bold shadow-sm transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Pay Now
                </button>
            </form>
        </div>
    <?php endif; ?>

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
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    <?= e($p['reference']) ?>
                                    <?php if($p['payment_method'] == 'Paystack'): ?>
                                        <span class="ml-2 bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded font-bold uppercase">Online</span>
                                    <?php endif; ?>
                                </td>
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

<script>
    // Initialize icons
    lucide.createIcons();
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>
