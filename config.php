<?php
session_start();

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'library_ukk';
$db_port = getenv('DB_PORT') ?: '3306';

// SSL Configuration (Recommended for Aiven)
$ca_cert = getenv('DB_SSL_CA');
$conn = mysqli_init();

if ($ca_cert) {
    mysqli_ssl_set($conn, NULL, NULL, $ca_cert, NULL, NULL);
    mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port, NULL, MYSQLI_CLIENT_SSL);
}
else {
    mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port);
}

if (!$conn || mysqli_connect_errno()) {
    die("Koneksi database gagal: " . (mysqli_connect_error() ?: mysqli_error($conn)));
}

// Base URL configuration
if (getenv('BASE_URL')) {
    $base_url = getenv('BASE_URL');
}
else {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // Detect project root relative to document root
    if (isset($_SERVER['DOCUMENT_ROOT']) && isset($_SERVER['SCRIPT_FILENAME'])) {
        $project_root = str_replace('\\', '/', dirname(__FILE__));
        $doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
        $url_path = str_replace($doc_root, '', $project_root);
        $base_url = "$protocol://$host" . rtrim($url_path, '/') . '/';
    }
    else {
        $base_url = "$protocol://$host/";
    }
}
$base_url = rtrim($base_url, '/') . '/';

function base_url($path = '')
{
    global $base_url;
    return $base_url . ltrim($path, '/');
}

function check_login()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . base_url('login.php'));
        exit();
    }
}

function check_admin()
{
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: " . base_url('index.php')); // Redirect to user dashboard or home
        exit();
    }
}
?>
