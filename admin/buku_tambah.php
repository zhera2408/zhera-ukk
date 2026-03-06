<?php

require_once 'header.php';


if (isset($_POST['tambah'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun = (int)$_POST['tahun_terbit'];
    $stok = (int)$_POST['stok'];

    // Upload Cover
    $cover = '';
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
            $cover = $new_filename;
        }
        else {
            echo "<script>alert('Gagal mengupload cover!');</script>";
        }
    }

    $query = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok, cover) VALUES ('$judul', '$pengarang', '$penerbit', '$tahun', '$stok', '$cover')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location='" . base_url('admin/buku.php') . "';</script>";
    }
    else {
        echo "<script>alert('Gagal menambahkan buku: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Buku</h3>
        <a href="<?= base_url('admin/buku.php'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul buku">
            </div>
            <div class="form-group">
                <label class="form-label">Pengarang</label>
                <input type="text" name="pengarang" class="form-control" required placeholder="Masukkan nama pengarang">
            </div>
            <div class="form-group">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" required placeholder="Masukkan nama penerbit">
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" required placeholder="Contoh: 2024" min="1900" max="<?= date('Y'); ?>">
                </div>
                <div>
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" required placeholder="Jumlah stok" min="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Cover Buku</label>
                <input type="file" name="cover" class="form-control" accept="image/*">
                <small style="color: var(--text-secondary);">Format: JPG, PNG, JPEG. Maksimal 2MB. (Opsional)</small>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
