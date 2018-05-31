<?

class Ext_InputSubmit extends Ext_Field {
	
	protected $_name = 'InputSubmit';
	protected $_has_child = false;
	
	function generate()
	{
		$this->content =  "<input type=\"submit\" name=\"$this->name\" value=\"$this->value\" class=\"$this->class\">";
	}
}
