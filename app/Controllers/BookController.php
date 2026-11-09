<?php
namespace App\Controllers;

use App\Models\Book;
use App\Middleware\AuthMiddleware;

class BookController {
    
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new Book();
        $classes = $model->getClasses();
        $selectedClass = $_GET['class_id'] ?? $classes[0]['id'] ?? null;
        $books = $selectedClass ? $model->getByClass($selectedClass) : [];

        view('admin.books.index', [
            'classes' => $classes,
            'books' => $books,
            'selectedClass' => $selectedClass
        ]);
    }

    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $model = new Book();
        $model->add([
            'class_id' => $_POST['class_id'],
            'title' => $_POST['title'],
            'author' => $_POST['author'] ?? 'N/A',
            'is_compulsory' => isset($_POST['is_compulsory']) ? 1 : 0
        ]);

        $_SESSION['success'] = "Book added to list!";
        redirect("admin/books?class_id=" . $_POST['class_id']);
    }

    public function delete() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        $model = new Book();
        $model->delete($_POST['id']);
        $_SESSION['success'] = "Book removed.";
        redirect("admin/books?class_id=" . $_POST['class_id']);
    }
}
