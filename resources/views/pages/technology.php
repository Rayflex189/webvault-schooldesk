<?php ob_start(); ?>
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-primary uppercase mb-2">Our Technology</h1>
        <p class="text-gray-500">Built for speed, security, and scalability.</p>
    </div>

    <div class="prose prose-lg prose-blue max-w-none text-gray-700">
        <p>WebVault SchoolDesk is engineered with a focus on performance and data integrity. We deliberately avoided bloated frameworks to ensure the software runs lightning-fast on any standard hosting environment.</p>

        <h2>The Core Stack</h2>
        <ul>
            <li><strong>Backend:</strong> Pure PHP 8.3 (custom MVC-inspired routing).</li>
            <li><strong>Database:</strong> MySQL/MariaDB using PDO for secure, prepared statements.</li>
            <li><strong>Frontend:</strong> Tailwind CSS for a premium, fully responsive UI.</li>
            <li><strong>Interactivity:</strong> Alpine.js for lightweight, snappy UI components (dropdowns, modals).</li>
            <li><strong>Visualizations:</strong> Chart.js for real-time analytics on the Admin Dashboard.</li>
        </ul>

        <h2>Engineering Highlights</h2>
        <p><strong>ACID Compliance:</strong> When a student or teacher is created, the system initiates a database transaction. It creates the user login account and the profile simultaneously. If either fails, the entire operation rolls back, ensuring you never have "ghost" accounts or half-created profiles.</p>
        <p><strong>Security First:</strong> From strict middleware preventing cross-role access to CSRF tokens on every form, security is baked into the architecture, not added on as an afterthought.</p>
    </div>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/legal_layout.php'; ?>
