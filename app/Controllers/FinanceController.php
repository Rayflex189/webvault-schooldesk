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

        $model = new Finance();
        $balanceInfo = $model->getStudentBalance($_POST['student_id'], $_POST['session'], $_POST['term']);
        
        if ($amount > $balanceInfo['balance']) {
            $_SESSION['error'] = "Payment exceeds outstanding balance. Expected: ₦" . number_format($balanceInfo['expected']) . ", Balance: ₦" . number_format($balanceInfo['balance']);
            redirect('admin/finance/create');
        }

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

    /**
     * Show the form to manage fee structures per class
     */
    public function manageFees() {
        AuthMiddleware::adminOnly();
        $model = new Finance();
        
        $settings = get_settings();
        $session = $_GET['session'] ?? $settings['current_session'] ?? '2024/2025';
        $term = $_GET['term'] ?? $settings['current_term'] ?? 'First Term';
        
        $classes = $model->getClasses();
        $structures = $model->getFeeStructures($session, $term);
        
        $feeMap = [];
        foreach($structures as $s) {
            $feeMap[$s['class_id']] = $s['amount'];
        }

        view('admin.finance.manage_fees', [
            'classes' => $classes,
            'feeMap' => $feeMap,
            'session' => $session,
            'term' => $term
        ]);
    }

    /**
     * Save the fee structures
     */
    public function saveFees() {
        AuthMiddleware::adminOnly();
        verify_csrf($_POST['csrf_token'] ?? '');
        
        $session = $_POST['session'] ?? null;
        $term = $_POST['term'] ?? null;
        $amounts = $_POST['amounts'] ?? [];

        if (!$session || !$term || empty($amounts)) {
            redirect('admin/finance/manage-fees');
        }

        $model = new Finance();
        $successCount = 0;
        
        foreach ($amounts as $classId => $amount) {
            if (is_numeric($amount) && $amount >= 0) {
                $model->saveFeeStructure([
                    'class_id' => $classId,
                    'session' => $session,
                    'term' => $term,
                    'amount' => $amount
                ]);
                $successCount++;
            }
        }

        $_SESSION['success'] = "Fee structures updated for {$successCount} classes!";
        redirect("admin/finance/manage-fees?session=" . urlencode($session) . "&term=" . urlencode($term));
    }

    /**
     * Show the Audit Trail of all transactions
     */
    public function auditTrail() {
        AuthMiddleware::adminOnly();
        
        $model = new Finance();
        $transactions = $model->getAllTransactions();
        
        view('admin.finance.audit_trail', ['transactions' => $transactions]);
    }
}
