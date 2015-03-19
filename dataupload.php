<?php
	include("system-header.php"); 
	
	$substringstart = 0;
	
	function startsWith($Haystack, $Needle){
	    // Recommended version, using strpos
	    return strpos($Haystack, $Needle) === 0;
	}
	
	class PriceItem {
	    // property declaration
	    public $from = 0;
	    public $to = 0;
	}
 
	class ProductLength {
	    // property declaration
	    public $length = 0;
	    public $longline = 0;
	}

	if (isset($_FILES['labourcsvfile']) && $_FILES['labourcsvfile']['tmp_name'] != "") {
		if ($_FILES["labourcsvfile"]["error"] > 0) {
			echo "Error: " . $_FILES["labourcsvfile"]["error"] . "<br />";
			
		} else {
		  	echo "Upload: " . $_FILES["labourcsvfile"]["name"] . "<br />";
		  	echo "Type: " . $_FILES["labourcsvfile"]["type"] . "<br />";
		  	echo "Size: " . ($_FILES["labourcsvfile"]["size"] / 1024) . " Kb<br />";
		  	echo "Stored in: " . $_FILES["labourcsvfile"]["tmp_name"] . "<br>";
		}
		
		$subcat1 = "";
		$subcat2 = "";
		$row = 1;
		
		if (($handle = fopen($_FILES['labourcsvfile']['tmp_name'], "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        if ($row++ == 1) {
		        	continue;
		        }
		        
		        $num = count($data);
		        
		        
		        if ($data[0] != "" && $data[2] != "") {
		        	$name = $data[2];
		        	
		        	if ($data[1] == "Standard Hours") {
			        	$inhourrate = substr($data[4], $substringstart);
			        	$outhourrate = substr($data[4], $substringstart);
			        	$sathourrate = substr($data[4], $substringstart);
			        	
			        	echo "<h1>RATE: " .$data[4] .  " = " . $inhourrate . "</h1>";
			        	
						$qry = "INSERT INTO datatech_technicianrates " .
								"(name, inhourrate, outhourrate, sathourrate, createdby, createddate) " .
								"VALUES " .
								"('$name', $inhourrate, $outhourrate, $sathourrate, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
								
						$result = mysql_query($qry);
			        	$techid =  mysql_insert_id();
	        	
						if (mysql_errno() == 1062) {
							$qry = "SELECT id " .
									"FROM datatech_technicianrates " .
									"WHERE name = '$name'";
							$result = mysql_query($qry);
							
							//Check whether the query was successful or not
							if ($result) {
								while (($member = mysql_fetch_assoc($result))) {
									$techid = $member['id'];
								}
							}
							
							$qry = "UPDATE datatech_technicianrates SET " .
									"inhourrate = $inhourrate " .
									"WHERE id = $techid";
							$result = mysql_query($qry);
						
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
							
						} else {
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						}
						
		        	} else if ($data[1] == "Out of Hours") {
			        	$inhourrate = substr($data[4], $substringstart);
			        	$outhourrate = substr($data[4], $substringstart);
			        	$sathourrate = substr($data[4], $substringstart);
			        	
						$qry = "INSERT INTO datatech_technicianrates " .
								"(name, inhourrate, outhourrate, sathourrate, createdby, createddate) " .
								"VALUES " .
								"('$name', $inhourrate, $outhourrate, $sathourrate, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
								
						$result = mysql_query($qry);
			        	$techid =  mysql_insert_id();
	        	
						if (mysql_errno() == 1062) {
							$qry = "SELECT id " .
									"FROM datatech_technicianrates " .
									"WHERE name = '$name'";
							$result = mysql_query($qry);
							
							//Check whether the query was successful or not
							if ($result) {
								while (($member = mysql_fetch_assoc($result))) {
									$techid = $member['id'];
								}
							}
							
							$qry = "UPDATE datatech_technicianrates SET " .
									"outhourrate = $outhourrate " .
									"WHERE id = $techid";
							$result = mysql_query($qry);
						
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
							
						} else {
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						}
		        	}
		        	
		        }
		    }
		    
		    fclose($handle);
			echo "<h1>" . $row . " downloaded</h1>";
		}
	}
	
	if (isset($_FILES['sundrycsvfile']) && $_FILES['sundrycsvfile']['tmp_name'] != "") {
		if ($_FILES["sundrycsvfile"]["error"] > 0) {
			echo "Error: " . $_FILES["sundrycsvfile"]["error"] . "<br />";
			
		} else {
		  	echo "Upload: " . $_FILES["sundrycsvfile"]["name"] . "<br />";
		  	echo "Type: " . $_FILES["sundrycsvfile"]["type"] . "<br />";
		  	echo "Size: " . ($_FILES["sundrycsvfile"]["size"] / 1024) . " Kb<br />";
		  	echo "Stored in: " . $_FILES["sundrycsvfile"]["tmp_name"] . "<br>";
		}
		
		$subcat1 = "";
		$row = 1;
		
		
		if (($handle = fopen($_FILES['sundrycsvfile']['tmp_name'], "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        if ($row++ == 1) {
		        	continue;
		        }
		        
		        $num = count($data);
		        
		        if ($data[4] != "") {
		        	$category = $data[0];
		        	$subcat1 = $data[1];
		        	$productname = $data[2];
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$category', 0, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$categoryid =  mysql_insert_id();

					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$category'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$categoryid = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}					
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$subcat1', $categoryid, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$subcat1id =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$subcat1' " .
								"AND parentcategoryid = $categoryid";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$subcat1id = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
					$qry = "INSERT INTO datatech_products (name, categoryid, createdby, createddate) " .
							"VALUES ('$productname', $subcat1id, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$productid =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_products " .
								"WHERE categoryid = $subcat1id " .
								"AND name = '$productname'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$productid = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
					$supplyinstalled = substr($data[4], $substringstart);
					$supplyonly = substr($data[5], $substringstart);
					
					$qry = "INSERT INTO datatech_supplieditems (productid, supplyinstalled, supplyonly, createdby, createddate) " .
							"VALUES ($productid, $supplyinstalled, $supplyonly , " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$productid =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "UPDATE datatech_supplieditems " .
								"WHERE productid = $productid";
						$result = mysql_query($qry);
						
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
		        }
		    }
		    
		    fclose($handle);
			echo "<h1>" . $row . " downloaded</h1>";
		}
	}
	
	if (isset($_FILES['patchleadcsvfile']) && $_FILES['patchleadcsvfile']['tmp_name'] != "") {
		if ($_FILES["patchleadcsvfile"]["error"] > 0) {
			echo "Error: " . $_FILES["patchleadcsvfile"]["error"] . "<br />";
			
		} else {
		  	echo "Upload: " . $_FILES["patchleadcsvfile"]["name"] . "<br />";
		  	echo "Type: " . $_FILES["patchleadcsvfile"]["type"] . "<br />";
		  	echo "Size: " . ($_FILES["patchleadcsvfile"]["size"] / 1024) . " Kb<br />";
		  	echo "Stored in: " . $_FILES["patchleadcsvfile"]["tmp_name"] . "<br>";
		}
		
		$subcat1 = "";
		$row = 1;
		
		
		if (($handle = fopen($_FILES['patchleadcsvfile']['tmp_name'], "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        if ($row++ == 1) {
		        	continue;
		        }
		        
		        $num = count($data);
		        
		        
		        if ($data[0] != "") {
		        	$category = $data[0];
		        	$subcat1 = $data[1];
		        	$subcat2 = $data[2];
//		        	$subcat2 = substr($data[3], 0, strpos($data[3], " "));
//		        	$productname = $data[3];
		        	$productname = $data[4];
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$category', 0, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$categoryid =  mysql_insert_id();

					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$category'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$categoryid = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}					
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$subcat1', $categoryid, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$subcat1id =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$subcat1' " .
								"AND parentcategoryid = $categoryid";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$subcat1id = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$subcat2', $subcat1id, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$subcat2id =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$subcat2' " .
								"AND parentcategoryid = $subcat1id";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$subcat2id = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
					preg_match("/[0-9]+m|[0-9]+[.][0-9]+m/", $productname, $matches);
					$productname = trim(str_replace("$matches[0]", "", $productname));
		            $length = substr($matches[0], 0, strlen($matches[0]) - 1);
					
					$qry = "INSERT INTO datatech_products (name, categoryid, createdby, createddate) " .
							"VALUES ('$productname', $subcat2id, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$productid =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_products " .
								"WHERE categoryid = $subcat2id " .
								"AND name = '$productname'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$productid = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
					$qry = "INSERT INTO datatech_productlengths " .
							"(productid, length,  createdby, createddate) " .
							"VALUES " .
							"($productid, '$length', " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$productlengthid =  mysql_insert_id();
	        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_productlengths " .
								"WHERE productid = $productid " .
								"AND length = '$length'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$productlengthid = $member['id'];
							}
						}
					
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					   
//		            $supplyinstalled = floatval(str_replace(",", "", substr($data[5], $substringstart)));
//		            $supplyonly = floatval(str_replace(",", "", substr($data[6], $substringstart)));
		            $supplyinstalled = floatval(str_replace(",", "", substr($data[6], $substringstart)));
		            $supplyonly = floatval(str_replace(",", "", substr($data[7], $substringstart)));
	            	$installonly = 0;
					
					$qry = "INSERT INTO datatech_suppliedlengthprice " .
							"(productlengthid, supplyinstalled, supplyonly, installonly, createdby, createddate) " .
							"VALUES " .
							"($productlengthid, $supplyinstalled, $supplyonly, $installonly, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
							
					$result = mysql_query($qry);
		        	$priceid =  mysql_insert_id();
        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_suppliedlengthprice " .
								"WHERE productlengthid = $productlengthid";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$priceid = $member['id'];
							}
						}
						
						$qry = "UPDATE datatech_suppliedlengthprice SET " .
								"supplyinstalled = $supplyinstalled, " .
								"supplyonly = $supplyonly," .
								"installonly = $installonly " .
								"WHERE id = $priceid";
						$result = mysql_query($qry);
					
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
					$qry = "INSERT INTO datatech_pricebreaks " .
							"(productlengthid, fromunit, tounit, price, createdby, createddate) " .
							"VALUES " .
							"($productlengthid, 0, 0, $supplyinstalled, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
							
					$result = mysql_query($qry);
		        	$productbreakid =  mysql_insert_id();
        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_pricebreaks " .
								"WHERE productlengthid = $productlengthid " .
								"AND fromunit = 0 " .
								"AND tounit = 0";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$pricebreakid = $member['id'];
							}
						}
						
						$qry = "UPDATE datatech_pricebreaks " .
								"SET price = $supplyinstalled " .
								"WHERE id = $pricebreakid";
						$result = mysql_query($qry);
					
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
		        }
		    }
		    
		    fclose($handle);
			echo "<h1>" . $row . " downloaded</h1>";
		}
	}
	
	if (isset($_FILES['panelcsvfile']) && $_FILES['panelcsvfile']['tmp_name'] != "") {
		if ($_FILES["panelcsvfile"]["error"] > 0) {
			echo "Error: " . $_FILES["panelcsvfile"]["error"] . "<br />";
			
		} else {
		  	echo "Upload: " . $_FILES["panelcsvfile"]["name"] . "<br />";
		  	echo "Type: " . $_FILES["panelcsvfile"]["type"] . "<br />";
		  	echo "Size: " . ($_FILES["panelcsvfile"]["size"] / 1024) . " Kb<br />";
		  	echo "Stored in: " . $_FILES["panelcsvfile"]["tmp_name"] . "<br>";
		}
		
		$subcat1 = "";
		$row = 1;
		
		
		if (($handle = fopen($_FILES['panelcsvfile']['tmp_name'], "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        if ($row++ == 1) {
		        	continue;
		        }
		        
		        $num = count($data);

		        if ($data[5] != "") {
		        	$category = $data[0];
		        	$subcat1 = $data[1];
		        	$subcat2 = $data[2];
		        	$productname = $data[4];
		        	
		        	if ($subcat2 == "N/A") {
		        		$subcat2 = "Cat6";
		        	}
		        	
		        	echo "Category: $category Subcat1: $subcat1 Subcat2: $subcat2<br>";
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$category', 0, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$categoryid =  mysql_insert_id();

					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$category'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$categoryid = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}					
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$subcat1', $categoryid, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$subcat1id =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$subcat1' " .
								"AND parentcategoryid = $categoryid";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$subcat1id = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$subcat2', $subcat1id, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$subcat2id =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$subcat2' " .
								"AND parentcategoryid = $subcat1id";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$subcat2id = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
					$qry = "INSERT INTO datatech_products (name, categoryid, createdby, createddate) " .
							"VALUES ('$productname', $subcat2id, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$productid =  mysql_insert_id();

					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_products " .
								"WHERE categoryid = $subcat2id " .
								"AND name = '$productname'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$productid = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
		            $length = substr($data[5], 0, strlen($data[5]) - 1);
		            
					$qry = "INSERT INTO datatech_productlengths " .
							"(productid, length,  createdby, createddate) " .
							"VALUES " .
							"($productid, '$length', " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$productlengthid =  mysql_insert_id();
	        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_productlengths " .
								"WHERE productid = $productid " .
								"AND length = '$length'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$productlengthid = $member['id'];
							}
						}
					
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
		
					if ($data[9] == "" && $data[8] == "") {
						continue;
					}
					
					if ($data[9] == "") {
						$fromunit = 0;
						$tounit = 0;
			            $price = floatval(str_replace(",", "", substr($data[8], $substringstart)));
						
						$qry = "INSERT INTO datatech_pricebreaks " .
								"(productlengthid, fromunit, tounit, price, createdby, createddate) " .
								"VALUES " .
								"($productlengthid, $fromunit, $tounit, $price, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
								
						$result = mysql_query($qry);
			        	$productbreakid =  mysql_insert_id();
	        	
						if (mysql_errno() == 1062) {
							$qry = "SELECT id " .
									"FROM datatech_pricebreaks " .
									"WHERE productlengthid = $productlengthid " .
									"AND fromunit = '$fromunit' " .
									"AND tounit = '$tounit'";
							$result = mysql_query($qry);
							
							//Check whether the query was successful or not
							if ($result) {
								while (($member = mysql_fetch_assoc($result))) {
									$pricebreakid = $member['id'];
								}
							}
							
							$qry = "UPDATE datatech_pricebreaks " .
									"SET price = $price " .
									"WHERE id = $pricebreakid";
							$result = mysql_query($qry);
						
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
							
						} else {
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						}
					
					} else {
						$fromunit = 1;
						$tounit = 20;
			            $price = floatval(str_replace(",", "", substr($data[8], $substringstart)));
						
						$qry = "INSERT INTO datatech_pricebreaks " .
								"(productlengthid, fromunit, tounit, price, createdby, createddate) " .
								"VALUES " .
								"($productlengthid, $fromunit, $tounit, $price, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
								
						$result = mysql_query($qry);
			        	$productbreakid =  mysql_insert_id();
	        	
						if (mysql_errno() == 1062) {
							$qry = "SELECT id " .
									"FROM datatech_pricebreaks " .
									"WHERE productlengthid = $productlengthid " .
									"AND fromunit = '$fromunit' " .
									"AND tounit = '$tounit'";
							$result = mysql_query($qry);
							
							//Check whether the query was successful or not
							if ($result) {
								while (($member = mysql_fetch_assoc($result))) {
									$pricebreakid = $member['id'];
								}
							}
							
							$qry = "UPDATE datatech_pricebreaks " .
									"SET price = $price " .
									"WHERE id = $pricebreakid";
							$result = mysql_query($qry);
						
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
							
						} else {
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						}
						
						$fromunit = 21;
						$tounit = 0;
			            $price = floatval(str_replace(",", "", substr($data[9], $substringstart)));
						
						$qry = "INSERT INTO datatech_pricebreaks " .
								"(productlengthid, fromunit, tounit, price, createdby, createddate) " .
								"VALUES " .
								"($productlengthid, $fromunit, $tounit, $price, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
								
						$result = mysql_query($qry);
			        	$productbreakid =  mysql_insert_id();
	        	
						if (mysql_errno() == 1062) {
							$qry = "SELECT id " .
									"FROM datatech_pricebreaks " .
									"WHERE productlengthid = $productlengthid " .
									"AND fromunit = '$fromunit' " .
									"AND tounit = '$tounit'";
							$result = mysql_query($qry);
							
							//Check whether the query was successful or not
							if ($result) {
								while (($member = mysql_fetch_assoc($result))) {
									$pricebreakid = $member['id'];
								}
							}
							
							$qry = "UPDATE datatech_pricebreaks " .
									"SET price = $price " .
									"WHERE id = $pricebreakid";
							$result = mysql_query($qry);
						
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
							
						} else {
							if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						}
					}
		            
					
		        }
		    }
		    
		    fclose($handle);
			echo "<h1>" . $row . " downloaded</h1>";
		}
	}
	
	if (isset($_FILES['longlinecsvfile']) && $_FILES['longlinecsvfile']['tmp_name'] != "") {
		if ($_FILES["longlinecsvfile"]["error"] > 0) {
			echo "Error: " . $_FILES["longlinecsvfile"]["error"] . "<br />";
			
		} else {
		  	echo "Upload: " . $_FILES["longlinecsvfile"]["name"] . "<br />";
		  	echo "Type: " . $_FILES["longlinecsvfile"]["type"] . "<br />";
		  	echo "Size: " . ($_FILES["longlinecsvfile"]["size"] / 1024) . " Kb<br />";
		  	echo "Stored in: " . $_FILES["longlinecsvfile"]["tmp_name"] . "<br>";
		}
		
		$subcat1 = "";
		$row = 1;
		
		
		if (($handle = fopen($_FILES['longlinecsvfile']['tmp_name'], "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        if ($row++ == 1) {
		        	continue;
		        }
		        
		        $num = count($data);
		        
		        
		        if ((isset($data[6]) && $data[6] != "") || (isset($data[7]) && $data[7] != "") || (isset($data[8]) && $data[8] != "")) {
		        	$category = $data[0];
		        	$subcat1 = $data[1];
		        	$subcat2 = "";
		        	$productname = $data[3];
		        	
		        	if (startsWith($productname, "RJ45")) {
			        	$subcat2 = "RJ45";
			        	
		        	} else if (strpos($productname, "OM2")) {
			        	$subcat2 = "OM2";
			        	
		        	} else if (strpos($productname, "OM3")) {
			        	$subcat2 = "OM3";
			        	
		        	} else if (strpos($productname, "OS1")) {
			        	$subcat2 = "OS1";
			        	
		        	} else if (strpos($productname, "G703")) {
			        	$subcat2 = "G703";
		        	}
		        	
		        	if ($subcat2 == "") {
		        		continue;
		        	}
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$category', 0, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$categoryid =  mysql_insert_id();

					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$category'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$categoryid = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}					
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$subcat1', $categoryid, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$subcat1id =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$subcat1' " .
								"AND parentcategoryid = $categoryid";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$subcat1id = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
		        	
					$qry = "INSERT INTO datatech_categories (name, parentcategoryid, createdby, createddate) " .
							"VALUES " .
							"('$subcat2', $subcat1id, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$subcat2id =  mysql_insert_id();
		        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_categories " .
								"WHERE name = '$subcat2' " .
								"AND parentcategoryid = $subcat1id";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$subcat2id = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
					$qry = "INSERT INTO datatech_products (name, categoryid, createdby, createddate) " .
							"VALUES ('$productname', $subcat2id, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$productid =  mysql_insert_id();

					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_products " .
								"WHERE categoryid = $subcat2id " .
								"AND name = '$productname'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$productid = $member['id'];
							}
						}
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
		            $length = substr($data[4], 0, strlen($data[4]) - 1);
		            
					$qry = "INSERT INTO datatech_productlengths " .
							"(productid, length,  createdby, createddate) " .
							"VALUES " .
							"($productid, '$length', " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
					$result = mysql_query($qry);
		        	$productlengthid =  mysql_insert_id();
	        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_productlengths " .
								"WHERE productid = $productid " .
								"AND length = '$length'";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$productlengthid = $member['id'];
							}
						}
					
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
		
		            $supplyinstalled = floatval(str_replace(",", "", substr($data[6], $substringstart)));
		            
		            if (! isset($data[7]) || $data[7] == "") {
			            $supplyonly = 0;
			            
		            } else {
			            $supplyonly = floatval(str_replace(",", "", substr($data[7], $substringstart)));
		            }
		            
		            if (! isset($data[8]) || $data[8] == "") {
		            	$installonly = 0;
		            	
		            } else {
			            $installonly = floatval(str_replace(",", "", substr($data[8], $substringstart)));
		            }
					echo "<h3>Long line supply and install:" . $productname . " = " . substr($data[6], $substringstart) . " replaced: " . str_replace(",", "", substr($data[6], $substringstart)) . " floatval:" . floatval(str_replace(",", "", substr($data[6], $substringstart))) . " supp: " .$supplyinstalled . "</h3>";
					
					$qry = "INSERT INTO datatech_suppliedlengthprice " .
							"(productlengthid, supplyinstalled, supplyonly, installonly, createdby, createddate) " .
							"VALUES " .
							"($productlengthid, $supplyinstalled, $supplyonly, $installonly, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
							
					$result = mysql_query($qry);
		        	$priceid =  mysql_insert_id();
        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_suppliedlengthprice " .
								"WHERE productlengthid = $productlengthid";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$priceid = $member['id'];
							}
						}
						
						$qry = "UPDATE datatech_suppliedlengthprice SET " .
								"supplyinstalled = $supplyinstalled, " .
								"supplyonly = $supplyonly," .
								"installonly = $installonly " .
								"WHERE id = $priceid";
						$result = mysql_query($qry);
					
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
					
					$qry = "INSERT INTO datatech_pricebreaks " .
							"(productlengthid, fromunit, tounit, price, createdby, createddate) " .
							"VALUES " .
							"($productlengthid, 0, 0, $supplyinstalled, " . $_SESSION['SESS_MEMBER_ID'] . ", NOW())";
							
					$result = mysql_query($qry);
		        	$productbreakid =  mysql_insert_id();
        	
					if (mysql_errno() == 1062) {
						$qry = "SELECT id " .
								"FROM datatech_pricebreaks " .
								"WHERE productlengthid = $productlengthid " .
								"AND fromunit = 0 " .
								"AND tounit = 0";
						$result = mysql_query($qry);
						
						//Check whether the query was successful or not
						if ($result) {
							while (($member = mysql_fetch_assoc($result))) {
								$pricebreakid = $member['id'];
							}
						}
						
						$qry = "UPDATE datatech_pricebreaks " .
								"SET price = $supplyinstalled " .
								"WHERE id = $pricebreakid";
						$result = mysql_query($qry);
					
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
						
					} else {
						if (! $result) die("Error :" . mysql_errno() . " : " . mysql_error() . " : " .  $qry);
					}
		        }
		    }
		    
		    fclose($handle);
			echo "<h1>" . $row . " downloaded</h1>";
		}
	}
	
	if (! isset($_FILES['sundrycsvfile']) &&
		! isset($_FILES['labourcsvfile']) &&
		! isset($_FILES['panelcsvfile']) &&
		! isset($_FILES['longlinecsvfile']) &&
		! isset($_FILES['patchleadcsvfile'])) {
?>	
		
<form class="contentform" method="post" enctype="multipart/form-data" onsubmit="return askPassword()">
	<label>Upload Labour CSV file </label>
	<input type="file" name="labourcsvfile" id="labourcsvfile" /> 
	
	<br />
	<label>Upload Sundry CSV file </label>
	<input type="file" name="sundrycsvfile" id="sundrycsvfile" /> 
	
	<br />
	<label>Upload Patch Leads CSV file </label>
	<input type="file" name="patchleadcsvfile" id="patchleadcsvfile" /> 
	
	<br />
	<label>Upload Panel CSV file </label>
	<input type="file" name="panelcsvfile" id="panelcsvfile" /> 
	
	<br />
	<label>Upload Long Line CSV file </label>
	<input type="file" name="longlinecsvfile" id="longlinecsvfile" /> 
	
	<br />
	<div id="submit" class="show">
		<input type="submit" value="Upload" />
	</div>
</form>
<?php
	}
	
	include("system-footer.php"); 
?>