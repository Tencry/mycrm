<?php

class Ext_Grid extends Ext_Widget {

	protected $_name = 'Grid';
	protected $_template = 'View/grid';

//ar	private static $instance = null;

	protected $columns;


/*ar 	public function __construct()
 	{		self::$instance = self::$instance+1;

 	}
*/
	//public function render()
	public function generate()
	{
		$this->name = $this->_name;
		/*$this->data = array_merge($this->data, array(
			$this->model . '_id'=>'',
			$this->model . '_add'=>''
		));*/

		//print_r($this->data);		if (Input::get('cut_objects') && !(Input::get((string)$this->_model)))
		{
			return false;
		}

		// Добавил префикс 'form_'
	    $form = $this->add('Ext_Form', 'form_'.(string) $this->_model);
	    $form->set_model($this->_model);
	    $form->autocomplete = 'off';
	    $php_self = $_SERVER['PHP_SELF'];
	    $form->action = $php_self . "?model=".$this->get_model();
		// edit form
		if ($_GET[$this->_model.'_id'])
		{
	        if ($this->allowEdit) {
				$f = $form->add('Ext_ButtonSubmit', 'update');
				$f->caption('Обновить');
			}
	        if ($this->allowDelete) {
				$f = $form->add('Ext_ButtonSubmit', 'delete');
				$f->caption('Удалить');
			}
			
			
	        $this->form = $form->render();

			die ($this->form);
//	        return parent::render();		}

		// add form
		else if ($_GET[$this->_model.'_add'])
		{			//$form = new C_Form($this->model);
	        //$form->setModel($this->model);
	       /* $form = $this->add_child((string)$this->model, 'Form');
	        $form->set_model($this->model);*/
	        if ($this->allowAdd) {
				$f = $form->add('Ext_ButtonSubmit', 'insert');
				$f->caption('Добавить');
			}
	        $this->form = $form->render();

			die ($this->form);
//	        return parent::render();
		}

		if (Input::get($this->_model.'_sortby'))
		{
			Input::memorize($this->_model.'_sortby',Input::get($this->_model.'_sortby'));
		}

		if ($this->sortby) $this->_model->orderby($this->sortby);
		else if ($sortby = Input::remember($this->_model.'_sortby')) $this->_model->orderby($sortby);
		if ($this->limit) $this->_model->limit($this->sql_page.','.$this->limit);
		if ($this->filter && Input::remember($this->_model.'_sword')) $this->_model->filter($this->filter,Input::remember($this->_model.'_sword'));

		$this->headers = $this->_model->get_fields();
		$this->rows = $this->_model->find_all();
		/*echo '<pre>';
		print_r($this->_model);
		echo '</pre>';*/

		if ($this->limit) $this->pagenums = $this->pagenums();

		// prefix before GET variable
		$this->prefix = $this->_model;
		//$this->number = rand(10,1000);
		//echo $this->number;

		$this->links = $this->columns;

		if ($export = Input::get('export'))
		{
			$export_class = 'Controller_Export_'.$export;
			$export = new $export_class();
			$export->setHeaders($this->headers);
			$export->setRows($this->rows);
			$export->render();
		}

		if (Input::get((string)$this->_model))
		{			//ardie(parent::render());
			//die($this->render());
		}

		//return  parent::render();
	}

	public function paginator($limit)
	{		if (Input::get($this->_model.'_page'))
		{			Input::memorize($this->_model.'_page',Input::get($this->_model.'_page'));		}		$this->page = Input::remember($this->_model.'_page');
		if ($this->page <= 0) $this->page = 1;

		$this->limit = $limit;
		$this->sql_page = ($this->page - 1) * $this->limit;	}

	// just number of pages
	private function pagenums()
	{
   		$num_rows = $this->_model->get_num_rows();
   		//if ($this->sql_page >= $num_rows) exit;

   		$total_pages = ceil($num_rows / $this->limit);

		if ($total_pages > 1) {
	   		$pagenums[] = 1; // first page
			for ($n = 2; $n < $total_pages; $n++)
			{				if (abs($n - $this->page)>5)
					continue;
				else if (abs($n - $this->page)==5 )
					$pagenums[] = '..';
				else					$pagenums[] = $n;			}
			$pagenums[] = $total_pages; // last page
		}

		return $pagenums;	}

	public function allowEdit()
	{		$this->allowEdit = true;	}

	public function allowAdd()
	{
		$this->allowAdd = true;
	}

	public function allowDelete()
	{
		$this->allowDelete = true;
	}

	public function allowSelect()
	{
		$this->allowSelect = true;
	}

	public function filter($array)
	{
		$this->filter = $array;
		if (Input::post($this->_model.'_search'))
		{
			Input::memorize($this->_model.'_sword',Input::post($this->_model.'_sword'));
			Input::memorize($this->_model.'_page',1);
		}

		if (Input::post($this->_model.'_clear')) {
			Input::forget($this->_model.'_sword');
			Input::memorize($this->_model.'_page',1);
		}
	}

	public function exportXLS()
	{		$this->exportXLS = true;	}

	public function exportPDF()
	{
		$this->exportPDF = true;
	}

	public function exportCSV()
	{
		$this->exportCSV = true;
	}

	public function sortby($sortby)
	{		$this->sortby = $sortby;	}

	public function addColumn($name,$link)
	{		$this->columns[$name] = $link;
	}

}
