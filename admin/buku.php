<?php require_once 'header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Buku</h3>
        <a href="buku_tambah.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Buku</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cover</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$no = 1;
$query = "SELECT * FROM buku ORDER BY id_buku DESC";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)):
?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <?php if ($row['cover']): ?>
                                <img src="../assets/img/<?= htmlspecialchars($row['cover']); ?>" alt="Cover" style="width: 50px; height: 75px; object-fit: cover; border-radius: 4px;">
                            <?php
    else: ?>
                                <div style="width: 50px; height: 75px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; border-radius: 4px; color: #64748b; font-size: 0.8rem;">No Cover</div>
                            <?php
    endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['judul']); ?></td>
                        <td><?= htmlspecialchars($row['pengarang']); ?></td>
                        <td><?= htmlspecialchars($row['penerbit']); ?></td>
                        <td><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                        <td>
                            <span class="badge <?= $row['stok'] > 0 ? 'badge-success' : 'badge-danger'; ?>">
                                <?= $row['stok']; ?>
                            </span>
                        </td>
                        <td>
                            <a href="buku_edit.php?id=<?= $row['id_buku']; ?>" class="btn btn-primary btn-sm" style="background-color: var(--accent-color);"><i class="fas fa-edit"></i></a>
                            <a href="buku_hapus.php?id=<?= $row['id_buku']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus buku ini?')" style="background-color: var(--danger-color);"><i class="fas fa-trash"></i></a>
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
