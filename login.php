<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: " . base_url('admin/index.php'));
    }
    else {
        header("Location: " . base_url('user/index.php'));
    }
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) >= 1) {
        $row_raw = mysqli_fetch_assoc($result);
        // Normalize column keys to lowercase to be case-insensitive
        $row = array_change_key_case($row_raw, CASE_LOWER);

        $raw_role = $row['role'] ?? '';
        $normalized_role = strtolower(trim($raw_role));

        // Fallback: if role is empty but username is 'admin', treat as admin
        if (empty($normalized_role) && strtolower(trim($row['username'] ?? '')) === 'admin') {
            $normalized_role = 'admin';
        }

        $_SESSION['user_id'] = $row['id_user'] ?? $row['id'] ?? null;
        $_SESSION['nama'] = $row['nama'] ?? $row['username'] ?? 'User';
        $_SESSION['role'] = $normalized_role ?: 'user';

        if ($_SESSION['role'] == 'admin') {
            header("Location: " . base_url('admin/index.php'));
        }
        else {
            header("Location: " . base_url('user/index.php'));
        }
        exit();
    }
    else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=2.0'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Selamat Datang</h1>
                <p>Silakan Masuk ke Perpustakaan Digital</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php
endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required autofocus placeholder="Masukkan username">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan password">
                </div>

                <button type="submit" class="btn btn-primary">Masuk</button>
            </form>
             <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #64748b;">
                Belum punya akun? <a href="<?= base_url('register.php'); ?>" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Daftar disini</a>
            </div>
        </div>
    </div>
</body>
</html>
