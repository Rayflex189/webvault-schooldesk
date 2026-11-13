<?php
// Variables are passed from LandingController
$schoolName = $settings['school_name'] ?? 'WebVault SchoolDesk';
$schoolMotto = $settings['motto'] ?? 'Knowledge is Power';
$schoolEmail = $settings['email'] ?? 'info@school.com';
$schoolPhone = $settings['phone'] ?? '+234 800 000 0000';
$schoolAddress = $settings['address'] ?? '123 Education Way, Lagos, Nigeria';

$nameParts = explode(' ', $schoolName);
$heroLine1 = $nameParts[0] ?? 'SCHOOL';
$heroLine2 = implode(' ', array_slice($nameParts, 1));
if (empty($heroLine2)) { $heroLine2 = 'DESK'; }
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($schoolName) ?> - Premium School Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- AOS for Scroll Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A', accent: '#0EA5E9', bg: '#F8FAFC', textMain: '#0F172A', muted: '#64748B'
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Fix mobile overflow by hiding horizontal scroll */
        body { overflow-x: hidden; width: 100%; position: relative; }
        
        .hero-text {
            font-size: clamp(3rem, 15vw, 12rem);
            line-height: 0.85;
            letter-spacing: -0.05em;
            mix-blend-mode: overlay;
            text-transform: uppercase;
            text-align: center;
            width: 100%;
            word-wrap: break-word;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-bg text-textMain font-sans antialiased w-full">

    <!-- Flash Messages -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="fixed top-4 right-4 z-[100] bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-bounce">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
            <?= e($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 px-4 sm:px-6 py-4 bg-white/90 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-primary p-2 rounded-lg text-white">
                    <i data-lucide="graduation-cap" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
                <!-- Truncate long school names on mobile -->
                <span class="text-lg sm:text-xl font-bold tracking-tight text-primary truncate max-w-[150px] sm:max-w-xs">
                    <?= e($schoolName) ?>
                </span>
            </div>
            
            <div class="hidden md:flex gap-8 text-sm font-semibold text-gray-600">
                <a href="#about" class="hover:text-primary transition">About</a>
                <a href="#gallery" class="hover:text-primary transition">Campus</a>
                <a href="#portals" class="hover:text-primary transition">Portals</a>
                <a href="#contact" class="hover:text-primary transition">Contact</a>
            </div>

            <div class="flex items-center gap-2 sm:gap-4">
                <a href="/login" class="bg-primary text-white px-4 py-2 sm:px-6 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold hover:bg-blue-900 transition shadow-lg shadow-primary/30 flex items-center gap-2">
                    Portal Login <i data-lucide="arrow-right" class="w-4 h-4 hidden sm:block"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-[100dvh] min-h-[600px] flex items-center justify-center overflow-hidden pt-20 w-full">
        <div class="absolute inset-0 z-0 w-full h-full">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop" alt="School" class="w-full h-full object-cover object-center" style="filter: brightness(0.8) grayscale(20%);">
            <div class="absolute inset-0 bg-gradient-to-t from-bg via-transparent to-transparent"></div>
            <div class="absolute inset-0 bg-primary/20"></div>
        </div>

        <!-- Massive Overlapping Text (Fixed width issues) -->
        <div class="absolute z-10 flex flex-col items-center justify-center w-full px-2 mt-10 pointer-events-none select-none" data-aos="zoom-in" data-aos-duration="1500">
            <h1 class="hero-text font-black text-white drop-shadow-2xl w-full">
                <?= e($heroLine1) ?><br><?= e($heroLine2) ?>
            </h1>
        </div>

        <div class="relative z-20 w-full max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row justify-between items-center md:items-end h-full pb-20 pt-40">
            
            <!-- Glass Card (Centered on mobile, Left on desktop) -->
            <div class="glass-card p-6 sm:p-8 rounded-3xl shadow-2xl w-full max-w-md mx-auto md:mx-0" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center gap-2 text-xs font-bold text-accent tracking-widest uppercase mb-3">
                    <span class="w-8 h-[2px] bg-accent"></span>
                    Welcome to Excellence
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-primary uppercase leading-none mb-4">
                    Manage<br>with ease.
                </h2>
                <p class="text-sm text-gray-600 mb-6 font-medium leading-relaxed italic border-l-4 border-accent pl-3">
                    "<?= e($schoolMotto) ?>"
                </p>
                <a href="/login" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-blue-900 transition shadow-lg w-full justify-center sm:w-auto">
                    ACCESS PORTAL <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            
            <!-- Floating images for desktop only -->
            <div class="hidden lg:flex flex-col gap-4 relative" data-aos="fade-left" data-aos-delay="500">
                <div class="w-40 h-48 rounded-2xl overflow-hidden shadow-2xl border-4 border-white transform translate-x-4">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Live Stats Bar -->
    <div class="relative z-30 max-w-5xl mx-auto -mt-10 sm:-mt-16 px-4 sm:px-6 w-full" data-aos="fade-up">
        <div class="bg-primary text-white rounded-3xl p-6 sm:p-10 flex flex-col sm:flex-row justify-between items-center shadow-2xl border border-blue-800 gap-6 sm:gap-8">
            <div class="text-center w-full">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <i data-lucide="users" class="w-6 h-6 sm:w-8 sm:h-8 text-accent"></i>
                    <h3 class="text-3xl sm:text-4xl font-black"><?= number_format($stats['students']) ?>+</h3>
                </div>
                <p class="text-blue-200 text-xs sm:text-sm font-medium uppercase tracking-widest">Active Students</p>
            </div>
            
            <div class="hidden sm:block w-px h-16 bg-blue-800"></div>
            
            <div class="text-center w-full">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <i data-lucide="user-check" class="w-6 h-6 sm:w-8 sm:h-8 text-accent"></i>
                    <h3 class="text-3xl sm:text-4xl font-black"><?= number_format($stats['teachers']) ?>+</h3>
                </div>
                <p class="text-blue-200 text-xs sm:text-sm font-medium uppercase tracking-widest">Expert Teachers</p>
            </div>

            <div class="hidden sm:block w-px h-16 bg-blue-800"></div>

            <div class="text-center w-full">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <i data-lucide="shield-check" class="w-6 h-6 sm:w-8 sm:h-8 text-accent"></i>
                    <h3 class="text-3xl sm:text-4xl font-black">100%</h3>
                </div>
                <p class="text-blue-200 text-xs sm:text-sm font-medium uppercase tracking-widest">Secure Data</p>
            </div>
        </div>
    </div>

    <!-- NEW SECTION: About the App (Extensive) -->
    <section id="about" class="py-20 sm:py-24 px-4 sm:px-6 max-w-7xl mx-auto">
        <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-black text-primary uppercase">Why Choose <?= e($heroLine1) ?>?</h2>
            <p class="text-muted mt-2 max-w-2xl mx-auto text-sm sm:text-base">We combine academic excellence with a world-class digital infrastructure to ensure your child thrives.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop" class="w-full h-48 object-cover" alt="Smart Classrooms">
                <div class="p-6">
                    <div class="w-10 h-10 bg-blue-50 text-primary rounded-lg flex items-center justify-center mb-4"><i data-lucide="monitor"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Smart Classrooms</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Our facilities are equipped with modern teaching aids, ensuring students engage with interactive learning materials.</p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop" class="w-full h-48 object-cover" alt="Expert Teachers">
                <div class="p-6">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center mb-4"><i data-lucide="award"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Expert Educators</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Our teachers are highly qualified, dedicated, and passionate about bringing out the best in every student.</p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100" data-aos="fade-up" data-aos-delay="300">
                <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=600&auto=format&fit=crop" class="w-full h-48 object-cover" alt="Digital Portal">
                <div class="p-6">
                    <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mb-4"><i data-lucide="smartphone"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Seamless Parent Portal</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Track your child's academic progress, pay fees securely online, and view daily behavior reports with ease.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW SECTION: Campus Gallery -->
    <section id="gallery" class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row justify-between items-end mb-8 sm:mb-12" data-aos="fade-up">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-black text-primary uppercase">Life on Campus</h2>
                    <p class="text-muted mt-2">A glimpse into our vibrant school community.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4" data-aos="fade-up" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=400&auto=format&fit=crop" class="w-full h-48 sm:h-64 object-cover rounded-2xl shadow-sm hover:scale-105 transition duration-300" alt="Library">
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=400&auto=format&fit=crop" class="w-full h-48 sm:h-64 object-cover rounded-2xl shadow-sm hover:scale-105 transition duration-300" alt="Science Lab">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=400&auto=format&fit=crop" class="w-full h-48 sm:h-64 object-cover rounded-2xl shadow-sm hover:scale-105 transition duration-300" alt="Sports">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=400&auto=format&fit=crop" class="w-full h-48 sm:h-64 object-cover rounded-2xl shadow-sm hover:scale-105 transition duration-300" alt="Graduation">
            </div>
        </div>
    </section>

    <!-- Portals Grid (Existing) -->
    <section id="portals" class="py-20 sm:py-24 px-4 sm:px-6 max-w-7xl mx-auto">
        <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-black text-primary uppercase">Tailored Portals</h2>
            <p class="text-muted mt-2">One unified system for everyone in the school ecosystem.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Cards (Condensed for space) -->
            <div class="group relative h-64 sm:h-80 rounded-3xl overflow-hidden cursor-pointer shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-start sm:items-end">
                    <div class="text-white mb-2 sm:mb-0">
                        <h3 class="text-lg sm:text-2xl font-black uppercase mb-1">Admin</h3>
                        <p class="text-xs text-blue-100 font-medium">Total Control</p>
                    </div>
                </div>
            </div>

            <div class="group relative h-64 sm:h-80 rounded-3xl overflow-hidden cursor-pointer shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-start sm:items-end">
                    <div class="text-white mb-2 sm:mb-0">
                        <h3 class="text-lg sm:text-2xl font-black uppercase mb-1">Teachers</h3>
                        <p class="text-xs text-blue-100 font-medium">Grade & Teach</p>
                    </div>
                </div>
            </div>

            <div class="group relative h-64 sm:h-80 rounded-3xl overflow-hidden cursor-pointer shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-start sm:items-end">
                    <div class="text-white mb-2 sm:mb-0">
                        <h3 class="text-lg sm:text-2xl font-black uppercase mb-1">Parents</h3>
                        <p class="text-xs text-blue-100 font-medium">Stay Informed</p>
                    </div>
                </div>
            </div>

            <div class="group relative h-64 sm:h-80 rounded-3xl overflow-hidden cursor-pointer shadow-lg" data-aos="fade-up" data-aos-delay="400">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-start sm:items-end">
                    <div class="text-white mb-2 sm:mb-0">
                        <h3 class="text-lg sm:text-2xl font-black uppercase mb-1">Students</h3>
                        <p class="text-xs text-blue-100 font-medium">Track Progress</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-12 sm:py-16 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4 sm:mb-6">
                    <div class="bg-white p-2 rounded-lg text-primary">
                        <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xl sm:text-2xl font-bold tracking-tight truncate"><?= e($schoolName) ?></span>
                </div>
                <p class="text-blue-200 text-sm max-w-sm leading-relaxed mb-6 italic">
                    "<?= e($schoolMotto) ?>"
                </p>
                <div class="space-y-2 text-sm text-blue-200">
                    <p class="flex items-center gap-2"><i data-lucide="map-pin" class="w-4 h-4 shrink-0"></i> <?= e($schoolAddress) ?></p>
                    <p class="flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4 shrink-0"></i> <?= e($schoolPhone) ?></p>
                    <p class="flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4 shrink-0"></i> <?= e($schoolEmail) ?></p>
                </div>
            </div>

            <div>
                <h4 class="font-bold mb-4 uppercase tracking-wider text-sm text-white">Quick Links</h4>
                <ul class="space-y-3 text-sm text-blue-200">
                    <li><a href="#about" class="hover:text-white transition">About Us</a></li>
                    <li><a href="#gallery" class="hover:text-white transition">Campus Life</a></li>
                    <li><a href="/login" class="hover:text-white transition">Portal Login</a></li>
                    <li><a href="#contact" class="hover:text-white transition">Contact Support</a></li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-blue-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-blue-300">
            <p>&copy; <?= date('Y') ?> <?= e($schoolName) ?>. All rights reserved.</p>
            <p>Powered by WebVault SchoolDesk.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50 });
        lucide.createIcons();
    </script>
</body>
</html>
