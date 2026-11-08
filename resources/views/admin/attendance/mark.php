<?php
// resources/views/admin/attendance/mark.php
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
    <div class="flex items-center gap-4">
        <a href="/admin/attendance" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Mark Attendance: <?= e($class_name) ?></h1>
            <p class="text-sm text-gray-500 mt-1">Date: <strong><?= date('l, F j, Y', strtotime($date)) ?></strong></p>
        </div>
    </div>
    
    <!-- Quick Action Button -->
    <button type="button" onclick="markAllPresent()" class="bg-green-100 text-green-700 hover:bg-green-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
        <i data-lucide="check-check" class="w-4 h-4"></i> Mark All Present
    </button>
</div>

<form action="/admin/attendance/store" method="POST">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
    <input type="hidden" name="class_id" value="<?= e($class_id) ?>">
    <input type="hidden" name="date" value="<?= e($date) ?>">

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4 font-medium">Student</th>
                        <th class="px-6 py-4 font-medium text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php if(empty($students)): ?>
                        <tr>
                            <td colspan="2" class="px-6 py-10 text-center text-gray-500">
                                <p>No active students found in this class.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($students as $student): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></p>
                                            <p class="text-xs text-gray-500"><?= e($student['admission_number']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <!-- Radio Buttons for Status -->
                                    <div class="flex justify-center gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="attendance[<?= $student['id'] ?>]" value="present" class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300" <?= ($student['status'] == 'present' || !$student['status']) ? 'checked' : '' ?>>
                                            <span class="text-sm font-medium text-gray-700">Present</span>
                                        </label>
                                        
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="attendance[<?= $student['id'] ?>]" value="absent" class="w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300" <?= ($student['status'] == 'absent') ? 'checked' : '' ?>>
                                            <span class="text-sm font-medium text-gray-700">Absent</span>
                                        </label>
                                        
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="attendance[<?= $student['id'] ?>]" value="late" class="w-4 h-4 text-yellow-500 focus:ring-yellow-500 border-gray-300" <?= ($student['status'] == 'late') ? 'checked' : '' ?>>
                                            <span class="text-sm font-medium text-gray-700">Late</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end gap-3 mb-10">
        <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-6 py-3 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2 w-full sm:w-auto justify-center">
            <i data-lucide="save" class="w-4 h-4"></i> Save Attendance Sheet
        </button>
    </div>
</form>

<script>
    // Quick action script to mark everyone present
    function markAllPresent() {
        const presentRadios = document.querySelectorAll('input[value="present"]');
        presentRadios.forEach(radio => {
            radio.checked = true;
        });
    }
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
