var globalAlertCallback = null;


function call(commandName, parameters) {
	if (parameters) {
		for (var param in parameters) {
			$("#" + param).val(parameters[param]);
			
			if (param == "page") {
				$("#commandForm").attr("action", parameters[param]);
			}
		}
	}
	
	setTimeout('document.body.style.cursor = "wait";', 0);
	
	$("#command").val(commandName);
	$("#commandForm").submit();
}

function dtAlert(body, callback) {
	globalAlertCallback = callback;
	
	$(".alertdialogbody").html(body);
	$("#alertdialog").dialog("open");
}

function isDate(txtDate) {     
	var objDate, 	// date object initialized from the txtDate string         
	mSeconds, 		// txtDate in milliseconds         
	day,      		// day         
	month,    		// month         
	year;     		// year     
	
	// date length should be 10 characters (no more no less)     
	
	if (txtDate.length !== 10) {         
		return false;     
	}     
	
	// third and sixth character should be '/'     
	
	if (txtDate.substring(2, 3) !== '/' || txtDate.substring(5, 6) !== '/') {         
		return false;     
	}     
	
	// extract month, day and year from the txtDate (expected format is mm/dd/yyyy)     
	// subtraction will cast variables to integer implicitly (needed     // for !== comparing)     
	
	day = txtDate.substring(0, 2) - 0;      
	month= txtDate.substring(3, 5) - 1; // because months in JS start from 0     
	year = txtDate.substring(6, 10) - 0;     
	
	// test year range     
	
	if (year < 1000 || year > 3000) {         
		return false;     
	}     
	
	// convert txtDate to milliseconds     
	
	mSeconds = (new Date(year, month, day)).getTime();     
	
	// initialize Date() object from calculated milliseconds     
	
	objDate = new Date();     
	objDate.setTime(mSeconds);     
	
	// compare input date and parts from Date() object     
	// if difference exists then date isn't valid     
	
	if (objDate.getFullYear() !== year ||         
		objDate.getMonth() !== month ||         
		objDate.getDate() !== day) {         
			return false;     
	}     
	// otherwise return true     
	return true; 
} 

function isTime(txtDate) {     
	var hour, minutes;     
	
	// date length should be 10 characters (no more no less)     
	
	if (txtDate.length !== 5) {         
		return false;     
	}     
	
	// third and sixth character should be '/'     
	
	if (txtDate.substring(2, 3) !== ':') {         
		return false;     
	}     
	
	hour = txtDate.substring(0, 2);      
	minutes= txtDate.substring(3, 5); 

	if (hour < 0 || hour > 23) {         
		return false;     
	}     
	
	if (minutes < 0 || minutes > 59) {         
		return false;     
	}     

	return true; 
} 

function callAjax(url, postdata, callback, async, error) {
	url = url + "?timestamp=" + new Date();
	
	$.ajax({
			url: url,
			dataType: 'json',
			async: async,
			data: postdata,
			type: "POST",
			error: function(jqXHR, textStatus, errorThrown) {
				if (error) {
					error(jqXHR, textStatus, errorThrown);
				} else {
//					alert("ERROR :" + errorThrown);
//					$("#footer").html(errorThrown);
				}
			},
			success: function(data) {
				if (callback != null) {
					callback(data);
				}
			}
		});
}

function verifyStandardForm(form) {
	var isValid = true;
	
	$(form).find("select").each(function() {
			var isRequired = ($(this).attr("required") != null && 
							(($(this).attr("required") == "true") || ($(this).attr("required") == true)));
		
			if (isRequired && $(this).find("option:selected").text() == "") {
				$(this).addClass("invalid");
				$(this).next().css("visibility", "visible");
				isValid = false;
				
			} else {
				$(this).removeClass("invalid");
				$(this).next().css("visibility", "hidden");
			}
		});

	
	$(form).find("input").each(function() {
			var isRequired = ($(this).attr("required") != null && 
							(($(this).attr("required") == "true") || ($(this).attr("required") == true)));
			
			if (isRequired && $(this).val() == "") {
				$(this).addClass("invalid");
				$(this).next().css("visibility", "visible");
				isValid = false;
				
			} else {
				$(this).removeClass("invalid");
				$(this).next().css("visibility", "hidden");
			}
		});

	return isValid;
}


function callAjax2(url, parameters, callback, error) {
	url = url + "?timestamp=" + new Date();
	
	if (parameters) {
		for (var param in parameters) {
			url = url + "&" + param + "=" + parameters[param];
		}
	}
	
	$.ajax({
			url: url,
			dataType: 'json',
			async: false,
			error: function(jqXHR, textStatus, errorThrown) {
				if (error) {
					error(jqXHR, textStatus, errorThrown);
				} else {
					alert("ERROR:" + errorThrown);
				}
			},
			success: function(data) {
				if (callback != null) {
					callback(data);
				}
			}
		});
}

function addRow(tableID, cells) {
	  // Get a reference to the table
	  var tableRef;
	  
	  tableRef = document.getElementById(tableID);
	  var body = tableRef.appendChild(document.createElement('tbody')) 
	  var tr = body.appendChild(document.createElement("tr"));

	  // Append a text node to the cell
	  for (var i = 0; i < cells; i++) {
		  var newCell = tr.appendChild(document.createElement("td"));
		  newCell.innerHTML = "<br>";
	  }
}

$(document).ready(function() {
		$("#alertdialog").dialog({
				modal: true,
				autoOpen: false,
				width: 300,
				show:"fade",
				title: "Information",
				hide:"fade",
				buttons: {
					Ok: function() {
						$(this).dialog("close");
						
						if (globalAlertCallback) {
							globalAlertCallback();
						}
					}
				}
			});
	
		$(".grid tbody tr").hover(
				function() {
					$(this).addClass("highlight");
				},
				function() {
					$(this).removeClass("highlight");
				}
			);
		
		try {
			$(".datepicker").datepicker({dateFormat: "dd/mm/yy"});
			
		} catch (error) {}
		
		try {
			$(".timepicker").timepicker();
			
		} catch (error) {}
		$(".entryform input").each(function() {
			$(this).after("<div class='bubble' title='Required field' />");
			$(this).blur(function() {
				if ($(this).attr("required") != null && $(this).attr("required") == "true" && $(this).val() == "") {
					$(this).addClass("invalid");
					$(this).next().css("visibility", "visible");
					
				} else {
					$(this).removeClass("invalid");
					$(this).next().css("visibility", "hidden");
				}
			});

		});
	
		$(".entryform select").each(function() {
			$(this).after("<div class='bubble' title='Required field' />");
			
			$(this).blur(function() {
				if ($(this).attr("required") != null && $(this).attr("required") == "true" && $(this).find("option:selected").text() == "") {
					$(this).addClass("invalid");
					$(this).next().css("visibility", "visible");
					
				} else {
					$(this).removeClass("invalid");
					$(this).next().css("visibility", "hidden");
				}
			});

		});
		
		$(".grid").each(
				function() {
					if ($(this).attr("id") != "") {
						var rows = $(this).find("tbody").children().length;
						var cells = $(this).find("thead tr").children('td').length;
						var maxrows = 19;
						
						if ($(this).attr("maxrows")) {
							maxrows = $(this).attr("maxrows");
						}
						
						if (rows < maxrows) {
							for (var i = rows; i < maxrows; i++) {
								addRow($(this).attr("id"), cells);
							}					
						}
					}
				}
			);
	});

function navigate(url) {
	window.location.href = url;
}

function getJSONData(url, selectid, callback) {
	$.ajax({
			url: url,
			dataType: 'json',
			async: false,
			error: function(jqXHR, textStatus, errorThrown) {
				alert("ERROR:" + errorThrown);
			},
			success: function(data) {
				var select = $(selectid);
				var options = select.attr('options');
				  
		        $('option', select).remove();  
				
		        $.each(data, function(index, array) {  
		             options[options.length] = new Option(array['name'], array['id']);  
		        });  

			 	callback();
			}
		});
}

function openClose(item) {
	if ($(item).parent().parent().next().find(".subtable").css("display") == "none") {
		$(item).parent().parent().next().find("> td").removeClass("hiddensubtable");
		$(item).parent().parent().next().find(".subtable").css("display", "block");
		item.src = "images/minus.gif";
		
	} else {
		$(item).parent().parent().next().find(".subtable").css("display", "none");
		$(item).parent().parent().next().find("> td").addClass("hiddensubtable");
		item.src = "images/plus.gif";
	}
}


function showHistory(id) {
	$("#historydialog").dialog("open");
}
