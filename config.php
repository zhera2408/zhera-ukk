<?php
session_start();
ob_start();

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'library_ukk';
$db_port = getenv('DB_PORT') ?: '3306';

// SSL Configuration (Recommended for Aiven)
$ca_cert = getenv('DB_SSL_CA');
$conn = mysqli_init();

if ($ca_cert) {
    // If CA cert is provided as a string (starts with BEGIN CERTIFICATE), save it to a temp file
    if (strpos($ca_cert, '-----BEGIN CERTIFICATE-----') !== false) {
        $temp_ca = tempnam(sys_get_temp_dir(), 'ca_cert_');
        file_put_contents($temp_ca, $ca_cert);
        $ca_cert = $temp_ca;
    }

    mysqli_ssl_set($conn, NULL, NULL, $ca_cert, NULL, NULL);
    $connect_res = @mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port, NULL, MYSQLI_CLIENT_SSL);
}
else {
    $connect_res = @mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port);
}

if (!$connect_res) {
    die("Koneksi database gagal: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

// Base URL configuration
if (getenv('BASE_URL')) {
    $base_url = getenv('BASE_URL');
    // If we're on a secure proxy but BASE_URL is http, fix it automatically
    if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')) {
        $base_url = str_replace('http://', 'https://', $base_url);
    }
}
else {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) ? "https" : "http";
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
    $role = isset($_SESSION['role']) ? strtolower(trim($_SESSION['role'])) : '';
    $username = isset($_SESSION['nama']) ? strtolower(trim($_SESSION['nama'])) : '';

    // Primary check: role is 'admin'
    // Fallback: if stored role is empty/null but username is 'Administrator' or 'admin'
    $is_admin = ($role === 'admin');

    if (!$is_admin) {
        header("Location: " . base_url('user/index.php'));
        exit();
    }
}
?>
