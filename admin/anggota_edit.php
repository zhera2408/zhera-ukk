<?php

require_once 'header.php';


if (!isset($_GET['id'])) {
    header("Location: " . base_url('admin/anggota.php'));
    exit();
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM users WHERE id_user = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='" . base_url('admin/anggota.php') . "';</script>";
    exit();
}

if (isset($_POST['edit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = $_POST['role'];

    // Cek jika username diubah dan sudah ada yang pakai
    if ($username != $data['username']) {
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('Username sudah ada!'); window.location='" . base_url('admin/anggota_edit.php?id=' . $id) . "';</script>";
            exit();
        }
    }

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $query_update = "UPDATE users SET nama='$nama', username='$username', password='$password', role='$role' WHERE id_user=$id";
    }
    else {
        $query_update = "UPDATE users SET nama='$nama', username='$username', role='$role' WHERE id_user=$id";
    }

    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='" . base_url('admin/anggota.php') . "';</script>";
    }
    else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit User</h3>
        <a href="<?= base_url('admin/anggota.php'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                <small style="color: var(--text-secondary);">*Hanya isi jika ingin mengganti password</small>
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="user" <?= $data['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                </select>
            </div>
            <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
