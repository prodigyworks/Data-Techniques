<?php
	require_once("libdata.php");
	
	class PanelLinkCrud extends LibDataCrud {
		public function parentCategory() {
			return "Sundry Items";
		}
		
		public function getCategoryApplication() {
			return "managesundryitemproducts.php";
		}
		
		public function getCategoryTitle() {
			return "Products";
		}
		
		public function getImageURL() {
			return "images/ship.png";
		}
	}

	$crud = new PanelLinkCrud();
	$crud->title = "Sundry Items";
	$crud->run();
?>