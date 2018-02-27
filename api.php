<?php
header('Content-type:application/json');
$postdata = json_decode(file_get_contents('php://input'), true);
$request = $postdata['request'];
require('db.php');

if ($request == 'getAdmins'){

		$sql = "SELECT * FROM admin";
		$result = $conn->query($sql);
		$response = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
            $arr = array(
        	'user' => $row["Username"],
        	'pass' => $row["Password"]
        	);
        	array_push($response,$arr);
    }
     echo json_encode($response);
} 

}
$conn->close();
?>