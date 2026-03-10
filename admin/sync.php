<?php
require_once '../config.php';

// Jika tidak ada koneksi, batalkan
if (!$conn) {
    die("Koneksi gagal");
}

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
