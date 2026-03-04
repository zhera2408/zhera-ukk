<?php

require_once 'header.php';


if (isset($_POST['tambah'])) {
    $id_user = (int)$_POST['id_user'];
    $id_buku = (int)$_POST['id_buku'];
    $tgl_pinjam = $_POST['tanggal_pinjam'];
    $tgl_kembali = $_POST['tanggal_kembali'];

    // Validasi stok buku
    $cek_stok = mysqli_query($conn, "SELECT stok FROM buku WHERE id_buku = $id_buku");
    $data_buku = mysqli_fetch_assoc($cek_stok);

    if ($data_buku['stok'] > 0) {
        $query = "INSERT INTO transaksi (id_user, id_buku, tanggal_pinjam, tanggal_kembali, status) VALUES ('$id_user', '$id_buku', '$tgl_pinjam', '$tgl_kembali', 'dipinjam')";

        if (mysqli_query($conn, $query)) {
            // Kurangi stok
            mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id_buku = $id_buku");
            echo "<script>alert('Peminjaman berhasil ditambahkan!'); window.location='peminjaman.php';</script>";
        }
        else {
            echo "<script>alert('Gagal menambahkan peminjaman: " . mysqli_error($conn) . "');</script>";
        }
    }
    else {
        echo "<script>alert('Stok buku habis!');</script>";
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Peminjaman</h3>
        <a href="peminjaman.php" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="form-group">
                <label class="form-label">Nama Peminjam</label>
                <select name="id_user" class="form-control" required>
                    <option value="">-- Pilih User --</option>
                    <?php
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY nama ASC");
while ($user = mysqli_fetch_assoc($users)):
?>
                        <option value="<?= $user['id_user']; ?>"><?= $user['nama']; ?> (<?= $user['username']; ?>)</option>
                    <?php
endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Buku</label>
                <select name="id_buku" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php
$bukus = mysqli_query($conn, "SELECT * FROM buku WHERE stok > 0 ORDER BY judul ASC");
while ($buku = mysqli_fetch_assoc($bukus)):
?>
                        <option value="<?= $buku['id_buku']; ?>"><?= $buku['judul']; ?> (Stok: <?= $buku['stok']; ?>)</option>
                    <?php
endwhile; ?>
                </select>
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>
                <div>
                    <label class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')); ?>" required>
                </div>
            </div>

            <button type="submit" name="tambah" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Transaksi</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
