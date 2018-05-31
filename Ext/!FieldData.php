<?

class Ext_FieldData extends Ext_Object {
	
	
	function __construct()
	{
		// general properties
		$this->name = '';
		$this->value = '';
		$this->label = $this->caption = '';
	
		// form properties
		$this->class = '';
		$this->type = '';
		$this->minlength = '';
		$this->required = '';
	
		// grid properties
		$this->sortable = '';

	}
	
	function get_class()
	{
		return 	(is_string($this->class)) ? $this->class : 'Ext_Field'.$this->type;
	}
	
	function label($label)
	{
		$this->label = $label;
		
		return $this;
	}
	
	function caption($caption)
	{
		$this->label($caption);
		$this->caption = $caption;
		
		return $this;
	}
	
	function sortable()
	{
		return $this;
	}
	
	function hide()
	{
		return $this;
	}
	
	function type($type)
	{
		$this->type = $type;
		
		return $this;
	}
	
	function required()
	{
		$this->required = true;
		
		return $this;
	}
	
	function minlength($minlength)
	{
		$this->minlength = $minlength;
		
		return $this;
	}
	
	function show_fields($array_of_field_names, $separator = ' ')
	{
		$this->option_fields = $array_of_field_names;
		$this->option_separator = $separator;

		return $this;
	}
}
