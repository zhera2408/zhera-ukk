<?php require_once 'header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data User</h3>
        <a href="<?= base_url('admin/anggota_tambah.php'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah User</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$no = 1;
$query = "SELECT * FROM users ORDER BY id_user DESC";
$result = mysqli_query($conn, $query);
while ($row_raw = mysqli_fetch_assoc($result)):
    $row = array_change_key_case($row_raw, CASE_LOWER);
?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama'] ?? $row['name'] ?? ''); ?></td>
                        <td><?= htmlspecialchars($row['username'] ?? ''); ?></td>
                        <td>
                            <?php $role = strtolower(trim($row['role'] ?? '')); ?>
                            <?php if ($role == 'admin'): ?>
                                <span class="badge badge-danger">Admin</span>
                            <?php
    else: ?>
                                <span class="badge badge-success">User</span>
                            <?php
    endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/anggota_edit.php?id=' . ($row['id_user'] ?? '')); ?>" class="btn btn-primary btn-sm" style="background-color: var(--accent-color);"><i class="fas fa-edit"></i> Edit</a>
                            <a href="<?= base_url('admin/anggota_hapus.php?id=' . ($row['id_user'] ?? '')); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')"><i class="fas fa-trash"></i> Hapus</a>
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
