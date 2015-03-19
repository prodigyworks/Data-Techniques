<?php
	require_once("crud.php");
	
	class LibCategoryCrud extends Crud {
		public function productApplication() {
			return "";
		}
		
		/* Post script event. */
		public function postScriptEvent() {
?>
			function onOpenEditDialog() {
				$("#name").focus();
			}
			
			function onDblClick(id) {
				subApp("<?php echo $this->productApplication(); ?>", id);
			}
<?php
		}
		
		public function postAddScriptEvent() {
?>
			callAjax(
					"finddata.php", 
					{ 
						sql: "SELECT B.name AS parentname FROM <?php echo $_SESSION['DB_PREFIX'];?>categories B WHERE B.id = <?php echo $_GET['id']; ?>"
					},
					function(data) {
						if (data.length > 0) {
							var node = data[0];

							$("#parentname").val(node.parentname);
						}
					},
					false
				);
<?php
		}
		
		
		public function __construct() {
	        parent::__construct();
	        
	        $this->onDblClick = "onDblClick";
	        $this->onOpenEditDialog = "onOpenEditDialog";
			$this->title = "Long Lines";
			$this->table = "{$_SESSION['DB_PREFIX']}categories";
			$this->dialogwidth = 480;
			$this->sql = 
					"SELECT A.*, B.name AS parentname " .
					"FROM {$_SESSION['DB_PREFIX']}categories A " .
					"INNER JOIN {$_SESSION['DB_PREFIX']}categories B " .
					"ON B.id = A.parentcategoryid " .
					"WHERE A.parentcategoryid = " . $_GET['id'] . " " .
					"ORDER BY A.name";
			
			$this->columns = array(
					array(
						'name'       => 'id',
						'length' 	 => 6,
						'pk'		 => true,
						'showInView' => false,
						'editable'	 => false,
						'bind' 	 	 => false,
						'filter'	 => false,
						'label' 	 => 'ID'
					),
					array(
						'name'       => 'parentcategoryid',
						'showInView' => false,
						'editable'	 => false,
						'length' 	 => 10,
						'default'	 => $_GET['id'],
						'label' 	 => 'Site ID'
					),
					array(
						'name'       => 'parentname',
						'length' 	 => 50,
						'readonly'	 => true,
						'bind'		 => false,
						'label' 	 => 'Category'
					),
					array(
						'name'       => 'name',
						'length' 	 => 50,
						'label' 	 => 'Type'
					)
				);
				
			$this->subapplications = array(
					array(
						'title'		  => 'Products',
						'imageurl'	  => 'images/ship.png',
						'application' => $this->productApplication()
					)
				);
		}
	}
?>
