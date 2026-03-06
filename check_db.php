<?php
require_once 'config.php';

echo "<h2>Database Diagnostic</h2>";
echo "Host: " . (getenv('DB_HOST') ?: 'localhost') . "<br>";
echo "Database: " . (getenv('DB_NAME') ?: 'library_ukk') . "<br>";

$result = mysqli_query($conn, "SHOW TABLES");
if (!$result) {
    die("Error listing tables: " . mysqli_error($conn));
}

echo "<h3>Tables in database:</h3><ul>";
while ($row = mysqli_fetch_row($result)) {
    echo "<li>" . $row[0] . "</li>";
}
echo "</ul>";

echo "<h3>Column check for 'transaksi' (if exists):</h3>";
$check = mysqli_query($conn, "SHOW COLUMNS FROM transaksi");
if ($check) {
    echo "<ul>";
    while ($col = mysqli_fetch_assoc($check)) {
        echo "<li>" . $col['Field'] . " (" . $col['Type'] . ")</li>";
    }
    echo "</ul>";
}
else {
    echo "Table 'transaksi' not found (lowercase).<br>";
}

$check2 = mysqli_query($conn, "SHOW COLUMNS FROM Transaksi");
if ($check2) {
    echo "Table 'Transaksi' found (PascalCase).<br>";
}
?>
