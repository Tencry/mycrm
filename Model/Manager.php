<?

class Model_Manager extends Model_Usr {

	protected $_table_name = 'managers';

	protected $_model_name = 'manager';

	public function define_fields()
	{

		$this->add_field('id')
			->caption('id')
			->sortable(true)
			->hide()
			;

		$this->add_field('name')
			->caption('Имя')
			->sortable(true)
			;

		$this->add_field('login')
			->caption('Логин')
			->sortable(true)
			;

		$this->add_field('password')
			->caption('Пароль')
			->sortable(true)
			;

	}
}
