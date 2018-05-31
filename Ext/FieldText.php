<?

class Ext_FieldText extends Ext_Field {
	
	protected $_name = 'FieldText';
	protected $_has_child = false;
	
	function generate()
	{
		$this->content =  "<label for=\"$this->name\">$this->caption</label><input type=\"text\" name=\"$this->name\" value=\"$this->value\" id=\"$this->name\">";
	}
}
