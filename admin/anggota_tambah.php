<?php

require_once 'header.php';


if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    // Cek username
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah ada!');</script>";
    }
    else {
        $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='anggota.php';</script>";
        }
        else {
            echo "<script>alert('Gagal menambahkan data!');</script>";
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah User</h3>
        <a href="anggota.php" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama lengkap">
            </div>
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
