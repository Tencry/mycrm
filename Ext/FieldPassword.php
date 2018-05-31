<?

class Ext_FieldPassword extends Ext_Field {
	
	protected $_name = 'FieldPassword';
	protected $_has_child = false;
	
	function generate()
	{
		$this->content =  "<input type=\"password\" name=\"$this->name\" value=\"$this->value\">";
	}
}
