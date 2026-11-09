<?php ob_start(); ?>

<style>
    /* The 3D Book Effect */
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
    /* The spine of the book */
    .book-spine {
        background: linear-gradient(to right, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0) 8%);
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 20px;
        z-index: 10;
    }
    /* Staggered List Animation */
    .book-item {
        opacity: 0;
        animation: slideUpFade 0.5s ease-out forwards;
    }
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="max-w-4xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-black text-primary uppercase tracking-tight flex items-center justify-center gap-3">
            <i data-lucide="book-open" class="w-8 h-8 text-accent"></i>
            School Booklists
        </h1>
        <p class="text-sm text-gray-500 mt-2">Required textbooks and materials for the current academic session.</p>
    </div>

    <div class="space-y-12">
        <?php foreach($childrenBooks as $index => $data): ?>
            <div class="book-perspective">
                <div class="book-card bg-white rounded-r-2xl rounded-l-md border border-gray-100 relative overflow-hidden" style="animation: slideUpFade 0.8s ease-out forwards; animation-delay: <?= $index * 0.2 ?>s;">
                    
                    <!-- Book Spine Effect -->
                    <div class="book-spine"></div>
                    
                    <!-- Book Cover / Header -->
                    <div class="bg-gradient-to-r from-primary to-blue-900 p-6 sm:p-8 relative overflow-hidden">
                        <!-- Decorative background circle -->
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
                        <!-- Page fold shadow effect -->
                        <div class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-gray-50 to-transparent pointer-events-none"></div>

                        <?php if(empty($data['books'])): ?>
                            <div class="text-center py-10">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="book" class="w-8 h-8 text-gray-300"></i>
                                </div>
                                <h3 class="text-gray-800 font-bold mb-1">No Books Listed Yet</h3>
                                <p class="text-sm text-gray-500">The school administrator has not published a booklist for this class yet.</p>
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php foreach($data['books'] as $bIndex => $b): ?>
                                    <div class="book-item group bg-gray-50 hover:bg-white rounded-xl border border-gray-100 p-4 transition-all duration-300 hover:shadow-md flex items-start gap-4" 
                                         style="animation-delay: <?= ($index * 0.1) + ($bIndex * 0.05) + 0.3 ?>s;">
                                        
                                        <!-- Book Icon -->
                                        <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i data-lucide="book" class="w-5 h-5 <?= $b['is_compulsory'] ? 'text-primary' : 'text-gray-400' ?>"></i>
                                        </div>
                                        
                                        <!-- Book Details -->
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
    </div>
</div>

<script>
    // Initialize Lucide icons for this page
    lucide.createIcons();
</script>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/app.php'; ?>
