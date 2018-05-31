<?

class Model_Seminar extends Ext_Model {

	protected $_table_name = 'seminars';

	protected $_model_name = 'seminar';

	protected function define_fields()
	{

		$this->add_field('id')
			->caption('id')
			->sortable(true)
			->hide()
			;

		$this->add_field('name')
			->caption('Семинар')
			->sortable(true)
			;

		$this->add_field('descr')
			->caption('Описание')
			->sortable(true)
			;

		$this->add_field('price')
			->caption('Цена')
			->sortable(true)
			;
	}
}
