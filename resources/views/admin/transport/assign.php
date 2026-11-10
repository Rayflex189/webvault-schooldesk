<?php ob_start(); ?>
<div class="flex items-center gap-4 mb-6">
    <a href="/admin/transport" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary transition-colors">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Assign Students to Buses</h1>
        <p class="text-sm text-gray-500 mt-1">Select a bus route for each student.</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                <th class="px-6 py-4 font-medium">Student</th>
                <th class="px-6 py-4 font-medium">Class</th>
                <th class="px-6 py-4 font-medium">Bus Route</th>
                <th class="px-6 py-4 font-medium text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            <?php foreach($students as $s): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900"><?= e($s['first_name'] . ' ' . $s['last_name']) ?></p>
                        <p class="text-xs text-gray-500"><?= e($s['admission_number']) ?></p>
                    </td>
                    <td class="px-6 py-4"><span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs border"><?= e($s['class_name']) ?></span></td>
                    <td class="px-6 py-4">
                        <form action="/admin/transport/update-assignment" method="POST" id="form-<?= $s['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <input type="hidden" name="student_id" value="<?= $s['id'] ?>">
                            <select name="bus_route_id" onchange="document.getElementById('form-<?= $s['id'] ?>').submit()" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-accent bg-white w-full max-w-xs">
                                <option value="">-- Not Assigned --</option>
                                <?php foreach($routes as $r): ?>
                                    <option value="<?= $r['id'] ?>" <?= $s['bus_route_id'] == $r['id'] ? 'selected' : '' ?>><?= e($r['route_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <?php if($s['route_name']): ?>
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold border border-green-200">Assigned</span>
                        <?php else: ?>
                            <span class="text-xs text-gray-400">Unassigned</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
