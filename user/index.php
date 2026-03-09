<?php

$title = 'Dashboard';
require_once 'header.php';

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang</h3>
    </div>
    <div class="card-body">
        <p>Selamat datang di perpustakaan digital. Silakan lihat daftar buku untuk meminjam.</p>
        
        <div class="stats-grid" style="margin-top: 2rem;">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Daftar Buku</h3>
                    <a href="<?= base_url('user/buku.php'); ?>" class="btn btn-primary btn-sm mt-2">Lihat Semua</a>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-book fa-3x" style="color: var(--primary-color);"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
