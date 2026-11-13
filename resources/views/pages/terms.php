<?php ob_start(); ?>
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-primary uppercase mb-2">Terms of Service</h1>
        <p class="text-gray-500">Last Updated: <?= date('F j, Y') ?></p>
    </div>

    <div class="prose prose-lg prose-blue max-w-none text-gray-700">
        <h2>1. Agreement to Terms</h2>
        <p>By purchasing, installing, or using WebVault SchoolDesk ("the Software"), you agree to be bound by these Terms of Service. If you do not agree to these terms, you must not use the Software.</p>

        <h2>2. License Grant & Restrictions</h2>
        <p>WebVault SchoolDesk is <strong>licensed, not sold</strong>. Upon purchasing a license, you are granted a non-exclusive, non-transferable right to install and use the Software for <strong>one (1) single educational institution</strong>.</p>
        <p>You are <strong>strictly prohibited</strong> from:</p>
        <ul>
            <li>Reselling, redistributing, sublicensing, or leasing the Software to any other school or third party.</li>
            <li>Using a single installation to host multiple separate schools (multi-tenancy).</li>
            <li>Modifying or removing the proprietary notices or copyrights within the source code.</li>
        </ul>

        <h2>3. Exclusive Distribution Rights</h2>
        <p>The exclusive right to distribute, modify, and resell this Software to other institutions remains <strong>solely with WebVault (Rayflex189)</strong>. The purchaser does not acquire the right to act as a reseller or distributor of the Software.</p>

        <h2>4. Limitation of Liability</h2>
        <p>In no event shall WebVault be liable for any direct, indirect, incidental, or consequential damages (including, without limitation, loss of data or profit) arising out of the use or inability to use the Software, even if advised of the possibility of such damages.</p>
    </div>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/legal_layout.php'; ?>
