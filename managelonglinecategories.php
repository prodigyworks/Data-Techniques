<?php
	require_once("libcategories.php");
	
	class LongLineCategoryCrud extends LibCategoryCrud {
		public function productApplication() {
			return "managelonglineproducts.php";
		}
	}

	$crud = new LongLineCategoryCrud();
	$crud->title = "Long Lines";
	$crud->run();
?>