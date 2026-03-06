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
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role = 'user'; // Default role is user

    // Check if username exists
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Username sudah digunakan!";
    }
    else {
        $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            $success = "Registrasi berhasil! Silakan login.";
        }
        else {
            $error = "Terjadi kesalahan: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan Digital</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .auth-container {
            background: linear-gradient(135deg, #f3b4ffff 0%, #efb0f1ff 100%);
        }
        .auth-card {
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-out;
        }
        .auth-header h1 {
            color: #f19febff;
            font-weight: 800;
        }
        .btn-primary {
            width: 100%;
            padding: 0.8rem;
            font-size: 1rem;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(226, 165, 238, 0.2);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Daftar Akun</h1>
                <p>Buat akun baru untuk mengakses perpustakaan</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php
endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = '<?= base_url('login.php'); ?>';
                    }, 2000);
                </script>
            <?php
endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" required placeholder="Masukkan nama lengkap">
                </div>

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required placeholder="Masukkan username">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan password">
                </div>

                <button type="submit" class="btn btn-primary">Daftar</button>
            </form>
             <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #64748b;">
                Sudah punya akun? <a href="<?= base_url('login.php'); ?>" style="color: #e8a4f1ff; text-decoration: none; font-weight: 600;">Login disini</a>
            </div>
        </div>
    </div>
</body>
</html>
