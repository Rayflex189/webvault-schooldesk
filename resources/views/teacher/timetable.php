<?php ob_start(); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Class Timetable</h1>
        <p class="text-sm text-gray-500 mt-1"><?= e($session) ?> - <?= e($term) ?></p>
    </div>
</div>

<div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6 flex gap-4 items-center">
    <label class="text-sm font-medium text-gray-700">Select Class:</label>
    <form action="/teacher/timetable" method="GET">
        <select name="class_id" onchange="this.form.submit()" class="border rounded-lg px-4 py-2 text-sm bg-white font-medium">
            <?php foreach($classes as $id => $name): ?>
                <option value="<?= $id ?>" <?= $selectedClass == $id ? 'selected' : '' ?>><?= e($name) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<?php require __DIR__ . '/../components/timetable_grid.php'; ?>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/app.php'; ?>
