<?php
// app/Models/Timetable.php

namespace App\Models;

use Database;
use PDO;

class Timetable {
    
    public function getSlots($classId, $session, $term) {
        $pdo = Database::getInstance();
        $sql = "SELECT t.*, s.name AS subject_name, s.code AS subject_code, 
                       te.first_name AS teacher_fname, te.last_name AS teacher_lname
                FROM timetables t
                JOIN subjects s ON t.subject_id = s.id
                LEFT JOIN teachers te ON t.teacher_id = te.id
                WHERE t.class_id = ? AND t.session = ? AND t.term = ?
                ORDER BY 
                    FIELD(t.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'),
                    t.start_time ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$classId, $session, $term]);
        return $stmt->fetchAll();
    }

    public function addSlot($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO timetables (class_id, subject_id, teacher_id, day_of_week, start_time, end_time, session, term) 
                VALUES (:class_id, :subject_id, :teacher_id, :day_of_week, :start_time, :end_time, :session, :term)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':class_id'    => $data['class_id'],
            ':subject_id'  => $data['subject_id'],
            ':teacher_id'  => !empty($data['teacher_id']) ? $data['teacher_id'] : null,
            ':day_of_week' => $data['day_of_week'],
            ':start_time'  => $data['start_time'],
            ':end_time'    => $data['end_time'],
            ':session'     => $data['session'],
            ':term'        => $data['term']
        ]);
    }

    public function deleteSlot($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM timetables WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getClasses() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name FROM classes ORDER BY name ASC")->fetchAll();
    }

    public function getSubjects() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, name, code FROM subjects ORDER BY name ASC")->fetchAll();
    }

    public function getTeachers() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, first_name, last_name FROM teachers ORDER BY first_name ASC")->fetchAll();
    }
}
