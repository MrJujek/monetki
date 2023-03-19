<?php
    include "./database/DatabaseData.php";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_errno) die('Brak połączenia z MySQL');
    $ran = json_decode($_POST['data']);

    $id = $ran->{'id'};
    $flag_name = $ran->{'flag'};
    $flag_name = $flag_name.".jpg";
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
    echo '<pre>';
    var_dump($ran);
    var_dump($flag_name);
    var_dump($flag_id);
    var_dump($response);
    echo '</pre>';

    $sql = "UPDATE data SET flag_id = ".$flag_id[0].", denomination = '".$denomination."', category = '".$category."', material_id = '".$response[0]['id']."', year = ".intval($year)." WHERE id = ".$id;
    $result = $conn->query($sql);

    $conn->close();
?>