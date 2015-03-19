<?php
require_once("quotationitem.php");
	
class SiteConfigClass {
	public $domainurl;
}

function start_db() {
	if(!isset($_SESSION)) {
		session_start();
	}
	
	date_default_timezone_set('Europe/London'); 
	
	error_reporting(0);

	if (! isset($_SESSION['PRODIGYWORKS.INI'])) {
		$_SESSION['PRODIGYWORKS.INI'] = parse_ini_file("prodigyworks.ini");
		$_SESSION['DB_PREFIX'] = $_SESSION['PRODIGYWORKS.INI']['DB_PREFIX']; 
	}
	
	if (! defined('DB_HOST')) {
		$iniFile = $_SESSION['PRODIGYWORKS.INI'];
		
		define('DB_HOST', $iniFile['DB_HOST']);
	    define('DB_USER', $iniFile['DB_USER']);
	    define('DB_PASSWORD', $iniFile['DB_PASSWORD']);
	    define('DB_DATABASE', $iniFile['DB_DATABASE']);
	    define('DEV_ENV', $iniFile['DEV_ENV']);
	    
		//Connect to mysql server
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		
		if (!$link) {
			logError('Failed to connect to server: ' . mysql_error());
		}
		
		//Select database
		$db = mysql_select_db(DB_DATABASE);
		
		if(!$db) {
			logError("Unable to select database:" . DB_DATABASE);
		}
		
		mysql_query("BEGIN");
	
		if (! isset($_SESSION['SITE_CONFIG'])) {
			$qry = "SELECT * FROM {$_SESSION['DB_PREFIX']}siteconfig";
			$result = mysql_query($qry);
	
			//Check whether the query was successful or not
			if ($result) {
				if (mysql_num_rows($result) == 1) {
					$member = mysql_fetch_assoc($result);
					
					$data = new SiteConfigClass();
					$data->domainurl = $member['domainurl'];
					
					$_SESSION['SITE_CONFIG'] = $data;
				}
					
			} else {
				header("location: system-access-denied.php");
			}
		}
	    
	}
}
function start_db2() {
	
	if(!isset($_SESSION)) {
		session_start();
	}
	
	error_reporting(E_ALL ^ E_DEPRECATED);

	define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_DATABASE', 'datatechnique');
	/*
	define('DB_HOST', '83.222.229.27');
    define('DB_USER', 'dtcrmuser');
    define('DB_PASSWORD', 'KwdC5yWtFn');
    define('DB_DATABASE', 'dtcrmdb');
    */
	/*
    
	define('DB_HOST', 'prodigyworks.co.uk.mysql');
    define('DB_USER', 'prodigyworks_co');
    define('DB_PASSWORD', 'i6qFAWND');
    define('DB_DATABASE', 'prodigyworks_co');
    */
/*
 * Database:

Server IP: 213.171.193.147

DB Name: dtcrmdb

User: dtcrmuser

Pass: KwdC5yWtFn


 */
}

function GetCostCode($costcode) {
	if ($costcode == "CAPEXCCF") {
		return "CAPEX DEAL RELATED CCF";
			
	} else if ($costcode == "CAPEXINTERNAL") {
		return "CAPEX NON DEAL RELATED";	
		
	} else if ($costcode == "OPEXINTERNAL") {
		return "OPEX NON DEAL RELATED";	
			
	} else if ($costcode == "CAPEXBESPOKE") {
		return "CAPEX - BESPOKE";	
			
	} else if ($costcode == "OPEXBESPOKE") {
		return "OPEX - BESPOKE";	
			
	} else if ($costcode == "OPEXCUSTOMERPO") {
		return "OPEX - Customer PO";	
	}
}

function GetUserName($userid = "") {
	if ($userid == "") {
		return $_SESSION['SESS_FIRST_NAME'] . " " . $_SESSION['SESS_LAST_NAME'];
		
	} else {
		$qry = "SELECT * FROM datatech_members A " .
				"WHERE A.member_id = $userid ";
		$result = mysql_query($qry);
		$name = "Unknown";
	
		//Check whether the query was successful or not
		if($result) {
			while (($member = mysql_fetch_assoc($result))) {
				$name = $member['firstname'] . " " . $member['lastname'];
			}
		}
		
		return $name;
	}
}

function GetEmail($userid) {
	$qry = "SELECT email FROM datatech_members A " .
			"WHERE A.member_id = $userid ";
	$result = mysql_query($qry);
	$name = "Unknown";

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$name = $member['email'];
		}
	}
	
	return $name;
}

function GetSiteName($siteid) {
	$qry = "SELECT * FROM datatech_sites A " .
			"WHERE A.id = $siteid ";
	$result = mysql_query($qry);
	$name = "Unknown";

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$name = $member['name'];
		}
	}
	
	return $name;
}

function GetSiteAddress($siteid) {
	$qry = "SELECT * FROM datatech_sites A " .
			"WHERE A.id = $siteid ";
	$result = mysql_query($qry);
	$name = "Unknown";

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$name = $member['name'];
			
			if ($member['address1'] != "") $name = $name . "\n" . $member['address1'];
			if ($member['address2'] != "") $name = $name . "\n" . $member['address2'];
			if ($member['address3'] != "") $name = $name . "\n" . $member['address3'];
			if ($member['address4'] != "") $name = $name . "\n" . $member['address4'];
			if ($member['address5'] != "") $name = $name . "\n" . $member['address5'];
			if ($member['address6'] != "") $name = $name . "\n" . $member['address6'];
			if ($member['address7'] != "") $name = $name . "\n" . $member['address7'];
		}
	}
	
	return $name;
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")  
{ 
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; 
 
  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue); 
 
  switch ($theType) { 
    case "text": 
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; 
      break;     
    case "long": 
    case "int": 
      $theValue = ($theValue != "") ? intval($theValue) : "NULL"; 
      break; 
    case "double": 
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL"; 
      break; 
    case "date": 
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; 
      break; 
    case "defined": 
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; 
      break; 
  } 
  return $theValue; 
} 

function initialise_db() {
		//Connect to mysql server
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		
		if (!$link) {
			die('Failed to connect to server: ' . mysql_error());
		}
		
		//Select database
		$db = mysql_select_db(DB_DATABASE);
		
		if(!$db) {
			die("Unable to select database");
		}
	
}
	
function dateStampString($oldnotes, $newnotes, $prefix = "") {
	if ($newnotes == $oldnotes) {
		return $oldnotes;
	}
	
	return 
		mysql_escape_string (
				$oldnotes . "\n\n" .
				$prefix . " - " . 
				date("F j, Y, H:i a") . " : " . 
				$_SESSION['SESS_FIRST_NAME'] . " " . 
				$_SESSION['SESS_LAST_NAME'] . "\n" . 
				$newnotes
			);
}
	
function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= "To: <$to>" . "\r\n";
	$headers .= "From: $from_name <$from>" . "\r\n";
	
	mail(
			$to,
			$subject,
			$body,
			$headers
		);
}
function smtpmailer2($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
//	$mail->SMTPAuth = false;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
//	$mail->Host = 'send.one.com';
	$mail->Port = 465; 
//	$mail->Port = 25; 
	$mail->Username = "istudentcontrol@gmail.com";  
	$mail->Password = "istudent";           
//	$mail->Username = "kevin.hilton@prodigyworks.co.uk";  
//	$mail->Password = "Jasmin717440";           
	$mail->SetFrom($from, $from_name);
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

function sendRoleMessage($role, $subject, $message) {
	require_once('phpmailer/class.phpmailer.php');

	$qry = "SELECT B.email FROM datatech_userroles A " .
			"INNER JOIN datatech_members B " .
			"ON B.member_id = A.memberid " .
			"WHERE A.roleid = '$role' ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			smtpmailer($member['email'], 'admin@dti.com', 'DTi Administration', $subject, $message);
		}
	}
	
	if (!empty($error)) echo $error;
}
	
function endsWith( $str, $sub ) {
	return ( substr( $str, strlen( $str ) - strlen( $sub ) ) == $sub );
}

function isAuthenticated() {
	return ! (!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == ''));
}

function sendUserMessage($id, $subject, $message) {
	require_once('phpmailer/class.phpmailer.php');

	$qry = "SELECT B.email FROM datatech_members B " .
			"WHERE B.member_id = $id ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			smtpmailer($member['email'], 'admin@dti.com', 'DTi Administration', $subject, $message);
		}
	}
	
	if (!empty($error)) echo $error;
}

function createCombo($id, $value, $name, $table, $where = " ") {
	echo "<select id='" . $id . "'  name='" . $id . "'>";
	createComboOptions($value, $name, $table, $where);
	
	echo "</select>";
}
	

function createComboOptions($value, $name, $table, $where = " ", $blank = true) {
	if ($blank) {
		echo "<option value='0'></option>";
	}
		
	$qry = "SELECT * " .
			"FROM $table " .
			$where . " " . 
			"ORDER BY $name";
	$result = mysql_query($qry);
	
	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			echo "<option value=" . $member[$value] . ">" . $member[$name] . "</option>";
		}
	}
}
	
function escape_notes($notes) {
	return str_replace("\r", "", str_replace("'", "\\'", str_replace("\n", "\\n", str_replace("\"", "\\\"", str_replace("\\", "\\\\", $notes)))));
}
function isUserAccessPermitted($action, $description = "") {
	require_once("constants.php");
	
	if ($description == "") {
		$desc = ActionConstants::getActionDescription($action);
		
	} else {
		$desc = $description;
	}
	
	$pageid = $_SESSION['pageid'];
	$found = 0;
	$actionid = 0;
	$qry = "SELECT A.id " .
			"FROM {$_SESSION['DB_PREFIX']}applicationactions A  " .
			"WHERE A.pageid = $pageid " .
			"AND A.code = '$action'";
	$result = mysql_query($qry);
	
	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$found = 1;
			$actionid = $member['id'];
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
	
	if ($found == 0) {
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}applicationactions (pageid, code, description) VALUES($pageid, '$action', '$desc')";
		$result = mysql_query($qry);
		
		if (! $result) {
			logError($qry . " - " . mysql_error());
		}
		
		$actionid = mysql_insert_id();
		
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}applicationactionroles (actionid, roleid) VALUES($actionid, 'PUBLIC')";
		$result = mysql_query($qry);
		
		if (! $result) {
			logError($qry . " - " . mysql_error());
		}
	}
	
	$found = 0;
	$qry = "SELECT A.* " .
			"FROM {$_SESSION['DB_PREFIX']}applicationactionroles A  " .
			"WHERE A.actionid = $actionid " .
			"AND A.roleid IN (" . ArrayToInClause($_SESSION['ROLES']) . ")";
	$result = mysql_query($qry);

	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$found = 1;
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
		
	return $found == 1;
}
    
function isUserInRole($roleid) {
	if (! isAuthenticated()) {
		return false;
	}
	
	for ($i = 0; $i < count($_SESSION['ROLES']); $i++) {
		if ($roleid == $_SESSION['ROLES'][$i]) {
			return true;
		}
	}
	
	return false;
}

function lastIndexOf($string, $item) {
	$index = strpos(strrev($string), strrev($item));

	if ($index) {
		$index = strlen($string) - strlen($item) - $index;
		
		return $index;
		
	} else {
		return -1;
	}
}


function logError($description, $kill = true) {
	if ($kill) {
		mysql_query("ROLLBACK");
	}
	
	if (isset($_SESSION['pageid'])) {
		$pageid = $_SESSION['pageid'];
		
	} else {
		$pageid = 1;
	}
	
	$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}errors (pageid, memberid, description) VALUES ($pageid, " . getLoggedOnMemberID() . ", '" . mysql_escape_string($description) . "')";
	$result = mysql_query($qry);
	
	if ($kill) {
		die($description);
	}
}

function convertStringToDate($str) {
	if (trim($str) == "") {
		return "";
	}
	
	return substr($str, 6, 4 ) . "-" . substr($str, 3, 2 ) . "-" . substr($str, 0, 2 );
}

function getSiteConfigData() {
	return $_SESSION['SITE_CONFIG'];
}

function getLoggedOnMemberID() {
	start_db();
	
	if (! isset($_SESSION['SESS_MEMBER_ID'])) {
		return 0;
	}
	
	return $_SESSION['SESS_MEMBER_ID'];
}

?>