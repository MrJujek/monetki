<a href="/makeFlags.php">Go to make flags</a>
<?php
include "./database/DatabaseData.php";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_errno) die('Brak połączenia z MySQL');

$sql = "SELECT * FROM `flags`";
$res = $conn->query($sql);
$response = array();
while ($row = mysqli_fetch_assoc($res)) {
    $response[] = $row;
}
echo '<pre>';
var_dump($response);
echo '</pre>';

for ($i = 0; $i < count($response); $i++) {
    echo '<img src="'.$response[$i]['flag'].'" alt="flag" width="50" height="50">';
}
$conn->close();     
?>
<table border=1>
    <tr>
        <th>Flag</th>
        <th>Nominał</th>
        <th>Category</th>
        <th>Material</th>
        <th>Year</th>
        <th>Delete</th>
    </tr>
    <?php
    for ($i = 0; $i < count($response); $i++) {
        echo '<tr>';
            echo '<td><img src="'.$response[$i]['flag'].'" alt="flag" width="50" height="50"></td>';
        echo '</tr>';
    }
    ?>
</table>