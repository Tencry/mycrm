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
			//->type('date')
			->caption('ФИО2')
			->sortable(true)
			->required()
			->minlength(10)
			;
		$this->add_field('users_id', 'hasone')
			//->type('reference')
			->show_fields(array('name', 'email'), '-')
			->caption('Выбери пользователя')
			->sortable(true)
			->set_model('Model_Usr')
			;

  		$this->add_field('users', 'hasmany')
			//->type('hasmany')
			->caption('HasMany')
			->link_table('link_clients_users')
			//->set_tables('clients', 'users')
			->set_model('Model_Usr')
			->parent_model($this)
			->show_fields(array('name'))
			;

		$this->add_field('adate', 'datepicker')
			//->type('date')
			->caption('Дата')
			->required();
			;
	}
}
