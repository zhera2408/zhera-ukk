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
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar">
            <div class="brand">
                <i class="fas fa-book-reader"></i> Perpustakaan
            </div>
            <ul class="nav-links">
                <?php $current_page = basename($_SERVER['REQUEST_URI'] ?: 'index.php'); ?>
                <li><a href="<?= base_url('user/index.php'); ?>" class="<?=($current_page == 'index.php' || $current_page == 'user' || $current_page == '') ? 'active' : ''; ?>"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="<?= base_url('user/buku.php'); ?>" class="<?=($current_page == 'buku.php') ? 'active' : ''; ?>"><i class="fas fa-book"></i> Daftar Buku</a></li>
                <li><a href="<?= base_url('user/riwayat.php'); ?>" class="<?=($current_page == 'riwayat.php') ? 'active' : ''; ?>"><i class="fas fa-history"></i> Riwayat Pinjam</a></li>
                <li><a href="<?= base_url('logout.php'); ?>" style="color: var(--danger-color);"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h2>Dashboard Peminjam</h2>
                <div class="user-info">
                    Halo, <strong><?php echo $_SESSION['nama']; ?></strong>
                </div>
            </header>
