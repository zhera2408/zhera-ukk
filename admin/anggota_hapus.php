<?php
require_once '../config.php';
check_login();
check_admin();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Check constraint
    $check = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_user = $id");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('User tidak dapat dihapus karena memiliki riwayat peminjaman!'); window.location='anggota.php';</script>";
        exit;
    }

    $query = "DELETE FROM users WHERE id_user = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: anggota.php");
    }
    else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
}
?>
