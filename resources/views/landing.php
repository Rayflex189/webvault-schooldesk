<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebVault SchoolDesk - Premium School Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A', // Navy
                        accent: '#0EA5E9',  // Sky Blue
                        bg: '#F8FAFC',      // Light Slate
                        textMain: '#0F172A', // Dark Slate
                        muted: '#64748B'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .hero-text {
            font-size: clamp(4rem, 15vw, 14rem);
            line-height: 0.85;
            letter-spacing: -0.05em;
            mix-blend-mode: overlay;
        }
        /* Hide scrollbar for horizontal scroll areas if used */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-bg text-textMain font-sans antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="absolute top-0 left-0 w-full z-50 px-6 py-6 flex justify-between items-center text-primary">
        <div class="flex items-center gap-2">
            <i data-lucide="graduation-cap" class="w-8 h-8 text-accent"></i>
            <span class="text-2xl font-bold tracking-tight">WebVault<span class="font-light">SchoolDesk</span></span>
        </div>
        
        <div class="hidden md:flex gap-8 text-sm font-medium">
            <a href="#" class="hover:text-accent transition">Features</a>
            <a href="#" class="hover:text-accent transition">Solutions</a>
            <a href="#" class="hover:text-accent transition">Pricing</a>
        </div>

        <div class="flex items-center gap-4">
            <a href="/login" class="text-sm font-medium hover:text-accent transition hidden sm:block">Log in</a>
            <a href="/login" class="bg-primary text-white px-5 py-2.5 rounded-full text-sm font-medium hover:bg-blue-900 transition shadow-lg shadow-primary/30 flex items-center gap-2">
                Get Started <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-screen min-h-[700px] flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop" 
                 alt="School Environment" 
                 class="w-full h-full object-cover object-center"
                 style="filter: brightness(0.9) grayscale(20%);">
            <!-- Gradient overlay to ensure text readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-bg via-transparent to-transparent"></div>
            <div class="absolute inset-0 bg-primary/10"></div>
        </div>

        <!-- Massive Overlapping Text -->
        <div class="absolute z-10 flex flex-col items-center justify-center w-full mt-20 pointer-events-none select-none">
            <h1 class="hero-text font-black text-white uppercase text-center drop-shadow-2xl">
                SCHOOL<br>DESK
            </h1>
        </div>

        <!-- Foreground Content -->
        <div class="relative z-20 w-full max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-end h-full pb-20 pt-40">
            
            <!-- Left Text -->
            <div class="max-w-md bg-white/80 backdrop-blur-md p-6 rounded-2xl border border-white/50 shadow-xl">
                <div class="flex items-center gap-2 text-xs font-bold text-accent tracking-widest uppercase mb-3">
                    <span class="w-8 h-[2px] bg-accent"></span>
                    New Era of Management
                </div>
                <h2 class="text-4xl font-black text-primary uppercase leading-none mb-4">
                    Manage<br>with ease.
                </h2>
                <p class="text-sm text-muted mb-6 font-medium leading-relaxed">
                    Simplify administration, academics, finance, and communication in one unified platform. Built for modern educational institutions.
                </p>
                <a href="/login" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-blue-900 transition shadow-lg">
                    EXPLORE NOW <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <!-- Right Floating Images (Like the fashion carousel) -->
            <div class="hidden lg:flex flex-col gap-4 relative">
                <div class="w-40 h-48 rounded-2xl overflow-hidden shadow-2xl border-2 border-white transform translate-x-4">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <div class="w-40 h-48 rounded-2xl overflow-hidden shadow-2xl border-2 border-white transform -translate-x-4">
                    <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-4 right-4 flex gap-2">
                    <button class="w-10 h-10 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/50 hover:bg-white/50 transition"><i data-lucide="arrow-left" class="w-4 h-4"></i></button>
                    <button class="w-10 h-10 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/50 hover:bg-white/50 transition"><i data-lucide="arrow-right" class="w-4 h-4"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Bar (Overlay) -->
    <div class="relative z-30 max-w-7xl mx-auto -mt-8 px-6">
        <div class="bg-primary text-white rounded-2xl p-4 sm:px-8 flex flex-wrap justify-between items-center shadow-2xl border border-blue-800">
            <div class="flex items-center gap-2 text-sm font-medium py-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-accent"></i> Secure & Reliable
            </div>
            <div class="hidden sm:block w-px h-6 bg-blue-800"></div>
            <div class="flex items-center gap-2 text-sm font-medium py-2">
                <i data-lucide="zap" class="w-5 h-5 text-accent"></i> Lightning Fast
            </div>
            <div class="hidden sm:block w-px h-6 bg-blue-800"></div>
            <div class="flex items-center gap-2 text-sm font-medium py-2">
                <i data-lucide="smartphone" class="w-5 h-5 text-accent"></i> Fully Responsive
            </div>
            <div class="hidden sm:block w-px h-6 bg-blue-800"></div>
            <div class="flex items-center gap-2 text-sm font-medium py-2">
                <i data-lucide="headphones" class="w-5 h-5 text-accent"></i> 24/7 Support
            </div>
        </div>
    </div>

    <!-- Shop By Category (Adapted to User Portals) -->
    <section class="py-20 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-muted tracking-widest uppercase mb-2">
                    <i data-lucide="layout-grid" class="w-4 h-4 text-primary"></i> Explore
                </div>
                <h2 class="text-3xl font-black text-primary uppercase">Tailored Portals</h2>
            </div>
            <a href="#" class="text-sm font-bold text-primary hover:text-accent transition flex items-center gap-1 mt-4 md:mt-0">
                View All Features <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1 -->
            <div class="group relative h-80 rounded-2xl overflow-hidden cursor-pointer">
                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div class="text-white">
                        <h3 class="text-xl font-black uppercase mb-1">Admin</h3>
                        <p class="text-xs text-blue-100 font-medium">Total Control</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-accent transition">
                        <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="group relative h-80 rounded-2xl overflow-hidden cursor-pointer">
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div class="text-white">
                        <h3 class="text-xl font-black uppercase mb-1">Teachers</h3>
                        <p class="text-xs text-blue-100 font-medium">Grade & Teach</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-accent transition">
                        <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="group relative h-80 rounded-2xl overflow-hidden cursor-pointer">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div class="text-white">
                        <h3 class="text-xl font-black uppercase mb-1">Parents</h3>
                        <p class="text-xs text-blue-100 font-medium">Stay Informed</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-accent transition">
                        <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="group relative h-80 rounded-2xl overflow-hidden cursor-pointer">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div class="text-white">
                        <h3 class="text-xl font-black uppercase mb-1">Students</h3>
                        <p class="text-xs text-blue-100 font-medium">Track Progress</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-accent transition">
                        <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Best Sellers (Adapted to Key Modules) -->
    <section class="py-10 px-6 max-w-7xl mx-auto mb-20">
        <div class="flex justify-between items-end mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-2xl font-black text-primary uppercase tracking-tight">Core Modules</h2>
            <a href="#" class="text-sm font-bold text-primary hover:text-accent transition flex items-center gap-1">
                View All <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            
            <!-- Module 1 -->
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                <div class="h-32 bg-gray-50 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                    <i data-lucide="users" class="w-10 h-10 text-primary group-hover:scale-110 transition"></i>
                </div>
                <h4 class="text-sm font-bold text-primary mb-1">Student Records</h4>
                <p class="text-xs text-muted">Admissions & Profiles</p>
            </div>

            <!-- Module 2 -->
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                <div class="h-32 bg-gray-50 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                    <i data-lucide="wallet" class="w-10 h-10 text-primary group-hover:scale-110 transition"></i>
                </div>
                <h4 class="text-sm font-bold text-primary mb-1">Fee Collection</h4>
                <p class="text-xs text-muted">Invoices & Receipts</p>
            </div>

            <!-- Module 3 -->
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                <div class="h-32 bg-gray-50 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                    <i data-lucide="file-edit" class="w-10 h-10 text-primary group-hover:scale-110 transition"></i>
                </div>
                <h4 class="text-sm font-bold text-primary mb-1">Exam Scores</h4>
                <p class="text-xs text-muted">CA & Exam Entry</p>
            </div>

            <!-- Module 4 -->
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                <div class="h-32 bg-gray-50 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                    <i data-lucide="printer" class="w-10 h-10 text-primary group-hover:scale-110 transition"></i>
                </div>
                <h4 class="text-sm font-bold text-primary mb-1">Report Cards</h4>
                <p class="text-xs text-muted">PDF Generation</p>
            </div>

            <!-- Module 5 -->
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                <div class="h-32 bg-gray-50 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                    <i data-lucide="calendar-check" class="w-10 h-10 text-primary group-hover:scale-110 transition"></i>
                </div>
                <h4 class="text-sm font-bold text-primary mb-1">Attendance</h4>
                <p class="text-xs text-muted">Daily Tracking</p>
            </div>

            <!-- Module 6 -->
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                <div class="h-32 bg-gray-50 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                    <i data-lucide="megaphone" class="w-10 h-10 text-primary group-hover:scale-110 transition"></i>
                </div>
                <h4 class="text-sm font-bold text-primary mb-1">Announcements</h4>
                <p class="text-xs text-muted">School-wide Broadcasts</p>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-16 px-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-accent opacity-10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        
        <div class="max-w-7xl mx-auto relative z-10 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-6">
                    <div class="bg-white p-2 rounded-lg text-primary">
                        <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                    </div>
                    <span class="text-2xl font-bold tracking-tight">WebVault<span class="font-light">SchoolDesk</span></span>
                </div>
                <p class="text-blue-200 text-sm max-w-sm leading-relaxed mb-6">
                    The modern, all-in-one platform for managing your educational institution efficiently and securely. Built for schools that demand excellence.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center hover:bg-accent transition"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center hover:bg-accent transition"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center hover:bg-accent transition"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold mb-4 uppercase tracking-wider text-sm text-white">Product</h4>
                <ul class="space-y-3 text-sm text-blue-200">
                    <li><a href="#" class="hover:text-white transition">Features</a></li>
                    <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                    <li><a href="#" class="hover:text-white transition">Documentation</a></li>
                    <li><a href="#" class="hover:text-white transition">System Status</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4 uppercase tracking-wider text-sm text-white">Company</h4>
                <ul class="space-y-3 text-sm text-blue-200">
                    <li><a href="#" class="hover:text-white transition">About Us</a></li>
                    <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-blue-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-blue-300 relative z-10">
            <p>&copy; <?= date('Y') ?> WebVault SchoolDesk. All rights reserved.</p>
            <p>Made with <i data-lucide="heart" class="w-3 h-3 inline text-red-500 mx-1"></i> for Educators.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
