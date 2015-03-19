<?php
	require_once("crud.php");
	
	class TechCrud extends Crud {
		/* Post script event. */
		public function postScriptEvent() {
?>
			function saturdayHourlyRate(node) {
				return new Number(parseFloat(node.sathourrate) / 9).toFixed(2);
			}
			
			function inHourlyRate(node) {
				return new Number(parseFloat(node.inhourrate) / 9).toFixed(2);
			}
			
			function outHourlyRate(node) {
				return new Number(parseFloat(node.outhourrate) / 9).toFixed(2);
			}
			
			function format_decimal(el, cval, opts) {
				return new Number(el).toFixed(2);
			}
			
			function inhourrate_onchange() {
				$("#inhourrate").val(getRealNumber($("#inhourrate").val(), 2));
				$("#inrealhourrate").val(getRealNumber(parseFloat($("#inhourrate").val() / 9), 2));
			}
			
			function outhourrate_onchange() {
				$("#outhourrate").val(getRealNumber($("#outhourrate").val(), 2));
				$("#outrealhourrate").val(getRealNumber(parseFloat($("#outhourrate").val() / 9), 2));
			}
			
			function sathourrate_onchange() {
				$("#sathourrate").val(getRealNumber($("#sathourrate").val(), 2));
				$("#satrealhourrate").val(getRealNumber(parseFloat($("#sathourrate").val() / 9), 2));
			}
<?php
		}
	}
	
	$crud = new TechCrud();
	$crud->title = "Technician Rates";
	$crud->table = "{$_SESSION['DB_PREFIX']}technicianrates";
	$crud->dialogwidth = 500;
	$crud->sql = 
			"SELECT A.* " .
			"FROM {$_SESSION['DB_PREFIX']}technicianrates A " .
			"ORDER BY A.name";
	
	$crud->columns = array(
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
				'name'       => 'name',
				'length' 	 => 35,
				'label' 	 => 'Technician'
			),
			array(
				'name'       => 'inhourrate',
				'datatype'	 => 'double',
				'onchange'	 => 'inhourrate_onchange',
				'formatter'	 => 'format_decimal',
				'length' 	 => 17,
				'label' 	 => 'In Day Rate'
			),
			array(
				'name'       => 'inrealhourrate',
				'datatype'	 => 'double',
				'type'		 => 'DERIVED',
				'function'   => 'inHourlyRate',
				'align'	 	 => 'right',
				'bind'	 	 => false,
				'length' 	 => 20,
				'label' 	 => 'In Hour Rate'
			),
			array(
				'name'       => 'outhourrate',
				'datatype'	 => 'double',
				'onchange'	 => 'outhourrate_onchange',
				'formatter'	 => 'format_decimal',
				'align'	 	 => 'right',
				'length' 	 => 17,
				'align'	 	 => 'right',
				'label' 	 => 'Out Day Rate'
			),
			array(
				'name'       => 'outrealhourrate',
				'datatype'	 => 'double',
				'type'		 => 'DERIVED',
				'function'   => 'outHourlyRate',
				'align'	 	 => 'right',
				'bind'	 	 => false,
				'length' 	 => 20,
				'label' 	 => 'Out Hour Rate'
			),
			array(
				'name'       => 'sathourrate',
				'datatype'	 => 'double',
				'align'	 	 => 'right',
				'required'	 => true,
				'onchange'	 => 'sathourrate_onchange',
				'formatter'	 => 'format_decimal',
				'length' 	 => 20,
				'label' 	 => 'Saturday Day Rate'
			),
			array(
				'name'       => 'satrealhourrate',
				'datatype'	 => 'double',
				'type'		 => 'DERIVED',
				'function'   => 'saturdayHourlyRate',
				'align'	 	 => 'right',
				'bind'	 	 => false,
				'length' 	 => 20,
				'label' 	 => 'Saturday Hour Rate'
			)
		);
		
	$crud->run();
?>
