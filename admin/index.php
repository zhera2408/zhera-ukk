<?php require_once 'header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang</h3>
    </div>
    <div class="card-body">
        <p>Selamat datang di halaman administrator. Anda dapat mengelola data buku, user, dan peminjaman di sini.</p>
        
        <div class="stats-grid" style="margin-top: 2rem;">
            <a href="<?= base_url('admin/anggota.php'); ?>" class="stat-card">
                <div class="stat-info">
                    <h3>
                        <?php
try {
    $q = mysqli_query($conn, "SELECT * FROM users");
    $users_count = $q ? mysqli_num_rows($q) : 0;
}
catch (Exception $e) {
    $users_count = 0;
}
echo $users_count;
?>
                    </h3>
                    <p>Total User</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users fa-2x" style="color: var(--primary-color);"></i>
                </div>
            </a>

            <a href="<?= base_url('admin/buku.php'); ?>" class="stat-card">
                <div class="stat-info">
                    <h3>
                        <?php
try {
    $q = mysqli_query($conn, "SELECT * FROM buku");
    $books_count = $q ? mysqli_num_rows($q) : 0;
}
catch (Exception $e) {
    $books_count = 0;
}
echo $books_count;
?>
                    </h3>
                    <p>Total Buku</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-book fa-2x" style="color: var(--accent-color);"></i>
                </div>
            </a>

            <a href="<?= base_url('admin/peminjaman.php'); ?>" class="stat-card">
                <div class="stat-info">
                    <h3>
                        <?php
try {
    $q = mysqli_query($conn, "SELECT * FROM transaksi WHERE status='dipinjam'");
    $loans_count = $q ? mysqli_num_rows($q) : 0;
}
catch (Exception $e) {
    $loans_count = 0;
}
echo $loans_count;
?>
                    </h3>
                    <p>Sedang Dipinjam</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-clock fa-2x" style="color: var(--warning-color, orange);"></i>
                </div>
            </a>

            <a href="<?= base_url('admin/peminjaman.php'); ?>" class="stat-card">
                <div class="stat-info">
                    <h3>
                        <?php
try {
    $query = mysqli_query($conn, "SELECT * FROM transaksi");
    $total_transaksi = $query ? mysqli_num_rows($query) : 0;
}
catch (Exception $e) {
    $total_transaksi = 0;
}
echo $total_transaksi;
?>
                    </h3>
                    <p>Total Transaksi</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-exchange-alt fa-2x" style="color: var(--success-color);"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
