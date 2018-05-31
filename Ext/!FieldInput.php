<?

class Ext_FieldInput extends Ext_Widget {
	
	protected $_name = 'FieldInput';
	protected $_has_child = false;
	
	function generate()
	{
		$this->content =  "<input type=\"$this->type\" name=\"$this->name\" value=\"$this->value\">";
	}
}
