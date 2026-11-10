<?php
// app/Models/SchoolClass.php

namespace App\Models;

use Database;
use PDO;

class SchoolClass {
    
    public function all() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM classes ORDER BY name ASC")->fetchAll();
    }

    public function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO classes (name, capacity, grading_scheme) VALUES (:name, :capacity, :scheme)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':capacity' => $data['capacity'],
            ':scheme' => $data['grading_scheme'] ?? 'standard'
        ]);
    }

    public function update($id, $data) {
        $pdo = Database::getInstance();
        $sql = "UPDATE classes SET name = :name, capacity = :capacity, grading_scheme = :scheme WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':name'     => $data['name'],
            ':capacity' => $data['capacity'],
            ':scheme'   => $data['grading_scheme'] ?? 'standard',
            ':id'       => $id
        ]);
    }

    public function getAllSubjects() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM subjects ORDER BY name ASC")->fetchAll();
    }

    public function getAssignedSubjects($classId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT subject_id FROM class_subjects WHERE class_id = ?");
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function syncSubjects($classId, $subjectIds) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM class_subjects WHERE class_id = ?");
        $stmt->execute([$classId]);

        if (!empty($subjectIds)) {
            $sql = "INSERT INTO class_subjects (class_id, subject_id) VALUES ";
            $values = [];
            $params = [];
            foreach ($subjectIds as $subId) {
                $values[] = "(?, ?)";
                $params[] = $classId;
                $params[] = $subId;
            }
            $sql .= implode(", ", $values);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        }
        return true;
    }
}
