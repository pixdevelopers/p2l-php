<?php
header('Content-type:application/json');
$postdata = json_decode(file_get_contents('php://input') , true);
$request = $postdata['request'];
require ('db.php');

		if ($request == 'addNewUserGroup') {
		$name = $postdata['name'];
		$manageUserGroups = $postdata['manageUserGroups'];
		$manageAdmins = $postdata['manageAdmins'];
		$manageFeatures = $postdata['manageFeatures'];
		$managePackages = $postdata['managePackages'];
		$manageUsers = $postdata['manageUsers'];

			// execute SQL query and return result in JSON format
			echo json_encode(true);

		}
$conn->close();
?>