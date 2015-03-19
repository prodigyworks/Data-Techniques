<html>
<head>
	<title>MySQL connection test</title>
</head>
<body>
<?php

// mysql_test.php 1.2


// Set these four details up with the DB information and run this file from their hosting.
// I've not tested the precise timing stuff under Windows yet, so it may break. Drop me an email if it does.

$database	= 'dtcrmdb';
$server	= '213.171.193.147';
$username	= 'dtcrmuser';
$password	= 'KwdC5yWtFn';



//***************** You don't need to go below this line **************

function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();


$link = mysql_connect($server, $username, $password) or die(
   	'<p style="color: red;">Oh no, database having problems... Could not connect: '.
 	 	mysql_error() .
   	'</p>'
);

mysql_select_db($database) or die('Could not select database');

$time_end = microtime_float();
$time = $time_end - $time_start;

// trim it to something sensible
$decimal_places = 3;
$time = sprintf('%.'. $decimal_places .'f', $time);

if ($time == 0)
{
	$time = "less than $time";
}

echo '<p style="color: darkgreen;">Connected successfully and everything is working correctly!</p>';
echo '<p>Database connection took '. $time .' seconds to open from PHP.';

// Closing connection
mysql_close($link);
?>
</body>
</html>