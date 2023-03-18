<a href="/">Index</a>
<a href="/makeMaterials.php">Make materials</a>

<?php
include "./database/DatabaseData.php";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_errno) die('Brak połączenia z MySQL');

$sql = "DELETE FROM `flags`";
$result = $conn->query($sql);

$dir    = "./flags/";
$files = scandir($dir);

for ($i = 2; $i < count($files); $i++) {
     $image = $dir.$files[$i];
     $type = pathinfo($image, PATHINFO_EXTENSION);
     $data = file_get_contents($image);
     $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
     $sql = "INSERT INTO flags (id, flag, name) VALUES ('".($i-2)."','$dataUri', '$files[$i]')";
     $result = $conn->query($sql);
}
$conn->close();
?>