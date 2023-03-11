<a href="/">Index</a>
<a href="/makeFlags.php">Make flags</a>

<?php
include "./database/DatabaseData.php";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_errno) die('Brak połączenia z MySQL');

$sql = "DELETE FROM `materials`";
$result = $conn->query($sql);

$materials = ['gold', 'silver', 'copper', 'zinc', 'aluminium', 'steel', 'bronze', 'nickel'];

for ($i = 0; $i < count($materials); $i++) {
     $sql = "INSERT INTO materials (id, material) VALUES ('$i','$materials[$i]')";
     $result = $conn->query($sql);
}
$conn->close();
?>