<?php
// resources/views/auth/login.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= env('APP_NAME') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A',
                        accent: '#0EA5E9',
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center font-sans antialiased">

    <div class="flex w-full h-full">
        
        <!-- Left Side: Branding/Image (Hidden on mobile) -->
        <div class="hidden lg:flex w-1/2 bg-primary text-white flex-col justify-center items-center p-12 relative overflow-hidden">
            <!-- Decorative background shapes -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <svg class="absolute -bottom-24 -left-24 w-96 h-96 text-white" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
                <svg class="absolute -top-24 -right-24 w-96 h-96 text-white" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
            </div>
            
            <div class="relative z-10 text-center max-w-md">
                <div class="bg-white/10 p-4 rounded-2xl inline-block mb-6 backdrop-blur-sm">
                    <i data-lucide="graduation-cap" class="w-12 h-12 text-accent"></i>
                </div>
                <h1 class="text-4xl font-bold mb-4 tracking-tight">WebVault SchoolDesk</h1>
                <p class="text-blue-200 text-lg">The modern, all-in-one platform for managing your educational institution efficiently and securely.</p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center gap-3 text-2xl font-bold text-primary mb-10">
                    <i data-lucide="graduation-cap" class="w-8 h-8 text-accent"></i>
                    SchoolDesk
                </div>

                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                    <p class="text-gray-500">Please sign in to your account to continue.</p>
                </div>

                <!-- Error Message -->
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        <?= e($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="/login" method="POST" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="user" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input type="text" id="username" name="username" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent transition-colors"
                                placeholder="Enter your username">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent transition-colors"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" class="h-4 w-4 text-accent focus:ring-accent border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        <a href="/forgot-password" class="text-sm font-medium text-accent hover:underline">Forgot password?</a>
                    </div>

                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                        Sign in
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-500">
                    Need an account? Contact your school administrator.
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
