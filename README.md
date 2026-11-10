# 🎓 WebVault SchoolDesk

**A Premium, All-in-One School Management SaaS built with Pure PHP.**

WebVault SchoolDesk is a comprehensive, multi-role educational management system designed specifically for modern private schools, colleges, and academies. Built without heavy frameworks (No Laravel, No React), it is incredibly fast, lightweight, and easy to deploy on any standard shared hosting (cPanel, Namecheap, etc.).

---

## ✨ Master Feature List

### 👑 Admin Portal
*   **Dynamic Dashboard**: Real-time stats, attendance trends (Chart.js), fee collection summaries, and house leaderboards.
*   **Student & Staff Management**: Full CRUD operations with automated user-account creation.
*   **Academics**: Manage Classes (Standard A-F or WAEC A1-F9 grading), Subjects, and Teacher Assignments.
*   **Exams & Report Cards**: Automated grading, class position calculation, and premium printable PDF report cards.
*   **Finance & Audit**: Set fee structures per class/term, record manual payments, track partial balances, and view an immutable Audit Trail.
*   **Communication**: Publish announcements and send Bulk HTML Emails to parents via SMTP.
*   **Booklist & Transport**: Manage required textbooks per class and assign students to school bus routes.
*   **System Settings**: Change School Name, Motto, SMTP credentials, Academic Sessions, and Terms without touching code.

### 👨‍🏫 Teacher Portal
*   **Class Dashboard**: View assigned classes and subjects.
*   **Attendance**: Take daily attendance for assigned classes.
*   **Exams**: Enter CA and Exam scores securely.
*   **Lesson Notes**: Submit weekly schemes of work for Admin review/approval.
*   **Behavior Log**: Record daily positive and negative behavior for students.
*   **Timetable**: View personalized teaching schedule.

### 👨‍👩‍👧 Parent Portal
*   **Child Overview**: View profiles and academic progress for all linked children.
*   **Finance**: View fee ledgers, download receipts, and **pay outstanding fees instantly via Paystack**.
*   **Academics**: View and print child's Report Cards.
*   **Resources**: View assigned Booklists and Bus Routes.
*   **Discipline**: Monitor child's Behavior Records.

### 🎒 Student Portal
*   **Personal Dashboard**: View academic summary and announcements.
*   **Results**: View and print personal Report Cards.
*   **Resources**: View Booklists, Timetables, Bus Routes, and Behavior Records.

---

## ⚙️ System Requirements

Because this system is built with **Pure PHP**, you do not need Composer, Node.js, or any build tools.

*   **PHP**: 8.1 or higher (8.3 recommended)
*   **Required PHP Extensions**: `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`.
*   **Database**: MySQL 5.7+ or MariaDB 10.3+
*   **Web Server**: Apache (with `mod_rewrite` enabled) or Nginx.
*   **SSL Certificate**: Highly recommended (Required for Paystack and secure sessions).

---

## 🚀 Installation Guide

### Step 1: Upload Files
Upload the entire project folder to your web server. 
**Important:** For maximum security, point your domain's document root to the `public/` folder (e.g., `public_html/public`). If you are on shared hosting where you cannot change the root, you can place everything in `public_html` and adjust the `.htaccess` slightly.

### Step 2: Create the Database
1. Log into your hosting control panel (cPanel/DirectAdmin).
2. Create a new MySQL database and user. Note down the database name, username, and password.
3. Open **phpMyAdmin**, select your new database, and import the `database/full_schema.sql` file. This will create all tables and seed the default Admin account.

### Step 3: Configure Environment
1. Locate the `.env.example` file in the root directory.
2. Rename it to `.env`.
3. Open `.env` and update the following configuration:
```env
APP_NAME="WebVault SchoolDesk"
APP_ENV=production
APP_URL=https://yourdomain.com
APP_DEBUG=false

DB_HOST=localhost
DB_PORT=3306
DB_NAME=your_database_name
DB_USER=your_database_user
DB_PASS=your_database_password
