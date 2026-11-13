<?php
$settings = get_settings();
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env('APP_NAME') ?> - <?= htmlspecialchars($settings['school_name'] ?? '') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#1E3A8A', accent: '#0EA5E9', bg: '#F8FAFC', textMain: '#0F172A' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Tailwind Typography Plugin for beautiful text formatting -->
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
</head>
<body class="bg-bg text-textMain font-sans antialiased flex flex-col min-h-screen">

    <!-- Simple Navbar -->
    <nav class="bg-white shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2 text-primary hover:text-accent transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                <span class="font-bold">Back to Home</span>
            </a>
            <div class="flex items-center gap-2 text-primary">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                <span class="font-bold tracking-tight"><?= htmlspecialchars($settings['school_name'] ?? 'SchoolDesk') ?></span>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-1">
        <?= $content ?? '' ?>
    </main>

    <!-- Simple Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-sm text-gray-500">
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['school_name'] ?? 'WebVault') ?>. All rights reserved.</p>
        <p class="mt-1">Powered by WebVault SchoolDesk.</p>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html>
