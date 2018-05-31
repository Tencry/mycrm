<?
header('Content-Type: text/html; charset=utf-8');
include 'startup.php';

class Pagegrid extends Component {

	protected $template = 'view/pagegrid';

	function index()
	{		$model_name = Input::get('model') or die();

		if (Input::get('tr'))
		{			$id = Input::get($model_name.'_id');
			$tr = $this->add_child($model_name, 'TR');
			$tr->setId($id);
			$tr->set_model('Model_'.$model_name);
			$tr->allowEdit($this->allowEdit);

			die ($tr->render());
		}

		if ($id = Input::get('selectoptions'))
		{
			$tr = $this->add_child($model_name, 'SelectOptions');
			$tr->setId($id);
			$tr->set_model('Model_'.$model_name);

			die ($tr->render());
		}

		$grid = $this->add_child($model_name.'_grid', 'Controller_Grid');
		//$grid = $this->add_child('client_grid', 'Controller_Grid');
		$grid->set_model('Model_'.$model_name);
		$grid->paginator(10);
		$grid->allowEdit();
		$grid->allowAdd();
		$grid->allowDelete();
		$grid->allowSelect();
		$grid->filter(array('id','name'));

	}
}


/**
 * Routings and execution
 */
$page = new Pagegrid();
$page->index();
$page->show();

