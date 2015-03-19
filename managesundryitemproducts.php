<?php
	require_once("libproducts.php");
	
	class PatchLeadProductCrud extends LibProductCrud {
		public function isLengthNeeded() {
			return false;
		}
		
		public function postScriptEvent() {
	        parent::postScriptEvent();
			
?>
			function format_decimal(el, cval, opts) {
				return new Number(el).toFixed(2);
			}
			
			function supplyinstalled_onchange() {
				$("#supplyinstalled").val(getRealNumber($("#supplyinstalled").val(), 2));
			}
<?php
		}
		
		public function postInsertEvent() {
			$supplyinstalled = $_POST['supplyinstalled'];
			$id = mysql_insert_id();
			
			$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}supplieditems " .
					"(" .
					"productid, supplyinstalled, supplyonly" .
					") " .
					"VALUES " .
					"(" .
					"$id, $supplyinstalled, 0" .
					")";
			$result = mysql_query($qry);
			
			if (! $result) {
				logError($qry . " - " . mysql_error());
			}
		}
		
		public function postUpdateEvent($id) {
			$supplyinstalled = $_POST['supplyinstalled'];
			
			$qry = "UPDATE {$_SESSION['DB_PREFIX']}supplieditems SET " .
					"supplyinstalled = $supplyinstalled " .
					"WHERE productid = $id ";
			$result = mysql_query($qry);
			
			if (! $result) {
				logError($qry . " - " . mysql_error());
			}
		}
		
		function __construct() {
	        parent::__construct();
	        
			$this->sql = 
					"SELECT A.*, B.name as categoryname, C.name AS parentname, E.supplyinstalled " .
					"FROM {$_SESSION['DB_PREFIX']}products A " .
					"INNER JOIN {$_SESSION['DB_PREFIX']}categories B " .
					"ON B.id = A.categoryid " .
					"INNER JOIN {$_SESSION['DB_PREFIX']}categories C " .
					"ON C.id = B.parentcategoryid " .
					"INNER JOIN {$_SESSION['DB_PREFIX']}supplieditems E " .
					"ON E.productid = A.id " .
					"WHERE A.categoryid = " . $_GET['id'] . " " .
					"ORDER BY A.name";
	        
			$this->columns[] = array(
					'name'       => 'supplyinstalled',
					'datatype'	 => 'double',
					'formatter'	 => 'format_decimal',
					'onchange'	 => 'supplyinstalled_onchange',
					'length' 	 => 20,
					'bind'		 => false,
					'label' 	 => 'Price'
				);
		}
	}

	$crud = new PatchLeadProductCrud();
	$crud->title = "Sundry Items";
	$crud->run();
?>