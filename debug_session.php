<?php
require_once 'config.php';

echo "<h2>Session Debug</h2><pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h2>Users in DB</h2>";
$res = mysqli_query($conn, "SELECT id_user, nama, username, role FROM users");
if ($res) {
    echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Nama</th><th>Username</th><th>Role</th><th>Role (hex)</th></tr>";
    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td>" . $row['id_user'] . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>" . bin2hex($row['role']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
else {
    echo "Error: " . mysqli_error($conn);
}
?>
