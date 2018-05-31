<?

class Component extends Controller {

	protected $template = 'view/component';
	protected $data = array();
	protected $items = array();

	function render()
	{
		$content = '';
		$id = '';
		foreach ($this->items as $item) {
			$content .= $item->render();
		}

		$this->data['content'] = $content;
		$this->data['id'] = $this->model->id;

		return View::render($this->template, $this->data);
	}

	function show()
	{
		echo $this->render();
	}

	function add_child($name, $object)
	{
		if ($object instanceof Component) {
			return $this->items[$name] = $object;
		} else if ($object == 'Form') {
			return $this->items[$name] = new $object($name);
		} else if ($object == 'Field') {
			return $this->items[$name] = new $object($name);
		} else {
			return $this->items[$name] = new $object();
		}
	}

	function get_child($name)
	{
		return $this->items[$name];
	}

	function remove_child($name)
	{
		$ret = $this->get_child($name);
		unset($this->items[$name]);
		return $ret;
	}

	public function set_data($data)
	{
		if (is_object($data))
		{
			$data = get_object_vars($data);
		}

		$this->data = $data;
	}

	public function __set($key, $value)
	{
		$this->data[$key] = $value;
	}

	public function __get($key)
	{
		if (isset($this->data[$key])) {
			return $this->data[$key];
		}
	}
}
