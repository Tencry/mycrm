<?


class Ext_Controller extends Ext_Object {

	protected $_model = null;

	function set_model($model)
	{
		if ($model instanceof Ext_Model) {
			$this->_model = $model;
		} else if (is_string($model)) {
			$this->_model = new $model();
		}
	}
	
	function get_model()
	{
		return $this->_model;
	}
}
