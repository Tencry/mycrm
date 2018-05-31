<?

class Ext_FieldHidden extends Ext_Field {
	
	protected $_name = 'FieldHidden';
	protected $_has_child = false;
	
	function generate()
	{
		$this->content =  "<input type=\"hidden\" name=\"$this->name\" value=\"$this->value\">";
	}
}
