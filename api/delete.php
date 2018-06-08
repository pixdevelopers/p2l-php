<?php
    
    require_once('dbconfig.php');

    $_POST = json_decode(file_get_contents('php://input'), true);
	$table = $_POST['table'];
	$where = $_POST['where'];
	$value = $_POST['value'];

    $query = "DELETE FROM $table WHERE $where='$value'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_affected_rows($con);
    if($rows > 0){
    	echo true;
    }
    else {
    	echo false;
    }
?>