<?php
	require_once("crud.php");
	

	$crud = new Crud();
	$crud->title = "Areas";
	$crud->table = "{$_SESSION['DB_PREFIX']}areas";
	$crud->dialogwidth = 480;
	$crud->sql = 
			"SELECT A.*, B.name AS sitename " .
			"FROM {$_SESSION['DB_PREFIX']}areas A " .
			"INNER JOIN {$_SESSION['DB_PREFIX']}sites B " .
			"ON B.id = A.siteid " .
			"WHERE A.siteid = " . $_GET['id'] . " " .
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
				'name'       => 'siteid',
				'showInView' => false,
				'editable'	 => false,
				'length' 	 => 10,
				'default'	 => $_GET['id'],
				'label' 	 => 'Site ID'
			),
			array(
				'name'       => 'sitename',
				'length' 	 => 10,
				'bind'		 => false,
				'editable'	 => false,
				'label' 	 => 'Site'
			),
			array(
				'name'       => 'name',
				'length' 	 => 50,
				'label' 	 => 'Area'
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
