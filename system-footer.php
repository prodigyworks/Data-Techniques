			</div>
	</div>	
<div class="modal" id="alertdialog">
	<table>
		<tr>
			<td width=40><img src="images/alert.png" /></td>
			<td><p class='alertdialogbody'></p></td>
		</tr>
	</table>
</div>
</center>

<script type="text/javascript">   
	var resetRefresh;
	var resetTimer;
	var refreshTimer = null;
	
<?php
	if (endsWith($_SERVER['PHP_SELF'], "/index.php")) {
?>
	resetRefresh = function() {
			if (refreshTimer != null) {
				clearTimeout(refreshTimer); // cancels the countdown.
			} 
		};
	
	resetTimer = function(){                 
			resetRefresh();
			
			refreshTimer = setTimeout(
					function() { 
						document.location = "<?php echo $_SERVER['PHP_SELF']; ?>";                 
					},
					1000 * 60 * 1
				); // reinitiates the countdown.             
		}; 

	$(document).ready(function() {
			resetTimer(); // initiates the countdown.
			
			// bind the checker function to user events.
			$(document).bind("mousemove keypress click", resetTimer);
		});

<?php
	}
?>
</script> 
	
</body>
</html>