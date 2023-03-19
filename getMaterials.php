<?php
    include "./database/DatabaseData.php";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_errno) die('Brak połączenia z MySQL');

    $sql = "SELECT material FROM `materials`";
    $res = $conn->query($sql);

    $response = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $response[] = $row;
    }

    for ($i = 0; $i < count($response); $i++) {
        $data = $data.explode(".",$response[$i]['material'])[0];
        if ($i != count($response) - 1) {
            $data = $data.",";
        }
    }

    header("Content-Type: application/json");
    echo json_encode($data);
    
    $conn->close();
    exit();
?>