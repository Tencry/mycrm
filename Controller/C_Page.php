<?

abstract class C_Page extends C_View {
	
	protected function before()
	{}
	
	protected function after()
	{}
	
	protected function request()
	{
		$action = "action_" . (isset($_GET['a']) ? $_GET['a'] : "index");
		$this->$action();
	}
	
	protected function response()
	{
		$page = $this->render();
		
		return $page;
	}

	public function execute()
	{
		$this->before();
		
		$this->request();
		
		$this->after();
		
		return $this->response();
	}
	
	abstract protected function action_index();
}
