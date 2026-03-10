<?php
require_once '../config.php';

if (!$conn) {
    die("Koneksi gagal");
}

// Cek kolom di tabel users
$result = mysqli_query($conn, "SHOW COLUMNS FROM users");
$columns = [];
while ($row = mysqli_fetch_assoc($result)) {
    $columns[] = $row['Field'];
}

// Jika ada "name" tapi tidak ada "nama", ubah namanya
if (in_array('name', $columns) && !in_array('nama', $columns)) {
    mysqli_query($conn, "ALTER TABLE users CHANGE `name` `nama` VARCHAR(100) NOT NULL");
}
elseif (!in_array('nama', $columns)) {
    mysqli_query($conn, "ALTER TABLE users ADD `nama` VARCHAR(100) NOT NULL AFTER `id_user`");
}

// Cek kolom 'role'
if (!in_array('role', $columns)) {
    mysqli_query($conn, "ALTER TABLE users ADD `role` ENUM('admin','user') NOT NULL DEFAULT 'user'");
}

// Hapus data, ganti dengan yg baru persis localhost
mysqli_query($conn, "TRUNCATE TABLE users");

$users = [
    ['zhera tiara', 'rara', md5('rara'), 'admin'],
    ['Siswa Teladan', 'siswa', md5('user'), 'user'],
    ['Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin']
];

foreach ($users as $u) {
    $stmt = mysqli_prepare($conn, "INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $u[0], $u[1], $u[2], $u[3]);
    mysqli_stmt_execute($stmt);
}

echo "<h1>Data Berhasil Disinkronisasi!</h1>";
echo "<p>Silakan kembali ke <a href='anggota.php'>Data User</a> untuk melihat perubahannya.</p>";
?>
