<?php
require_once '../config.php';
check_login();
check_admin();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Check if book is in transaction
    $check = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_buku = $id");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Buku tidak dapat dihapus karena ada di riwayat peminjaman!'); window.location='buku.php';</script>";
        exit;
    }

    $query = "DELETE FROM buku WHERE id_buku = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: buku.php");
    }
    else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
}
else {
    header("Location: buku.php");
}
?>
