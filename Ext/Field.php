<?

/**
 * Каждый публичный метод возвращает указатель на свой экземпляр класса Ext_Field
 * Фигню написал, иначе не мог выразить.
 */
class Ext_Field extends Ext_Widget
{
	protected $_name = 'Field';
	
	protected $_hide = false;

	function __construct($name)
	{
		parent::__construct($name);
		
		$this->name = $this->_name;
	}


	/**
	 * Свойства класса Ext_field
	 * Все методы для назначения свойств должны возвращать указатель на свой экземпляр класса
	 */
	function name($name = null)
	{
		if (is_null($name)) {
			return $this->_name;
		} else {
			$this->name = $this->_name = $name;
			return $this;
		}
	}

	function type($type)
	{
		$this->type = $type;
/*
		switch ($type) {
			case 'reference':
				$this->_template = 'View/form_select';
				break;
			case 'textarea':
				$this->_template = 'View/form_textarea';
				break;
			case 'hasmany':
				$this->_template = 'View/form_hasmany';
				break;
			case 'date':
				$this->_template = 'View/form_date';
				break;
			default:
				$this->_template = 'View/form_input';
				break;
		}
*/
		return $this;
	}

	function caption($caption)
	{
		$this->label = $this->caption = $caption;

		return $this;
	}

	function value($value = '')
	{
		$this->value = $value;

		return $this;
	}

	function sortable($sortable)
	{
		$this->sortable = $sortable;

		return $this;
	}

	function required($type=null)
	{
		$this->required = 'required';
		if ($type) $this->required .= ' '.$type;

		return $this;
	}

	function minlength($minlength)
	{
		$this->minlength = $minlength;

		return $this;
	}

	function hide()
	{
		$this->type('hidden');
		$this->_hide = true;
	}
/*hasone&hasmany class method
	function show_fields($array_of_field_names, $separator = ' ')
	{
		$this->option_fields = $array_of_field_names;
		$this->option_separator = $separator;

		return $this;
	}*/

	// Переопределен для подобия с другими методами Ext_Field
	function set_model($model)
	{
		parent::set_model($model);

		return $this;
	}


	/*
	 * Переопределен для получения данных поля ref и hasmany
	 * Подумать как оптимизировать
	 */
/*	function get_data()
	{
		//if ($this->type == 'hasone') {
			/*if ($this->value)
				$this->_model->where('id',$this->value);
			else
				$this->_model->limit(10);

			$this->_model->orderby('-id');
			
			$this->_data = array (
				'name' => $this->name,
				'type' => $this->type,
				'caption' => $this->caption,
				'options' => $this->_model->find_all(),
				'option_fields' => $this->option_fields,
				'option_separator' => $this->option_separator,
				'model' => $this->_model
			);
			*/
		//} else if ($this->type == 'hasmany') {
			//$this->data['model'] = 
				//$this->model = $this->_model;
			//$this->data['caption'] = $this->caption;
			

			// Method 2
/*
			$curr_rec_id = isset($_GET['client_id']) ? $_GET['client_id'] : 0;

			if ($curr_rec_id) {

				$query = "SELECT * FROM ".$this->table2." WHERE id IN (SELECT ".$this->table2."_id FROM ".$this->link_table." WHERE ".$this->table1."_id=".$curr_rec_id.")";
				$arr = Database::factory()->select($query);


				foreach ($arr as $val) {
					if ($val['id'])
						$this->_model->where('id',$val['id']);
					else
						$this->_model->limit(10);

					$this->_model->orderby('-id');
					$this->_data['linked_records'][] = array (
						'name' => $this->name,
						'type' => $this->type,
						'caption' => $this->caption,
						'options' => $this->_model->find_all(),
						'option_fields' => $this->option_fields,
						'option_separator' => $this->option_separator,
						'model' => $this->_model
					);
				}
			}*/

		//}
		
/*		return parent::get_data();
	}*/

	function generate()
	{
/** Это тоже думаю не нужно
		//echo $this->_name;
		$default_data = array (
			'minlength'=>3,
			'name'=>'',
			'placeholder'=>'',
			'class'=>'',
			'value'=>'',
			'linked_records'=>'',
			'email'=>''
		);
		$this->set_data(array_merge($default_data, $this->get_data()));*/
	}
}
