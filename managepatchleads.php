<?php
	require_once("libdata.php");
	
	class PatchLeadCrud extends LibDataCrud {
		public function parentCategory() {
			return "Patchleads";
		}
		
		public function getCategoryApplication() {
			return "managepatchleadcategories.php";
		}
	}

	$crud = new PatchLeadCrud();
	$crud->title = "Patch Leads";
	$crud->run();
?>
