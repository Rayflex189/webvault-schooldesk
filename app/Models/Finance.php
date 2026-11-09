<?php
// app/Models/Finance.php

namespace App\Models;

use Database;
use PDO;

class Finance {
    
    /**
     * Get the fee ledger showing expected vs paid per student
     */
    public function getFeeLedger($session, $term) {
        $pdo = Database::getInstance();
        $sql = "SELECT s.id, s.first_name, s.last_name, s.admission_number, c.name AS class_name,
                       COALESCE(f.amount, 0) AS expected_fee,
                       COALESCE(SUM(p.amount), 0) AS total_paid
                FROM students s
                JOIN classes c ON s.class_id = c.id
                LEFT JOIN fee_structures f ON s.class_id = f.class_id AND f.session = :session1 AND f.term = :term1
                LEFT JOIN payments p ON s.id = p.student_id AND p.session = :session2 AND p.term = :term2
                WHERE s.status = 'active'
                GROUP BY s.id
                ORDER BY c.name ASC, s.first_name ASC";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':session1' => $session, ':term1' => $term,
            ':session2' => $session, ':term2' => $term
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Get the balance for a single student
     */
    public function getStudentBalance($studentId, $session, $term) {
        $pdo = Database::getInstance();
        $sql = "SELECT 
                    (SELECT amount FROM fee_structures f JOIN students s ON f.class_id = s.class_id WHERE s.id = ? AND f.session = ? AND f.term = ?) AS expected,
                    (SELECT SUM(amount) FROM payments WHERE student_id = ? AND session = ? AND term = ?) AS paid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId, $session, $term, $studentId, $session, $term]);
        $result = $stmt->fetch();
        
        $expected = $result['expected'] ?? 0;
        $paid = $result['paid'] ?? 0;
        
        return [
            'expected' => (float)$expected,
            'paid' => (float)$paid,
            'balance' => (float)($expected - $paid)
        ];
    }

    /**
     * Record a manual payment
     */
    public function recordPayment($data) {
        $pdo = Database::getInstance();
        try {
            $pdo->beginTransaction();
            $sql = "INSERT INTO payments (student_id, amount, payment_method, reference, term, session, recorded_by) 
                    VALUES (:student_id, :amount, :payment_method, :reference, :term, :session, :recorded_by)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':student_id'     => $data['student_id'],
                ':amount'         => $data['amount'],
                ':payment_method' => $data['payment_method'],
                ':reference'      => $data['reference'],
                ':term'           => $data['term'],
                ':session'        => $data['session'],
                ':recorded_by'    => $data['recorded_by']
            ]);
            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
    
    /**
     * Get all active students
     */
    public function getStudents() {
        $pdo = Database::getInstance();
        return $pdo->query("
            SELECT s.id, s.first_name, s.last_name, s.admission_number, c.name AS class_name 
            FROM students s 
            JOIN classes c ON s.class_id = c.id 
            WHERE s.status = 'active' 
            ORDER BY s.first_name ASC
        ")->fetchAll();
    }

    /**
     * Get all classes
     */
    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }

    /**
     * Get fee structures for a specific session and term
     */
    public function getFeeStructures($session, $term) {
        $pdo = Database::getInstance();
        $sql = "SELECT f.*, c.name AS class_name 
                FROM fee_structures f
                JOIN classes c ON f.class_id = c.id
                WHERE f.session = ? AND f.term = ?
                ORDER BY c.name ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$session, $term]);
        return $stmt->fetchAll();
    }

    /**
     * Save or update a fee structure
     */
    public function saveFeeStructure($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO fee_structures (class_id, session, term, amount) 
                VALUES (:class_id, :session, :term, :amount)
                ON DUPLICATE KEY UPDATE amount = VALUES(amount)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':class_id' => $data['class_id'],
            ':session'  => $data['session'],
            ':term'     => $data['term'],
            ':amount'   => $data['amount']
        ]);
    }

    /**
     * Get all transactions for the Audit Trail
     */
    public function getAllTransactions() {
        $pdo = Database::getInstance();
        $sql = "SELECT p.*, 
                       s.first_name, s.last_name, s.admission_number,
                       u.username as recorded_by_name
                FROM payments p
                JOIN students s ON p.student_id = s.id
                JOIN users u ON p.recorded_by = u.id
                ORDER BY p.created_at DESC";
        return $pdo->query($sql)->fetchAll();
    }
}
