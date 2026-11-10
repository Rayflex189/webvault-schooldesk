<?php
// resources/views/admin/dashboard.php
ob_start();
?>

<div class="flex justify-between items-end mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>! 👋</p>
    </div>
    
    <!-- Interactive Term Switcher -->
    <div class="relative" x-data="{ openTerm: false }">
        <button @click="openTerm = !openTerm" @click.outside="openTerm = false" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center gap-2 shadow-sm transition-colors">
            <i data-lucide="calendar" class="w-4 h-4"></i>
            <span class="hidden sm:inline"><?= htmlspecialchars($active_session ?? '2024/2025') ?> - </span><?= htmlspecialchars($active_term ?? 'First Term') ?>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
        </button>
        
        <div x-cloak x-show="openTerm" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
            <div class="px-4 py-2 border-b border-gray-100 mb-2">
                <p class="text-xs text-gray-500 font-bold uppercase">Switch Active Term</p>
            </div>
            <form action="/admin/settings/update-session" method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <input type="hidden" name="session" value="<?= htmlspecialchars($active_session ?? '2024/2025') ?>">
                
                <button type="submit" name="term" value="First Term" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex justify-between items-center <?= ($active_term ?? '') == 'First Term' ? 'bg-blue-50 text-primary font-bold' : '' ?>">
                    First Term
                    <?php if(($active_term ?? '') == 'First Term'): ?><i data-lucide="check" class="w-4 h-4"></i><?php endif; ?>
                </button>
                <button type="submit" name="term" value="Second Term" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex justify-between items-center <?= ($active_term ?? '') == 'Second Term' ? 'bg-blue-50 text-primary font-bold' : '' ?>">
                    Second Term
                    <?php if(($active_term ?? '') == 'Second Term'): ?><i data-lucide="check" class="w-4 h-4"></i><?php endif; ?>
                </button>
                <button type="submit" name="term" value="Third Term" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex justify-between items-center <?= ($active_term ?? '') == 'Third Term' ? 'bg-blue-50 text-primary font-bold' : '' ?>">
                    Third Term
                    <?php if(($active_term ?? '') == 'Third Term'): ?><i data-lucide="check" class="w-4 h-4"></i><?php endif; ?>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4 mb-6">
    
    <!-- Card 1: Students -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Students</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= number_format($stats['students']) ?></h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i> Active Enrolled
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
            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= number_format($stats['teachers']) ?></h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i> Active Staff
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
            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['attendance_percentage'] ?>%</h3>
            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1 font-medium">
                Based on records
            </p>
        </div>
    </div>

    <!-- Card 4: Fees -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between col-span-2 lg:col-span-1">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-bold bg-gray-100 text-gray-500 px-2 py-1 rounded-full uppercase"><?= htmlspecialchars($active_term ?? 'First Term') ?></span>
        </div>
        <div class="mt-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Fees Collected</p>
            <h3 class="text-2xl font-bold text-emerald-600 mt-1">₦<?= number_format($stats['fees_collected'], 2) ?></h3>
            <div class="flex flex-col gap-1 mt-2">
                <p class="text-[11px] text-gray-500 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Expected: ₦<?= number_format($stats['total_expected'] ?? 0, 2) ?>
                </p>
                <p class="text-[11px] text-red-500 font-medium flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Balance: ₦<?= number_format($stats['total_outstanding'] ?? 0, 2) ?>
                </p>
            </div>
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
            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= number_format($stats['parents']) ?></h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i> Registered
            </p>
        </div>
    </div>

</div>

<!-- First Row: Chart & Activities -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    
    <!-- Attendance Chart Area -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-6 flex flex-col">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Attendance Overview (Last 7 Days)</h2>
        </div>
        <!-- Canvas for Line Chart -->
        <div class="flex-1 relative w-full h-72">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>

    <!-- Recent Activities (Recently Added Students) -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Recent Admissions</h2>
            <a href="/admin/students" class="text-sm text-accent font-medium hover:underline">View All</a>
        </div>
        <div class="space-y-4">
            
            <?php if(empty($recentStudents)): ?>
                <p class="text-sm text-gray-500 text-center py-4">No recent admissions.</p>
            <?php else: ?>
                <?php foreach($recentStudents as $student): ?>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></p>
                            <p class="text-xs text-gray-500">Admitted to <?= e($student['class_name'] ?? 'Unassigned') ?></p>
                            <p class="text-[10px] text-gray-400 mt-1"><?= date('M j, Y', strtotime($student['created_at'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Second Row of Charts & Leaderboard -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Student Distribution Bar Chart -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800">Student Distribution by Class</h2>
        </div>
        <div class="flex-1 relative w-full h-72">
            <canvas id="studentsChart"></canvas>
        </div>
    </div>

    <!-- House Leaderboard -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 flex flex-col justify-center">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800">House Leaderboard</h2>
        </div>
        
        <div class="space-y-5">
            <?php 
            $houseColors = [
                'Red' => 'bg-red-500', 'Blue' => 'bg-blue-500', 'Green' => 'bg-green-500', 'Yellow' => 'bg-yellow-500'
            ];
            $totalStudents = array_sum($houseStats);
            
            foreach($houseStats as $houseName => $count): 
                $percentage = $totalStudents > 0 ? ($count / $totalStudents) * 100 : 0;
            ?>
                <div>
                    <div class="flex justify-between text-sm font-bold mb-1.5">
                        <span class="text-gray-800 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full <?= $houseColors[$houseName] ?>"></span>
                            <?= $houseName ?> House
                        </span>
                        <span class="text-gray-500"><?= $count ?> Students</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3">
                        <div class="<?= $houseColors[$houseName] ?> h-3 rounded-full transition-all duration-1000" style="width: <?= $percentage ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- 1. Attendance Line Chart ---
    const attCtx = document.getElementById('attendanceChart').getContext('2d');
    
    let gradientPresent = attCtx.createLinearGradient(0, 0, 0, 300);
    gradientPresent.addColorStop(0, 'rgba(14, 165, 233, 0.5)');
    gradientPresent.addColorStop(1, 'rgba(14, 165, 233, 0.0)');

    new Chart(attCtx, {
        type: 'line',
        data: {
            labels: <?= $chart_attendance_labels ?>,
            datasets: [
                {
                    label: 'Present',
                    data: <?= $chart_attendance_present ?>,
                    borderColor: '#0EA5E9',
                    backgroundColor: gradientPresent,
                    borderWidth: 2,
                    pointBackgroundColor: '#0EA5E9',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Absent',
                    data: <?= $chart_attendance_absent ?>,
                    borderColor: '#EF4444',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointBackgroundColor: '#EF4444',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8 } } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4], color: '#E2E8F0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // --- 2. Student Distribution Bar Chart ---
    const stuCtx = document.getElementById('studentsChart').getContext('2d');
    new Chart(stuCtx, {
        type: 'bar',
        data: {
            labels: <?= $chart_students_labels ?>,
            datasets: [{
                label: 'Number of Students',
                data: <?= $chart_students_data ?>,
                backgroundColor: '#1E3A8A',
                borderRadius: 6,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { borderDash: [2, 4], color: '#E2E8F0' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

<?php
// Render the content into the layout
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>
