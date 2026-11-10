<?php ob_start(); ?>
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My School Bus</h1>
        <p class="text-sm text-gray-500 mt-1">Your transport details.</p>
    </div>

    <?php if(!$route): ?>
        <div class="bg-white p-10 rounded-xl border border-gray-200 text-center text-gray-500 shadow-sm">
            <i data-lucide="bus" class="w-12 h-12 mx-auto text-gray-300 mb-3"></i>
            <p>You have not been assigned to a school bus.</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-primary p-6 text-white text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                    <i data-lucide="bus" class="w-8 h-8"></i>
                </div>
                <h2 class="text-2xl font-bold"><?= e($route['route_name']) ?></h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-1">Pickup</p>
                        <p class="text-xl font-bold text-blue-900"><?= $route['pickup_time'] ? date('g:i A', strtotime($route['pickup_time'])) : 'N/A' ?></p>
                    </div>
                    <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                        <p class="text-xs text-indigo-600 font-bold uppercase tracking-wider mb-1">Dropoff</p>
                        <p class="text-xl font-bold text-indigo-900"><?= $route['dropoff_time'] ? date('g:i A', strtotime($route['dropoff_time'])) : 'N/A' ?></p>
                    </div>
                </div>
                <div class="border-t pt-4">
                    <h3 class="text-sm font-bold text-gray-800 mb-3">Driver Details</h3>
                    <p class="text-sm text-gray-600 flex items-center gap-2 mb-2"><i data-lucide="user" class="w-4 h-4 text-gray-400"></i> <?= e($route['driver_name'] ?: 'Not assigned') ?></p>
                    <p class="text-sm text-gray-600 flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4 text-gray-400"></i> <?= e($route['driver_phone'] ?: 'Not assigned') ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/app.php'; ?>
