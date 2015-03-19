<?php
	require_once("libproducts.php");
	
	class LongLineProductCrud extends LibProductCrud {
		public function getLengthApplication() {
			return "managelonglinelengths.php";
		}
	}

	$crud = new LongLineProductCrud();
	$crud->title = "Long Lines";
	$crud->run();
?>