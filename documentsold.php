<?php
	include("system-header.php"); 
	
	function delete() {
		if (isset($_POST['pk1'])) {
			$id = $_POST['pk1'];
			$qry = "DELETE FROM datatech_documents WHERE id = $id";
			$result = mysql_query($qry);
		}
	}
	
?>
	
<form id="documentForm" name="documentForm" onsubmit="return validate()" enctype="multipart/form-data" method="POST" action="system-documentupload.php?id=<?php echo $_GET['id']; ?>?">
	<div id="documentDiv">
		<label>TITLE</label>
		<input type="text" id="title" name="title" style="width:350px" /><br>
		
		<label>DOCUMENT</label>
		<input type="file" id="document" name="document" style="width:450px" /><br>
		<input type="submit" style="margin-left:0px" class="dataButton" value="ADD DOCUMENT" id="btnHeanerNotes" />
		<br>
	</div>
</form>
<?php
	$header = new QuotationHeader();
	$header->load($_GET['id']);
	$header->showHeaderDetails();
?>

<div style="height:320px; overflow-y: scroll">
	<table class='grid list' width=100% cellspacing=0 cellpadding=0>
		<thead>
			<tr>
				<td width='20px'></td>
				<td>Name</td>
				<td>File Name</td>
				<td>Type</td>
				<td>Size</td>
				<td>Date Created</td>
				<td>Created By</td>
			</tr>
		</thead>
		<?php
			$qry = "SELECT A.*, DATE_FORMAT(A.createddate, '%d/%m/%Y') AS createddate, " .
					"DATE_FORMAT(A.lastmodifieddate, '%d/%m/%Y') AS lastmodifieddate, " .
					"B.firstname, B.lastname " .
					"FROM datatech_documents A " .
					"INNER JOIN datatech_members B " .
					"ON B.member_id = A.createdby " .
					"WHERE A.headerid = " . $_GET['id'] . " " .
					"ORDER BY A.id";
			$result = mysql_query($qry);
			
			if (! $result) die("Error: " . mysql_error());
			
			//Check whether the query was successful or not
			if ($result) {
				while (($member = mysql_fetch_assoc($result))) {
					echo "<tr>\n";
					echo "<td width='20px' title='Delete' onclick='deleteDocument(" . $member['id'] . ")'><img src='images/delete.png' /></td>\n";
					echo "<td><a target='_new' href='viewdocuments.php?id=" . $member['id'] . "'>" . $member['name'] . "</a></td>\n";
					echo "<td>" . $member['filename'] . "</td>\n";
					echo "<td>" . $member['mimetype'] . "</td>\n";
					echo "<td>" . $member['size'] . "</td>\n";
					echo "<td>" . $member['createddate'] . "</td>\n";
					echo "<td>" . $member['firstname'] . " " . $member['lastname'] . "</td>\n";
					echo "</tr>\n";
				}
			}
		?>
	</table>
</div>
<script>
	function deleteDocument(id) {
		if (confirm("You are about to delete this document. Are you sure ?")) {
			call("delete", {pk1: id});
		}
	}
	
	function validate() {
		if ($("#title").val() == "") {
			alert("Please enter a title");
			$("#title").focus();
			return false;
		}
		
		if ($("#document").val() == "") {
			alert("Please enter a file");
			$("#document").focus();
			return false;
		}
		
		return true;
	}
</script>
<?php
	include("system-footer.php"); 
?>