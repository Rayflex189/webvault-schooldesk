<?php ob_start(); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Transport Details</h1>
    <p class="text-sm text-gray-500 mt-1">View bus routes and driver information for your children.</p>
</div>

<div class="space-y-6">
    <?php foreach($childrenRoutes as $data): ?>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gray-50 p-4 border-b flex justify-between items-center">
                <h2 class="font-bold text-lg text-gray-800"><?= e($data['child']['first_name'] . ' ' . $data['child']['last_name']) ?></h2>
                <span class="text-xs font-medium bg-blue-100 text-blue-700 px-2 py-1 rounded"><?= e($data['child']['class_name']) ?></span>
            </div>
            
            <?php if(!$data['route']): ?>
                <div class="p-6 text-center text-gray-500 text-sm">No bus route assigned to this student.</div>
            <?php else: ?>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center shrink-0">
                            <i data-lucide="bus" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Assigned Route</p>
                            <p class="text-xl font-bold text-gray-900"><?= e($data['route']['route_name']) ?></p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Driver Information</p>
                        <p class="text-sm font-medium text-gray-800 flex items-center gap-2 mb-1"><i data-lucide="user" class="w-4 h-4 text-gray-400"></i> <?= e($data['route']['driver_name'] ?: 'Not assigned') ?></p>
                        <p class="text-sm font-medium text-gray-800 flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4 text-gray-400"></i> <?= e($data['route']['driver_phone'] ?: 'Not assigned') ?></p>
                    </div>
                    <div class="md:col-span-2 flex justify-around bg-blue-50 text-blue-900 rounded-xl p-4 border border-blue-100">
                        <div class="text-center">
                            <p class="text-[10px] font-bold uppercase tracking-widest opacity-70">Morning Pickup</p>
                            <p class="text-lg font-black"><?= $data['route']['pickup_time'] ? date('g:i A', strtotime($data['route']['pickup_time'])) : 'N/A' ?></p>
                        </div>
                        <div class="w-px bg-blue-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-bold uppercase tracking-widest opacity-70">Afternoon Dropoff</p>
                            <p class="text-lg font-black"><?= $data['route']['dropoff_time'] ? date('g:i A', strtotime($data['route']['dropoff_time'])) : 'N/A' ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/app.php'; ?>
