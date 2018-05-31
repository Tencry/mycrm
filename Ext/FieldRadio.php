<?

class Ext_FieldRadio extends Ext_Field {
	
	protected $_name = 'FieldRadio';
	protected $_has_child = false;
	
	function generate()
	{
		$this->content =  "<label class=\"radio\"><input name=\"{$this->name}\" type=\"radio\" value=\"{$this->value}\" {$this->get_attr()}> {$this->label}</label>";
	}
	
	function get_attr()
	{
		$attr = '';
		if ($this->value) 
			$attr = ' checked';
			
		return $attr;
	}
}
