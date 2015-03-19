<?php
	require_once("libcategories.php");
	
	class PatchLeadCategoryCrud extends LibCategoryCrud {
		public function productApplication() {
			return "managepatchleadproducts.php";
		}
	}

	$crud = new PatchLeadCategoryCrud();
	$crud->title = "Patch Leads";
	$crud->run();
?>