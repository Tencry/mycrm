<?

class Model_Groups extends Model {

	protected $table_name = 'groups';

	protected $model_name = 'groups';

	protected function define_fields()
	{

		$this->add_field('id')
			->caption('id')
			->sortable(true)
			->hide()
			;

		$this->add_field('name')
			->caption('Название')
			->sortable(true)
			;

		$this->add_field('descr')
			->caption('Описание')
			->sortable(true)
			;

	}
}
