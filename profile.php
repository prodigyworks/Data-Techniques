<?php 
	include("system-header.php"); 
	showErrors(); 
?>
<!--  Start of content -->
<div class="registerPage">
<?php
	$memberid =  $_SESSION['SESS_MEMBER_ID'];
	
	if (isset($_GET['id'])) {
		global $memberid;
		
		$memberid = $_GET['id'];
	}
	
	$qry = "SELECT firstname, lastname, email, imageid " .
			"FROM datatech_members " .
			"WHERE member_id = $memberid ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			
			if ($member['imageid'] != 0) {
			
?>
	<img style='position:absolute;margin-left: 400px' src='system-imageviewer.php?id=<?php echo $member['imageid']; ?>' />
				
<?php
			}
?>
	<form id="loginForm" enctype="multipart/form-data" name="loginForm" method="post" action="system-register-exec.php?id=<?php echo $memberid; ?>">
	  <table border="0" align="left" cellpadding="2" cellspacing="0">
	    <tr>
	      <td>First Name </td>
	      <td><input name="fname" type="text" class="textfield" id="fname" value="<?php echo $member['firstname']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>Last Name </td>
	      <td><input name="lname" type="text" class="textfield" id="lname" value="<?php echo $member['lastname']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>Email</td>
	      <td><input name="email" type="text" class="textfield60" id="email"  value="<?php echo $member['email']; ?>" /></td>
	    </tr>
<?php
	if (($memberid == $_SESSION['SESS_MEMBER_ID'])) {
?>
	    <tr>
	      <td>Image</td>
	      <td><input name="image" type="file" class="textfield60" id="image" /></td>
	    </tr>
	    <tr>
	    	<td colspan="2">
	    		<br />
	    		<h3>Security</h3>
	    		<hr />
	    	</td>
	    </tr>
	    <tr>
	      <td>Password</td>
	      <td><input name="password" type="password" class="textfield" id="password" /></td>
	    </tr>
	    <tr>
	      <td>Confirm Password </td>
	      <td><input name="cpassword" type="password" class="textfield" id="cpassword" /></td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td><input type="submit" name="Submit" id="Submit" value="Update" /></td>
	    </tr>
	  </table>
	  <input type="hidden" id="description" name="description" value="Profile image" />
<?php
	} else {
?>
	  <script>
	  		$(document).ready(
	  				function() {
	  					$("#fname").attr("disabled", true);
	  					$("#lname").attr("disabled", true);
	  					$("#email").attr("disabled", true);
	  				}
	  			);
	  </script>		
<?php
	}
?>
	</form>
</div>
<?php
		}
	}
			
?>
<!--  End of content -->
<?php include("system-footer.php"); ?>
