<?php
// resources/views/admin/students/index.php
ob_start();
?>

<!-- Flash Messages -->
<?php if(isset($_SESSION['success'])): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between text-sm shadow-sm transition-all">
        <div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i><?= e($_SESSION['success']) ?></div>
        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between text-sm shadow-sm transition-all">
        <div class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-4 h-4"></i><?= e($_SESSION['error']) ?></div>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Students</h1>
        <p class="text-sm text-gray-500 mt-1">Manage all enrolled students in the school.</p>
    </div>
    
    <a href="/admin/students/create" class="bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors w-full sm:w-auto justify-center">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Add New Student
    </a>
</div>

<!-- Search and Filters -->
<div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
    <form action="/admin/students" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="relative flex-1">
            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Search by name or admission number..." 
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent text-sm">
        </div>
        <select name="class" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent bg-white text-gray-700">
            <option value="">All Classes</option>
            <option value="1">JSS 1A</option>
            <option value="2">JSS 1B</option>
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium transition-colors border border-gray-200">
            Filter
        </button>
    </form>
</div>

<!-- Data Table -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-medium">Admission No.</th>
                    <th class="px-6 py-4 font-medium">Student Name</th>
                    <th class="px-6 py-4 font-medium">Class</th>
                    <th class="px-6 py-4 font-medium">Gender</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                
                <?php if(empty($students)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i data-lucide="inbox" class="w-10 h-10 mx-auto text-gray-300 mb-3"></i>
                            <p>No students found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($students as $student): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= e($student['admission_number']) ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-md text-xs font-medium border border-gray-200">
                                    <?= e($student['class_name'] ?? 'Unassigned') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600"><?= e($student['gender']) ?></td>
                            <td class="px-6 py-4">
                                <?php if($student['status'] === 'active'): ?>
                                    <span class="flex items-center gap-1.5 text-green-600 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                    </span>
                                <?php else: ?>
                                    <span class="flex items-center gap-1.5 text-gray-500 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> <?= ucfirst($student['status']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Updated Actions Column -->
                            <td class="px-6 py-4 text-right space-x-3">
                                <!-- Edit Button -->
                                <a href="/admin/students/edit?id=<?= $student['id'] ?>" class="text-gray-400 hover:text-primary transition-colors inline-block" title="Edit Student">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                
                                <!-- Delete Form -->
                                <form action="/admin/students/delete" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this student? This will permanently remove their login account, scores, and attendance records.');">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="id" value="<?= $student['id'] ?>">
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete Student">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                    </button>
                                </form>
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
