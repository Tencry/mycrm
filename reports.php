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
		$this->title = "Отчеты";
		$this->content = '<h4>Отчет по доходам</h4>';
		
		$db = Database::factory();
		
		$res = $db->select("SELECT g.name AS gr, s.name AS sem, s.price, COUNT(lcg.clients_id) AS num, s.price*COUNT(lcg.clients_id) AS income FROM groups g LEFT JOIN seminars s ON g.seminar_id=s.id LEFT JOIN link_clients_groups lcg ON g.id=lcg.groups_id GROUP BY g.id");
		
		$rep = '<table class="table table-striped"><tr><th>Группа</th><th>Семинар</th><th>Цена</th><th>Кол-во студентов</th><th>Доход</th></tr>';
		foreach ($res as $r) {
			$rep .= "<tr><td>{$r['gr']}</td><td>{$r['sem']}</td><td>{$r['price']}</td><td>{$r['num']}</td><td>{$r['income']}</td></tr>";
		}
		$rep .= '</table>';
		
		
		$this->content .= $rep;
	}
}


$page = new CPage();
$page->show();
