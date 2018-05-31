<?

class Ext_FieldHasmany extends Ext_Field {
	
	protected $_name = 'FieldHasmany';
	protected $_template = 'View/form_hasmany';
	//protected $_has_child = true;
	
	function generate()
	{
		$this->model = $this->_model;
		
		
		//$curr_rec_id = isset($_GET['cli_id']) ? $_GET['cli_id'] : 0;
		$argv = $this->_parent_model . '_id';
		$curr_rec_id = isset($_GET[$argv]) ? $_GET[$argv] : 0;

		if ($curr_rec_id) {

			$table2 = $this->_model->get_table();
			$table1 = $this->_parent_model->get_table();
			//$query = "SELECT * FROM ".$this->table2." WHERE id IN (SELECT ".$this->table2."_id FROM ".$this->link_table." WHERE ".$this->table1."_id=".$curr_rec_id.")";
			$query = "SELECT * FROM ".$table2." WHERE id IN (SELECT ".$table2."_id FROM ".$this->link_table." WHERE ".$table1."_id=".$curr_rec_id.")";
			$arr = Database::factory()->select($query);

			$records = array();
			foreach ($arr as $val) {
				$this->_model->where('id',$val['id']);
				
				/*echo '<pre>';
				print_r($this->_model->get_data());
				echo '</pre>';*/
				
				// test code
				/*$this->_model->find_by_id($val['id']);
				$hasOne = $this->add('Ext_FieldHasone', $this->name);
				$hasOne->set_model($this->_model);
				$hasOne->value = $val['id'];*/
				
				$this->_model->orderby('-id');
				$records[] = array (
					//'name' => $this->name,
					//'type' => $this->type,
					//'caption' => $this->caption,
					'options' => $this->_model->find_all(),
					//'option_fields' => $this->option_fields,
					//'option_separator' => $this->option_separator,
				//	'model' => $this->_model
				);
				//$this->options = $this->_model->find_all();
				$this->linked_records = $records;
			}
		}
	}
	
	function link_table($table)
	{
		$this->link_table = $table;
		return $this;
	}
	
/** Удалить
	function set_tables($table1, $table2)
	{
		$this->table1 = $table1;
		$this->table2 = $table2;
		
		return $this;
	}*/
	
	
	function show_fields($array_of_field_names = array('id'), $separator = ' ')
	{
		$this->option_fields = $array_of_field_names;
		$this->option_separator = $separator;

		return $this;
	}
	
	
	/** По новому */
	protected $_parent_model = null;
	function parent_model($model)
	{
		$this->_parent_model = $model;
		
		return $this;
	}
}
