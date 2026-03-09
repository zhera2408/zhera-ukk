<?php require_once 'header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Buku</h3>
        <a href="<?= base_url('admin/buku_tambah.php'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Buku</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">NO </th>
                        <th style="width: 100px;">COVER</th>
                        <th>JUDUL</th>
                        <th>PENGARANG</th>
                        <th>PENERBIT</th>
                        <th style="width: 100px;">TAHUN</th>
                        <th style="width: 80px;">STOK</th>
                        <th style="width: 120px;">AKSI</th>
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
                        <td style="vertical-align: middle;"><?= $no++; ?></td>
                        <td style="vertical-align: middle;">
                            <?php if ($row['cover']): ?>
                                <img src="<?= base_url('assets/img/' . htmlspecialchars($row['cover'])); ?>" alt="Cover" style="width: 45px; height: 65px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <?php
    else: ?>
                                <div style="width: 45px; height: 65px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; border-radius: 4px; color: #94a3b8; font-size: 0.7rem;">NO IMG</div>
                            <?php
    endif; ?>
                        </td>
                        <td style="vertical-align: middle; font-weight: 500;"><?= htmlspecialchars($row['judul']); ?></td>
                        <td style="vertical-align: middle; color: var(--text-secondary);"><?= htmlspecialchars($row['pengarang']); ?></td>
                        <td style="vertical-align: middle; color: var(--text-secondary);"><?= htmlspecialchars($row['penerbit']); ?></td>
                        <td style="vertical-align: middle; color: var(--text-secondary);"><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                        <td style="vertical-align: middle;">
                            <span class="badge" style="background: #dcfce7; color: #166534; padding: 0.4rem 0.8rem; border-radius: 50px; font-weight: 600;">
                                <?= $row['stok']; ?>
                            </span>
                        </td>
                        <td style="vertical-align: middle;">
                            <div style="display: flex; gap: 0.4rem;">
                                <a href="<?= base_url('admin/buku_edit.php?id=' . $row['id_buku']); ?>" class="btn btn-sm" style="background-color: #0ea5e9; color: white; width: 32px; height: 32px; padding: 0;"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('admin/buku_hapus.php?id=' . $row['id_buku']); ?>" class="btn btn-sm" onclick="return confirm('Yakin ingin menghapus buku ini?')" style="background-color: #ef4444; color: white; width: 32px; height: 32px; padding: 0;"><i class="fas fa-trash"></i></a>
                            </div>
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
