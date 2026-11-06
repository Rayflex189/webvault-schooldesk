<?php
// public/index.php

// 1. Load Environment Variables
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value, " \t\n\r\0\x0B\"'");
    }
}

// 2. Load Helpers & Config  <--- UPDATED COMMENT
require_once __DIR__ . '/../app/Helpers/functions.php';
require_once __DIR__ . '/../config/database.php'; // <--- ADDED THIS LINE

// 3. Start Secure Session
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    if (env('SESSION_SECURE_COOKIE') === 'true') {
        ini_set('session.cookie_secure', 1);
    }
    session_start();
}

// 4. Simple PSR-4 Autoloader for 'App\' namespace
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

// 5. Get the Request URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim(str_replace('/webvault-schooldesk/public', '', $uri), '/'); // Adjusted spelling here too
if ($uri === '') $uri = '/';

// 6. Load Routes
$routes = require_once __DIR__ . '/../routes/web.php';

// 7. Dispatch the Route
if (array_key_exists($uri, $routes)) {
    $action = $routes[$uri];
    
    if (is_callable($action)) {
        call_user_func($action);
    } elseif (is_array($action)) {
        // Example: [$controllerInstance, 'method']
        // $controller = new $action[0]();
        // call_user_func([$controller, $action[1]]);
    }
} else {
    http_response_code(404);
    echo "<h1 style='font-family: sans-serif; text-align: center; margin-top: 50px;'>404 - Page Not Found</h1>";
}
