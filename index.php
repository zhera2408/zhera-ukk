<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    }
    else {
        header("Location: user/index.php");
    }
}
else {
    header("Location: login.php");
}
exit();
?>
