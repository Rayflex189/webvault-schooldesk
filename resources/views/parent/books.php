<?php ob_start(); ?>

<style>
    /* =========================================
       LOADING SCREEN ANIMATION (The Book Opening)
       ========================================= */
    #page-loader {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: #F8FAFC;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: opacity 0.6s ease, visibility 0.6s;
    }
    #page-loader.hidden-loader {
        opacity: 0;
        visibility: hidden;
    }
    
    /* The 3D Book Setup */
    .loader-book {
        width: 80px;
        height: 110px;
        position: relative;
        perspective: 1000px;
        margin-bottom: 24px;
    }
    
    /* The Left Side (Static Base) */
    .loader-book-base {
        position: absolute;
        top: 0;
        left: 0;
        width: 50%;
        height: 100%;
        background: #1E3A8A;
        border-radius: 4px 0 0 4px;
        box-shadow: -5px 5px 15px rgba(0,0,0,0.1);
    }

    /* The Flipping Pages */
    .loader-page {
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-left: none;
        border-radius: 0 4px 4px 0;
        transform-origin: left center;
        animation: flipPage 2s infinite ease-in-out;
        box-shadow: inset 3px 0 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    /* Fake text lines on the pages */
    .loader-page::before {
        content: '';
        position: absolute;
        top: 15%;
        left: 15%;
        right: 15%;
        bottom: 15%;
        background: repeating-linear-gradient(
            transparent,
            transparent 6px,
            #cbd5e1 6px,
            #cbd5e1 8px
        );
        opacity: 0.4;
    }
    
    .loader-page:nth-child(2) { animation-delay: 0.0s; }
    .loader-page:nth-child(3) { animation-delay: 0.3s; }
    .loader-page:nth-child(4) { animation-delay: 0.6s; }

    /* The Front Cover (Opens first) */
    .loader-cover {
        position: absolute;
        top: -2px;
        right: 0;
        width: 52%;
        height: calc(100% + 4px);
        background: #1E3A8A;
        border-radius: 0 4px 4px 0;
        transform-origin: left center;
        animation: flipCover 2s infinite ease-in-out;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 5px 0 15px rgba(0,0,0,0.2);
    }
    .loader-cover::after {
        content: '';
        width: 70%;
        height: 80%;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 4px;
    }

    /* Animation Keyframes */
    @keyframes flipCover {
        0% { transform: rotateY(0deg); }
        50% { transform: rotateY(-180deg); }
        100% { transform: rotateY(-180deg); }
    }
    @keyframes flipPage {
        0%, 20% { transform: rotateY(0deg); }
        60%, 100% { transform: rotateY(-180deg); }
    }


    /* =========================================
       MAIN PAGE 3D BOOK EFFECT
       ========================================= */
    .book-perspective {
        perspective: 2000px;
    }
    .book-card {
        transform-origin: left center;
        transform: rotateY(-15deg);
        transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.8s ease;
        box-shadow: 20px 20px 40px -10px rgba(0,0,0,0.15);
    }
    .book-card:hover {
        transform: rotateY(0deg);
        box-shadow: 0px 20px 40px -5px rgba(0,0,0,0.1);
    }
    .book-spine {
        background: linear-gradient(to right, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0) 8%);
        position: absolute;
        left: 0; top: 0; bottom: 0; width: 20px; z-index: 10;
    }
    .book-item {
        opacity: 0;
        animation: slideUpFade 0.5s ease-out forwards;
    }
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- THE LOADING SCREEN -->
<div id="page-loader">
    <div class="loader-book">
        <div class="loader-book-base"></div>
        <div class="loader-page"></div>
        <div class="loader-page"></div>
        <div class="loader-page"></div>
        <div class="loader-cover"></div>
    </div>
    <h2 class="text-xl font-bold text-primary animate-pulse tracking-wide uppercase">Opening Booklists...</h2>
</div>

<!-- MAIN CONTENT (Starts hidden, then fades in) -->
<div id="main-content" class="max-w-4xl mx-auto opacity-0 transition-opacity duration-700">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-black text-primary uppercase tracking-tight flex items-center justify-center gap-3">
            <i data-lucide="book-open" class="w-8 h-8 text-accent"></i>
            School Booklists
        </h1>
        <p class="text-sm text-gray-500 mt-2">Required textbooks and materials for your children's classes.</p>
    </div>

    <div class="space-y-12">
        <?php if(empty($childrenBooks)): ?>
            <div class="bg-white p-10 rounded-xl border border-gray-200 text-center text-gray-500">
                <p>No children linked to this account yet.</p>
            </div>
        <?php else: ?>
            <?php foreach($childrenBooks as $index => $data): ?>
                <div class="book-perspective">
                    <!-- Staggered animation based on child index -->
                    <div class="book-card bg-white rounded-r-2xl rounded-l-md border border-gray-100 relative overflow-hidden" 
                         style="animation: slideUpFade 0.8s ease-out forwards; animation-delay: <?= $index * 0.2 ?>s;">
                        
                        <div class="book-spine"></div>
                        
                        <!-- Book Cover / Header -->
                        <div class="bg-gradient-to-r from-primary to-blue-900 p-6 sm:p-8 relative overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white opacity-5 rounded-full blur-2xl"></div>
                            
                            <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <div class="flex items-center gap-2 text-blue-200 text-xs font-bold tracking-widest uppercase mb-2">
                                        <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                                        Official Booklist
                                    </div>
                                    <h2 class="text-2xl sm:text-3xl font-bold text-white mb-1"><?= e($data['child_name']) ?></h2>
                                    <span class="inline-block bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium border border-white/10">
                                        <?= e($data['class_name']) ?>
                                    </span>
                                </div>
                                
                                <div class="text-right hidden sm:block">
                                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20">
                                        <i data-lucide="library" class="w-8 h-8 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book Content / Inner Pages -->
                        <div class="p-6 sm:p-8 relative">
                            <div class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-gray-50 to-transparent pointer-events-none"></div>

                            <?php if(empty($data['books'])): ?>
                                <div class="text-center py-10">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i data-lucide="book" class="w-8 h-8 text-gray-300"></i>
                                    </div>
                                    <h3 class="text-gray-800 font-bold mb-1">No Books Listed Yet</h3>
                                    <p class="text-sm text-gray-500">The school has not published a booklist for this class yet.</p>
                                </div>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php foreach($data['books'] as $bIndex => $b): ?>
                                        <div class="book-item group bg-gray-50 hover:bg-white rounded-xl border border-gray-100 p-4 transition-all duration-300 hover:shadow-md flex items-start gap-4" 
                                             style="animation-delay: <?= ($index * 0.1) + ($bIndex * 0.05) + 0.3 ?>s;">
                                            
                                            <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                                <i data-lucide="book" class="w-5 h-5 <?= $b['is_compulsory'] ? 'text-primary' : 'text-gray-400' ?>"></i>
                                            </div>
                                            
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-bold text-gray-900 text-sm truncate"><?= e($b['title']) ?></h3>
                                                <p class="text-xs text-gray-500 mt-0.5 truncate">By <?= e($b['author']) ?></p>
                                                
                                                <div class="mt-2">
                                                    <?php if($b['is_compulsory']): ?>
                                                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border border-red-100">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Compulsory
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border border-gray-200">
                                                            Optional
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // The Loading Simulation Logic
    document.addEventListener("DOMContentLoaded", () => {
        const loader = document.getElementById('page-loader');
        const mainContent = document.getElementById('main-content');

        // Wait 2.5 seconds to simulate opening the book
        setTimeout(() => {
            // Hide loader
            loader.classList.add('hidden-loader');
            
            // Show main content
            mainContent.classList.remove('opacity-0');
            mainContent.classList.add('opacity-100');
            
            // Optional: Remove loader from DOM completely after transition
            setTimeout(() => { loader.remove(); }, 600);
        }, 2500); 
    });
</script>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/app.php'; ?>
