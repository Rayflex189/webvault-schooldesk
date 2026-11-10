<?php ob_start(); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Transport & Bus Routes</h1>
        <p class="text-sm text-gray-500 mt-1">Manage school buses and driver details.</p>
    </div>
    <a href="/admin/transport/assign" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors">
        <i data-lucide="users" class="w-4 h-4"></i> Assign Students to Buses
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add Route Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-fit">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Add New Route</h2>
        <form action="/admin/transport/store" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Route Name</label>
                <input type="text" name="route_name" required placeholder="e.g. Ikeja Route" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Driver Name</label>
                <input type="text" name="driver_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Driver Phone</label>
                <input type="text" name="driver_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Time</label>
                    <input type="time" name="pickup_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dropoff Time</label>
                    <input type="time" name="dropoff_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                </div>
            </div>
            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg font-bold transition">Save Route</button>
        </form>
    </div>

    <!-- Routes List -->
    <div class="lg:col-span-2 space-y-4">
        <?php if(empty($routes)): ?>
            <div class="bg-white p-6 rounded-xl border border-gray-200 text-center text-gray-500">No bus routes created yet.</div>
        <?php else: ?>
            <?php foreach($routes as $route): ?>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-primary flex items-center justify-center shrink-0">
                            <i data-lucide="bus" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg"><?= e($route['route_name']) ?></h3>
                            <p class="text-sm text-gray-600 flex items-center gap-1"><i data-lucide="user" class="w-3 h-3"></i> <?= e($route['driver_name'] ?: 'No Driver') ?> (<?= e($route['driver_phone'] ?: 'N/A') ?>)</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg border border-gray-100 w-full sm:w-auto">
                        <div class="text-center">
                            <p class="text-xs text-gray-400 uppercase font-bold">Pickup</p>
                            <p class="font-bold"><?= $route['pickup_time'] ? date('g:i A', strtotime($route['pickup_time'])) : 'N/A' ?></p>
                        </div>
                        <div class="w-px h-6 bg-gray-300"></div>
                        <div class="text-center">
                            <p class="text-xs text-gray-400 uppercase font-bold">Dropoff</p>
                            <p class="font-bold"><?= $route['dropoff_time'] ? date('g:i A', strtotime($route['dropoff_time'])) : 'N/A' ?></p>
                        </div>
                    </div>
                    <form action="/admin/transport/delete" method="POST" onsubmit="return confirm('Delete this route? Students will be unassigned.');">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="id" value="<?= $route['id'] ?>">
                        <button type="submit" class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded-lg transition-colors"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
