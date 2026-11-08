# WebVault SchoolDesk

A premium, complete, and secure School Management System built with Pure PHP, MySQL, and Tailwind CSS.

## 🚀 Features
- **Multi-Role Portals**: Dedicated dashboards for Admins, Teachers, Parents, and Students.
- **Student & Staff Management**: Complete profiles, admissions, and assignments.
- **Academic Engine**: Classes, Subjects, Attendance tracking, and Exam score entry.
- **Report Cards**: Automated CA/Exam grading, class positions, and printable PDF report sheets.
- **Finance Module**: Fee structures, payment ledger, and outstanding balances.
- **Secure Architecture**: Role-based access control (RBAC), PDO prepared statements, CSRF protection, and strict data isolation.
- **Dynamic Settings**: Change school name, logo, motto, and active academic terms instantly.

## ⚙️ System Requirements
- PHP 8.0 or higher
- MySQL 5.7 or MariaDB 10.3 or higher
- Apache Web Server (with `mod_rewrite` enabled)
- cPanel or standard Linux VPS

## 📦 Installation Guide

1. **Upload Files**:
   Upload the entire project directory to your web server's root folder (e.g., `public_html`).
   *Important: Point your domain's document root to the `public/` folder for maximum security.*

2. **Create a Database**:
   Using cPanel (or your MySQL manager), create a new database and a database user. Grant all privileges to the user.

3. **Import the Schema**:
   Open phpMyAdmin, select your new database, and import the `database/full_schema.sql` file. This will create all tables and set up the initial administrator account.

4. **Configure Environment**:
   - Rename `.env.example` to `.env`.
   - Open `.env` and update the following lines with your database credentials:
     ```env
     APP_URL=https://yourdomain.com
     DB_HOST=localhost
     DB_NAME=your_database_name
     DB_USER=your_database_user
     DB_PASS=your_database_password
     ```

5. **Set Permissions**:
   Ensure the `storage/` and `public/uploads/` directories are writable by the web server:
   ```bash
   chmod -R 775 storage
   chmod -R 775 public/uploads
