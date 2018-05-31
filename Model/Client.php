<?

class Model_Client extends Model {

	protected $table_name = 'clients';

	protected $model_name = 'client';

	protected function define_fields()
	{


		$this->add_field('id')
			->caption('Код')
			->sortable(true)
			->hide()
			;

		$this->add_field('name')
			->type('date')
			->caption('ФИО')
			->sortable(true)
			->required()
			->minlength(10)
			;
		$this->add_field('users_id')
			->type('reference')
			->show_fields(array('name', 'email'), '-')
			->caption('User')
			->sortable(true)
			->set_model('Model_User')
			;

  		$this->add_field('users')
			->type('hasmany')
			->caption('HasMany')
			->link_table('link_clients_users')
			->set_tables('clients', 'users')
			->set_model('Model_User')
			->show_fields(array('name'))
			;

		$this->add_field('adate')
			->type('date')
			->caption('Дата')
			->required();
			;
	}
}
