<?php
// app/Controllers/FinanceController.php

namespace App\Controllers;

use App\Models\Finance;
use App\Middleware\AuthMiddleware;

class FinanceController {
    
    /**
     * Show the main finance dashboard/ledger
     */
    public function index() {
        AuthMiddleware::adminOnly();
        
        $session = $_GET['session'] ?? '2024/2025';
        $term = $_GET['term'] ?? 'First Term';
        
        $model = new Finance();
        $ledger = $model->getFeeLedger($session, $term);
        
        view('admin.finance.index', [
            'ledger' => $ledger,
            'session' => $session,
            'term' => $term
        ]);
    }

    /**
     * Show the form to record a payment
     */
    public function create() {
        AuthMiddleware::adminOnly();
        $model = new Finance();
        
        view('admin.finance.create', [
            'students' => $model->getStudents()
        ]);
    }

    /**
     * Store the payment in the database
     */
    public function store() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        // 1. Basic Validation
        $required = ['student_id', 'amount', 'reference', 'term', 'session'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = "All fields are required.";
                redirect('admin/finance/create');
            }
        }

        $amount = (float)$_POST['amount'];
        if ($amount <= 0) {
            $_SESSION['error'] = "Payment amount must be greater than zero.";
            redirect('admin/finance/create');
        }

        // 2. Check Balance (Prevent overpayment for now, unless it's a credit)
        $model = new Finance();
        $balanceInfo = $model->getStudentBalance($_POST['student_id'], $_POST['session'], $_POST['term']);
        
        if ($amount > $balanceInfo['balance']) {
            $_SESSION['error'] = "Payment exceeds outstanding balance. Expected: ₦" . number_format($balanceInfo['expected']) . ", Balance: ₦" . number_format($balanceInfo['balance']);
            redirect('admin/finance/create');
        }

        // 3. Record Payment
        $paymentData = $_POST;
        $paymentData['recorded_by'] = $_SESSION['user_id'];
        
        $success = $model->recordPayment($paymentData);

        if ($success) {
            $_SESSION['success'] = "Payment of ₦" . number_format($amount, 2) . " recorded successfully!";
            redirect('admin/finance');
        } else {
            $_SESSION['error'] = "Failed to record payment. Reference might be a duplicate.";
            redirect('admin/finance/create');
        }
    }
}
