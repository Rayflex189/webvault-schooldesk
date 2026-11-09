<?php ob_start(); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Teacher Recommendations</h1>
        <p class="text-sm text-gray-500 mt-1">Review books suggested by teachers for specific classes.</p>
    </div>
    <a href="/admin/books" class="text-accent font-medium text-sm hover:underline">Back to Booklist</a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                <th class="px-6 py-4 font-medium">Recommended By</th>
                <th class="px-6 py-4 font-medium">Class</th>
                <th class="px-6 py-4 font-medium">Book Details</th>
                <th class="px-6 py-4 font-medium">Reason</th>
                <th class="px-6 py-4 font-medium text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            <?php if(empty($recommendations)): ?>
                <tr><td colspan="5" class="px-6 py-10 text-center text-gray-500">No pending recommendations.</td></tr>
            <?php else: ?>
                <?php foreach($recommendations as $r): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-800"><?= e($r['first_name'] . ' ' . $r['last_name']) ?></td>
                        <td class="px-6 py-4"><span class="bg-gray-100 px-2 py-1 rounded text-xs font-medium border"><?= e($r['class_name']) ?></span></td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900"><?= e($r['title']) ?></p>
                            <p class="text-xs text-gray-500">By <?= e($r['author']) ?></p>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-xs"><?= e($r['reason']) ?></td>
                        <td class="px-6 py-4 text-right">
                            <form action="/admin/books/recommendations/approve" method="POST" class="inline-block">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded-lg text-xs font-bold transition">Approve</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
