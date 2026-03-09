<?php
require_once '../config.php';
check_login();
check_admin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=2.0'); ?>">
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
if ($current_page == 'admin' || $current_page == '')
    $current_page = 'index.php';
?>
                <li><a href="<?= base_url('admin/index.php'); ?>" class="<?=($current_page == 'index.php') ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="<?= base_url('admin/anggota.php'); ?>" class="<?=(strpos($current_page, 'anggota') !== false) ? 'active' : ''; ?>"><i class="fas fa-users"></i> Data User</a></li>
                <li><a href="<?= base_url('admin/buku.php'); ?>" class="<?=(strpos($current_page, 'buku') !== false) ? 'active' : ''; ?>"><i class="fas fa-book"></i> Data Buku</a></li>
                <li><a href="<?= base_url('admin/peminjaman.php'); ?>" class="<?=(strpos($current_page, 'peminjaman') !== false || strpos($current_page, 'transaksi') !== false) ? 'active' : ''; ?>"><i class="fas fa-clipboard-list"></i> Peminjaman</a></li>
                <li><a href="<?= base_url('logout.php'); ?>" style="color: var(--danger-color);"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h2>
                    <button class="btn btn-sm btn-primary" onclick="toggleSidebar()" style="margin-right: 1rem; display: none;" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                    <?php
if ($current_page == 'index.php')
    echo 'Dashboard Admin';
elseif (strpos($current_page, 'anggota') !== false)
    echo 'Kelola Data User';
elseif (strpos($current_page, 'buku') !== false)
    echo 'Kelola Data Buku';
elseif (strpos($current_page, 'peminjaman') !== false || strpos($current_page, 'transaksi') !== false)
    echo 'Data Peminjaman';
?>
                </h2>
                <div class="user-info">
                    Halo, <strong><?php echo $_SESSION['nama']; ?></strong>
                </div>
            </header>
