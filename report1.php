<?php 
	include("system-header.php"); 
?>
<form class="contentform" method="post" action="report1data.php" onsubmit="return validateYear()">
	<label>Year</label>
	<input type="text" id="year" name="year" value="<?php echo date("Y"); ?>" />
	
	<label>Month</label>
	<SELECT id="month" name="month">
		<OPTION value="01">January</OPTION>
		<OPTION value="02">February</OPTION>
		<OPTION value="03">March</OPTION>
		<OPTION value="04">April</OPTION>
		<OPTION value="05">May</OPTION>
		<OPTION value="06">June</OPTION>
		<OPTION value="07">July</OPTION>
		<OPTION value="08">August</OPTION>
		<OPTION value="09">September</OPTION>
		<OPTION value="10">October</OPTION>
		<OPTION value="11">November</OPTION>
		<OPTION value="12">December</OPTION>
	</SELECT>
	
	<INPUT type="submit" VALUE="Go"></INPUT>
</form>
<SCRIPT>
	function IsNumeric(input) {
	    return (input - 0) == input && input.length > 0;
	}
	
	function validateYear() {
		if ($("#year").val() == "") {
			dtAlert("Please enter a year");
			$("#year").focus();
			return false;
		}
		
		if (! IsNumeric($("#year").val())) {
			dtAlert("Please enter a valid year");
			$("#year").focus();
			return false;
		}
		
		return true;
	}
	
	$(document).ready(
			function() {
				$("#month").val("<?php echo date("m"); ?>");
			}
		);
</SCRIPT>

<?php include("system-footer.php"); ?>