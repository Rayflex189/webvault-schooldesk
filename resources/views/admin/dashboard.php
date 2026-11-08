<?php
// resources/views/admin/dashboard.php

// Capture the view content
ob_start();
?>

<div class="flex justify-between items-end mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>! 👋</p>
    </div>
    <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center gap-2 shadow-sm">
        <i data-lucide="calendar" class="w-4 h-4"></i>
        This Term
        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
    </button>
</div>

<!-- Stat Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    
    <!-- Card 1: Students -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Students</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">1,245</h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i> 12 this month
            </p>
        </div>
    </div>

    <!-- Card 2: Teachers -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Teachers</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">86</h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i> 8 this month
            </p>
        </div>
    </div>

    <!-- Card 3: Attendance -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-sky-50 text-sky-600 rounded-lg">
                <i data-lucide="clipboard-check" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Attendance Today</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">92%</h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i> 5% vs yesterday
            </p>
        </div>
    </div>

    <!-- Card 4: Fees -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Fees Collection</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">₦2,450,000</h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i> 18% this month
            </p>
        </div>
    </div>

    <!-- Card 5: Parents -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                <i data-lucide="users-2" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Parents</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">1,102</h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i> 10 this month
            </p>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Chart Area Placeholder -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-96 flex flex-col">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Attendance Overview</h2>
        </div>
        <div class="flex-1 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-400">
            <div class="text-center">
                <i data-lucide="bar-chart-3" class="w-10 h-10 mx-auto mb-2 text-gray-300"></i>
                <p class="text-sm">Chart.js will render here in Phase 4</p>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Recent Activities</h2>
        </div>
        <div class="space-y-4">
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">System Initialized</p>
                    <p class="text-xs text-gray-500">SchoolDesk is ready to use.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Render the content into the layout
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>
