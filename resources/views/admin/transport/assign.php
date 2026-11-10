<?php
// resources/views/admin/transport/assign.php
ob_start();
?>

<style>
    /* Staggered Slide-Up Animation */
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-card {
        opacity: 0;
        animation: slideUpFade 0.4s ease-out forwards;
    }
    /* Custom styling for the select dropdown to make it look premium */
    .premium-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
</style>

<div class="max-w-6xl mx-auto pb-10">
    
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="/admin/transport" class="p-3 bg-white border border-gray-200 rounded-xl text-gray-500 hover:text-primary hover:bg-gray-50 transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Assign Students to Buses</h1>
            <p class="text-sm text-gray-500 mt-1">Select a bus route for each student. Changes save automatically.</p>
        </div>
    </div>

    <!-- Students Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach($students as $index => $s): ?>
            <!-- Staggered animation delay based on index -->
            <div class="animate-card bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-5 relative overflow-hidden" 
                 style="animation-delay: <?= $index * 0.05 ?>s;">
                
                <!-- Decorative top accent based on assignment status -->
                <div class="absolute top-0 left-0 w-full h-1 <?= $s['route_name'] ? 'bg-green-500' : 'bg-gray-300' ?>"></div>

                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-primary flex items-center justify-center font-bold text-sm shrink-0">
                            <?= strtoupper(substr($s['first_name'], 0, 1) . substr($s['last_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 truncate max-w-[150px]"><?= e($s['first_name'] . ' ' . $s['last_name']) ?></h3>
                            <p class="text-xs text-gray-500 font-medium"><?= e($s['admission_number']) ?></p>
                        </div>
                    </div>
                    
                    <!-- Class Badge -->
                    <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-1 rounded-md border border-gray-200 uppercase tracking-wider">
                        <?= e($s['class_name']) ?>
                    </span>
                </div>

                <!-- Status indicator -->
                <div class="mb-4">
                    <?php if($s['route_name']): ?>
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 px-2.5 py-1 rounded-full text-xs font-bold border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Assigned to <?= e($s['route_name']) ?>
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 bg-gray-50 text-gray-500 px-2.5 py-1 rounded-full text-xs font-bold border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Unassigned
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Auto-submit Form -->
                <form action="/admin/transport/update-assignment" method="POST" id="form-<?= $s['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="student_id" value="<?= $s['id'] ?>">
                    
                    <div class="relative">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1 ml-1">Bus Route</label>
                        <select name="bus_route_id" onchange="this.form.submit()" 
                                class="premium-select w-full bg-gray-50 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all cursor-pointer">
                            <option value="">-- No Bus Assigned --</option>
                            <?php foreach($routes as $r): ?>
                                <option value="<?= $r['id'] ?>" <?= $s['bus_route_id'] == $r['id'] ? 'selected' : '' ?>>
                                    <?= e($r['route_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
