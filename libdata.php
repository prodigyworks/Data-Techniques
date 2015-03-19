<?php
	require_once("crud.php");
	
	class LibDataCrud extends Crud {
		public function parentCategory() {
			return "";
		}
		
		public function getCategoryTitle() {
			return "Categories";
		}
		
		public function getCategoryApplication() {
			return "";
		}
		
		public function getImageURL() {
			return "images/version.png";
		}
		
		public function postAddScriptEvent() {
?>
			callAjax(
					"finddata.php", 
					{ 
						sql: "SELECT id FROM <?php echo $_SESSION['DB_PREFIX'];?>categories WHERE name = '<?php echo $this->parentCategory(); ?>'"
					},
					function(data) {
						if (data.length > 0) {
							var node = data[0];

							$("#parentcategoryid").val(node.id);
						}
					},
					false
				);
<?php
		}
		
		/* Post script event. */
		public function postScriptEvent() {
?>
			function onDblClick(id) {
				subApp("<?php echo $this->getCategoryApplication(); ?>", id);
			}
<?php
		}
		
		public function __construct() {
	        parent::__construct();
	        
	        $this->onDblClick = "onDblClick";
			$this->title = "Long Lines";
			$this->table = "{$_SESSION['DB_PREFIX']}categories";
			$this->dialogwidth = 480;
			$this->sql = 
					"SELECT A.*, C.name AS parentname " .
					"FROM {$_SESSION['DB_PREFIX']}categories A " .
					"INNER JOIN {$_SESSION['DB_PREFIX']}categories C " .
					"ON C.id = A.parentcategoryid " .
					"WHERE A.parentcategoryid = (SELECT B.id FROM {$_SESSION['DB_PREFIX']}categories B WHERE B.name = '" . $this->parentCategory() ."' and parentcategoryid = 0) " .
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
						'type'       => 'DATACOMBO',
						'length' 	 => 20,
						'label' 	 => 'Type',
						'table'		 => 'categories',
						'table_id'	 => 'id',
						'readonly'	 => true,
						'alias'		 => 'parentname',
						'table_name' => 'name'
					),
					array(
						'name'       => 'name',
						'length' 	 => 50,
						'label' 	 => 'Type'
					)
				);
				
			$this->subapplications = array(
					array(
						'title'		  => $this->getCategoryTitle(),
						'imageurl'	  => $this->getImageURL(),
						'application' => $this->getCategoryApplication()
					)
				);
	    }
		
	}
?>
