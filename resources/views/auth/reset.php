<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - <?= env('APP_NAME') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center font-sans antialiased p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="lock" class="w-8 h-8"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Create New Password</h2>
            <p class="text-sm text-gray-500 mt-2">Your new password must be different from previous used passwords.</p>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="bg-red-50 text-red-700 p-3 rounded-lg text-sm mb-4 text-center"><?= e($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="/reset-password" method="POST" class="space-y-5">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="token" value="<?= e($token) ?>">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" required minlength="6" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-accent" placeholder="••••••••">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="confirm_password" required minlength="6" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-accent" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white py-3 rounded-xl font-bold shadow-lg transition-colors">
                Reset Password
            </button>
        </form>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
