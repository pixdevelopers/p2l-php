<?php

    require_once('dbconfig.php');
        $_POST = json_decode(file_get_contents('php://input'), true);

    $data = array();
        $table = $_POST['table'];

    $query = "SELECT * FROM  $table ORDER BY id ASC";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }

    echo $json_response = json_encode($data);



?>