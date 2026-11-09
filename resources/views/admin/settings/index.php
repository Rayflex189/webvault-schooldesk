<?php
// resources/views/admin/settings/index.php
ob_start();
?>

<!-- Flash Messages -->
<?php if(isset($_SESSION['success'])): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between text-sm shadow-sm">
        <div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i><?= e($_SESSION['success']) ?></div>
        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">School Settings</h1>
    <p class="text-sm text-gray-500 mt-1">Configure your school's profile, SMTP email gateway, and academic calendar.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Left Column: School Profile & SMTP -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">School Information</h2>
            <form action="/admin/settings/update-school" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">School Name</label>
                    <input type="text" name="school_name" value="<?= e($settings['school_name']) ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Motto</label>
                    <input type="text" name="motto" value="<?= e($settings['motto']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent"><?= e($settings['address']) ?></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" value="<?= e($settings['phone']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="<?= e($settings['email']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Form Receiving Email</label>
                    <input type="email" name="contact_email" value="<?= e($settings['contact_email'] ?? '') ?>" required placeholder="admin@school.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                </div>

                <!-- SMTP Settings Block -->
                <div class="border-t pt-4 mt-4">
                    <h4 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i data-lucide="server" class="w-4 h-4 text-accent"></i> SMTP Email Gateway
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">SMTP Host</label>
                            <input type="text" name="smtp_host" value="<?= e($settings['smtp_host'] ?? '') ?>" placeholder="smtp.gmail.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">SMTP Port</label>
                            <input type="number" name="smtp_port" value="<?= e($settings['smtp_port'] ?? '587') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">SMTP Username</label>
                            <input type="text" name="smtp_user" value="<?= e($settings['smtp_user'] ?? '') ?>" placeholder="your@email.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">SMTP Password</label>
                            <input type="password" name="smtp_pass" value="<?= e($settings['smtp_pass'] ?? '') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Encryption</label>
                            <select name="smtp_encryption" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white text-sm">
                                <option value="tls" <?= ($settings['smtp_encryption'] ?? '') == 'tls' ? 'selected' : '' ?>>TLS (Port 587)</option>
                                <option value="ssl" <?= ($settings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : '' ?>>SSL (Port 465)</option>
                                <option value="none" <?= ($settings['smtp_encryption'] ?? '') == 'none' ? 'selected' : '' ?>>None</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">From Email</label>
                            <input type="email" name="mail_from_email" value="<?= e($settings['mail_from_email'] ?? '') ?>" placeholder="no-reply@school.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">From Name</label>
                            <input type="text" name="mail_from_name" value="<?= e($settings['mail_from_name'] ?? '') ?>" placeholder="SchoolDesk Admin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors mt-2">
                    Save Settings
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Academic Setup -->
    <div class="space-y-6">
        
        <!-- Active Session -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 border-t-4 border-t-accent">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Current Academic Period</h2>
            <div class="bg-blue-50 p-3 rounded-lg mb-4 text-sm text-blue-800 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4"></i>
                Currently Active: <strong><?= e($settings['current_session']) ?> - <?= e($settings['current_term']) ?></strong>
            </div>

            <form action="/admin/settings/update-session" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Active Session</label>
                    <select name="session" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white">
                        <?php foreach($sessions as $s): ?>
                            <option value="<?= e($s['session_name']) ?>" <?= $s['session_name'] == $settings['current_session'] ? 'selected' : '' ?>>
                                <?= e($s['session_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Active Term</label>
                    <select name="term" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent bg-white">
                        <option value="First Term" <?= $settings['current_term'] == 'First Term' ? 'selected' : '' ?>>First Term</option>
                        <option value="Second Term" <?= $settings['current_term'] == 'Second Term' ? 'selected' : '' ?>>Second Term</option>
                        <option value="Third Term" <?= $settings['current_term'] == 'Third Term' ? 'selected' : '' ?>>Third Term</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-accent hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Set Active Session
                </button>
            </form>
        </div>

        <!-- Manage Sessions -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Manage Sessions</h2>
            
            <div class="flex flex-wrap gap-2 mb-4">
                <?php foreach($sessions as $s): ?>
                    <span class="px-3 py-1 rounded-full text-xs font-medium border <?= $s['is_active'] ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-600 border-gray-200' ?>">
                        <?= e($s['session_name']) ?>
                    </span>
                <?php endforeach; ?>
            </div>

            <form action="/admin/settings/create-session" method="POST" class="flex gap-2">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <input type="text" name="session_name" placeholder="e.g. 2026/2027" required class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent text-sm">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Add
                </button>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
