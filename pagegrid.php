<?
header('Content-Type: text/html; charset=utf-8');
include 'startup.php';

class Pagegrid extends Ext_Widget {

	protected $_template = 'view/pagegrid';

	function generate()
	{		$model_name = Input::get('model') or die();

		if (Input::get('tr'))
		{			$id = Input::get($model_name.'_id');
			$tr = $this->add('TR', $model_name);
			$tr->setId($id);
			$tr->set_model('Model_'.$model_name);
			$tr->allowEdit($this->allowEdit);

			die ($tr->render());
		}

		if ($id = Input::get('selectoptions'))
		{
			$tr = $this->add('SelectOptions', $model_name);
			$tr->setId($id);
			$tr->set_model('Model_'.$model_name);

			die ($tr->render());
		}

		$grid = $this->add('Ext_Grid', $model_name.'_grid');
		//$grid = $this->add_child('client_grid', 'Controller_Grid');
		$grid->allowEdit();
		$grid->allowAdd();
		$grid->allowDelete();
		$grid->allowSelect();
		$grid->set_model('Model_'.$model_name);
		$grid->paginator(10);
		$grid->filter(array('id','name'));
	}
}


/**
 * Routings and execution
 */
$page = new Pagegrid();
//$page->index();
$page->show();

