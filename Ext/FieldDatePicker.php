<?

class Ext_FieldDatePicker extends Ext_Field {
	
	protected $_name = 'FieldDatePicker';
	protected $_has_child = false;
	
	function generate()
	{
		$this->id = $this->name;
		
		$this->content = 
			"<label for=\"$this->name\">$this->caption</label><input class=\"{$this->required} datepicker\" type=\"text\" name=\"$this->name\" value=\"$this->value\" id=\"$this->name\">";

	}
}
