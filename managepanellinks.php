<?php
	require_once("libdata.php");
	
	class PanelLinkCrud extends LibDataCrud {
		public function parentCategory() {
			return "Panel Link";
		}
		
		public function getCategoryApplication() {
			return "managepanellinkcategories.php";
		}
	}

	$crud = new PanelLinkCrud();
	$crud->title = "Panel Links";
	$crud->run();
?>