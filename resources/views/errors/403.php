<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Unauthorized Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A',
                        accent: '#0EA5E9',
                        bg: '#F8FAFC',
                    }
                }
            }
        }
    </script>
    <style>
        /* 3D Book Container */
        .book-container {
            perspective: 2000px;
            width: 180px;
            height: 240px;
            position: relative;
            margin: 0 auto 40px auto;
        }

        .book {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
        }

        /* Left Static Page */
        .book-left {
            position: absolute;
            width: 50%;
            height: 100%;
            background: #F8FAFC;
            left: 0;
            border-radius: 8px 0 0 8px;
            box-shadow: inset 5px 0 15px rgba(0,0,0,0.05), -5px 5px 15px rgba(0,0,0,0.1);
            border: 1px solid #E2E8F0;
            border-right: none;
            background-image: repeating-linear-gradient(0deg, transparent, transparent 24px, #cbd5e1 25px);
            background-position: 0 20px;
            z-index: 2;
        }

        /* Right Flipping Page */
        .book-right-page {
            position: absolute;
            width: 50%;
            height: 100%;
            background: #F8FAFC;
            right: 0;
            border-radius: 0 8px 8px 0;
            border: 1px solid #E2E8F0;
            border-left: none;
            background-image: repeating-linear-gradient(0deg, transparent, transparent 24px, #cbd5e1 25px);
            background-position: 0 20px;
            transform-origin: left center;
            animation: flipPage 2s ease-in-out forwards;
            z-index: 3;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.1);
        }

        /* Front Cover */
        .book-cover {
            position: absolute;
            width: 52%;
            height: calc(100% + 4px);
            top: -2px;
            background: #1E3A8A;
            right: 0;
            border-radius: 0 8px 8px 0;
            transform-origin: left center;
            animation: flipCover 2s ease-in-out forwards;
            z-index: 4;
            box-shadow: 2px 5px 20px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #1E3A8A;
        }
        
        /* Decorative cover emblem */
        .book-cover::after {
            content: '!';
            font-size: 3rem;
            font-weight: 900;
            color: rgba(255,255,255,0.1);
        }

        /* Animations */
        @keyframes flipCover {
            0% { transform: rotateY(0deg); }
            30% { transform: rotateY(-180deg); }
            100% { transform: rotateY(-180deg); }
        }

        @keyframes flipPage {
            0%, 20% { transform: rotateY(0deg); }
            60%, 100% { transform: rotateY(-180deg); }
        }

        /* Text Fade-in */
        .fade-in-text {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            animation-delay: 1.5s; /* Waits for the book to open */
        }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-bg min-h-screen flex items-center justify-center p-6 font-sans antialiased overflow-hidden relative">

    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-primary opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-accent opacity-5 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center max-w-lg w-full">
        
        <!-- 3D Book Animation -->
        <div class="book-container">
            <div class="book">
                <div class="book-left"></div>
                <div class="book-right-page"></div>
                <div class="book-cover"></div>
            </div>
        </div>

        <!-- Error Message -->
        <div class="fade-in-text bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-gray-100">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            
            <h1 class="text-4xl font-black text-gray-900 mb-2 tracking-tight">403</h1>
            <h2 class="text-xl font-bold text-primary mb-4">Unauthorized Access</h2>
            
            <p class="text-sm text-gray-500 leading-relaxed mb-8">
                The book is closed on this page. You do not have the necessary permissions to view this area of the portal. Please return to your designated dashboard.
            </p>

            <!-- Dynamic Back Button -->
            <?php
            // Determine where to send them back based on their role
            $redirectUrl = '/login';
            if (isset($_SESSION['role_id'])) {
                if ($_SESSION['role_id'] == 1) $redirectUrl = '/admin/dashboard';
                elseif ($_SESSION['role_id'] == 2) $redirectUrl = '/teacher/dashboard';
                elseif ($_SESSION['role_id'] == 3) $redirectUrl = '/parent/dashboard';
                elseif ($_SESSION['role_id'] == 4) $redirectUrl = '/student/dashboard';
            }
            ?>
            <a href="<?= $redirectUrl ?>" class="inline-flex items-center gap-2 bg-primary hover:bg-blue-900 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-primary/30 transition-all hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Return to My Portal
            </a>
        </div>
    </div>

</body>
</html>
