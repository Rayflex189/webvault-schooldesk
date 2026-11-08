<?php
ob_start();
?>
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
        <p class="text-sm text-gray-500 mt-1">Manage your account details and security.</p>
    </div>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm"><?= e($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm"><?= e($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8 mb-6">
        <div class="flex items-center gap-4 mb-6">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['username']) ?>&background=0EA5E9&color=fff&size=64" class="w-16 h-16 rounded-full">
            <div>
                <h2 class="text-xl font-bold text-gray-900"><?= e($user['username']) ?></h2>
                <p class="text-sm text-gray-500"><?= e($user['email']) ?></p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 font-medium">Account Created</p>
                <p class="text-gray-900"><?= date('F j, Y', strtotime($user['created_at'])) ?></p>
            </div>
            <div>
                <p class="text-gray-500 font-medium">Status</p>
                <p class="text-green-600 font-medium capitalize"><?= e($user['status']) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Change Password</h3>
        <form action="/profile/update" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="new_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="confirm_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            </div>
            <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-6 py-2 rounded-lg font-medium transition">Update Password</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/layouts/app.php';
?>
