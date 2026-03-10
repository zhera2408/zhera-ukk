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
        // Cek kolom di tabel users (Aiven mungkin pakai 'name', localhost pakai 'nama')
        $col_result = mysqli_query($conn, "SHOW COLUMNS FROM users");
        $columns = [];
        while ($col_row = mysqli_fetch_assoc($col_result)) {
            $columns[] = $col_row['Field'];
        }

        $nama_col = 'nama';
        if (in_array('name', $columns) && !in_array('nama', $columns)) {
            $nama_col = 'name';
        }
        elseif (!in_array('name', $columns) && !in_array('nama', $columns)) {
            // Jika dua-duanya tidak ada, coba tambahkan 'nama' on the fly
            mysqli_query($conn, "ALTER TABLE users ADD `nama` VARCHAR(100) NOT NULL AFTER `id_user`");
            $nama_col = 'nama';
        }

        // Cek kolom 'role'
        if (!in_array('role', $columns)) {
            mysqli_query($conn, "ALTER TABLE users ADD `role` ENUM('admin','user') NOT NULL DEFAULT 'user'");
        }

        // Check for 'nama_lengkap' and include it to avoid default value constraint errors
        $insert_fields = [$nama_col, 'username', 'password', 'role'];
        $insert_values = ["'$nama'", "'$username'", "'$password'", "'$role'"];
        if (in_array('nama_lengkap', $columns)) {
            // Also insert into nama_lengkap if that column exists
            if ($nama_col !== 'nama_lengkap') {
                $insert_fields[] = 'nama_lengkap';
                $insert_values[] = "'$nama'";
            }
        }
        $fields_str = implode(', ', $insert_fields);
        $values_str = implode(', ', $insert_values);

        $query = "INSERT INTO users ($fields_str) VALUES ($values_str)";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='" . base_url('admin/anggota.php') . "';</script>";
        }
        else {
            echo "<script>alert('Gagal menambahkan data " . mysqli_error($conn) . " !');</script>";
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah User</h3>
        <a href="<?= base_url('admin/anggota.php'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
