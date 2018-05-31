<?

class Ext_TestWidget extends Ext_Widget {
	
	protected $_template = 'view\ext_widget';
	protected $_has_child = false;
	
	function generate()
	{
		$def_data = array();
		//$this->content = 'Hello World!';
		
		$this->set_data(array_merge($def_data, $this->get_data()));
	}
}
