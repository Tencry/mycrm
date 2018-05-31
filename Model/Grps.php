<?

class Model_Grps extends Ext_Model {

	protected $_table_name = 'groups';

	protected $_model_name = 'grps';

	protected function define_fields()
	{

		$this->add_field('id')
			->caption('id')
			->sortable(true)
			->hide()
			;
			
		$this->add_field('date', 'datepicker')
			->caption('Дата проведения')
			->sortable(true)
			;

		$this->add_field('name')
			->caption('Группа')
			->sortable(true)
			;

		$this->add_field('seminar_id', 'hasone')
			->show_fields(array('name'))
			->caption('Семинар')
			->sortable(true)
			->set_model('Model_Seminar')
			;

		$this->add_field('descr', 'textarea')
			->caption('Описание')
			->sortable(true)
			;

  		/*$this->add_field('users', 'hasmany')
			->caption('Студенты')
			->link_table('link_clients_groups')
			->set_model('Model_Cli')
			->parent_model($this)
			->show_fields(array('name'))
			;*/
	}
}
