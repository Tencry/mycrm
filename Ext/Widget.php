<?

abstract class Ext_Widget extends Ext_Controller {

	protected $_template = 'View/ext_widget';
	
	protected $_name = 'Widget';
	private static $_idx = 0;
	
	private $_items = array();
	
	// Указывает возможность содержания дочерних виджетов
	protected $_has_child = true;
	
	function __construct($name = null)
	{
		if (empty($name) || !is_string($name)) {
			$this->_name .= ++self::$_idx;
		} else {
			$this->_name = $name;
		}
		
		//$this->generate();
	}

	abstract function generate();

	function render_children()
	{
		$content = '';
		foreach ($this->_items as $item) {
			$content .= $item->render();
		}

		$this->content .= $content;
	}

	function render()
	{
		$this->generate();
		
		if ($this->_has_child)
			$this->render_children();

		if ($_GET['cut_object'] == $this->_name) {
			die (View::render($this->_template, $this->_data));
		}

		if (!isset($_GET['cut_object']))
			return View::render($this->_template, $this->_data);
	}

	function show()
	{
		echo $this->render();
	}

	/**
	 * Управление дочерними объектами
	 */
	function add($object, $name=null)
	{
		if ($this->_has_child == false) return;
		
		if ($object instanceof Ext_Widget) {
			return $this->_items[$name] = $object;
		} else if (is_string($object)) {
			return $this->_items[$name] = new $object($name);
		}
	}
	
	function add_before($object, $name=null)
	{
		if ($this->_has_child == false) return;
		
		$arr = array();
		//array_unshift($this->_items, $object)
		if ($object instanceof Ext_Widget) {
			$arr[$name] = $object;
		} else if (is_string($object)) {
			$arr[$name] = new $object($name);
		}
		
		$this->_items = array_merge($arr, $this->_items);
		
		//return $arr[$name];
	}

	function get($name)
	{
		return $this->_items[$name];
	}

	function remove($name)
	{
		$ret = $this->_items[$name];
		unset($this->_items[$name]);
		return $ret;
	}
	
	function get_all()
	{
		return $this->_items;
	}

	// Подумать над этим
	function set_model($model)
	{
		parent::set_model($model);
		
		$this->generate();
	}
}
