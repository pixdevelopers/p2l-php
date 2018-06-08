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

	if($fieldsLength == $valuesLength){
		for ($i=0; $i < $fieldsLength ; $i++) {
			$fieldsStrng .= "`" .$fields[$i] . "`" ;
			$valuesStrng .= "'" .$values[$i]. "'";
			if($i < ($fieldsLength - 1)){
				$fieldsStrng .=  ' ,';
			$valuesStrng .=  ' ,';
			}

		}
	}

	$query = "INSERT into $table ($fieldsStrng) VALUES ($valuesStrng);";
	$result = mysqli_query($con,$query);
	$rows = mysqli_affected_rows($con);
	if($rows > 0){
    	echo true;
    }
    else {
    	echo false;
    }
?>