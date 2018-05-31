<?

class Ext_FieldCheckbox extends Ext_Field {
	
	protected $_name = 'FieldCheckbox';
	protected $_has_child = false;
	
	function generate()
	{
		$this->content =  "<label class=\"checkbox\"><input name=\"{$this->name}\" type=\"checkbox\" value=\"{$this->value}\" {$this->get_attr()}> {$this->label}</label>";
	}
	
	function get_attr()
	{
		$attr = '';
		if ($this->value) 
			$attr = ' checked';
			
		return $attr;
	}
}
