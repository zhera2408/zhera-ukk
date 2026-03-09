<?php
require_once '../config.php';
check_login();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : ''; ?>Dashboard User</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=1.2'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar">
            <div class="brand">
                <i class="fas fa-book-reader"></i> Perpustakaan
            </div>
            <ul class="nav-links">
                <?php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'] ?? 'index.php', PHP_URL_PATH));
if ($current_page == 'user' || $current_page == '')
    $current_page = 'index.php';
?>
                <li><a href="<?= base_url('user/index.php'); ?>" class="<?=($current_page == 'index.php') ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="<?= base_url('user/buku.php'); ?>" class="<?=($current_page == 'buku.php') ? 'active' : ''; ?>"><i class="fas fa-book"></i> Daftar Buku</a></li>
                <li><a href="<?= base_url('user/riwayat.php'); ?>" class="<?=($current_page == 'riwayat.php') ? 'active' : ''; ?>"><i class="fas fa-history"></i> Riwayat Pinjam</a></li>
                <li><a href="<?= base_url('logout.php'); ?>" style="color: var(--danger-color);"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h2>
                    <?php
if ($current_page == 'index.php')
    echo 'Dashboard Peminjam';
elseif ($current_page == 'buku.php')
    echo 'Daftar Buku';
elseif ($current_page == 'riwayat.php')
    echo 'Riwayat Peminjaman';
?>
                </h2>
                <div class="user-info">
                    Halo, <strong><?php echo $_SESSION['nama']; ?></strong>
                </div>
            </header>
