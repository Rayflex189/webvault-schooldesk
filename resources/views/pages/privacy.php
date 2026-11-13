<?php ob_start(); ?>
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-primary uppercase mb-2">Privacy Policy</h1>
        <p class="text-gray-500">Last Updated: <?= date('F j, Y') ?></p>
    </div>

    <div class="prose prose-lg prose-blue max-w-none text-gray-700">
        <h2>1. Data We Collect</h2>
        <p>As a School Management System, we collect personal data to facilitate educational administration. This includes:</p>
        <ul>
            <li><strong>Student Data:</strong> Names, dates of birth, gender, class assignments, and academic records.</li>
            <li><strong>Parent/Guardian Data:</strong> Names, email addresses, phone numbers, and payment history.</li>
            <li><strong>Staff Data:</strong> Names, qualifications, and contact information.</li>
        </ul>

        <h2>2. How We Protect Your Data</h2>
        <p>We take data security extremely seriously. WebVault SchoolDesk implements industry-standard security measures, including:</p>
        <ul>
            <li><strong>Password Hashing:</strong> All user passwords are securely hashed using Bcrypt (via PHP's <code>password_hash()</code>). We never store plain-text passwords.</li>
            <li><strong>SQL Injection Prevention:</strong> We use PDO prepared statements for all database queries.</li>
            <li><strong>CSRF Protection:</strong> All forms are protected against Cross-Site Request Forgery.</li>
            <li><strong>Role-Based Access Control:</strong> Data is strictly isolated. Parents can only view data belonging to their own children.</li>
        </ul>

        <h2>3. Third-Party Integrations</h2>
        <p>To provide a complete experience, we integrate with trusted third parties:</p>
        <ul>
            <li><strong>Paystack:</strong> For secure online fee payments. We do not store your credit card details on our servers.</li>
            <li><strong>SMTP Providers (e.g., Gmail, Zoho):</strong> Used exclusively to send transactional emails (receipts, password resets).</li>
        </ul>

        <h2>4. Data Ownership</h2>
        <p>The school institution retains full ownership of the data entered into the system. If the school chooses to terminate their use of the Software, they are responsible for exporting their own data.</p>
    </div>
</div>
<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/legal_layout.php'; ?>
