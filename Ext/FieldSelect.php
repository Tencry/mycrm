<?

class Ext_FieldSelect extends Ext_Field {
	
	protected $_name = 'FieldSelect';
	protected $_has_child = false;
	
	function generate()
	{
		$this->value = 'select';
		$this->content =  "<input type=\"text\" name=\"$this->name\" value=\"$this->value\">";
	}
}
