<?php 
	date_default_timezone_set('Europe/London'); 
	
	include("system-header.php"); 
?>

<!--  Start of content -->
<link rel="stylesheet" href="css/fullcalendar.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/fullcalendar.print.css" type="text/css" media="all" />

<script type="text/javascript" src="js/gcal.js"></script>
<script type="text/javascript" src="js/fullcalendar.js"></script>

<script>
	$(document).ready(function() {
	
		$('#calendar').fullCalendar({
			editable: true,
			aspectRatio: 2.1,
			allDayDefault: false, 

			eventRender: function(event, element) {
			   element.attr('title', "Clickx to view " + event.title);
			},
			
			eventClick: function(calEvent, jsEvent, view) {

				window.location.href = "viewquote.php?id=" + calEvent.id;
		    },
			
		    dayClick: function(date, allDay, jsEvent, view) {
		
		        // change the day's background color just for fun
		
		    },
			
			events: [
				<?php
					$result = mysql_query(
							"SELECT A.id, " .
							"DATE_FORMAT(A.scheduleddate, '%Y') AS startyear, " .
							"DATE_FORMAT(A.scheduleddate, '%c') AS startmonth, " .
							"DATE_FORMAT(A.scheduleddate, '%e') AS startday, " .
							"DATE_FORMAT(A.scheduleddate, '%H:%m:%S') AS starttime, " .
							"DATE_FORMAT(A.scheduleddate, '%Y') AS endyear, " .
							"DATE_FORMAT(A.scheduleddate, '%c') AS endmonth, " .
							"DATE_FORMAT(A.scheduleddate, '%e') AS endday, " .
							"DATE_FORMAT(A.scheduleddate, '%H:%m:%S') AS endtime, " .
							"A.prefix, B.prefix AS jobprefix, A.status " .
							"FROM datatech_quoteheader A " .
							"LEFT OUTER JOIN datatech_jobheader B " .
							"ON B.quoteid = A.id " .
							"WHERE A.scheduleddate IS NOT NULL " .
							"ORDER BY A.scheduleddate"
						);
					if ($result) {
						$counter = 0;
						
						/* Show children. */
						while (($member = mysql_fetch_assoc($result))) {
							if ($counter++ > 0) {
								echo ",\n";
							}
							
							$startHour = substr($member['starttime'], 0, 2 );
							$startMinute = substr($member['starttime'], 3, 2 );
							
							$endHour = substr($member['endtime'], 0, 2 );
							$endMinute = substr($member['endtime'], 3, 2 );
														
							echo "{\n";
							echo "id:" . $member['id'] . ",\n";
							
							if ($member['jobprefix'] == null) {
								echo "title: '" . $member['prefix'] . sprintf("%04d", $member['id']) . "',\n";

							} else {
								echo "title: '" . $member['jobprefix'] . sprintf("%04d", $member['id']) . "',\n";
							}
							
							echo "allDay: false,\n";
							echo "start: new Date(" . $member['startyear'] . ", " . ($member['startmonth'] - 1) . ", " . $member['startday'] . ", $startHour, $startMinute),\n";
							echo "end: new Date(" . $member['endyear'] . ", " . ($member['endmonth'] - 1) . ", " . $member['endday'] . ", $endHour, $endMinute)\n";
							echo "}\n";
						}
						
					} else {
//						die("Error:" + mysql_error());
					}
					
				?>
			]
		});
		
	});
	
	
	
</script>
<div id='calendar'></div>

<!--  End of content -->
<?php include("system-footer.php"); ?>