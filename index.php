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
		$this->title = "Page title";
		$this->content = '<p>Информация о системе автоматизации бизнес-процессов учебного центра.</p>';
		
		//$this->setup();
	}
	
	function setup()
	{
		switch ($_GET['page']) {
			case 'groups':
				$this->groups();
				break;
			
			case 'about':
				/*$about = $this->add('Ext_TestWidget', 'about');
				$about->content = 'About page.';*/
				$this->content = 'About';
				break;
			default:
				$this->test();
				break;
		}
	}
	
	function groups()
	{
		$grid = $this->add('Ext_Grid', 'group_grid');
		$grid->set_model('Model_Grps');
		$grid->paginator(10);
		$grid->allowEdit();
		$grid->allowAdd();
		$grid->allowDelete();
	}
	
	function test()
	{
		$grid = $this->add('Ext_Grid', 'client_grid');
		$grid->set_model('Model_Cli');
		
		$grid->paginator(3);
		$grid->exportXLS();
		$grid->exportPDF();
		$grid->exportCSV();
		$grid->allowEdit();
		$grid->allowAdd();
		$grid->allowDelete();
		$grid->filter(array('id','name'));
		$link = 'openDialog(\'pagegrid.php?model=usr\');';
		$grid->addColumn('test',$link);
		
		$grid = $this->add('Ext_Grid', 'user_grid');
		$grid->set_model('Model_Usr');
		
	}
}

$page = new CPage();
$page->show();
