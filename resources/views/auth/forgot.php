<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - <?= env('APP_NAME') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center font-sans antialiased p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="key" class="w-8 h-8"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Forgot Password?</h2>
            <p class="text-sm text-gray-500 mt-2">Enter your email address and we'll send you a link to reset your password.</p>
        </div>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="bg-green-50 text-green-700 p-3 rounded-lg text-sm mb-4 text-center"><?= e($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="bg-red-50 text-red-700 p-3 rounded-lg text-sm mb-4 text-center"><?= e($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="/forgot-password" method="POST" class="space-y-5">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent focus:border-accent" placeholder="admin@school.com">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white py-3 rounded-xl font-bold shadow-lg transition-colors">
                Send Reset Link
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="/login" class="text-sm font-medium text-accent hover:underline flex items-center justify-center gap-1">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Login
            </a>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
