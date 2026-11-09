<?php ob_start(); ?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl border shadow-sm">
    <h1 class="text-2xl font-bold mb-6">Recommend a Book</h1>
    <form action="/teacher/books/recommend/store" method="POST" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <div>
            <label class="block text-sm font-medium mb-1">Select Class</label>
            <select name="class_id" required class="w-full border rounded-lg px-4 py-2 bg-white">
                <?php foreach($classes as $c): ?><option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?>
            </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Book Title</label><input type="text" name="title" required class="w-full border rounded-lg px-4 py-2"></div>
        <div><label class="block text-sm font-medium mb-1">Author (Optional)</label><input type="text" name="author" class="w-full border rounded-lg px-4 py-2"></div>
        <div><label class="block text-sm font-medium mb-1">Why should this be added?</label><textarea name="reason" rows="3" required class="w-full border rounded-lg px-4 py-2"></textarea></div>
        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-medium">Send to Admin</button>
    </form>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
