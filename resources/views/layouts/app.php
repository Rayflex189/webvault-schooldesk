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
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-out forwards',
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
<body class="bg-bg text-textMain font-sans antialiased flex h-screen overflow-hidden relative">

    <!-- Mobile Overlay (Darkens background when menu is open) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity duration-300"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white flex flex-col h-full shadow-lg transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out">
        <div class="h-16 flex items-center justify-between px-6 border-b border-blue-800">
            <div class="flex items-center gap-3 text-xl font-bold tracking-tight">
                <div class="bg-white p-1.5 rounded-lg text-primary">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
                SchoolDesk
            </div>
            <!-- Mobile Close Button -->
            <button id="close-sidebar" class="md:hidden text-gray-300 hover:text-white p-1">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <?php if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                <!-- ================= ADMIN MENU ================= -->
                <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-2">Management</p>
                <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2.5 <?= $_SERVER['REQUEST_URI'] == '/admin/dashboard' ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </a>
                <a href="/admin/announcements" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/announcements') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="megaphone" class="w-5 h-5"></i> Announcements
                </a>
                <a href="/admin/students" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/students') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="users" class="w-5 h-5"></i> Students
                </a>
                <a href="/admin/teachers" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/teachers') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="user-check" class="w-5 h-5"></i> Teachers
                </a>
                
                <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-6">Academics</p>
                <a href="/admin/classes" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/classes') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="school" class="w-5 h-5"></i> Classes
                </a>
                <a href="/admin/subjects" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/subjects') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="book" class="w-5 h-5"></i> Subjects
                </a>
                <a href="/admin/assignments" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/assignments') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i> Assignments
                </a>
                <a href="/admin/attendance" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/attendance') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="calendar" class="w-5 h-5"></i> Attendance
                </a>
                <a href="/admin/exams" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/exams') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="file-edit" class="w-5 h-5"></i> Exams
                </a>
                <a href="/admin/reports" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/reports') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="printer" class="w-5 h-5"></i> Report Cards
                </a>

                <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-6">Finance</p>
                <a href="/admin/finance" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/finance') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="wallet" class="w-5 h-5"></i> Fees & Payments
                </a>
                
            <?php elseif(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 2): ?>
                <!-- ================= TEACHER MENU ================= -->
                <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-2">Teacher Portal</p>
                <a href="/teacher/dashboard" class="flex items-center gap-3 px-3 py-2.5 <?= $_SERVER['REQUEST_URI'] == '/teacher/dashboard' ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> My Dashboard
                </a>
                <a href="/teacher/attendance" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/teacher/attendance') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="clipboard-check" class="w-5 h-5"></i> Take Attendance
                </a>
                <a href="/teacher/exams" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/teacher/exams') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="file-edit" class="w-5 h-5"></i> Enter Scores
                </a>
            <?php endif; ?>
        </nav>
        
        <!-- User Profile Snippet -->
        <div class="p-4 border-t border-blue-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-accent flex items-center justify-center text-sm font-bold uppercase">
                    <?= substr($_SESSION['username'] ?? 'U', 0, 2) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></p>
                    <p class="text-xs text-blue-300">
                        <?= $_SESSION['role_id'] == 1 ? 'Administrator' : 'Teacher' ?>
                    </p>
                </div>
                <a href="/logout" class="text-blue-300 hover:text-red-400 transition-colors" title="Logout">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-full overflow-hidden w-full">
        
        <!-- Top Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 z-30 shadow-sm shrink-0">
            <div class="flex items-center gap-4">
                <!-- Hamburger Button (Mobile Only) -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-primary p-1">
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
                
                <!-- User Dropdown -->
                <div class="flex items-center gap-2 cursor-pointer border-l pl-4 border-gray-200 ml-2">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['username'] ?? 'User') ?>&background=0EA5E9&color=fff" class="w-8 h-8 rounded-full">
                    <span class="text-sm font-medium text-gray-700 hidden sm:block"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                    <a href="/logout" class="text-red-500 hover:text-red-700 ml-2" title="Logout">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </header>

        <!-- Dynamic Page Content with Animation -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 pb-20 animate-fade-in">
            <?= $content ?? '' ?>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Mobile Menu Logic
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeSidebarBtn = document.getElementById('close-sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        mobileMenuBtn.addEventListener('click', toggleSidebar);
        closeSidebarBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
