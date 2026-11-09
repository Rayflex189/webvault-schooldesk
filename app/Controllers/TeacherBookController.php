<?php
namespace App\Controllers;

use App\Middleware\TeacherMiddleware;
use App\Models\Book;
use App\Models\TeacherAssignment;
use Database;

class TeacherBookController {
    public function index() {
        TeacherMiddleware::handle();
        $pdo = Database::getInstance();
        
        // Get teacher's ID
        $stmt = $pdo->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $teacher = $stmt->fetch();

        // Get classes assigned to this teacher
        $assignmentModel = new TeacherAssignment();
        $assignments = $assignmentModel->getAssignmentsByUserId($_SESSION['user_id']);
        
        $classes = [];
        foreach($assignments as $a) {
            $classes[$a['class_id']] = $a['class_name'];
        }

        $selectedClass = $_GET['class_id'] ?? array_key_first($classes);
        $bookModel = new Book();
        $books = $selectedClass ? $bookModel->getByClass($selectedClass) : [];

        view('teacher.books.index', [
            'classes' => $classes,
            'books' => $books,
            'selectedClass' => $selectedClass,
            'teacher_id' => $teacher['id'] ?? null
        ]);
    }

    public function recommend() {
        TeacherMiddleware::handle();
        $model = new Book();
        $classes = $model->getClasses();
        view('teacher.books.recommend', ['classes' => $classes]);
    }

    public function storeRecommendation() {
        TeacherMiddleware::handle();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $teacher = $stmt->fetch();

        $model = new Book();
        $model->recommend([
            'teacher_id' => $teacher['id'],
            'class_id' => $_POST['class_id'],
            'title' => $_POST['title'],
            'author' => $_POST['author'] ?? 'N/A',
            'reason' => $_POST['reason']
        ]);

        $_SESSION['success'] = "Recommendation sent to Admin!";
        redirect('teacher/books');
    }
}
