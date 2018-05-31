<?
header('Content-Type: text/html; charset=utf-8');
include 'startup.php';

$mgr = new Model_Manager();
if (!$mgr->logged_id()) {
	header("Location: /login.php");
	exit;
}

class CPage extends Ext_Widget {
	protected $_name = 'page';
	protected $_template = 'view/ext_page';
	
	function generate()
	{
		$this->title = "Группы";
		
		$this->setup();
	}
	
	function setup()
	{
		$grid = $this->add('Ext_Grid', 'group_grid');
		$grid->set_model('Model_Grps');
		$grid->paginator(10);
		$grid->allowEdit();
		$grid->allowAdd();
		$grid->allowDelete();
	}
}


$page = new CPage();
$page->show();
