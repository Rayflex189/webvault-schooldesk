<?php
// app/Models/Finance.php

namespace App\Models;

use Database;
use PDO;

class Finance {
    
    /**
     * Get all students, their class fees, and their total payments for a specific term
     */
    public function getFeeLedger($session, $term) {
        $pdo = Database::getInstance();
        
        $sql = "SELECT s.id, s.first_name, s.last_name, s.admission_number, c.name AS class_name,
                       COALESCE(f.amount, 0) AS expected_fee,
                       COALESCE(SUM(p.amount), 0) AS total_paid
                FROM students s
                JOIN classes c ON s.class_id = c.id
                LEFT JOIN fee_structures f ON s.class_id = f.class_id AND f.session = :session AND f.term = :term
                LEFT JOIN payments p ON s.id = p.student_id AND p.session = :session AND p.term = :term
                WHERE s.status = 'active'
                GROUP BY s.id
                ORDER BY c.name ASC, s.first_name ASC";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':session' => $session, ':term' => $term]);
        return $stmt->fetchAll();
    }

    /**
     * Get a single student's financial summary
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
     * Record a payment safely using a transaction
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
}
