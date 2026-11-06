<?php
// app/Helpers/functions.php

/**
 * Get environment variable from $_ENV
 */
function env($key, $default = null) {
    $value = $_ENV[$key] ?? getenv($key);
    if ($value === false) {
        return $default;
    }
    // Convert string booleans to actual booleans
    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'empty':
        case '(empty)':
            return '';
        case 'null':
        case '(null)':
            return null;
    }
    return $value;
}

/**
 * Render a view file with data
 */
function view($path, $data = []) {
    extract($data);
    $viewPath = __DIR__ . '/../../resources/views/' . str_replace('.', '/', $path) . '.php';
    
    if (!file_exists($viewPath)) {
        http_response_code(500);
        die("View not found: {$path}");
    }
    
    require_once $viewPath;
}

/**
 * Redirect to a specific path
 */
function redirect($path) {
    header("Location: " . rtrim(env('APP_URL', ''), '/') . '/' . ltrim($path, '/'));
    exit;
}

/**
 * Escape output to prevent XSS
 */
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF Token
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF Token
 */
function verify_csrf($token) {
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(419);
        die('CSRF token mismatch.');
    }
}
