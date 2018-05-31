<?

abstract class Ext_Object {
	
	/**
	 * Управление данными объекта
	 */
	protected $_data = array();
	
	public function set_data($data)
	{
		if (is_object($data))
		{
			$data = get_object_vars($data);
		}
		
		if (!is_array($data)) return;

		$this->_data = $data;
	}
	
	public function get_data()
	{
		return $this->_data;
	}

	public function __set($key, $value)
	{
		$this->_data[$key] = $value;
	}

	public function __get($key)
	{
		if (isset($this->_data[$key])) {
			return $this->_data[$key];
		}
	}
}
