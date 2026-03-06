<?php

$title = 'Daftar Buku';
require_once 'header.php';

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Katalog Buku</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 2rem;">
            <?php
$query = mysqli_query($conn, "SELECT * FROM buku ORDER BY judul ASC");
if (mysqli_num_rows($query) > 0):
    while ($row = mysqli_fetch_assoc($query)):
?>
                <div class="card" style="padding: 0; overflow: hidden; border: 1px solid var(--border-color); background: var(--surface-primary);">
                    <div style="aspect-ratio: 2/3; overflow: hidden; background: #f1f5f9;">
                        <?php if ($row['cover']): ?>
                            <img src="<?= base_url('assets/img/' . htmlspecialchars($row['cover'])); ?>" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php
        else: ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 0.9rem;">No Cover</div>
                        <?php
        endif; ?>
                    </div>
                    <div style="padding: 1rem;">
                        <h4 style="margin-bottom: 0.5rem; font-size: 1rem; color: var(--text-primary);"><?= htmlspecialchars($row['judul']); ?></h4>
                        <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">Oleh: <?= htmlspecialchars($row['pengarang']); ?></p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                             <span class="badge <?= $row['stok'] > 0 ? 'badge-success' : 'badge-danger'; ?>" style="font-size: 0.75rem;">
                                <?= $row['stok'] > 0 ? 'Tersedia: ' . $row['stok'] : 'Stok Habis'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php
    endwhile;
else:
?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--text-secondary);">
                    <i class="fas fa-search fa-3x" style="margin-bottom: 1rem; opacity: 0.2;"></i>
                    <p>Belum ada buku di perpustakaan.</p>
                </div>
            <?php
endif; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
