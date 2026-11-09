<?php
// resources/views/admin/teachers/index.php
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

<?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between text-sm shadow-sm">
        <div class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-4 h-4"></i><?= e($_SESSION['error']) ?></div>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Teachers</h1>
        <p class="text-sm text-gray-500 mt-1">Manage teaching staff and their qualifications.</p>
    </div>
    
    <a href="/admin/teachers/create" class="bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors w-full sm:w-auto justify-center">
        <i data-lucide="plus" class="w-4 h-4"></i> Add New Teacher
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-medium">Staff ID</th>
                    <th class="px-6 py-4 font-medium">Name</th>
                    <th class="px-6 py-4 font-medium">Contact</th>
                    <th class="px-6 py-4 font-medium">Qualification</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                
                <?php if(empty($teachers)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i data-lucide="user-x" class="w-10 h-10 mx-auto text-gray-300 mb-3"></i>
                            <p>No teachers found.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($teachers as $teacher): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= e($teacher['staff_id']) ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= strtoupper(substr($teacher['first_name'], 0, 1) . substr($teacher['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900"><?= e($teacher['first_name'] . ' ' . $teacher['last_name']) ?></p>
                                        <p class="text-xs text-gray-500"><?= e($teacher['gender']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800"><?= e($teacher['email']) ?></p>
                                <p class="text-xs text-gray-500"><?= e($teacher['phone']) ?></p>
                            </td>
                            <td class="px-6 py-4 text-gray-600"><?= e($teacher['qualification']) ?></td>
                            <td class="px-6 py-4">
                                <?php if($teacher['status'] === 'active'): ?>
                                    <span class="flex items-center gap-1.5 text-green-600 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                    </span>
                                <?php else: ?>
                                    <span class="flex items-center gap-1.5 text-gray-500 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Updated Actions Column -->
                            <td class="px-6 py-4 text-right space-x-3">
                                <!-- Edit Button -->
                                <a href="/admin/teachers/edit?id=<?= $teacher['id'] ?>" class="text-gray-400 hover:text-primary transition-colors inline-block" title="Edit Teacher">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                
                                <!-- Delete Form -->
                                <form action="/admin/teachers/delete" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this teacher? This will also delete their login account.');">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="id" value="<?= $teacher['id'] ?>">
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete Teacher">
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
