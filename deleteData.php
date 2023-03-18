<?php
    include "./database/DatabaseData.php";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_errno) die('Brak połączenia z MySQL');
    $ran = json_decode($_POST['data']);

    $id = $ran->{'id'};

    $sql = "DELETE FROM data WHERE id = $id";
    $result = $conn->query($sql);

    $conn->close();
?>