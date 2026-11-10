<?php
// app/Models/Transport.php

namespace App\Models;

use Database;
use PDO;

class Transport {
    
    public function getAllRoutes() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM bus_routes ORDER BY route_name ASC")->fetchAll();
    }

    public function createRoute($data) {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO bus_routes (route_name, driver_name, driver_phone, pickup_time, dropoff_time) 
                VALUES (:name, :driver, :phone, :pickup, :dropoff)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':name'    => $data['route_name'],
            ':driver'  => $data['driver_name'],
            ':phone'   => $data['driver_phone'],
            ':pickup'  => $data['pickup_time'],
            ':dropoff' => $data['dropoff_time']
        ]);
    }

    public function deleteRoute($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM bus_routes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getRouteById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM bus_routes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get all students with their current bus assignment
     */
    public function getAllStudentsWithRoutes() {
        $pdo = Database::getInstance();
        $sql = "SELECT s.id, s.first_name, s.last_name, s.admission_number, c.name AS class_name, s.bus_route_id, b.route_name 
                FROM students s
                JOIN classes c ON s.class_id = c.id
                LEFT JOIN bus_routes b ON s.bus_route_id = b.id
                WHERE s.status = 'active'
                ORDER BY c.name ASC, s.first_name ASC";
        return $pdo->query($sql)->fetchAll();
    }

    public function assignStudent($studentId, $routeId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE students SET bus_route_id = ? WHERE id = ?");
        return $stmt->execute([$routeId ? $routeId : null, $studentId]);
    }

    /**
     * Get a student's assigned route
     */
    public function getStudentRoute($studentId) {
        $pdo = Database::getInstance();
        $sql = "SELECT b.* FROM bus_routes b 
                JOIN students s ON s.bus_route_id = b.id 
                WHERE s.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetch();
    }
}
