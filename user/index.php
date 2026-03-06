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
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
            <div class="card" style="background: var(--surface-secondary); text-align: center; border: 1px solid var(--border-color); padding: 1.5rem;">
                <i class="fas fa-book fa-3x" style="margin-bottom: 1rem; color: var(--primary-color);"></i>
                <h4>Daftar Buku</h4>
                <a href="<?= base_url('user/buku.php'); ?>" class="btn btn-primary btn-sm mt-3" style="width: 100%;">Lihat Semua</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
