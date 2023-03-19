<link href="./style/style.css" rel="stylesheet" type="text/css">
<script src="./scripts/add.js" defer></script>
<?php
    include "./database/DatabaseData.php";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_errno) die('Brak połączenia z MySQL');
?>
<div class="show">
    <table border=1 id="main_table">
        <tr>
            <th>Flag</th>
            <th>Denominate</th>
            <th>Category</th>
            <th>Material</th>
            <th>Year</th>
            <th>Delete</th>
        </tr>
        <?php
            $sql = "SELECT * FROM `data`";
            $res = $conn->query($sql);
        
            $response = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $response[] = $row;
            }

            for ($i = 0; $i < count($response); $i++) {
                echo '<tr>';
                    echo '<td class="flags">';
                        $sql = "SELECT * FROM `flags` WHERE id = ".$response[$i]['flag_id'];
                        $res = $conn->query($sql);
                        $flag = array();
                        while ($row = mysqli_fetch_assoc($res)) {
                            $flag[] = $row;
                        }
                        echo '<img src='.$flag[0]['flag'].' alt='.$flag[0]['name'].'>';
                    echo '</td>';
                    echo '<td class="row">';
                        echo $response[$i]['denomination'];
                    echo '</td>';
                    echo '<td class="row">';
                        echo $response[$i]['category'];
                    echo '</td>';
                    echo '<td class="row">';
                        $sql = "SELECT * FROM `materials` WHERE id = ".$response[$i]['material_id'];
                        $res = $conn->query($sql);
                        $material = array();
                        while ($row = mysqli_fetch_assoc($res)) {
                            $material[] = $row;
                        }
                        echo $material[0]['material'];
                    echo '</td>';
                    echo '<td class="row">';
                        echo $response[$i]['year'];
                    echo '</td>';
                    echo '<td class="delete_confirm" id="delete'.$response[$i]['id'].'"><img src="./img/delete.jpg" alt="delete"></td>';
                echo '</tr>';
            }
        ?>
    </table>
</div>
<div class="add">
    Add new coin
    <table border=1>
        <tr>
            <th>Flag</th>
            <th>Denominate</th>
            <th>Category</th>
            <th>Material</th>
            <th>Year</th>
            <th>Confirm</th>
        </tr>
        <tr>
            <td>
                <select name="flag" id="flag">
                    <?php
                        $sql = "SELECT * FROM `flags`";
                        $res = $conn->query($sql);
                    
                        $response = array();
                        while ($row = mysqli_fetch_assoc($res)) {
                            $response[] = $row;
                        }

                        for ($i = 0; $i < count($response); $i++) {
                            echo '<option>';
                                echo explode(".",$response[$i]['name'])[0];
                            echo '</option>';
                        }
                    ?>
                </select>
            </td>
            <td>
                <input type="text" name="denomination" id="denomination">
            </td>
            <td>
                <input type="text" name="category" id="category">
            </td>
            <td>
                <select name="material" id="material">
                    <?php
                        $sql = "SELECT * FROM `materials`";
                        $res = $conn->query($sql);
                    
                        $response = array();
                        while ($row = mysqli_fetch_assoc($res)) {
                            $response[] = $row;
                        }
                        
                        for ($i = 0; $i < count($response); $i++) {
                            echo '<option>';
                                echo $response[$i]['material'];
                            echo '</option>';
                        }
                    ?>
                </select>
            </td>
            <td>
                <input type="number" name="year" id="year">
            </td>
            <td class="add_confirm" onclick="add_confirm()"><img src="./img/confirm.png" alt="confirm"></td>
        </tr>
    </table>
</div>

<a href="/makeFlags.php">Make flags</a>
<a href="/makeMaterials.php">Make materials</a>