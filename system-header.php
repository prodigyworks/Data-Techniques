<?php
	require_once('system-db.php');
	
	if(!isset($_SESSION)) {
		session_start();
	}
	
	if (! isAuthenticated() && ! endsWith($_SERVER['PHP_SELF'], "/system-login.php")) {
		header("location: system-login.php?session=" . urlencode(base64_encode($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] )));
		exit();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php 
	//Include database connection details
	require_once('system-config.php');

?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/jquery-ui-1.8.21.custom.css" type="text/css" />

<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datatechniques.js" language="javascript" ></script> 
<title>DTi - Project Tracker</title>
<script>
	var autoLoad = false;
</script>
</head>
<body>
	<?php
		if (isset($_POST['command'])) {
			$_POST['command']();
		}
	?>
	
	<form method="POST" id="commandForm" name="commandForm">
		<input type="hidden" id="command" name="command" />
		<input type="hidden" id="pk1" name="pk1" />
		<input type="hidden" id="pk2" name="pk2" />
	</form>
	<center>
	<div id="toppanel">
		<?php
			if (isAuthenticated()) {
		?>
			<label>logged on: </label>
			<label><a href='profile.php'><?php echo $_SESSION['SESS_FIRST_NAME'] . " " . $_SESSION['SESS_LAST_NAME']; ?></a></label>
			<a style="padding-left: 50px" href="system-logout.php">Log out</a>
		<?php
			}
		?>
	</div>
	<div align="center" class="page">
		<div id="header">
		</div>
			
		<div id="nav">
			<?php
				BreadCrumbManager::showBreadcrumbTrail();
				
				showMenu();
			?>
		</div>
		
		
		<div id="logo"></div>
		
		<div id="content" class="rounded-corners">
			<div class="title" id="apptitle"><?php echo $_SESSION['title']; ?></div>

			