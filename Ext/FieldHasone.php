<?

class Ext_FieldHasone extends Ext_Field {
	
	protected $_name = 'FieldHasone';
	protected $_template = 'View/form_select';
	protected $_has_child = false;
	
	function generate()
	{
		if ($this->value)
			$this->_model->where('id',$this->value);
		else
			$this->_model->limit(10);

		$this->_model->orderby('-id');

/*		$this->_data = array (
//			'name' => $this->name,
//				'type' => $this->type,
//				'caption' => $this->caption,
			'options' => $this->_model->find_all(),
	//		'option_fields' => $this->option_fields,
//				'option_separator' => $this->option_separator,
				'model' => $this->_model
		);*/
		
		$this->options = $this->_model->find_all();
		$this->model = $this->_model;
	}
	
	
	function show_fields($array_of_field_names=array('id'), $separator = ' ')
	{
		$this->option_fields = $array_of_field_names;
		$this->option_separator = $separator;

		return $this;
	}
}
