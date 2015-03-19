<?php
	require_once("libcategories.php");
	
	class LongLineCategoryCrud extends LibCategoryCrud {
		public function productApplication() {
			return "managepanellinkproducts.php";
		}
	}

	$crud = new LongLineCategoryCrud();
	$crud->title = "Panel Links";
	$crud->run();
?>