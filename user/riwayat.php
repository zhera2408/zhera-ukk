<?php
$title = 'Riwayat Pinjam';
require_once 'header.php';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history" style="color: var(--primary-color);"></i> Riwayat Peminjaman</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$id_user = $_SESSION['user_id'];

// Case-sensitivity and existence check for different server configurations
$table_check = mysqli_query($conn, "SHOW TABLES LIKE 'transaksi'");
if (mysqli_num_rows($table_check) == 0) {
    $table_check_alt = mysqli_query($conn, "SHOW TABLES LIKE 'Transaksi'");
    $table_name = (mysqli_num_rows($table_check_alt) > 0) ? 'Transaksi' : 'transaksi';
}
else {
    $table_name = 'transaksi';
}

$query_text = "SELECT t.*, b.judul 
                                  FROM $table_name t 
                                  LEFT JOIN buku b ON t.id_buku = b.id_buku 
                                  WHERE t.id_user = $id_user 
                                  ORDER BY t.id_transaksi DESC";

$result = @mysqli_query($conn, $query_text);
$no = 1;

if ($result && mysqli_num_rows($result) > 0):
    while ($row_raw = mysqli_fetch_assoc($result)):
        $row = array_change_key_case($row_raw, CASE_LOWER);
        $judul = $row['judul'] ?? 'Buku Tidak Terdata';
        $status = $row['status'] ?? 'dipinjam';
?>
                        <tr>
                            <td><span style="font-weight: 700; color: var(--text-secondary);"><?= $no++; ?></span></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 32px; height: 32px; background: var(--surface-secondary); display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                        <i class="fas fa-book" style="color: var(--primary-color); font-size: 0.8rem;"></i>
                                    </div>
                                    <span style="font-weight: 600;"><?= htmlspecialchars($judul); ?></span>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.9rem;">
                                    <i class="far fa-calendar-alt" style="margin-right: 0.5rem; color: var(--text-secondary);"></i>
                                    <?= date('d M Y', strtotime($row['tanggal_pinjam'])); ?>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.9rem; color: var(--danger-color); font-weight: 500;">
                                    <i class="far fa-clock" style="margin-right: 0.5rem;"></i>
                                    <?= date('d M Y', strtotime($row['tanggal_kembali'])); ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($status == 'dipinjam'): ?>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-hourglass-half" style="margin-right: 4px;"></i> Dipinjam
                                    </span>
                                <?php
        else: ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle" style="margin-right: 4px;"></i> Kembali
                                    </span>
                                <?php
        endif; ?>
                            </td>
                        </tr>
                    <?php
    endwhile;
else:
?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 4rem 1rem;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem; opacity: 0.5;">
                                    <i class="fas fa-clipboard-list fa-4x"></i>
                                    <p style="font-weight: 500;">Belum ada riwayat peminjaman.</p>
                                    <a href="<?= base_url('user/buku.php'); ?>" class="btn btn-primary btn-sm">Pinjam Buku Sekarang</a>
                                </div>
                            </td>
                        </tr>
                    <?php
endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
