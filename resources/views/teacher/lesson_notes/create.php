<?php ob_start(); ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="/teacher/lesson-notes" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Submit Lesson Note</h1>
            <p class="text-sm text-gray-500 mt-1">Prepare your scheme of work for the Admin.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="/teacher/lesson-notes/store" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="teacher_id" value="<?= $teacher_id ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Assigned Class & Subject <span class="text-red-500">*</span></label>
                    <select name="assignment" required onchange="updateAssignment(this)" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white">
                        <option value="">-- Choose --</option>
                        <?php foreach($assignments as $a): ?>
                            <option value="<?= $a['class_id'] ?>|<?= $a['subject_id'] ?>">
                                <?= e($a['class_name'] . ' - ' . $a['subject_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Hidden inputs populated by JS -->
                    <input type="hidden" name="class_id" id="class_id" required>
                    <input type="hidden" name="subject_id" id="subject_id" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Week Number <span class="text-red-500">*</span></label>
                    <input type="number" name="week_number" required min="1" max="15" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent" placeholder="e.g. 1">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Topic / Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent" placeholder="e.g. Introduction to Algebra">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lesson Note Content <span class="text-red-500">*</span></label>
                <textarea name="content" required rows="10" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent resize-y" placeholder="Write your lesson objectives, materials needed, and steps here..."></textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="/teacher/lesson-notes" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i> Submit to Admin
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // JS to split the combined class/subject dropdown into two separate hidden inputs
    function updateAssignment(select) {
        if(select.value) {
            const parts = select.value.split('|');
            document.getElementById('class_id').value = parts[0];
            document.getElementById('subject_id').value = parts[1];
        }
    }
</script>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
