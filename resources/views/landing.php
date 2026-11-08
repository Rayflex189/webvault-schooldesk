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
<html lang="en" class="scroll-smooth">
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
        .hero-text {
            font-size: clamp(3rem, 12vw, 11rem);
            line-height: 0.85;
            letter-spacing: -0.05em;
            mix-blend-mode: overlay;
            text-transform: uppercase;
            text-align: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-bg text-textMain font-sans antialiased overflow-x-hidden">

    <!-- Alerts -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="fixed top-4 right-4 z-[100] bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-bounce">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
            <?= e($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 px-6 py-4 bg-white/80 backdrop-blur-md shadow-sm transition-all" id="navbar">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-primary p-2 rounded-lg text-white">
                    <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                </div>
                <span class="text-xl font-bold tracking-tight text-primary truncate max-w-[200px]"><?= e($schoolName) ?></span>
            </div>
            
            <div class="hidden md:flex gap-8 text-sm font-semibold text-gray-600">
                <a href="#portals" class="hover:text-primary transition">Portals</a>
                <a href="#testimonials" class="hover:text-primary transition">Reviews</a>
                <a href="#contact" class="hover:text-primary transition">Contact</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="/login" class="bg-primary text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-blue-900 transition shadow-lg shadow-primary/30 flex items-center gap-2">
                    Portal Login <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-screen min-h-[700px] flex items-center justify-center overflow-hidden pt-20">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop" alt="School" class="w-full h-full object-cover object-center" style="filter: brightness(0.9) grayscale(20%);">
            <div class="absolute inset-0 bg-gradient-to-t from-bg via-transparent to-transparent"></div>
            <div class="absolute inset-0 bg-primary/20"></div>
        </div>

        <div class="absolute z-10 flex flex-col items-center justify-center w-full mt-20 pointer-events-none select-none px-4" data-aos="zoom-in" data-aos-duration="1500">
            <h1 class="hero-text font-black text-white drop-shadow-2xl">
                <?= e($heroLine1) ?><br><?= e($heroLine2) ?>
            </h1>
        </div>

        <div class="relative z-20 w-full max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-end h-full pb-20 pt-40">
            <div class="max-w-md glass-card p-8 rounded-3xl shadow-2xl" data-aos="fade-right" data-aos-delay="300">
                <div class="flex items-center gap-2 text-xs font-bold text-accent tracking-widest uppercase mb-3">
                    <span class="w-8 h-[2px] bg-accent"></span>
                    Welcome to Excellence
                </div>
                <h2 class="text-4xl font-black text-primary uppercase leading-none mb-4">
                    Manage<br>with ease.
                </h2>
                <p class="text-sm text-gray-600 mb-6 font-medium leading-relaxed italic border-l-4 border-accent pl-3">
                    "<?= e($schoolMotto) ?>"
                </p>
                <a href="/login" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-blue-900 transition shadow-lg">
                    ACCESS PORTAL <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            
            <div class="hidden lg:flex flex-col gap-4 relative" data-aos="fade-left" data-aos-delay="500">
                <div class="w-40 h-48 rounded-2xl overflow-hidden shadow-2xl border-4 border-white transform translate-x-4">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Live Stats Bar (Overlapping) -->
    <div class="relative z-30 max-w-5xl mx-auto -mt-16 px-6" data-aos="fade-up">
        <div class="bg-primary text-white rounded-3xl p-8 sm:p-10 flex flex-col sm:flex-row justify-between items-center shadow-2xl border border-blue-800 gap-8">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <i data-lucide="users" class="w-8 h-8 text-accent"></i>
                    <h3 class="text-4xl font-black"><?= number_format($stats['students']) ?>+</h3>
                </div>
                <p class="text-blue-200 text-sm font-medium uppercase tracking-widest">Active Students</p>
            </div>
            
            <div class="hidden sm:block w-px h-16 bg-blue-800"></div>
            
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <i data-lucide="user-check" class="w-8 h-8 text-accent"></i>
                    <h3 class="text-4xl font-black"><?= number_format($stats['teachers']) ?>+</h3>
                </div>
                <p class="text-blue-200 text-sm font-medium uppercase tracking-widest">Expert Teachers</p>
            </div>

            <div class="hidden sm:block w-px h-16 bg-blue-800"></div>

            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <i data-lucide="shield-check" class="w-8 h-8 text-accent"></i>
                    <h3 class="text-4xl font-black">100%</h3>
                </div>
                <p class="text-blue-200 text-sm font-medium uppercase tracking-widest">Secure Data</p>
            </div>
        </div>
    </div>

    <!-- Portals Grid -->
    <section id="portals" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="flex items-center justify-center gap-2 text-xs font-bold text-muted tracking-widest uppercase mb-2">
                <i data-lucide="layout-grid" class="w-4 h-4 text-primary"></i> Explore
            </div>
            <h2 class="text-4xl font-black text-primary uppercase">Tailored Portals</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Cards (Same as before, but adding data-aos delay classes) -->
            <div class="group relative h-80 rounded-3xl overflow-hidden cursor-pointer shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div class="text-white">
                        <h3 class="text-2xl font-black uppercase mb-1">Admin</h3>
                        <p class="text-xs text-blue-100 font-medium">Total Control</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-accent transition">
                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>

            <div class="group relative h-80 rounded-3xl overflow-hidden cursor-pointer shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div class="text-white">
                        <h3 class="text-2xl font-black uppercase mb-1">Teachers</h3>
                        <p class="text-xs text-blue-100 font-medium">Grade & Teach</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-accent transition">
                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>

            <div class="group relative h-80 rounded-3xl overflow-hidden cursor-pointer shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div class="text-white">
                        <h3 class="text-2xl font-black uppercase mb-1">Parents</h3>
                        <p class="text-xs text-blue-100 font-medium">Stay Informed</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-accent transition">
                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>

            <div class="group relative h-80 rounded-3xl overflow-hidden cursor-pointer shadow-lg" data-aos="fade-up" data-aos-delay="400">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 flex justify-between items-end">
                    <div class="text-white">
                        <h3 class="text-2xl font-black uppercase mb-1">Students</h3>
                        <p class="text-xs text-blue-100 font-medium">Track Progress</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-accent transition">
                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-black text-primary uppercase">What People Say</h2>
                <p class="text-muted mt-2">Hear from our community of educators and parents.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <?php foreach($testimonials as $t): ?>
                    <div class="bg-bg p-8 rounded-3xl border border-gray-100 shadow-sm relative" data-aos="zoom-in-up">
                        <div class="flex text-yellow-400 mb-4">
                            <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                            <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                            <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                            <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                            <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        </div>
                        <p class="text-gray-600 italic mb-6 leading-relaxed">"<?= e($t['content']) ?>"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-accent text-white flex items-center justify-center font-bold">
                                <?= substr($t['name'], 0, 1) ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-primary"><?= e($t['name']) ?></h4>
                                <p class="text-xs text-muted"><?= e($t['role']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Submit a Review Form -->
            <div class="max-w-2xl mx-auto bg-primary rounded-3xl p-8 shadow-2xl" data-aos="fade-up">
                <h3 class="text-2xl font-bold text-white mb-6 text-center">Leave a Review</h3>
                <form action="/submit-testimonial" method="POST" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" required placeholder="Your Name" class="w-full px-4 py-3 rounded-xl bg-blue-900/50 border border-blue-700 text-white placeholder-blue-300 focus:outline-none focus:border-accent">
                        <select name="role" required class="w-full px-4 py-3 rounded-xl bg-blue-900/50 border border-blue-700 text-white focus:outline-none focus:border-accent">
                            <option value="Parent">Parent</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Student">Student</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                    <textarea name="content" rows="3" required placeholder="Share your experience..." class="w-full px-4 py-3 rounded-xl bg-blue-900/50 border border-blue-700 text-white placeholder-blue-300 focus:outline-none focus:border-accent"></textarea>
                    <button type="submit" class="w-full bg-accent hover:bg-sky-600 text-white font-bold py-3 rounded-xl transition shadow-lg">Publish Review</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contact" class="py-24 px-6 bg-bg">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-16">
            
            <div class="lg:w-1/2" data-aos="fade-right">
                <h2 class="text-4xl font-black text-primary uppercase mb-6">Get in Touch</h2>
                <p class="text-muted mb-8 leading-relaxed">Have questions about our platform? Need a custom feature for your school? Send us a message and our team will get back to you.</p>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary shrink-0"><i data-lucide="map-pin" class="w-6 h-6"></i></div>
                        <div>
                            <h4 class="font-bold text-gray-900">Address</h4>
                            <p class="text-sm text-muted mt-1"><?= e($schoolAddress) ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary shrink-0"><i data-lucide="phone" class="w-6 h-6"></i></div>
                        <div>
                            <h4 class="font-bold text-gray-900">Phone</h4>
                            <p class="text-sm text-muted mt-1"><?= e($schoolPhone) ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary shrink-0"><i data-lucide="mail" class="w-6 h-6"></i></div>
                        <div>
                            <h4 class="font-bold text-gray-900">Email</h4>
                            <p class="text-sm text-muted mt-1"><?= e($schoolEmail) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2" data-aos="fade-left">
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <form action="/submit-contact" method="POST" class="space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Your Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                            <textarea name="message" rows="4" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent focus:outline-none"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white font-bold py-4 rounded-xl transition shadow-lg">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <i data-lucide="graduation-cap" class="w-8 h-8 text-accent"></i>
                <span class="text-xl font-bold tracking-tight"><?= e($schoolName) ?></span>
            </div>
            <p class="text-sm text-blue-200"><?= e($schoolMotto) ?></p>
            <p class="text-xs text-blue-300">&copy; <?= date('Y') ?> All rights reserved. Powered by WebVault SchoolDesk.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init Animations
        AOS.init({ once: true, offset: 50 });
        lucide.createIcons();
    </script>
</body>
</html>
