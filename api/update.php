<?php
    require_once('dbconfig.php');
	
    $_POST = json_decode(file_get_contents('php://input'), true);
    $table = $_POST['table'];
    $values = $_POST['values'];
    $fields = $_POST['fields'];
    $fieldsLength = count($fields);
    $valuesLength = count($values);
    $fieldsStrng = "";
    $valuesStrng = "";
    $where = $_POST['where'];
    $whereValue= $_POST['whereValue'];
    $queryStrng = "";

    if($fieldsLength == $valuesLength){
        for ($i=0; $i < $fieldsLength ; $i++) {
            $queryStrng .= "`".$fields[$i]."`" ." = '".$values[$i]."'"  ;
            if($i < ($fieldsLength - 1)){
                $queryStrng .=  ' ,';
            }

        }
    }

    $query = "UPDATE `$table` SET $queryStrng WHERE `$where` = $whereValue";
    $result = mysqli_query($con,$query);
    $rows = mysqli_affected_rows($con);

   if($rows > 0){
        echo true;
    }
    else {
        echo false;
    }
?>