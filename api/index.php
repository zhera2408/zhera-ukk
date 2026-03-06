<?php
// PHP Router for Vercel
// This script allows us to run multiple PHP files from the root directory 
// while staying compatible with Vercel's /api folder requirements.

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Default to index.php if path is empty or /
if ($path == '/' || !$path) {
    $path = '/index.php';
}

// Security: Prevent directory traversal
$path = str_replace('..', '', $path);
$file = realpath(__DIR__ . '/..' . $path);

// Check if it's a directory (like /admin/)
if ($file && is_dir($file)) {
    $file = realpath($file . '/index.php');
}

if ($file && file_exists($file)) {
    $extension = pathinfo($file, PATHINFO_EXTENSION);

    // Only execute PHP files
    if ($extension === 'php') {
        // Fix relative includes within PHP files
        chdir(dirname($file));
        require_once $file;
        exit;
    }
}

// 404 handler
http_response_code(404);
echo "404 Not Found - Terjadi kesalahan saat memproses rute.";
