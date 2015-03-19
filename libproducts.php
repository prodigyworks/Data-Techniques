<?php
	require_once("crud.php");
	
	class LibProductCrud extends Crud {
		public function getLengthApplication() {
			return "";
		}
		
		public function isLengthNeeded() {
			return true;
		}
		
		public function postAddScriptEvent() {
?>
			callAjax(
					"finddata.php", 
					{ 
						sql: "SELECT B.name as categoryname, C.name AS parentname FROM <?php echo $_SESSION['DB_PREFIX'];?>categories B INNER JOIN <?php echo $_SESSION['DB_PREFIX'];?>categories C ON C.id = B.parentcategoryid WHERE B.id = <?php echo $_GET['id']; ?>"
					},
					function(data) {
						if (data.length > 0) {
							var node = data[0];

							$("#parentname").val(node.parentname);
							$("#categoryname").val(node.categoryname);
						}
					},
					false
				);
<?php
		}
		
		/* Post script event. */
		public function postScriptEvent() {
?>
			function onOpenEditDialog() {
				$("#name").focus();
			}
			
			function onDblClick(id) {
				subApp("<?php echo $this->getLengthApplication(); ?>", id);
			}
<?php
		}
		
		
		function __construct() {
	        parent::__construct();
	        
	        if ($this->isLengthNeeded()) {
		        $this->onDblClick = "onDblClick";
	        }
	        
	        $this->onOpenEditDialog = "onOpenEditDialog";
			$this->table = "{$_SESSION['DB_PREFIX']}products";
			$this->dialogwidth = 580;
			$this->sql = 
					"SELECT A.*, B.name as categoryname, C.name AS parentname " .
					"FROM {$_SESSION['DB_PREFIX']}products A " .
					"INNER JOIN {$_SESSION['DB_PREFIX']}categories B " .
					"ON B.id = A.categoryid " .
					"INNER JOIN {$_SESSION['DB_PREFIX']}categories C " .
					"ON C.id = B.parentcategoryid " .
					"WHERE A.categoryid = " . $_GET['id'] . " " .
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
						'name'       => 'categoryid',
						'showInView' => false,
						'editable'	 => false,
						'length' 	 => 10,
						'default'	 => $_GET['id'],
						'label' 	 => 'Category ID'
					),
					array(
						'name'       => 'parentname',
						'length' 	 => 30,
						'readonly'	 => true,
						'bind'		 => false,
						'label' 	 => 'Type'
					),
					array(
						'name'       => 'categoryname',
						'length' 	 => 30,
						'readonly'	 => true,
						'bind'		 => false,
						'label' 	 => 'Category'
					),
					array(
						'name'       => 'name',
						'length' 	 => 70,
						'label' 	 => 'Product'
					)
				);
				
			if ($this->isLengthNeeded()) {
				$this->subapplications = array(
						array(
							'title'		  => 'Lengths',
							'imageurl'	  => 'images/length.png',
							'application' => $this->getLengthApplication()
						)
					);
			}
		}
	}
?>
