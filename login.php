<?
header('Content-Type: text/html; charset=utf-8');
include 'startup.php';

class CPage extends Ext_Widget {
	protected $_name = 'page';
	protected $_template = 'view/ext_page';
	
	function generate()
	{
		$this->title = "Студенты";
		
		$this->setup();
	}
	
	function setup()
	{
		
		if ($_POST) {
			
			$mgr = new Model_Manager();
			
			if ($mgr->login($_POST['username'], $_POST['password'])) {
				header("Location: /index.php");
				exit;
			} else echo 'Неверный логин или пароль.';
			
		}
		
		
		$c = $this->add('Ext_Container');
		
		$f = $c->add('Ext_Form', 'loginform');
		$f->hideedit = true;
		$f->add('Ext_FieldText', 'username')->caption('Имя пользователя');
		$f->add('Ext_FieldText', 'password')->caption('Пароль');
		$f->add('Ext_TestWidget')->content = '<hr>';
		
		$btn = $f->add('Ext_InputSubmit', 'login2');
		$btn->value = 'Войти';
		$btn->class = 'btn';
		
		$f->add('Ext_TestWidget')->content = '<p>Демо-пользователь<br>Логин: demo<br>Пароль: demo</p>';
	}
}


$page = new CPage();
$page->show();
