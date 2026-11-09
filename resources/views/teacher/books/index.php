<?php ob_start(); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Class Booklists</h1>
    <a href="/teacher/books/recommend" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium">Recommend a Book</a>
</div>

<div class="bg-white p-4 rounded-xl border mb-6 flex gap-4 items-center">
    <form action="/teacher/books" method="GET">
        <select name="class_id" onchange="this.form.submit()" class="border rounded-lg px-4 py-2 text-sm bg-white">
            <?php foreach($classes as $id => $name): ?>
                <option value="<?= $id ?>" <?= $selectedClass == $id ? 'selected' : '' ?>><?= e($name) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr><th class="px-6 py-4 text-xs font-medium text-gray-500 uppercase">Title</th><th class="px-6 py-4 text-xs font-medium text-gray-500 uppercase">Author</th></tr>
        </thead>
        <tbody class="divide-y text-sm">
            <?php foreach($books as $b): ?>
                <tr><td class="px-6 py-4 font-medium"><?= e($b['title']) ?></td><td class="px-6 py-4 text-gray-600"><?= e($b['author']) ?></td></tr>
            <?php endforeach; ?>
            <?php if(empty($books)): ?><tr><td colspan="2" class="p-6 text-center text-gray-500">No books listed.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
