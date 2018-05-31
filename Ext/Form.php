<?


class Ext_Form extends Ext_Widget {

	protected $_template = 'View/ext_form';
	protected $_name = 'Form';

	function __construct($name)
	{
		parent::__construct($name);
		
		$this->name = $this->_name;
	}

	/**
	 * Реализуем метод порождения для формы
	 */
	function generate()
	{
		// Значения по умолчанию
		$default_data = array(
			'action' => '',
			'method' => 'POST', // 'GET',
		//	'name' => $this->_name,
			'autocomplete' => 'on', // 'off'
		//	'class' => 'editform',
		);

		// Логика при установленной модели
		if ($this->_model) {
			if (isset($_POST['FORM_SUBMIT']) && ($_POST['FORM_SUBMIT']==$this->_name)) {

				// Выбираем данные для записи из POST
				$this->_model->set_data($_POST); // validate();
				if (isset($_POST['update'])) {
					//$this->_model->update();
					$this->_model->save();
					$this->_model->delete_links();
					$this->_model->save_links();
				} else if (isset($_POST['insert'])) {
					//$this->_model->insert();
					$this->_model->save(true);
					$this->_model->save_links();
				} else if (isset($_POST['delete'])) {
					$this->_model->delete();
					$this->_model->delete_links();
				}
			}

			// Подучаем данные по id для отображения
			if (isset($_GET[$this->_model.'_id']))
				$this->_model->find_by_id($_GET[$this->_model.'_id']);

			$container = new Ext_Container('form_fields');
			// Служебные поля
			$f = $container->add('Ext_FieldHidden', 'FORM_SUBMIT'); // submitted form name
			$f->value = $this->name;
			$f = $container->add('Ext_FieldHidden', 'id'); // Поле содержащее id записи
			$f->value = $this->_model->id;

			// Порождаем поля по данным из модели
			$arr_fields = $this->_model->get_fields();

			foreach ($arr_fields as $field) {
				$field->get_data();

				$container->add($field, $field->name);
			}
			
			$this->add_before($container);
		}

		// Объединение данных
		$this->set_data(array_merge($default_data, $this->get_data()));
		
	}
	
}
