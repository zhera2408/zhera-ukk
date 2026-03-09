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
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar">
            <div class="brand">
                <i class="fas fa-book-reader"></i> Perpustakaan
            </div>
            <ul class="nav-links">
                <li><a href="<?= base_url('admin/index.php'); ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="<?= base_url('admin/anggota.php'); ?>" class="<?php echo(basename($_SERVER['PHP_SELF']) == 'anggota.php' || basename($_SERVER['PHP_SELF']) == 'anggota_tambah.php' || basename($_SERVER['PHP_SELF']) == 'anggota_edit.php') ? 'active' : ''; ?>"><i class="fas fa-users"></i> Data User</a></li>
                <li><a href="<?= base_url('admin/buku.php'); ?>" class="<?php echo(basename($_SERVER['PHP_SELF']) == 'buku.php' || basename($_SERVER['PHP_SELF']) == 'buku_tambah.php' || basename($_SERVER['PHP_SELF']) == 'buku_edit.php') ? 'active' : ''; ?>"><i class="fas fa-book"></i> Data Buku</a></li>
                <li><a href="<?= base_url('admin/peminjaman.php'); ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'peminjaman.php' ? 'active' : ''; ?>"><i class="fas fa-clipboard-list"></i> Peminjaman</a></li>
                <li><a href="<?= base_url('logout.php'); ?>" style="color: var(--danger-color);"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h2>
                    <button class="btn btn-sm btn-primary" onclick="toggleSidebar()" style="margin-right: 1rem; display: none;" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                    <?php
if (basename($_SERVER['PHP_SELF']) == 'index.php')
    echo 'Dashboard Admin';
elseif (strpos(basename($_SERVER['PHP_SELF']), 'anggota') !== false)
    echo 'Kelola Data User';
elseif (strpos(basename($_SERVER['PHP_SELF']), 'buku') !== false)
    echo 'Kelola Data Buku';
elseif (strpos(basename($_SERVER['PHP_SELF']), 'peminjaman') !== false)
    echo 'Data Peminjaman';
?>
                </h2>
                <div class="user-info">
                    Halo, <strong><?php echo $_SESSION['nama']; ?></strong>
                </div>
            </header>
