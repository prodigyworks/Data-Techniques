<?php include("system-header.php"); ?>

<!--  Start of content -->
<?php
	if (isset($_POST['below1kid'])) {
		$below1kid = $_POST['below1kid'];
		$below5kid = $_POST['below5kid'];
		$over5kid = $_POST['over5kid'];
		$documentfolder = mysql_escape_string($_POST['documentfolder']) ;
		$stageapproval = $_POST['stageapproval'];
		$stagescheduled = $_POST['stagescheduled'];
		$stageceapproval = $_POST['stageceapproval'];
		
		$capexdealpovaluethreshold = $_POST['capexdealpovaluethreshold'];
		
		$qry = "UPDATE datatech_siteconfig SET " .
				"below1kid = '$below1kid', " .
				"below5kid = '$below5kid', " .
				"over5kid = '$over5kid', " .
				"capexdealpovaluethreshold = $capexdealpovaluethreshold, " .
				"stageapproval = '$stageapproval', " .
				"stagescheduled = '$stagescheduled', " .
				"stageceapproval = '$stageceapproval', " .
				"documentfolder = '$documentfolder'";
		$result = mysql_query($qry);

	   	if (! $result) {
	   		die("UPDATE datatech_siteconfig:" . $qry . " - " . mysql_error());
	   	}
		
		if (isset($_POST['changepot1']) && $_POST['changepot1'] == "Y") {
			$capexdealpovalue = $_POST['currentcapexdealpovalue'];
			$qry = "UPDATE datatech_siteconfig SET capexdealpovalue = $capexdealpovalue, currentcapexdealpovalue = $capexdealpovalue";
			$result = mysql_query($qry);
		}
		
		
	   	if (! $result) {
	   		die("UPDATE datatech_siteconfig (POT):" . $qry . " - " . mysql_error());
	   	}
	}
	
	$qry = "SELECT * FROM datatech_siteconfig";
	$result = mysql_query($qry);
	
	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
?>
<form id="contentForm" name="contentForm" method="post">
	<input type="hidden" id="changepot1" name="changepot1" value="" />
	
	<label>Approval role under 5k</label>
	<?php createCombo("below1kid", "roleid", "roleid", "datatech_roles", "", false); ?>
	
	<label>Approval role under 50k</label>
	<?php createCombo("below5kid", "roleid", "roleid", "datatech_roles", "", false); ?>
	
	<label>Approval role over 50k</label>
	<?php createCombo("over5kid", "roleid", "roleid", "datatech_roles", "", false); ?>
	
	<label>Document Upload Folder</label>
	<input type="text" id="documentfolder" name="documentfolder" cols=80 style="width:400px" />
	<br>
	
	<label>CAPEX Deal Related - CCF PO Value</label>
	<input type="hidden" id="capexdealpovalue" name="capexdealpovalue" cols=20 style="width:100px" value="<?php echo $member['capexdealpovalue']; ?>" />
	<input type="text" id="currentcapexdealpovalue" name="currentcapexdealpovalue" cols=20 style="width:100px" value="<?php echo $member['currentcapexdealpovalue']; ?>" disabled />
	<img src='images/reset.png' title='Reset the Capex deal cash pot' id='capexdealimg' />
	<input type="text" id="capexdealpovaluethreshold" name="capexdealpovaluethreshold" cols=20 style="width:30px" value="<?php echo $member['capexdealpovaluethreshold']; ?>" />%
	<br>
	
	<label>Cancellation route once approved</label>
	<?php createCombo("stageapproval", "id", "id", "datatech_cancellationroute", "", false); ?>
	<br>
	
	<label>Cancellation route once scheduled</label>
	<?php createCombo("stagescheduled", "id", "id", "datatech_cancellationroute", "", false); ?>
	<br>
	
	<label>Cancellation route once CE approved</label>
	<?php createCombo("stageceapproval", "id", "id", "datatech_cancellationroute", "", false); ?>
	<br>
	
	<input class="commandButton" type="submit" value="Update" />
</form>
<script>
	$(document).ready(function() {
			$("#below1kid").val("<?php echo $member['below1kid']; ?>");
			$("#below5kid").val("<?php echo $member['below5kid']; ?>");
			$("#over5kid").val("<?php echo $member['over5kid']; ?>");
			$("#stageapproval").val("<?php echo $member['stageapproval']; ?>");
			$("#stagescheduled").val("<?php echo $member['stagescheduled']; ?>");
			$("#stageceapproval").val("<?php echo $member['stageceapproval']; ?>");
			$("#documentfolder").val("<?php echo mysql_escape_string( $member['documentfolder']); ?>");
			
			$("#capexdealimg").click(
					function() {
						$("#changepot1").val("Y");
						$("#currentcapexdealpovalue").attr("disabled", false);
					}
				);
		});
				
	<?php
			}
		}
	?>
</script>
<!--  End of content -->

<?php include("system-footer.php"); ?>
