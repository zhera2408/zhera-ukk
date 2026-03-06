<?php

$title = 'Riwayat Pinjam';
require_once 'header.php';

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Peminjaman Saya</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$id_user = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT t.*, b.judul FROM transaksi t JOIN buku b ON t.id_buku = b.id_buku WHERE t.id_user = $id_user ORDER BY t.id_transaksi DESC");
$no = 1;
if (mysqli_num_rows($query) > 0):
    while ($row = mysqli_fetch_assoc($query)):
?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_kembali'])); ?></td>
                            <td>
                                <?php if ($row['status'] == 'dipinjam'): ?>
                                    <span class="badge badge-warning">Sedang Dipinjam</span>
                                <?php
        else: ?>
                                    <span class="badge badge-success">Sudah Dikembalikan</span>
                                <?php
        endif; ?>
                            </td>
                        </tr>
                    <?php
    endwhile;
else:
?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-secondary);">Anda belum pernah meminjam buku.</td>
                        </tr>
                    <?php
endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
