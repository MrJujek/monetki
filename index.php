<link href="./style/style.css" rel="stylesheet" type="text/css">
<?php
    include "./database/DatabaseData.php";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_errno) die('Brak połączenia z MySQL');
?>
<div class="show">
    <table border=1>
        <tr>
            <th>Flag</th>
            <th>Denominate</th>
            <th>Category</th>
            <th>Material</th>
            <th>Year</th>
            <th>Delete</th>
        </tr>
    </table>
</div>
<div class="add">
    Dodawanie rekordu
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

                        echo '<pre>';
                        var_dump($response);
                        echo '</pre>';

                        for ($i = 0; $i < count($response); $i++) {
                            echo '<option>';
                                echo $response[$i]['name'];
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
                        $sql = "SELECT * FROM `material`";
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
                <input type="text" name="year" id="year">
            </td>
            <td><img src="./img/confirm.png" alt="confirm"></td>
        </tr>
    </table>
</div>

<a href="/makeFlags.php">Go to make flags</a>