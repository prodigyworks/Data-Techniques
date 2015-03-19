<?php
	require_once("quotationitem.php");
	require_once("system-db.php");
	
	start_db();
	initialise_db();
	
	unset($_SESSION['QUOTATION']);
	
	$qry = "DELETE FROM datatech_documents WHERE sessionid = '" . session_id() . "'";
	$result = mysql_query($qry);
	
   	if (! $result) {
   		die("Error DELETE FROM datatech_documents:" . $qry . " - " . mysql_error());
   	}
   	
	header("location: newquote.php")
?>