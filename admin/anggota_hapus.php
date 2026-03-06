<?php
require_once '../config.php';
check_login();
check_admin();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Check constraint
    $check = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_user = $id");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('User tidak dapat dihapus karena memiliki riwayat peminjaman!'); window.location='" . base_url('admin/anggota.php') . "';</script>";
        exit;
    }

    $query = "DELETE FROM users WHERE id_user = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: " . base_url('admin/anggota.php'));
    }
    else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
}
?>
