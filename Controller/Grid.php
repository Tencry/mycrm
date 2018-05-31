<?php

class Controller_Grid extends Component {


	protected $template = 'View/grid';

	private static $instance = null;

	protected $columns;


 	public function __construct()
 	{		self::$instance = self::$instance+1;

 	}

	public function render()
	{
		/*$this->data = array_merge($this->data, array(
			$this->model . '_id'=>'',
			$this->model . '_add'=>''
		));*/

		//print_r($this->data);		if (Input::get('cut_objects') && !(Input::get((string)$this->model)))
		{
			return false;
		}

	    $form = $this->add_child((string) $this->model, 'Form');
	    $form->set_model($this->model);


		// edit form
		if ($_GET[$this->model.'_id'])
		{			//$form = new C_Form($this->model);
			//$form->setModel($this->model);
	        /*$form = $this->add_child((string) $this->model, 'Form');
	        $form->set_model($this->model);*/
	        ($this->allowEdit) ? $form->add_button('update', 'Обновить') : null;
	        ($this->allowDelete) ? $form->add_button('delete', 'Удалить') : null;
	        $this->form = $form->render();

			die ($this->form);
//	        return parent::render();		}

		// add form
		else if ($_GET[$this->model.'_add'])
		{			//$form = new C_Form($this->model);
	        //$form->setModel($this->model);
	       /* $form = $this->add_child((string)$this->model, 'Form');
	        $form->set_model($this->model);*/
	        ($this->allowAdd) ? $form->add_button('insert', 'Добавить') : null;
	        $this->form = $form->render();

			die ($this->form);
//	        return parent::render();
		}

		if (Input::get($this->model.'_sortby'))
		{
			Input::memorize($this->model.'_sortby',Input::get($this->model.'_sortby'));
		}

		if ($this->sortby) $this->model->orderby($this->sortby);
		else if ($sortby = Input::remember($this->model.'_sortby')) $this->model->orderby($sortby);
		if ($this->limit) $this->model->limit($this->sql_page.','.$this->limit);
		if ($this->filter && Input::remember($this->model.'_sword')) $this->model->filter($this->filter,Input::remember($this->model.'_sword'));

		$this->headers = $this->model->get_fields();
		$this->rows = $this->model->find_all();
		//echo '<pre>';
		//print_r($this->rows);
		//echo '</pre>';

		if ($this->limit) $this->pagenums = $this->pagenums();

		// prefix before GET variable
		$this->prefix = $this->model;
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

		if (Input::get((string)$this->model))
		{			die(parent::render());
		}

		return  parent::render();
	}

	public function paginator($limit)
	{		if (Input::get($this->model.'_page'))
		{			Input::memorize($this->model.'_page',Input::get($this->model.'_page'));		}		$this->page = Input::remember($this->model.'_page');
		if ($this->page <= 0) $this->page = 1;

		$this->limit = $limit;
		$this->sql_page = ($this->page - 1) * $this->limit;	}

	// just number of pages
	private function pagenums()
	{
   		$num_rows = $this->model->get_num_rows();
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
		if (Input::post($this->model.'_search'))
		{
			Input::memorize($this->model.'_sword',Input::post($this->model.'_sword'));
			Input::memorize($this->model.'_page',1);
		}

		if (Input::post($this->model.'_clear')) {
			Input::forget($this->model.'_sword');
			Input::memorize($this->model.'_page',1);
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
