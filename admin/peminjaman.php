<?php require_once 'header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Peminjaman</h3>
        <a href="transaksi_tambah.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Peminjaman</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$no = 1;
$query = "SELECT transaksi.*, users.nama as nama_user, buku.judul as judul_buku 
                              FROM transaksi 
                              JOIN users ON transaksi.id_user = users.id_user 
                              JOIN buku ON transaksi.id_buku = buku.id_buku 
                              ORDER BY transaksi.id_transaksi DESC";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)):
?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_user']); ?></td>
                        <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_kembali'])); ?></td>
                        <td>
                            <?php if ($row['status'] == 'dipinjam'): ?>
                                <span class="badge badge-warning">Dipinjam</span>
                            <?php
    else: ?>
                                <span class="badge badge-success">Dikembalikan</span>
                            <?php
    endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'dipinjam'): ?>
                                <a href="transaksi_kembali.php?id=<?= $row['id_transaksi']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi pengembalian buku?')" style="background-color: var(--success-color);"><i class="fas fa-check"></i> Kembalikan</a>
                            <?php
    else: ?>
                                <span style="color: var(--text-secondary); font-size: 0.9rem;">Selesai</span>
                            <?php
    endif; ?>
                        </td>
                    </tr>
                    <?php
endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
