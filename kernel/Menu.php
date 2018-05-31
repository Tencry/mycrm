<?


class Menu extends Component {
	
	protected $template = 'view/navbar';
	
	function add_item($text, $ref, $active)
	{
		$item = $this->add_child($text, 'MenuItem');
		$item->set_data(
			array('text'=>$text, 'ref'=>$ref, 'active'=>$active)
		);
	}
}
