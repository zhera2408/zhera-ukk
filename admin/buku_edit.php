<?php

require_once 'header.php';


if (!isset($_GET['id'])) {
    header("Location: " . base_url('admin/buku.php'));
    exit();
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM buku WHERE id_buku = $id";
$result = mysqli_query($conn, $query);
$data_raw = mysqli_fetch_assoc($result);
$data = $data_raw ? array_change_key_case($data_raw, CASE_LOWER) : null;

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='" . base_url('admin/buku.php') . "';</script>";
    exit();
}

if (isset($_POST['edit'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun = (int)$_POST['tahun_terbit'];
    $stok = (int)$_POST['stok'];
    $cover = $data['cover'];

    // Upload Cover Baru
    if (isset($_FILES['cover']['name']) && $_FILES['cover']['name'] != '') {
        $filename = $_FILES['cover']['name'];
        $tmp_name = $_FILES['cover']['tmp_name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $ext;
        $upload_dir = '../assets/img/';

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($tmp_name, $upload_dir . $new_filename)) {
            // Hapus cover lama jika ada
            if ($cover && file_exists($upload_dir . $cover)) {
                unlink($upload_dir . $cover);
            }
            $cover = $new_filename;
        }
    }

    $query_update = "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun', stok='$stok', cover='$cover' WHERE id_buku=$id";

    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Buku berhasil diupdate!'); window.location='" . base_url('admin/buku.php') . "';</script>";
    }
    else {
        echo "<script>alert('Gagal mengupdate buku: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Buku</h3>
        <a href="<?= base_url('admin/buku.php'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Pengarang</label>
                <input type="text" name="pengarang" class="form-control" value="<?= htmlspecialchars($data['pengarang'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" value="<?= htmlspecialchars($data['penerbit'] ?? ''); ?>" required>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" value="<?= htmlspecialchars($data['tahun_terbit'] ?? ''); ?>" required min="1900" max="<?= date('Y'); ?>">
                </div>
                <div>
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($data['stok'] ?? 0); ?>" required min="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Cover Buku</label>
                <?php if ($data['cover'] ?? ''): ?>
                    <div style="margin-bottom: 0.5rem;">
                        <img src="<?= base_url('assets/img/' . $data['cover']); ?>" alt="Cover Saat Ini" style="width: 80px; height: 120px; object-fit: cover; border-radius: 4px;">
                    </div>
                <?php
endif; ?>
                <input type="file" name="cover" class="form-control" accept="image/*">
                <small style="color: var(--text-secondary);">Biarkan kosong jika tidak ingin mengubah cover.</small>
            </div>
            <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
