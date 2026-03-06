<?php
require_once '../config.php';
check_login();
check_admin();

if (isset($_GET['id'])) {
    $id_transaksi = (int)$_GET['id'];

    // Get transaction data
    $query = "SELECT * FROM transaksi WHERE id_transaksi = $id_transaksi AND status = 'dipinjam'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_buku = $row['id_buku'];

        // Update transaction status
        mysqli_query($conn, "UPDATE transaksi SET status = 'dikembalikan' WHERE id_transaksi = $id_transaksi");

        // Return stock
        mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id_buku = $id_buku");

        echo "<script>alert('Buku berhasil dikembalikan!'); window.location='" . base_url('admin/peminjaman.php') . "';</script>";
        exit;
    }
}

header("Location: " . base_url('admin/peminjaman.php'));
?>
