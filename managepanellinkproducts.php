<?php
	require_once("libproducts.php");
	
	class LongLineProductCrud extends LibProductCrud {
		public function getLengthApplication() {
			return "managepanellinklengths.php";
		}
	}

	$crud = new LongLineProductCrud();
	$crud->title = "Panel Links";
	$crud->run();
?>