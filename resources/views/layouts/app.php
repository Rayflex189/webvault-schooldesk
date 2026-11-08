<?php
// resources/views/layouts/app.php
$settings = get_settings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env('APP_NAME') ?> - <?= htmlspecialchars($settings['school_name'] ?? '') ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for Dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-bg text-textMain font-sans antialiased flex h-screen overflow-hidden relative">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity duration-300"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white flex flex-col h-full shadow-lg transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out">
        <div class="h-16 flex items-center justify-between px-6 border-b border-blue-800">
            <div class="flex items-center gap-3 text-lg font-bold tracking-tight truncate">
                <div class="bg-white p-1.5 rounded-lg text-primary shrink-0">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
                <?= htmlspecialchars($settings['school_name'] ?? 'SchoolDesk') ?>
            </div>
            <!-- Mobile Close Button -->
            <button id="close-sidebar" class="md:hidden text-gray-300 hover:text-white p-1">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <?php if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                <!-- ADMIN MENU -->
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
                <a href="/admin/parents" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/parents') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="users-2" class="w-5 h-5"></i> Parents
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

                <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-6">Finance & System</p>
                <a href="/admin/finance" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/finance') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="wallet" class="w-5 h-5"></i> Fees & Payments
                </a>
                <a href="/admin/settings" class="flex items-center gap-3 px-3 py-2.5 <?= strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="settings" class="w-5 h-5"></i> Settings
                </a>
                
            <?php elseif(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 2): ?>
                <!-- TEACHER MENU -->
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

            <?php elseif(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 3): ?>
                <!-- PARENT MENU -->
                <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-2">Parent Portal</p>
                <a href="/parent/dashboard" class="flex items-center gap-3 px-3 py-2.5 <?= $_SERVER['REQUEST_URI'] == '/parent/dashboard' ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="home" class="w-5 h-5"></i> My Dashboard
                </a>

            <?php elseif(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 4): ?>
                <!-- STUDENT MENU -->
                <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-2">Student Portal</p>
                <a href="/student/dashboard" class="flex items-center gap-3 px-3 py-2.5 <?= $_SERVER['REQUEST_URI'] == '/student/dashboard' ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' ?> rounded-lg font-medium transition-colors">
                    <i data-lucide="home" class="w-5 h-5"></i> My Dashboard
                </a>
            <?php endif; ?>
        </nav>
        
        <!-- Sidebar Footer Snippet -->
        <div class="p-4 border-t border-blue-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-accent flex items-center justify-center text-sm font-bold uppercase">
                    <?= substr($_SESSION['username'] ?? 'U', 0, 2) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></p>
                    <p class="text-xs text-blue-300">
                        <?php 
                            if(($_SESSION['role_id'] ?? 0) == 1) echo 'Administrator';
                            elseif(($_SESSION['role_id'] ?? 0) == 2) echo 'Teacher';
                            elseif(($_SESSION['role_id'] ?? 0) == 3) echo 'Parent';
                            elseif(($_SESSION['role_id'] ?? 0) == 4) echo 'Student';
                        ?>
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
            
            <!-- Left Side: Hamburger & Search -->
            <div class="flex items-center gap-4">
                <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-primary p-1">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                
                <div class="relative hidden sm:block">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search anything..." class="pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent w-64">
                </div>
            </div>
            
            <!-- Right Side: Dropdowns -->
            <div class="flex items-center gap-4 text-gray-500" x-data="{ openSessions: false, openNotifications: false, openUser: false }">
                
                <!-- Session Dropdown -->
                <div class="relative hidden lg:block">
                    <button @click="openSessions = !openSessions" @click.outside="openSessions = false" class="flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg border border-blue-100 text-sm font-medium hover:bg-blue-100 transition">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <?= htmlspecialchars($settings['current_session'] ?? '2024/2025') ?> - <?= htmlspecialchars($settings['current_term'] ?? 'First Term') ?>
                        <i data-lucide="chevron-down" class="w-3 h-3"></i>
                    </button>
                    
                    <div x-cloak x-show="openSessions" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-100 mb-2">
                            <p class="text-xs text-gray-500 font-bold uppercase">Academic Calendar</p>
                        </div>
                        <?php $sessionsList = (new \App\Models\Setting())->getSessions(); ?>
                        <?php foreach($sessionsList as $s): ?>
                            <div class="px-4 py-2 text-sm text-gray-700 flex justify-between items-center hover:bg-gray-50">
                                <?= e($s['session_name']) ?>
                                <?php if($s['is_active']): ?>
                                    <span class="w-2 h-2 rounded-full bg-green-500" title="Active"></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <div class="border-t border-gray-100 mt-2 pt-2">
                            <a href="/admin/settings" class="block px-4 py-2 text-sm text-accent font-medium hover:bg-gray-50">Manage Settings</a>
                        </div>
                    </div>
                </div>

                <!-- Notifications Dropdown -->
                <div class="relative">
                    <button @click="openNotifications = !openNotifications" @click.outside="openNotifications = false" class="hover:text-primary relative p-2 rounded-full hover:bg-gray-50 transition">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </button>
                    
                    <div x-cloak x-show="openNotifications" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-100 mb-2 flex justify-between items-center">
                            <p class="text-xs text-gray-500 font-bold uppercase">Latest Announcements</p>
                        </div>
                        <?php 
                        $pdo = \Database::getInstance();
                        $stmt = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 3");
                        $notifs = $stmt->fetchAll();
                        ?>
                        <?php if(empty($notifs)): ?>
                            <p class="px-4 py-4 text-sm text-gray-500 text-center">No new announcements.</p>
                        <?php else: ?>
                            <?php foreach($notifs as $n): ?>
                                <a href="/admin/announcements" class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition">
                                    <p class="text-sm font-bold text-gray-800 line-clamp-1"><?= e($n['title']) ?></p>
                                    <p class="text-xs text-gray-500 line-clamp-2 mt-1"><?= e($n['content']) ?></p>
                                    <p class="text-[10px] text-gray-400 mt-1"><?= date('M j, Y', strtotime($n['created_at'])) ?></p>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="pt-2">
                            <a href="/admin/announcements" class="block text-center text-sm text-accent font-medium hover:underline py-1">View All</a>
                        </div>
                    </div>
                </div>
                
                <!-- User Profile Dropdown -->
                <div class="flex items-center gap-2 cursor-pointer border-l pl-4 border-gray-200 ml-2 relative">
                    <button @click="openUser = !openUser" @click.outside="openUser = false" class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['username'] ?? 'User') ?>&background=0EA5E9&color=fff" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-medium text-gray-700 hidden sm:block"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                        <i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i>
                    </button>
                    
                    <div x-cloak x-show="openUser" x-transition class="absolute right-0 top-12 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-gray-400"></i> My Profile
                        </a>
                        <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2 border-t border-gray-100 mt-1 pt-2">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                        </a>
                    </div>
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
        lucide.createIcons();
        
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
