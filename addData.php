<?php
    include "./database/DatabaseData.php";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_errno) die('Brak połączenia z MySQL');
    $ran = json_decode($_POST['data']);

    echo '<pre>';
    var_dump(json_decode($_POST['data']));
    echo $ran->{'flag'};
    echo '</pre>';

    $flag_name = $ran->{'flag'};
    $denomination = $ran->{'denomination'};
    $category = $ran->{'category'};
    $material_name = $ran->{'material'};
    $year = $ran->{'year'};

    $sql = "SELECT * FROM `flags` WHERE name = '$flag_name'";
    $flag_id = $conn->query($sql);
    echo "EEEEEE";
    var_dump($flag_id);

    $sql = "INSERT INTO data (flag_id, denomination, category, material_id, year) VALUES (1, '$denomination', '$category', 1, ".intval($year).")";
    $result = $conn->query($sql);

    $conn->close();
?>