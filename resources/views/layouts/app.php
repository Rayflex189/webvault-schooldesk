<?php
// resources/views/layouts/app.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env('APP_NAME') ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A', // Navy Blue
                        accent: '#0EA5E9',  // Sky Blue
                        bg: '#F8FAFC',      // Light Slate
                        textMain: '#0F172A'
                    }
                }
            }
        }
    </script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Custom scrollbar for sidebar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</head>
<body class="bg-bg text-textMain font-sans antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-primary text-white flex flex-col hidden md:flex h-full shadow-lg z-20">
        <div class="h-16 flex items-center px-6 border-b border-blue-800">
            <div class="flex items-center gap-3 text-xl font-bold tracking-tight">
                <div class="bg-white p-1.5 rounded-lg text-primary">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
                SchoolDesk
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2.5 bg-blue-800 text-white rounded-lg font-medium transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-blue-200 hover:bg-blue-800/50 hover:text-white rounded-lg font-medium transition-colors">
                <i data-lucide="users" class="w-5 h-5"></i>
                Students
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-blue-200 hover:bg-blue-800/50 hover:text-white rounded-lg font-medium transition-colors">
                <i data-lucide="user-check" class="w-5 h-5"></i>
                Teachers
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-blue-200 hover:bg-blue-800/50 hover:text-white rounded-lg font-medium transition-colors">
                <i data-lucide="calendar" class="w-5 h-5"></i>
                Attendance
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-blue-200 hover:bg-blue-800/50 hover:text-white rounded-lg font-medium transition-colors">
                <i data-lucide="wallet" class="w-5 h-5"></i>
                Fees & Payments
            </a>
        </nav>
        
        <div class="p-4 border-t border-blue-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-accent flex items-center justify-center text-sm font-bold">AD</div>
                <div>
                    <p class="text-sm font-medium">Admin User</p>
                    <p class="text-xs text-blue-300">Super Admin</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Top Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10 shadow-sm">
            <div class="flex items-center gap-4">
                <button class="md:hidden text-gray-500 hover:text-primary">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <div class="relative hidden sm:block">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search anything..." class="pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent w-64">
                </div>
            </div>
            
            <div class="flex items-center gap-4 text-gray-500">
                <button class="hover:text-primary relative">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <button class="hover:text-primary">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </button>
                <div class="h-6 w-px bg-gray-300 mx-2"></div>
                <div class="flex items-center gap-2 cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=0EA5E9&color=fff" class="w-8 h-8 rounded-full">
                    <span class="text-sm font-medium text-gray-700 hidden sm:block">Admin User</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i>
                </div>
            </div>
        </header>

        <!-- Dynamic Page Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <?= $content ?? '' ?>
        </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>
