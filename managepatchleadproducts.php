<?php
	require_once("libproducts.php");
	
	class PatchLeadProductCrud extends LibProductCrud {
		public function getLengthApplication() {
			return "managepatchleadlengths.php";
		}
	}

	$crud = new PatchLeadProductCrud();
	$crud->title = "Patch Leads";
	$crud->run();
?>