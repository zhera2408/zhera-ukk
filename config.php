<?php
session_start();

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'library_ukk';
$db_port = getenv('DB_PORT') ?: '3306';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Base URL configuration
$base_url = getenv('BASE_URL') ?: 'http://localhost/peminjamanbuku_zhera/';

function base_url($path = '')
{
    global $base_url;
    return $base_url . $path;
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
