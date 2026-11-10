<?php
// resources/views/admin/students/create.php
ob_start();
?>

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="/admin/students" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Add New Student</h1>
            <p class="text-sm text-gray-500 mt-1">Enter the student's details to enroll them.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/admin/students/store" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Admission Number <span class="text-red-500">*</span></label>
                    <input type="text" name="admission_number" required placeholder="e.g. WSD/2024/005"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assign Class <span class="text-red-500">*</span></label>
                    <select name="class_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent bg-white">
                        <option value="">Select a class</option>
                        <?php foreach($classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= e($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" required placeholder="John"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" required placeholder="Doe"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent bg-white">
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="dob" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent text-gray-700">
                </div>

                <!-- New House Dropdown -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">School House</label>
                    <select name="house" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent bg-white">
                        <option value="">-- No House Assigned --</option>
                        <option value="Red">Red House</option>
                        <option value="Blue">Blue House</option>
                        <option value="Green">Green House</option>
                        <option value="Yellow">Yellow House</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="/admin/students" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Save Student
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
