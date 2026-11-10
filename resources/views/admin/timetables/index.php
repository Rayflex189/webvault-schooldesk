<?php
// resources/views/admin/timetables/index.php
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

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Class Timetable</h1>
        <p class="text-sm text-gray-500 mt-1">Manage the weekly schedule for each class.</p>
    </div>
</div>

<!-- Selectors -->
<div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
    <form action="/admin/timetables" method="GET" class="flex flex-col sm:flex-row gap-4">
        <select name="class_id" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent bg-white font-medium">
            <?php foreach($classes as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $selectedClass == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <select name="session" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent bg-white text-gray-700">
            <option value="2023/2024" <?= $session == '2023/2024' ? 'selected' : '' ?>>2023/2024</option>
            <option value="2024/2025" <?= $session == '2024/2025' ? 'selected' : '' ?>>2024/2025</option>
        </select>
        
        <select name="term" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent bg-white text-gray-700">
            <option value="First Term" <?= $term == 'First Term' ? 'selected' : '' ?>>First Term</option>
            <option value="Second Term" <?= $term == 'Second Term' ? 'selected' : '' ?>>Second Term</option>
            <option value="Third Term" <?= $term == 'Third Term' ? 'selected' : '' ?>>Third Term</option>
        </select>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Add Slot Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-fit">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-accent"></i> Add New Slot
        </h2>
        
        <form action="/admin/timetables/store" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="class_id" value="<?= $selectedClass ?>">
            <input type="hidden" name="session" value="<?= $session ?>">
            <input type="hidden" name="term" value="<?= $term ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <select name="subject_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white text-sm">
                    <?php foreach($subjects as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= e($s['name']) ?> (<?= e($s['code']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teacher (Optional)</label>
                <select name="teacher_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white text-sm">
                    <option value="">-- Select Teacher --</option>
                    <?php foreach($teachers as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= e($t['first_name'] . ' ' . $t['last_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Day of Week</label>
                <select name="day_of_week" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white text-sm">
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="time" name="start_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="time" name="end_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                </div>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg font-medium shadow-sm transition-colors flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Add to Timetable
            </button>
        </form>
    </div>

    <!-- Timetable Grid -->
    <div class="lg:col-span-2 space-y-6">
        <?php 
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach($days as $day): 
            // Filter slots for this specific day
            $daySlots = array_filter($slots, function($slot) use ($day) {
                return $slot['day_of_week'] === $day;
            });
        ?>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 uppercase tracking-wider"><?= $day ?></h3>
                    <span class="text-xs bg-primary text-white px-2 py-1 rounded-full font-bold"><?= count($daySlots) ?> Classes</span>
                </div>
                
                <?php if(empty($daySlots)): ?>
                    <div class="p-6 text-center text-gray-400 text-sm">No classes scheduled.</div>
                <?php else: ?>
                    <div class="divide-y divide-gray-100">
                        <?php foreach($daySlots as $slot): ?>
                            <div class="p-4 sm:px-6 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-24 text-sm font-bold text-gray-500">
                                        <?= date('g:i A', strtotime($slot['start_time'])) ?> - <br>
                                        <?= date('g:i A', strtotime($slot['end_time'])) ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900"><?= e($slot['subject_name']) ?></p>
                                        <p class="text-xs text-gray-500">
                                            <?= $slot['teacher_fname'] ? e($slot['teacher_fname'] . ' ' . $slot['teacher_lname']) : 'No Teacher Assigned' ?>
                                        </p>
                                    </div>
                                </div>
                                <form action="/admin/timetables/delete" method="POST" onsubmit="return confirm('Remove this slot?');">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="id" value="<?= $slot['id'] ?>">
                                    <input type="hidden" name="class_id" value="<?= $selectedClass ?>">
                                    <input type="hidden" name="session" value="<?= $session ?>">
                                    <input type="hidden" name="term" value="<?= $term ?>">
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors bg-white rounded-lg border border-gray-200 hover:border-red-200">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
