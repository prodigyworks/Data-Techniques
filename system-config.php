<?php
	$link = null;
	$db = null;
	
	require_once('system-db.php');
	
	class BreadCrumb {
	    // property declaration
	    public $page = "";
	    public $label = "";
	}
	
	class BreadCrumbManager {
		public static function initialise() {
			if (! isset($_SESSION['BREADCRUMBMANAGER'])) {
				$_SESSION['BREADCRUMBMANAGER'] = array();
			}
		}
		
		public static function add($pageName, $pageLabel) {
			$bc = new BreadCrumb();
			$bc->page = $pageName;
			$bc->label = $pageLabel;
			
			$_SESSION['BREADCRUMBMANAGER'][count($_SESSION['BREADCRUMBMANAGER'])] = $bc;
		}
		
		public static function remove($index) {
			unset($_SESSION['BREADCRUMBMANAGER'][$index]);
		}
		
		public static function showBreadcrumbTrail() {
			$first = true;
			
			echo "<h4 class='breadcrumb'>";
			
			for ($i = count($_SESSION['BREADCRUMBMANAGER']) - 1; $i >= 0; $i--) {
				if (! $first) {
					echo "<span>&nbsp;/&nbsp;</span>";
				}
				
				$first = false;
				
				echo "<a href='" .$_SESSION['BREADCRUMBMANAGER'][$i]->page . "' ";
				
				if ($i == 0) {
					echo "class='lastchild'";
				}
				
				echo ">" . $_SESSION['BREADCRUMBMANAGER'][$i]->label . "</a>";
			} 
			
			echo "</h4>";
		}
		
		public static function fetchParent($id) {
			$qry = "SELECT A.pageid, B.pagename, B.label FROM datatech_pagenavigation A " .
					"INNER JOIN datatech_pages B " .
					"ON B.pageid = A.pageid " .
					"WHERE A.childpageid = $id";
			$result = mysql_query($qry);
			
			//Check whether the query was successful or not
			if ($result) {
				if (mysql_num_rows($result) == 1) {
					$member = mysql_fetch_assoc($result);
					
					if ($id != $member['pageid']) {
						self::add($member['pagename'], $member['label']);
						self::fetchParent($member['pageid']);
					}
					
				} else if (mysql_num_rows($result) == 0) {
					if ($id > 1) { /* Not a home connection */
						self::add("index.php", "Dashboard");
					}
				}
			}
		}
		
		public static function calculate() {
			unset($_SESSION['BREADCRUMBMANAGER']);
			
			self::initialise();
    		self::add($_SESSION['pagename'], $_SESSION['title']);
			self::fetchParent($_SESSION['pageid']);
	    	
	    	if (isAuthenticated()) {
		    	if (isset($_SESSION['lastconnectiontime'])) {
		    		$lastsessiontime = time() - $_SESSION['lastconnectiontime'];
		    		
		    		/* 5 minutes. */
		    		if ($lastsessiontime >= 3000) {	//Unset the variables stored in session
		    			if (isset($_SESSION['QUOTATION'])) {
		    				/* Auto save quote on timeout. */
		    				$header = $_SESSION['QUOTATION'];
		    				$header->save();
		    			}
		    			
						unset($_SESSION['SESS_MEMBER_ID']);
						unset($_SESSION['SESS_FIRST_NAME']);
						unset($_SESSION['SESS_LAST_NAME']);
						unset($_SESSION['ROLES']);
//						unset($_SESSION['ERRMSG_ARR']);
	
		    			header("location: system-login.php?session=" . urlencode(base64_encode("index.php")));
		    		}
		    	}
	    	}
	    	
	   		$_SESSION['lastconnectiontime'] = time();
	    }
	}
	
	class SessionManagerClass {
		public static function initialise() {
			//Start session
			start_db();
		    
		    $_SESSION['pagename'] = substr($_SERVER["PHP_SELF"], strripos($_SERVER["PHP_SELF"], "/") + 1);
		    
		    BreadCrumbManager::initialise();
		    
		    self::initialiseDB();
			self::initialisePageData();

			BreadCrumbManager::calculate();
		}
		
	    public static function initialiseDB() {
	    	initialise_db();
		
			if (! isset($_SESSION['ROLES'])) {
				$_SESSION['ROLES'] = array();
				$_SESSION['ROLES'][0] = "PUBLIC";
			}
	    }
	    
        public static function initialisePageData() {
			$qry = "SELECT DISTINCT A.* FROM datatech_pages A " .
					"INNER JOIN datatech_pageroles B " .
					"ON B.pageid = A.pageid " .
					"WHERE A.pagename = '" . $_SESSION['pagename'] . "' " .
					"AND B.roleid IN (" . ArrayToInClause($_SESSION['ROLES']) . ")";
			$result = mysql_query($qry);

			//Check whether the query was successful or not
			if ($result) {
				if (mysql_num_rows($result) == 1) {
					$member = mysql_fetch_assoc($result);
					
					$_SESSION['pageid'] = $member['pageid'];
					$_SESSION['title'] = $member['label'];
					
					echo "<script>document.title = '" . $member['label'] . " - DTi';</script>\n";
					
				} else {
					header("location: system-access-denied.php");
				}
					
			} else {
				header("location: system-access-denied.php");
			}
	    }
	    
	}

    SessionManagerClass::initialise();
	
	function showErrors() {
		if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
			echo '<ul class="err">';
			foreach($_SESSION['ERRMSG_ARR'] as $msg) {
				echo '<li>',$msg,'</li>'; 
			}
			echo '</ul>';
			unset($_SESSION['ERRMSG_ARR']);
		}
	}
    
    function showSubMenu($id) {
		$qry = "SELECT DISTINCT B.pagename, B.label FROM datatech_pagenavigation A " .
				"INNER JOIN datatech_pages B " .
				"ON A.childpageid = B.pageid " .
				"INNER JOIN datatech_pageroles C " .
				"ON C.pageid = B.pageid " .
				"WHERE A.pageid = " . $id . " " .
				"AND A.pagetype = 'M' " .
				"AND C.roleid IN (" . ArrayToInClause($_SESSION['ROLES']) . ") " .
				"ORDER BY A.sequence";
		$result=mysql_query($qry);

		//Check whether the query was successful or not
		if($result) {
			
			if (mysql_num_rows($result) >  0) {
				echo "<ul class='submenu'>\n";
		
				/* Show children. */
				while (($member = mysql_fetch_assoc($result))) {
					if ($member['pagename'] == $_SESSION['pagename']) {
						echo "<li class='selected submenuitem'>" ;
						
					} else {
						echo "<li class='submenuitem'>";
					}
					
					echo "<a href='" . $member['pagename'] . "'>" . $member['label'] . "</a></li>\n";
				}
		
				echo "</ul>\n";
			}
		}
    }

    function findParentMenu($id, $ancestors) {
		$qry = "SELECT pageid, pagetype " .
				"FROM datatech_pagenavigation " .
				"WHERE childpageid = $id";
		$result=mysql_query($qry);

		//Check whether the query was successful or not
		if($result) {
			
			if (mysql_num_rows($result) > 0) {
				$member = mysql_fetch_assoc($result);
				$ancestors[count($ancestors)] = $member['pageid'];
				
				if ($member['pagetype'] == "M" ||
					$member['pagetype'] == "L") {
					$ancestors = findParentMenu($member['pageid'], $ancestors);
				}
				
			} else {
				$ancestors[count($ancestors)] = 1;
			}
		}
		
		return $ancestors;
    }
    
    function showMenu() {
    	nestPages($_SESSION['pageid'], array($_SESSION['pageid']));
    }
    
    function nestPages($id, $ancestors) {
		$qry = "SELECT DISTINCT A.*, B.* FROM datatech_pagenavigation A " .
				"INNER JOIN datatech_pages B " .
				"ON A.childpageid = B.pageid " .
				"INNER JOIN datatech_pageroles C " .
				"ON C.pageid = B.pageid " .
				"WHERE A.pageid = " . $id . " " .
				"AND A.pagetype = 'P' " .
				"AND C.roleid IN (" . ArrayToInClause($_SESSION['ROLES']) . ") " .
				"ORDER BY A.sequence";
		$result=mysql_query($qry);
		
		//Check whether the query was successful or not
		if($result) {
			
			if (mysql_num_rows($result) == 0) {
				if (isAuthenticated()) {
					$ancestors = findParentMenu($id, $ancestors);
					
					nestPages($ancestors[count($ancestors) - 1], $ancestors);
				}
				
			} else {
				$result=mysql_query($qry);
				$highestPage = 0;

				while (($member = mysql_fetch_assoc($result))) {
					
					for ($index = 0; $index < count($ancestors); $index++) {
						if ($ancestors[$index] == $member['pageid']) {
							
							if ($highestPage < $member['pageid']) {
								$highestPage = $member['pageid'];
							}
						}
					}
				}
		
				$result=mysql_query($qry);
				
				echo "<ul class='menu'>\n";
		
				/* Show children. */
				while (($member = mysql_fetch_assoc($result))) {

					if ($highestPage == $member['pageid']) {
						echo "<li class='selected menuitem'" ;
						
					} else {
						echo "<li class='menuitem' ";
					}
					
					echo " onclick='window.location.href = \"" . $member['pagename'] . "\"'>";
					
				    showSubMenu($member['childpageid']);

					echo "<a href='" . $member['pagename'] . "'>" . $member['label'] . "</a></li>\n";
					
					if ($member['divider'] == 1) {
						echo "<div class='divider'>&nbsp;</div>\n";
					}
				}
		
				echo "</ul>\n";
			}
		}
    }
	
	function ArrayToInClause($arr) {
		$count = count($arr);
		$str = "";
		
		for ($i = 0; $i < $count; $i++) {
			if ($i > 0) {
				$str = $str . ", ";
			}
			
			$str = $str . "\"" . $arr[$i] . "\"";
		}
		
		return $str;
	}
	
	function createDocumentLink() {
		echo "<div class='modal documentmodal' id='documentDialog'>\n";
		echo "<iframe width=100% height=100% src='' frameborder='0' scrolling='no' src='' ></iframe>\n";
		echo "</div>\n";
		echo "<script>\n";
		echo "$(document).ready(function() {\n";
		echo "	$('#documentDialog').dialog({\n";
		echo "			autoOpen: false,\n";
		echo "			modal: true,\n";
		echo "			width: 1100,\n";
		echo "			height: 600,\n";
		echo "			title: 'Documents',\n";
		echo "			show:'fade',\n";
		echo "			hide:'fade',\n";
		echo "			dialogClass: 'document-dialog',\n";
		echo "			buttons: {\n";
		echo "				'Back': function() {\n";
		echo "					$(this).dialog('close');\n";
		echo "					try { resetTimer(); } catch (e) {}\n";
		echo "				}\n";
		echo "			}\n";
		echo "		});\n";
		echo "	});\n";
				
		echo "	function viewDocument(headerid) {\n";
		echo "		try {resetRefresh(); } catch(e) {}\n";
		echo "		$('iframe').attr('src', 'documents.php?id=' + headerid);\n";
		echo "		$('#documentDialog').dialog('open');\n";
		echo "	}\n";
		echo "	function viewSessionDocument(sessionid) {\n";
		echo "		try {resetRefresh(); } catch(e) {}\n";
		echo "		$('iframe').attr('src', 'documents.php?sessionid=' + sessionid);\n";
		echo "		$('#documentDialog').dialog('open');\n";
		echo "	}\n";
		echo "</script>\n";
	}
?>
