<?

class Ext_FieldTextarea extends Ext_Field {
	
	protected $_name = 'FieldTextarea';
	protected $_has_child = false;
	
	function generate()
	{
		$default_data = array(
			'cols' => '',
			'rows' => '',
			'value' => ''
		);
		$this->set_data(array_merge($default_data, $this->get_data()));
		$this->content = "<label for=\"$this->name\">$this->caption</label><textarea name=\"{$this->name}\" cols=\"{$this->cols}\" rows=\"{$this->rows}\" id=\"$this->name\">{$this->value}</textarea>";
	}
}
