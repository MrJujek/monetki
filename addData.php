<?php
    include "./database/DatabaseData.php";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_errno) die('Brak połączenia z MySQL');
    $ran = json_decode($_POST['data']);

    $flag_name = $ran->{'flag'};
    $denomination = $ran->{'denomination'};
    $category = $ran->{'category'};
    $material_name = $ran->{'material'};
    $year = $ran->{'year'};

    // get flag_id
    $sql = "SELECT * FROM `flags` WHERE name = '$flag_name'";
    $res = $conn->query($sql);
    $response = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $response[] = $row;
    }
    
    for ($i = 0; $i < count($response); $i++) {
        $flag_id[$i] = $response[$i]["id"];
    } 

    // get material_id
    $sql = "SELECT * FROM `materials` WHERE material = '$material_name'";
    $res = $conn->query($sql);
    $response = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $response[] = $row;
    }
    
    for ($i = 0; $i < count($response); $i++) {
        $material_id[$i] = $response[$i]["id"];
    } 

    $sql = "INSERT INTO data (flag_id, denomination, category, material_id, year) VALUES ($flag_id[0], '$denomination', '$category', $material_id[0], ".intval($year).")";
    $result = $conn->query($sql);

    $conn->close();
?>