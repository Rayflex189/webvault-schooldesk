<?php
// app/Models/LessonNote.php

namespace App\Models;

use Database;
use PDO;

class LessonNote {
    
    public function create($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO lesson_notes (teacher_id, class_id, subject_id, term, session, week_number, title, content) 
                VALUES (:teacher_id, :class_id, :subject_id, :term, :session, :week, :title, :content)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':teacher_id' => $data['teacher_id'],
            ':class_id'   => $data['class_id'],
            ':subject_id' => $data['subject_id'],
            ':term'       => $data['term'],
            ':session'    => $data['session'],
            ':week'       => $data['week_number'],
            ':title'      => $data['title'],
            ':content'    => $data['content']
        ]);
    }

    public function getByTeacher($teacherId) {
        $pdo = Database::getInstance();
        $sql = "SELECT ln.*, c.name AS class_name, s.name AS subject_name 
                FROM lesson_notes ln
                JOIN classes c ON ln.class_id = c.id
                JOIN subjects s ON ln.subject_id = s.id
                WHERE ln.teacher_id = ?
                ORDER BY ln.week_number DESC, ln.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll();
    }

    public function getAll() {
        $pdo = Database::getInstance();
        $sql = "SELECT ln.*, t.first_name, t.last_name, c.name AS class_name, s.name AS subject_name 
                FROM lesson_notes ln
                JOIN teachers t ON ln.teacher_id = t.id
                JOIN classes c ON ln.class_id = c.id
                JOIN subjects s ON ln.subject_id = s.id
                ORDER BY ln.status ASC, ln.created_at DESC";
        return $pdo->query($sql)->fetchAll();
    }

    public function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM lesson_notes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateStatus($id, $status, $remarks) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE lesson_notes SET status = ?, admin_remarks = ? WHERE id = ?");
        return $stmt->execute([$status, $remarks, $id]);
    }
}
