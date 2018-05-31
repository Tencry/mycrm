<?

class Model_Cli extends Ext_Model {

	protected $_table_name = 'clients';

	protected $_model_name = 'cli';

	protected function define_fields()
	{


		$this->add_field('id', 'hidden')
			->caption('id')
			->sortable(true)
			->hide()
			;

		$this->add_field('name', 'text')
			->caption('ФИО')
			->sortable(true)
			->required()
			->minlength(10)
			;

  		$this->add_field('groups', 'hasmany')
			->caption('Группы')
			->link_table('link_clients_groups')
			->set_model('Model_Grps')
			->parent_model($this)
			->show_fields(array('name'))
			;
	}
}
