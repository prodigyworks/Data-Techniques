<?php include("system-header.php"); ?>

<!--  Start of content -->
<?php showErrors(); ?>
<div class="registerPage">
	<form id="loginForm" enctype="multipart/form-data" name="loginForm" method="post" action="system-register-exec.php">
	  <table border="0" align="left" cellpadding="2" cellspacing="0">
	    <tr>
	      <td>First Name </td>
	      <td><input name="fname" type="text" class="textfield" id="fname" /></td>
	    </tr>
	    <tr>
	      <td>Last Name </td>
	      <td><input name="lname" type="text" class="textfield" id="lname" /></td>
	    </tr>
	    <tr>
	      <td>Login</td>
	      <td><input name="login" type="text" class="textfield" id="login" /></td>
	    </tr>
	    <tr>
	      <td>Email</td>
	      <td><input name="email" type="text" class="textfield60" id="email" /></td>
	    </tr>
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
	      <td><input type="submit" name="Submit" id="Submit" value="Register" /></td>
	    </tr>
	  </table>
	  <input type="hidden" id="description" name="description" value="Profile image" />
	</form>
</div>
<script>
	$(document).ready(function() {
		$("#fname").focus();
	});
</script>
<!--  End of content -->

<?php include("system-footer.php"); ?>
