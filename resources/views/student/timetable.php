<?php ob_start(); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">My Timetable</h1>
        <p class="text-sm text-gray-500 mt-1"><?= e($session) ?> - <?= e($term) ?></p>
    </div>
</div>

<?php require __DIR__ . '/../components/timetable_grid.php'; ?>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/app.php'; ?>
