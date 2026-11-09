<?php ob_start(); ?>

<!-- Flash Messages -->
<?php if(isset($_SESSION['success'])): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between text-sm shadow-sm">
        <div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i><?= e($_SESSION['success']) ?></div>
        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between text-sm shadow-sm">
        <div class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-4 h-4"></i><?= e($_SESSION['error']) ?></div>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Email Communication</h1>
    <p class="text-sm text-gray-500 mt-1">Send bulk emails to parents and staff via SMTP.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Composer Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
            <i data-lucide="mail" class="w-5 h-5 text-accent"></i> Compose Email
        </h2>
        
        <form action="/admin/communication/send" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Send To</label>
                <select name="audience" id="audience" onchange="toggleClassSelect()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white">
                    <option value="all_parents">All Parents</option>
                    <option value="class_parents">Parents of a Specific Class</option>
                    <option value="all_teachers">All Teachers</option>
                </select>
            </div>

            <div id="class-selector" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Class</label>
                <select name="class_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white">
                    <?php foreach($classes as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <input type="text" name="subject" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent" placeholder="e.g. Resumption Date Notice">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message Body</label>
                <textarea name="message" required rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent resize-none" placeholder="Type your email message here..."></textarea>
                <p class="text-xs text-gray-500 mt-1">Use <code class="bg-gray-100 px-1 rounded text-primary font-bold">{name}</code> to insert the parent's name.</p>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-4 py-3 rounded-lg font-bold shadow-sm transition-colors flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-5 h-5"></i> Send Bulk Email
            </button>
        </form>
    </div>

    <!-- Recent Logs -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Recent Outbox</h2>
            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded font-bold">Last 10</span>
        </div>
        <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
            <?php if(empty($logs)): ?>
                <div class="p-6 text-center text-gray-500 text-sm">No emails sent yet.</div>
            <?php else: ?>
                <?php foreach($logs as $log): ?>
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-sm font-bold text-gray-800 flex items-center gap-1">
                                <i data-lucide="mail" class="w-3 h-3 text-gray-400"></i>
                                <?= e($log['recipient_email']) ?>
                            </span>
                            <span class="text-[10px] text-gray-400"><?= date('M j, g:i A', strtotime($log['created_at'])) ?></span>
                        </div>
                        <p class="text-xs text-gray-600 line-clamp-2"><strong>Subject:</strong> <?= e($log['message']) ?></p>
                        <div class="mt-2">
                            <?php if($log['status'] === 'sent'): ?>
                                <span class="inline-flex items-center gap-1 bg-green-50 text-green-600 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Sent
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Failed
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function toggleClassSelect() {
        const audience = document.getElementById('audience').value;
        const classSelector = document.getElementById('class-selector');
        if (audience === 'class_parents') {
            classSelector.classList.remove('hidden');
        } else {
            classSelector.classList.add('hidden');
        }
    }
</script>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../../layouts/app.php'; ?>
