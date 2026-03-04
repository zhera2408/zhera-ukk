<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'library_ukk';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Base URL configuration - Adjust if needed
$base_url = 'http://localhost/peminjamanbuku_zhera/';

function base_url($path = '') {
    global $base_url;
    return $base_url . $path;
}

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . base_url('login.php'));
        exit();
    }
}

function check_admin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: " . base_url('index.php')); // Redirect to user dashboard or home
        exit();
    }
}
?>
