<?php
// Fetch global school settings so the landing page is fully dynamic
$settings = get_settings();
$schoolName = $settings['school_name'] ?? 'WebVault SchoolDesk';
$schoolMotto = $settings['motto'] ?? 'Knowledge is Power';
$schoolEmail = $settings['email'] ?? 'info@school.com';
$schoolPhone = $settings['phone'] ?? '+234 800 000 0000';
$schoolAddress = $settings['address'] ?? '123 Education Way, Lagos, Nigeria';

// Dynamically split the school name for the massive hero text
$nameParts = explode(' ', $schoolName);
$heroLine1 = $nameParts[0] ?? 'SCHOOL';
$heroLine2 = implode(' ', array_slice($nameParts, 1));
if (empty($heroLine2)) { $heroLine2 = 'DESK'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($schoolName) ?> - Premium School Management</title>
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
            font-size: clamp(3rem, 12vw, 11rem);
            line-height: 0.85;
            letter-spacing: -0.05em;
            mix-blend-mode: overlay;
            text-transform: uppercase;
            text-align: center;
        }
    </style>
</head>
<body class="bg-bg text-textMain font-sans antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="absolute top-0 left-0 w-full z-50 px-6 py-6 flex justify-between items-center text-primary">
        <div class="flex items-center gap-2">
            <i data-lucide="graduation-cap" class="w-8 h-8 text-accent"></i>
            <span class="text-2xl font-bold tracking-tight truncate max-w-[200px] sm:max-w-xs"><?= e($schoolName) ?></span>
        </div>
        
        <div class="hidden md:flex gap-8 text-sm font-medium">
            <a href="#" class="hover:text-accent transition">Features</a>
            <a href="#" class="hover:text-accent transition">Solutions</a>
            <a href="#" class="hover:text-accent transition">Pricing</a>
        </div>

        <div class="flex items-center gap-4">
            <a href="/login" class="text-sm font-medium hover:text-accent transition hidden sm:block">Log in</a>
            <a href="/login" class="bg-primary text-white px-5 py-2.5 rounded-full text-sm font-medium hover:bg-blue-900 transition shadow-lg shadow-primary/30 flex items-center gap-2">
                Portal Login <i data-lucide="arrow-right" class="w-4 h-4"></i>
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

        <!-- Massive Overlapping Text (Dynamic) -->
        <div class="absolute z-10 flex flex-col items-center justify-center w-full mt-20 pointer-events-none select-none px-4">
            <h1 class="hero-text font-black text-white drop-shadow-2xl">
                <?= e($heroLine1) ?><br><?= e($heroLine2) ?>
            </h1>
        </div>

        <!-- Foreground Content -->
        <div class="relative z-20 w-full max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-end h-full pb-20 pt-40">
            
            <!-- Left Text -->
            <div class="max-w-md bg-white/80 backdrop-blur-md p-6 rounded-2xl border border-white/50 shadow-xl">
                <div class="flex items-center gap-2 text-xs font-bold text-accent tracking-widest uppercase mb-3">
                    <span class="w-8 h-[2px] bg-accent"></span>
                    Welcome to Excellence
                </div>
                <h2 class="text-4xl font-black text-primary uppercase leading-none mb-4">
                    Manage<br>with ease.
                </h2>
                <p class="text-sm text-muted mb-6 font-medium leading-relaxed italic">
                    "<?= e($schoolMotto) ?>"
                </p>
                <a href="/login" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-blue-900 transition shadow-lg">
                    ACCESS PORTAL <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <!-- Right Floating Images -->
            <div class="hidden lg:flex flex-col gap-4 relative">
                <div class="w-40 h-48 rounded-2xl overflow-hidden shadow-2xl border-2 border-white transform translate-x-4">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <div class="w-40 h-48 rounded-2xl overflow-hidden shadow-2xl border-2 border-white transform -translate-x-4">
                    <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Bar (Overlay) -->
    <div class="relative z-30 max-w-7xl mx-auto -mt-8 px-6">
        <div class="bg-primary text-white rounded-2xl p-4 sm:px-8 flex flex-wrap justify-between items-center shadow-2xl border border-blue-800">
            <div class="flex items-center gap-2 text-sm font-medium py-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-accent"></i> Secure Portal
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
                <i data-lucide="mail" class="w-5 h-5 text-accent"></i> <?= e($schoolEmail) ?>
            </div>
        </div>
    </div>

    <!-- Portals Section -->
    <section class="py-20 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-muted tracking-widest uppercase mb-2">
                    <i data-lucide="layout-grid" class="w-4 h-4 text-primary"></i> Explore
                </div>
                <h2 class="text-3xl font-black text-primary uppercase">Tailored Portals</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Admin Card -->
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

            <!-- Teacher Card -->
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

            <!-- Parent Card -->
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

            <!-- Student Card -->
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

    <!-- Footer -->
    <footer class="bg-primary text-white py-16 px-6 relative overflow-hidden mt-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-accent opacity-10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        
        <div class="max-w-7xl mx-auto relative z-10 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-6">
                    <div class="bg-white p-2 rounded-lg text-primary">
                        <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                    </div>
                    <span class="text-2xl font-bold tracking-tight truncate"><?= e($schoolName) ?></span>
                </div>
                <p class="text-blue-200 text-sm max-w-sm leading-relaxed mb-6 italic">
                    "<?= e($schoolMotto) ?>"
                </p>
                <div class="space-y-2 text-sm text-blue-200">
                    <p class="flex items-center gap-2"><i data-lucide="map-pin" class="w-4 h-4"></i> <?= e($schoolAddress) ?></p>
                    <p class="flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4"></i> <?= e($schoolPhone) ?></p>
                    <p class="flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4"></i> <?= e($schoolEmail) ?></p>
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
            <p>&copy; <?= date('Y') ?> <?= e($schoolName) ?>. All rights reserved.</p>
            <p>Powered by WebVault SchoolDesk.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
