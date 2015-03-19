<?php
	require_once("crud.php");
	
	class SiteCrud extends Crud {
		
		/* Pre command event. */
		/* Post script event. */
		public function postScriptEvent() {
?>
			function fullAddress(node) {
				var address = "";
				
				if (node.address1 != "") {
					address = node.address1;
				}
				
				if (node.address2 != "" && node.address2 != null) {
					if (address != "") {
						address += ", ";
					}
					
					address += node.address2;
				}
				
				if (node.address3 != "" && node.address3 != null) {
					if (address != "") {
						address += ", ";
					}
					
					address += node.address3;
				}
				
				if (node.address4 != "" && node.address4 != null) {
					if (address != "") {
						address += ", ";
					}
					
					address += node.address4;
				}
				
				if (node.address5 != "" && node.address5 != null) {
					if (address != "") {
						address += ", ";
					}
					
					address += node.address5;
				}
				
				if (node.address6 != "" && node.address6 != null) {
					if (address != "") {
						address += ", ";
					}
					
					address += node.address6;
				}
				
				if (node.address7 != "" && node.address7 != null) {
					if (address != "") {
						address += ", ";
					}
					
					address += node.address7;
				}
				
				return address;
			}
<?php
		}
	}

	$crud = new SiteCrud();
	$crud->title = "Sites";
	$crud->table = "{$_SESSION['DB_PREFIX']}sites";
	$crud->dialogwidth = 480;
	$crud->sql = 
			"SELECT A.* " .
			"FROM {$_SESSION['DB_PREFIX']}sites A " .
			"ORDER BY A.name";
	
	$crud->columns = array(
			array(
				'name'       => 'id',
				'length' 	 => 6,
				'pk'		 => true,
				'showInView' => false,
				'editable'	 => false,
				'bind' 	 	 => false,
				'filter'	 => false,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'name',
				'length' 	 => 10,
				'label' 	 => 'Name'
			),
			array(
				'name'       => 'address1',
				'length' 	 => 40,
				'showInView' => false,
				'label' 	 => 'Address 1'
			),
			array(
				'name'       => 'address2',
				'length' 	 => 40,
				'showInView' => false,
				'label' 	 => 'Address 2'
			),
			array(
				'name'       => 'address3',
				'length' 	 => 40,
				'showInView' => false,
				'label' 	 => 'Address 3'
			),
			array(
				'name'       => 'address4',
				'length' 	 => 40,
				'showInView' => false,
				'label' 	 => 'Address 4'
			),
			array(
				'name'       => 'address5',
				'length' 	 => 40,
				'showInView' => false,
				'label' 	 => 'Address 5'
			),
			array(
				'name'       => 'address6',
				'length' 	 => 40,
				'showInView' => false,
				'label' 	 => 'Address 6'
			),
			array(
				'name'       => 'address7',
				'length' 	 => 40,
				'showInView' => false,
				'label' 	 => 'Address 7'
			),
			array(
				'name'       => 'address',
				'type'		 => 'DERIVED',
				'length' 	 => 120,
				'bind'		 => false,
				'function'   => 'fullAddress',
				'sortcolumn' => 'A.address1',
				'editable'	 => false,
				'label' 	 => 'Address'
			)
		);
		
	$crud->subapplications = array(
			array(
				'title'		  => 'Areas',
				'imageurl'	  => 'images/minimize.gif',
				'application' => 'manageareas.php'
			)
		);
		
	$crud->run();
?>
