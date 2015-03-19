<?php
	require_once("libdata.php");
	
	class LongLineCrud extends LibDataCrud {
		public function parentCategory() {
			return "Longlines";
		}
		
		public function getCategoryApplication() {
			return "managelonglinecategories.php";
		}
	}

	$crud = new LongLineCrud();
	$crud->title = "Long Lines";
	$crud->run();
?>
