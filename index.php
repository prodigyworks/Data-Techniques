<?php
	include("system-header.php"); 
	include("confirmdialog.php");
	
	createDocumentLink();
	createConfirmDialog("confirmdialog", "Quote / Job cancellation ?", "cancelJob");
	createConfirmDialog("recoverdialog", "Quote / Job recovery ?", "recoverJob");
?>
<!--  Start of content -->
<div class="modal" id="notesdialog">
	<h3 id="notesheader">XX</h2>
	<label>ORIGINAL NOTES</label>
	<textarea id="notes" name="notes" readonly cols=180 rows=10></textarea>
	<br>
	<br>
	<label>CANCELLATION NOTES</label>
	<textarea id="completionnotes" name="completionnotes" cols="180" rows=7></textarea>
	<br />
	<br />
</div>

<div class="roundbox bgBlue">
	<?php
		function cancelJob() {
			if (isset($_POST['pk1'])) {
				$header = new QuotationHeader();
				$header->load($_POST['pk1']);
				$header->cancel($_POST['pk2']);
			}
		}
		
		function recoverJob() {
			if (isset($_POST['pk1'])) {
				$header = new QuotationHeader();
				$header->load($_POST['pk1']);
				$header->recover();
			}
		}
		
		if (isUserInRole("SUBADMIN")) {
			showPanel(
					"All Jobs Pending Cancellation", 
					"CREATOR", 
					"WHERE A.status IN ('P')",
					"jobreport",
					"confirmcancellation",
					"approvecancel.png",
					"Approve Cancellation",
					false,
					true
				);
				
			showPanel(
					"All Quotes - Draft Stage", 
					"CREATOR", 
					"WHERE A.status IN ('N', 'R') AND approvalid IS NULL ",
					"quotationreport"
				);
				
			showPanel(
					"All Quotes Awaiting Verification", 
					"CREATOR", 
					"WHERE A.status IN ('N', 'R') AND approvalid IS NOT NULL ",
					"quotationreport"
				);
				
			showPanel(
					"All Jobs Awaiting Scheduling", 
					"CREATOR", 
					"WHERE A.status IN ('A') ",
					"jobreport",
					"viewquote",
					"view.png",
					"View"
				);
				
			showPanel(
					"All Jobs Awaiting CE Approval", 
					"CREATOR", 
					"WHERE A.status IN ('S')",
					"jobreport",
					"viewquote",
					"view.png",
					"View"
				);
				
			showPanel(
					"All Jobs Awaiting Completion", 
					"CREATOR", 
					"WHERE A.status IN ('I') ",
					"jobreport",
					"viewquote",
					"view.png",
					"View"
				);
				
			showPanel(
					"All Jobs Awaiting QA", 
					"CREATOR", 
					"WHERE A.status IN ('C') ",
					"jobreport",
					"viewquote",
					"view.png",
					"View",
					false
				);
				
			showPanel(
					"All Jobs Awaiting Handover", 
					"CREATOR", 
					"WHERE A.status IN ('Q') ",
					"jobreport",
					"viewquote",
					"view.png",
					"View",
					false
				);
							
		} else if (isAuthenticated()) {
			showPanel(
					"My Quotes - Draft Stage", 
					"", 
					"WHERE A.status IN ('N', 'R') AND approvalid IS NULL " .
					"AND (A.createdby = " . $_SESSION['SESS_MEMBER_ID'] . " OR A.contactid  = " . $_SESSION['SESS_MEMBER_ID'] . ") ",
					"quotationreport"
				);
				
			showPanel(
					"My Quotes Awaiting Verification", 
					"", 
					"WHERE A.status IN ('N', 'R') AND approvalid IS NOT NULL " .
					"AND (A.createdby = " . $_SESSION['SESS_MEMBER_ID'] . " OR A.contactid  = " . $_SESSION['SESS_MEMBER_ID'] . ") ",
					"quotationreport"
				);
				
			showPanel(
					"My Jobs Awaiting Scheduling", 
					"", 
					"WHERE A.status IN ('A') " .
					"AND (A.createdby = " . $_SESSION['SESS_MEMBER_ID'] . " OR A.contactid  = " . $_SESSION['SESS_MEMBER_ID'] . ") ",
					"jobreport",
					"viewquote",
					"view.png",
					"View"
				);
				
			showPanel(
					"My Jobs Awaiting CE Approval", 
					"", 
					"WHERE A.status IN ('S') " .
					"AND (A.createdby = " . $_SESSION['SESS_MEMBER_ID'] . " OR A.contactid  = " . $_SESSION['SESS_MEMBER_ID'] . ") ",
					"jobreport",
					"viewquote",
					"view.png",
					"View"
				);
				
			showPanel(
					"My Jobs Awaiting Completion", 
					"", 
					"WHERE A.status IN ('I') " .
					"AND (A.createdby = " . $_SESSION['SESS_MEMBER_ID'] . " OR A.contactid  = " . $_SESSION['SESS_MEMBER_ID'] . ") ",
					"jobreport",
					"viewquote",
					"view.png",
					"View"
				);
				
			showPanel(
					"My Jobs Awaiting QA", 
					"", 
					"WHERE A.status IN ('C') " .
					"AND (A.createdby = " . $_SESSION['SESS_MEMBER_ID'] . " OR A.contactid  = " . $_SESSION['SESS_MEMBER_ID'] . ") ",
					"jobreport",
					"viewquote",
					"view.png",
					"View",
					false
				);
				
			showPanel(
					"My Jobs Awaiting Handover", 
					"", 
					"WHERE A.status IN ('Q') " .
					"AND (A.createdby = " . $_SESSION['SESS_MEMBER_ID'] . " OR A.contactid  = " . $_SESSION['SESS_MEMBER_ID'] . ") ",
					"jobreport",
					"viewquote",
					"view.png",
					"View",
					false
				);
		}
			
	?>
</div>

<div class="roundbox bgYellow">
	<?php
		if (isAuthenticated()) {
			showPanel(
					"Jobs Awaiting Cancellation Approval", 
					"CREATOR", 
					"INNER JOIN datatech_cancelledjobflowheader BA " .
					"ON BA.quoteid = A.id " .
					"INNER JOIN datatech_cancelledjobflowdetail BB " .
					"ON BB.flowheaderid = BA.id " .
					"AND BB.status != 'Y' " .
					"INNER JOIN datatech_userroles CA " .
					"ON CA.roleid = BB.roleid " .
					"WHERE A.status IN ('P') " .
					"AND CA.memberid = " . $_SESSION['SESS_MEMBER_ID'],
					"jobreport",
					"confirmcancellation",
					"approvecancel.png",
					"Approve Cancellation",
					false
				);
				
			showPanel(
					"Quotes Awaiting Verification", 
					"APPROVAL", 
					"WHERE A.status IN ('N', 'R') " .
					"AND A.approvalid IN " .
					"(SELECT roleid FROM datatech_userroles " .
					"WHERE memberid = " . $_SESSION['SESS_MEMBER_ID'] . ")",
					"quotationreport",
					"approval",
					"thumbs_up.gif",
					"Verify / Reject"
				);
				
			showPanel(
					"Job Awaiting Scheduling", 
					"SCHEDULE", 
					"WHERE A.status IN ('A') AND A.approvalid IS NOT NULL ",
					"jobreport",
					"schedule",
					"clock.png",
					"Schedule Job"
				);
				
			showPanel(
					"Job Awaiting CE Approval", 
					"CEAPPROVAL", 
					"WHERE A.status IN ('S') ",
					"jobreport",
					"implement",
					"approve.png",
					"CE Approval"
				);
				
			showPanel(
					"Job Awaiting Completion", 
					"COMPLETE", 
					"WHERE A.status IN ('I') ",
					"jobreport",
					"complete",
					"finish.gif",
					"Complete"
				);
				
			showPanel(
					"Job Awaiting QA", 
					"QA", 
					"WHERE A.status IN ('C') ",
					"jobreport",
					"qa",
					"quality.png",
					"QA",
					false
				);
				
			showPanel(
					"Job Awaiting Handover", 
					"ARCHIVE", 
					"WHERE A.status IN ('Q') ",
					"jobreport",
					"handover",
					"handover.png",
					"Hand Over",
					false
				);
		}
	?>
</div>
<!--  End of content -->
<?php
	function showPanel($title, $role, $whereClause, $pdf = "jobreport", $app = "editquote", $img = "edit.png", $tooltip = "Edit", $includeCancel = true, $includeRevert = false) {
		echo "<div class='portlet'>\n";
		echo "<h4>$title</h4>";
		
		if ($role == "" || isUserInRole($role)) {
			if (isset($_SESSION['PORTLET_' . $title]) && $_SESSION['PORTLET_' . $title] == "hide") {
				echo "<img title='Show' src='images/maximize.png' onclick='showHide(this)' />\n";
				
			} else {
				echo "<img title='Hide' src='images/minimize.png' onclick='showHide(this)' />\n";
			}
			
			$first = true;
			
			$qry = "SELECT DISTINCT A.prefix, A.status, A.notes, A.id, A.ccf, B.login, A.customer AS clientname, C.prefix AS jobprefix, " .
					"DATE_FORMAT(A.createddate, '%d/%m/%Y') AS createddate, " .
					"DATE_FORMAT(A.createddate, '%H:%i') AS createdtime, " .
					"DATE_FORMAT(A.approveddate, '%d/%m/%Y') AS approveddate, " .
					"DATE_FORMAT(A.approveddate, '%H:%i') AS approvedtime, " .
					"DATE_FORMAT(A.scheduleddate, '%d/%m/%Y') AS scheduleddate, " .
					"DATE_FORMAT(A.scheduleddate, '%H:%i') AS scheduledtime, " .
					"DATE_FORMAT(A.ceapproveddate, '%d/%m/%Y') AS ceapproveddate, " .
					"DATE_FORMAT(A.ceapproveddate, '%H:%i') AS ceapprovedtime, " .
					"DATE_FORMAT(A.completeddate, '%d/%m/%Y') AS completeddate, " .
					"DATE_FORMAT(A.completeddate, '%H:%i') AS completedtime, " .
					"DATE_FORMAT(A.qadate, '%d/%m/%Y') AS qadate, " .
					"DATE_FORMAT(A.qadate, '%H:%i') AS qatime, " .
					"(10 - DATEDIFF(CURDATE(), A.ceapproveddate)) AS remaining, D.name AS sitename " .
					"FROM datatech_quoteheader A " .
					"LEFT OUTER JOIN datatech_jobheader C " .
					"ON C.quoteid = A.id " .
					"LEFT OUTER JOIN datatech_members B " .
					"ON B.member_id = A.createdby " .
					"INNER JOIN datatech_sites D " .
					"ON D.id = A.siteid " .
					$whereClause . " " .
					"ORDER BY A.id";
			$result = mysql_query($qry);
			
			//Check whether the query was successful or not
			if ($result) {
				while (($member = mysql_fetch_assoc($result))) {
					if ($first) {
						if (isset($_SESSION['PORTLET_' . $title]) && $_SESSION['PORTLET_' . $title] == "hide") {
							echo "<table width='100%' cellspacing=0 cellpadding=0 class='grid' style='display:none'>\n";
							
						} else {
							echo "<table width='100%' cellspacing=0 cellpadding=0 class='grid'>\n";
						}
						
						echo "<thead>\n";
						echo "<tr>\n"; 
						
						if ($member['status'] == "N" || $member['status'] == "R") {
							echo "<td>Quote</td>\n";
							
						} else {
							echo "<td>Job</td>\n";
						}
	 					
						echo "<td  >Customer</td>\n";
						echo "<td   align=right>Value</td>\n";
						echo "<td  >Site</td>\n";
						
						if ($member['status'] == "N" || $member['status'] == "R") {
							echo "<td  >Raised</td>\n";
							
						} else if ($member['status'] == "A") {
							echo "<td  >Verified</td>\n";
							
						} else if ($member['status'] == "S") {
							echo "<td  >Scheduled</td>\n";
							
						} else if ($member['status'] == "I") {
							echo "<td  >Approved</td>\n";
							
						} else if ($member['status'] == "C") {
							echo "<td  >Completed</td>\n";
							
						} else if ($member['status'] == "Q") {
							echo "<td  >QA'd</td>\n";
						}
	
						if ($member['status'] == "I") {
							echo "<td   align=right>TR</td>\n";
						}
	
						echo "<td width='16px'></td>\n";
						echo "<td width='16px'></td>\n";
						echo "<td width='16px'></td>\n";
						
						if (isUserInRole("SUBADMIN") && $member['status'] == "P") {
							echo "<td width='16px'></td>\n";
						}
						
						if (isUserInRole("SUBADMIN") && $includeCancel) {
							echo "<td width='16px'></td>\n";
						}
						
						echo "</tr>\n";
						echo "</thead>\n";
			
						$first = false;					
					}
					
					$qry = "SELECT SUM(total) AS ordervalue " .
							"FROM datatech_quoteitem " .
							"WHERE headerid = " . $member['id'];
					$itemresult = mysql_query($qry);
					
					if ($itemresult) {
						while (($itemmember = mysql_fetch_assoc($itemresult))) {
							echo "<tr>";
							
							if ($member['status'] == "N" || $member['status'] == "R") {
								echo "<td  nowrap>" . $member['prefix'] . sprintf("%04d", $member['id']) . "</td>";
								echo "<td><div class='client2'>" . $member['clientname'].  "</div></td>";
								
							} else if ($member['status'] == "I") {
								echo "<td  nowrap>" . $member['jobprefix'] . sprintf("%04d", $member['id']) . "</td>";
								echo "<td><div class='client3'>" . $member['clientname'].  "</div></td>";
								
							} else {
								echo "<td   nowrap>" . $member['jobprefix'] . sprintf("%04d", $member['id']) . "</td>";
								echo "<td><div class='client1'>" . $member['clientname'].  "</div></td>";
								
							}
							
							echo
								"<td   align=right><div class='value'>" . number_format($itemmember['ordervalue'], 2) . "</div></td>" .
								"<td  >" . $member['sitename'].  "</td>";
								
	
							if ($member['status'] == "N" || $member['status'] == "R") {
								echo "<td title='" . $member['createdtime'] . "'><div class='date'>" . $member['createddate'].  "</div></td>";
								
							} else if ($member['status'] == "A") {
								echo "<td title='" . $member['approvedtime'] . "'><div class='date'>" . $member['approveddate'].  "</div></td>";
								
							} else if ($member['status'] == "S") {
								echo "<td title='" . $member['scheduledtime'] . "'><div class='date'>" . $member['scheduleddate'].  "</div></td>";
								
							} else if ($member['status'] == "I") {
								echo "<td title='" . $member['ceapprovedtime'] . "'><div class='date'>" . $member['ceapproveddate'].  "</div></td>";
								
							} else if ($member['status'] == "C") {
								echo "<td title='" . $member['completedtime'] . "'><div class='date'>" . $member['completeddate'].  "</div></td>";
								
							} else if ($member['status'] == "Q") {
								echo "<td title='" . $member['qatime'] . "'><div class='date'>" . $member['qadate'].  "</div></td>";
							}
								
							if ($member['status'] == "I") {
								echo "<td   align=right>" . $member['remaining'].  "</td>";
							}
								
							echo
								"<td  width='16px'  title='" . $tooltip . "'><a href='" . $app . ".php?id=" . $member['id'] . "'><img src='images/" . $img . "' /></a></td>" .
								"<td  width='16px'  title='PDF'><a target='_new' href='" . $pdf . ".php?id=" . $member['id'] . "'><img src='images/pdf.png' /></a></td>" .
								"<td  width='16px'  title='Documents' onclick='viewDocument(" . $member['id'] . ")'><img src='images/document.gif' /></td>";
								
							if (isUserInRole("SUBADMIN") && $member['status'] == "P") {
								echo "<td  width='16px'  title='Recover' onclick='recover(" . $member['id'] . ")'><img src='images/recover.png' /></td>";
							}
								
							if (isUserInRole("SUBADMIN") && $includeCancel) {
								if ($member['status'] == "N" || $member['status'] == "R") {
									echo "<td  width='16px'  title='Cancel' onclick='cancelDocument(" . $member['id'] . ", \"" . $member['prefix'] . sprintf("%04d", $member['id']) ."\")'><img src='images/cancel.png' /></td>";
									
								} else {
									echo "<td  width='16px'  title='Cancel' onclick='cancelDocument(" . $member['id'] . ", \"" . $member['jobprefix'] . sprintf("%04d", $member['id']) ."\")'><img src='images/cancel.png' /></td>";
								}
								
							}
								
							echo "</tr>";
						}
					}
				}
				
			} else {
				die($qry . " = " . mysql_error());
			}
			
			if (! $first) {
				echo "</table>\n";
			} else {
				echo "<img src='images/empty.gif' />";
			}
		}
		
		echo "</div>\n";
	}
?>
<script>
	var selectedID = null;
	var selectedDesc = null;
	
	function showHide(widget) {
		var setting;
		
		if ($(widget).attr("src") == "images/maximize.png") {
			$(widget).attr("src", "images/minimize.png");
			$(widget).attr("title", "Hide");
			$(widget).next().show();
			setting = "show";
			
		} else {
			$(widget).attr("src", "images/maximize.png");
			$(widget).attr("title", "Show");
			$(widget).next().hide();
			setting = "hide";
		}

		callAjax2(
				"updateportletsetting.php", 
				{
					item: setting,
					title: $(widget).prev().html()
				}
			);
					
	}
	
	function cancelDocument(id, name) {
		selectedID = id;
		selectedDesc = name;
		
		callAjax(
				"getnotes.php", 
				{
					id: id
				},
				function(data) {
					$("#notes").val(data[0].notes);
					$("#notesheader").html("Cancellation of " + data[0].id);
				},
				function(jqXHR, textStatus, errorThrown) {
					dtAlert(errorThrown);
				}
			);
			
		resetRefresh();
		
		$("#notesdialog").dialog("open");
	}
	
	function recover(item) {
		selectedID = item;
		
		$("#recoverdialog .confirmdialogbody").html("You are about to recover the job / quote.<br>Are you sure ?");
		$("#recoverdialog").dialog("open");
	}
	
	function recoverJob() {
		call("recoverJob", { pk1: selectedID });
	}
	
	function cancelJob() {
		call("cancelJob", { pk1: selectedID, pk2: $("#completionnotes").val() });
	}
	
	$(document).ready(
			function() {
				$("#notesdialog").dialog({
						modal: true,
						autoOpen: false,
						width: 800,
						show:"fade",
						hide:"fade",
						title: "Notes",
						open: function(event, ui){
							$("#completionnotes").focus();
						},
						buttons: {
							Ok: function() {
								if (selectedDesc.substring(0, 2) == "SC") {
									$("#confirmdialog .confirmdialogbody").html("You are about to cancel the job " + selectedDesc + ".<br>Are you sure ?");
									
								} else {
									$("#confirmdialog .confirmdialogbody").html("You are about to cancel the quote " + selectedDesc + ".<br>Are you sure ?");
								}
								
								$("#confirmdialog").dialog("open");
							},
							Cancel: function() {
								$(this).dialog("close");
								
								resetTimer();
							}
						}
					});
			}
		);
</script>
<?php include("system-footer.php"); ?>
