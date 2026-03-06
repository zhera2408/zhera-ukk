<?php
$title = 'Daftar Buku';
require_once 'header.php';
?>

<div style="margin-bottom: 2rem;">
    <h2 style="margin-bottom: 0.5rem;"><i class="fas fa-book-open" style="color: var(--primary-color);"></i> Katalog Perpustakaan</h2>
    <p style="color: var(--text-secondary);">Temukan buku favorit Anda dan mulai meminjam sekarang juga.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 2rem;">
    <?php
// Fixing "Unknown column 'judul' in 'order clause'" by ordering by id_buku instead
$query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");

if ($query && mysqli_num_rows($query) > 0):
    while ($row = mysqli_fetch_assoc($query)):
        // Normalize casing just in case
        $row = array_change_key_case($row, CASE_LOWER);
        $id_buku = $row['id_buku'];
        $judul = $row['judul'] ?? 'Untitled';
        $pengarang = $row['pengarang'] ?? 'Anonim';
        $cover = $row['cover'] ?? '';
        $stok = (int)($row['stok'] ?? 0);
?>
        <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; height: 100%;">
            <div style="position: relative; aspect-ratio: 2/3; overflow: hidden; background: var(--surface-secondary);">
                <?php if ($cover): ?>
                    <img src="<?= base_url('assets/img/' . htmlspecialchars($cover)); ?>" alt="Cover" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                <?php
        else: ?>
                    <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--text-secondary); opacity: 0.5;">
                        <i class="fas fa-book fa-4x" style="margin-bottom: 1rem;"></i>
                        <span>No Cover</span>
                    </div>
                <?php
        endif; ?>
                
                <div style="position: absolute; top: 1rem; right: 1rem;">
                    <span class="badge <?= $stok > 0 ? 'badge-success' : 'badge-danger'; ?>" style="box-shadow: var(--shadow-md);">
                        <?= $stok > 0 ? $stok . ' Tersedia' : 'Habis'; ?>
                    </span>
                </div>
            </div>
            
            <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-primary); line-height: 1.3;">
                        <?= htmlspecialchars($judul); ?>
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1.5rem;">
                        <i class="fas fa-user-edit" style="margin-right: 0.5rem; opacity: 0.7;"></i> 
                        <?= htmlspecialchars($pengarang); ?>
                    </p>
                </div>
                
                <?php if ($stok > 0): ?>
                    <div style="text-align: center; color: var(--text-secondary); font-size: 0.8rem; font-style: italic; margin-bottom: 1rem;">
                        Silakan hubungi petugas untuk meminjam buku ini.
                    </div>
                <?php
        else: ?>
                    <button class="btn btn-secondary btn-sm" disabled style="width: 100%; opacity: 0.6; cursor: not-allowed;">
                        Tidak Tersedia
                    </button>
                <?php
        endif; ?>
            </div>
        </div>
    <?php
    endwhile;
else:
?>
        <div style="grid-column: 1 / -1; padding: 5rem 2rem; text-align: center; background: white; border-radius: var(--border-radius-lg);">
            <i class="fas fa-search fa-4x" style="margin-bottom: 1.5rem; color: var(--primary-light); opacity: 0.5;"></i>
            <h3>Belum ada koleksi buku</h3>
            <p style="color: var(--text-secondary);">Silakan kembali lagi nanti.</p>
        </div>
    <?php
endif; ?>
</div>

<?php require_once 'footer.php'; ?>
