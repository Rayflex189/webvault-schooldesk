<?php
// config/database.php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', '3306');
        $db   = env('DB_NAME', 'webyault_schooldesk');
        $user = env('DB_USER', 'root');
        $pass = env('DB_PASS', '');
        $charset = env('DB_CHARSET', 'utf8mb4');

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            // In production, log this error instead of dying
            if (env('APP_DEBUG') === 'true') {
                die("Database Connection Error: " . $e->getMessage());
            } else {
                die("Could not connect to the database.");
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
