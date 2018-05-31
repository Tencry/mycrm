<?

class Ext_ButtonSubmit extends Ext_Field {
	
	protected $_name = 'ButtonSubmit';
	protected $_has_child = false;
	
	function generate()
	{
		$this->content =  "<button name=\"{$this->name}\" value=\"{$this->value}\" type=\"submit\" class=\"btn\">{$this->label}</button>";
	}
}
