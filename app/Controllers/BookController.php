<?php
// app/Controllers/BookController.php

namespace App\Controllers;

use App\Models\Book;
use App\Middleware\AuthMiddleware;

class BookController {
    
    /**
     * Display the booklist for a specific class
     */
    public function index() {
        AuthMiddleware::adminOnly();
        $model = new Book();
        $classes = $model->getClasses();
        
        // Default to the first class if none is selected
        $selectedClass = $_GET['class_id'] ?? $classes[0]['id'] ?? null;
        $books = $selectedClass ? $model->getByClass($selectedClass) : [];

        view('admin.books.index', [
            'classes' => $classes,
            'books' => $books,
            'selectedClass' => $selectedClass
        ]);
    }

    /**
     * Add a new book to the official list
     */
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

    /**
     * Delete a book from the official list
     */
    public function delete() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        $model = new Book();
        $model->delete($_POST['id']);
        $_SESSION['success'] = "Book removed.";
        redirect("admin/books?class_id=" . $_POST['class_id']);
    }

    /**
     * Display pending teacher recommendations
     */
    public function recommendations() {
        AuthMiddleware::adminOnly();
        $model = new Book();
        $recommendations = $model->getPendingRecommendations();
        
        view('admin.books.recommendations', ['recommendations' => $recommendations]);
    }

    /**
     * Approve a recommendation and move it to the official list
     */
    public function approveRecommendation() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $model = new Book();
        $model->approveRecommendation($_POST['id']);
        
        $_SESSION['success'] = "Book recommendation approved and added to class list!";
        redirect('admin/books/recommendations');
    }
}
