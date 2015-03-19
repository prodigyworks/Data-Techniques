<?php
	//Include database connection details
	require_once('system-db.php');
	
	start_db();
	initialise_db();
	
	$id = $_GET['id'];
	$qry = "SELECT * " .
			"FROM datatech_productlengths " .
			"WHERE productid = $id " .
			"ORDER BY id";
	$result = mysql_query($qry);
	
	//Check whether the query was successful or not
	echo "[\n";
	echo "{\"id\": \"0\", \"name\": \"\"}";
	
	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			echo ",\n";
			echo "{\"id\": " . $member['id'] . ", \"name\": \"" . $member['length'] . "M\"}";
		}
	}
	
	echo "\n]\n";
?>