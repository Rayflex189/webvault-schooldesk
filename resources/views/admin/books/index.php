<?php
ob_start();
?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manage Booklist</h1>
        <p class="text-sm text-gray-500 mt-1">Assign required textbooks and materials per class.</p>
    </div>
</div>

<!-- Select Class -->
<div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
    <form action="/admin/books" method="GET" class="flex gap-4 items-center">
        <label class="text-sm font-medium text-gray-700">Select Class:</label>
        <select name="class_id" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-accent bg-white">
            <?php foreach($classes as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $selectedClass == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add Book Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 h-fit">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Add New Book</h2>
        <form action="/admin/books/store" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="class_id" value="<?= $selectedClass ?>">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Book Title</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Author (Optional)</label>
                <input type="text" name="author" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_compulsory" id="compulsory" checked class="w-4 h-4 text-accent rounded border-gray-300">
                <label for="compulsory" class="text-sm text-gray-700">Compulsory Book</label>
            </div>
            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-4 py-2 rounded-lg font-medium transition">Add to List</button>
        </form>
    </div>

    <!-- Book List -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-medium">Title</th>
                    <th class="px-6 py-4 font-medium">Author</th>
                    <th class="px-6 py-4 font-medium">Type</th>
                    <th class="px-6 py-4 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <?php if(empty($books)): ?>
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No books added for this class yet.</td></tr>
                <?php else: ?>
                    <?php foreach($books as $b): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= e($b['title']) ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= e($b['author']) ?></td>
                            <td class="px-6 py-4">
                                <?php if($b['is_compulsory']): ?>
                                    <span class="bg-red-50 text-red-600 px-2 py-1 rounded text-xs font-bold border border-red-100">Compulsory</span>
                                <?php else: ?>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold border border-gray-200">Optional</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="/admin/books/delete" method="POST" onsubmit="return confirm('Remove this book?');">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                    <input type="hidden" name="class_id" value="<?= $selectedClass ?>">
                                    <button type="submit" class="text-gray-400 hover:text-red-500"><i data-lucide="trash" class="w-4 h-4"></i></button>
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
