<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: " . base_url('admin/index.php'));
    }
    else {
        header("Location: " . base_url('user/index.php'));
    }
}
else {
    header("Location: " . base_url('login.php'));
}
exit();
?>
