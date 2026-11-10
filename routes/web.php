<?php
// routes/web.php

use App\Controllers\LandingController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\StudentController;
use App\Controllers\TeacherController;
use App\Controllers\ParentController;
use App\Controllers\SubjectController;
use App\Controllers\ClassController;
use App\Controllers\BookController;
use App\Controllers\TeacherBookController;
use App\Controllers\TeacherAssignmentController;
use App\Controllers\AttendanceController;
use App\Controllers\ExamController;
use App\Controllers\TimetableController;
use App\Controllers\ReportCardController;
use App\Controllers\FinanceController;
use App\Controllers\AnnouncementController;
use App\Controllers\CommunicationController;
use App\Controllers\TeacherDashboardController;
use App\Controllers\TeacherAttendanceController;
use App\Controllers\TeacherExamController;
use App\Controllers\ParentDashboardController;
use App\Controllers\StudentDashboardController;
use App\Controllers\SettingController;
use App\Controllers\ProfileController;

return [
    // ==========================================
    // Public Routes (Landing Page & Auth)
    // ==========================================
    '/' => function() {
        $controller = new LandingController();
        $controller->index();
    },
    'submit-testimonial' => function() {
        $controller = new LandingController();
        $controller->submitTestimonial();
    },
    'submit-contact' => function() {
        $controller = new LandingController();
        $controller->submitContact();
    },
    'login' => function() {
        $auth = new AuthController();
        $auth->login();
    },
    'logout' => function() {
        $auth = new AuthController();
        $auth->logout();
    },

    // ==========================================
    // Protected User Routes (All Roles)
    // ==========================================
    'profile' => function() {
        $controller = new ProfileController();
        $controller->index();
    },
    'profile/update' => function() {
        $controller = new ProfileController();
        $controller->updatePassword();
    },

    // ==========================================
    // Protected Admin Routes
    // ==========================================
    'admin/dashboard' => function() {
        $controller = new DashboardController();
        $controller->index();
    },
    
    // Admin: Student Management
    'admin/students' => function() {
        $controller = new StudentController();
        $controller->index();
    },
    'admin/students/create' => function() {
        $controller = new StudentController();
        $controller->create();
    },
    'admin/students/store' => function() {
        $controller = new StudentController();
        $controller->store();
    },
    'admin/students/edit' => function() {
        $controller = new StudentController();
        $controller->edit();
    },
    'admin/students/update' => function() {
        $controller = new StudentController();
        $controller->update();
    },
    'admin/students/delete' => function() {
        $controller = new StudentController();
        $controller->destroy();
    },

    // Admin: Teacher Management
    'admin/teachers' => function() {
        $controller = new TeacherController();
        $controller->index();
    },
    'admin/teachers/create' => function() {
        $controller = new TeacherController();
        $controller->create();
    },
    'admin/teachers/store' => function() {
        $controller = new TeacherController();
        $controller->store();
    },
    'admin/teachers/edit' => function() {
        $controller = new TeacherController();
        $controller->edit();
    },
    'admin/teachers/update' => function() {
        $controller = new TeacherController();
        $controller->update();
    },
    'admin/teachers/delete' => function() {
        $controller = new TeacherController();
        $controller->destroy();
    },

    // Admin: Parent Management
    'admin/parents' => function() {
        $controller = new ParentController();
        $controller->index();
    },
    'admin/parents/create' => function() {
        $controller = new ParentController();
        $controller->create();
    },
    'admin/parents/store' => function() {
        $controller = new ParentController();
        $controller->store();
    },

    // Admin: Subject Management
    'admin/subjects' => function() {
        $controller = new SubjectController();
        $controller->index();
    },
    'admin/subjects/create' => function() {
        $controller = new SubjectController();
        $controller->create();
    },
    'admin/subjects/store' => function() {
        $controller = new SubjectController();
        $controller->store();
    },
    'admin/subjects/edit' => function() {
        $controller = new SubjectController();
        $controller->edit();
    },
    'admin/subjects/update' => function() {
        $controller = new SubjectController();
        $controller->update();
    },
    'admin/subjects/delete' => function() {
        $controller = new SubjectController();
        $controller->destroy();
    },

    // Admin: Class Management
    'admin/classes' => function() {
        $controller = new ClassController();
        $controller->index();
    },
    'admin/classes/create' => function() {
        $controller = new ClassController();
        $controller->create();
    },
    'admin/classes/store' => function() {
        $controller = new ClassController();
        $controller->store();
    },
    'admin/classes/edit' => function() {
        $controller = new ClassController();
        $controller->edit();
    },
    'admin/classes/update' => function() {
        $controller = new ClassController();
        $controller->update();
    },
    'admin/classes/subjects' => function() {
        $controller = new ClassController();
        $controller->manageSubjects();
    },
    'admin/classes/subjects/update' => function() {
        $controller = new ClassController();
        $controller->updateSubjects();
    },

    // Admin: Booklist Management
    'admin/books' => function() {
        $controller = new BookController();
        $controller->index();
    },
    'admin/books/store' => function() {
        $controller = new BookController();
        $controller->store();
    },
    'admin/books/delete' => function() {
        $controller = new BookController();
        $controller->delete();
    },
    'admin/books/recommendations' => function() {
        $controller = new BookController();
        $controller->recommendations();
    },
    'admin/books/recommendations/approve' => function() {
        $controller = new BookController();
        $controller->approveRecommendation();
    },

    // Admin: Teacher Assignments
    'admin/assignments' => function() {
        $controller = new TeacherAssignmentController();
        $controller->index();
    },
    'admin/assignments/create' => function() {
        $controller = new TeacherAssignmentController();
        $controller->create();
    },
    'admin/assignments/store' => function() {
        $controller = new TeacherAssignmentController();
        $controller->store();
    },
    'admin/assignments/edit' => function() {
        $controller = new TeacherAssignmentController();
        $controller->edit();
    },
    'admin/assignments/update' => function() {
        $controller = new TeacherAssignmentController();
        $controller->update();
    },
    'admin/assignments/delete' => function() {
        $controller = new TeacherAssignmentController();
        $controller->destroy();
    },

    // Admin: Attendance Management
    'admin/attendance' => function() {
        $controller = new AttendanceController();
        $controller->index();
    },
    'admin/attendance/mark' => function() {
        $controller = new AttendanceController();
        $controller->mark();
    },
    'admin/attendance/store' => function() {
        $controller = new AttendanceController();
        $controller->store();
    },

    // Admin: Exams & Results
    'admin/exams' => function() {
        $controller = new ExamController();
        $controller->index();
    },
    'admin/exams/entry' => function() {
        $controller = new ExamController();
        $controller->entry();
    },
    'admin/exams/store' => function() {
        $controller = new ExamController();
        $controller->store();
    },

    // Admin: Timetable Management
    'admin/timetables' => function() {
        $controller = new TimetableController();
        $controller->index();
    },
    'admin/timetables/store' => function() {
        $controller = new TimetableController();
        $controller->store();
    },
    'admin/timetables/delete' => function() {
        $controller = new TimetableController();
        $controller->destroy();
    },

    // Admin: Report Cards
    'admin/reports' => function() {
        $controller = new ReportCardController();
        $controller->index();
    },
    'admin/reports/generate' => function() {
        $controller = new ReportCardController();
        $controller->generate();
    },

    // Admin: Finance & Fees
    'admin/finance' => function() {
        $controller = new FinanceController();
        $controller->index();
    },
    'admin/finance/create' => function() {
        $controller = new FinanceController();
        $controller->create();
    },
    'admin/finance/store' => function() {
        $controller = new FinanceController();
        $controller->store();
    },
    'admin/finance/manage-fees' => function() {
        $controller = new FinanceController();
        $controller->manageFees();
    },
    'admin/finance/save-fees' => function() {
        $controller = new FinanceController();
        $controller->saveFees();
    },
    'admin/finance/audit-trail' => function() {
        $controller = new FinanceController();
        $controller->auditTrail();
    },

    // Admin: Announcements
    'admin/announcements' => function() {
        $controller = new AnnouncementController();
        $controller->index();
    },
    'admin/announcements/create' => function() {
        $controller = new AnnouncementController();
        $controller->create();
    },
    'admin/announcements/store' => function() {
        $controller = new AnnouncementController();
        $controller->store();
    },

    // Admin: Communication
    'admin/communication' => function() {
        $controller = new CommunicationController();
        $controller->index();
    },
    'admin/communication/send' => function() {
        $controller = new CommunicationController();
        $controller->send();
    },

    // Admin: Settings
    'admin/settings' => function() {
        $controller = new SettingController();
        $controller->index();
    },
    'admin/settings/update-school' => function() {
        $controller = new SettingController();
        $controller->updateSchoolInfo();
    },
    'admin/settings/update-session' => function() {
        $controller = new SettingController();
        $controller->updateCurrentSession();
    },
    'admin/settings/create-session' => function() {
        $controller = new SettingController();
        $controller->createSession();
    },

    // ==========================================
    // Teacher Portal Routes
    // ==========================================
    'teacher/dashboard' => function() {
        $controller = new TeacherDashboardController();
        $controller->index();
    },
    
    // Teacher: Attendance
    'teacher/attendance' => function() {
        $controller = new TeacherAttendanceController();
        $controller->mark();
    },
    'teacher/attendance/store' => function() {
        $controller = new TeacherAttendanceController();
        $controller->store();
    },

    // Teacher: Exams & Scores
    'teacher/exams' => function() {
        $controller = new TeacherExamController();
        $controller->index();
    },
    'teacher/exams/entry' => function() {
        $controller = new TeacherExamController();
        $controller->entry();
    },
    'teacher/exams/store' => function() {
        $controller = new TeacherExamController();
        $controller->store();
    },

    // Teacher: Booklist & Recommendations
    'teacher/books' => function() {
        $controller = new TeacherBookController();
        $controller->index();
    },
    'teacher/books/recommend' => function() {
        $controller = new TeacherBookController();
        $controller->recommend();
    },
    'teacher/books/recommend/store' => function() {
        $controller = new TeacherBookController();
        $controller->storeRecommendation();
    },

    // Teacher: Timetable
    'teacher/timetable' => function() {
        $controller = new TeacherDashboardController();
        $controller->timetable();
    },

    // ==========================================
    // Parent Portal Routes
    // ==========================================
    'parent/dashboard' => function() {
        $controller = new ParentDashboardController();
        $controller->index();
    },
    'parent/report-card' => function() {
        $controller = new ParentDashboardController();
        $controller->reportCard();
    },
    'parent/fees' => function() {
        $controller = new ParentDashboardController();
        $controller->fees();
    },
    'parent/books' => function() {
        $controller = new ParentDashboardController();
        $controller->books();
    },
    
    // Parent: Paystack Payments
    'parent/payment/initiate' => function() {
        $controller = new ParentDashboardController();
        $controller->initiatePayment();
    },
    'parent/payment/callback' => function() {
        $controller = new ParentDashboardController();
        $controller->verifyPayment();
    },

    // Parent: Timetable
    'parent/timetable' => function() {
        $controller = new ParentDashboardController();
        $controller->timetable();
    },

    // ==========================================
    // Student Portal Routes
    // ==========================================
    'student/dashboard' => function() {
        $controller = new StudentDashboardController();
        $controller->index();
    },
    'student/report-card' => function() {
        $controller = new StudentDashboardController();
        $controller->reportCard();
    },
    'student/books' => function() {
        $controller = new StudentDashboardController();
        $controller->books();
    },

    // Student: Timetable
    'student/timetable' => function() {
        $controller = new StudentDashboardController();
        $controller->timetable();
    }
];
