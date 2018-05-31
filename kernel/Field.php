<?

class Field extends Component
{
	public $template = 'View/form_input';

	public $model;

	public $name;
	public $type;
	public $caption;
	public $value = '';
	public $sortable;
	public $required;
	public $minlength;

	private $option_fields = array('id');
	private $option_separator = '|';

	public function __construct($name, $type='text')
	{
		$this->data = array (
			'id'=>'', 'class'=>'', 'placeholder'=>'',
			'type'=>$type, 'name'=>$name, 'value'=>''
		);

		$this->type($type);
/*
		if ($type == 'reference') {
			$this->template = 'View/form_select';
		} else if ($this->type == 'textarea') {
			$this->template = 'View/form_textarea';
		}*/

		$this->name = $this->caption = $name;

	}

	function name($name = null)
	{
		if (is_null($name)) {
			return $this->name;
		} else {
			$this->name = $name;
			return $this;
		}
	}

	function type($type)
	{
		$this->data['type'] = $this->type = $type;

		switch ($type) {
			case 'reference':
				$this->template = 'View/form_select';
				break;
			case 'textarea':
				$this->template = 'View/form_textarea';
				break;
			case 'hasmany':
				$this->template = 'View/form_hasmany';
				break;
			case 'date':
				$this->template = 'View/form_date';
				$this->date['id'] = 'datepicker'; // zachem?
				break;
			default:
				$this->template = 'View/form_input';
				break;
		}

		//if ($type=='hidden')
		//	$this->caption('');

		return $this;
	}

	function caption($caption)
	{
		$this->label = $this->caption = $caption;

		return $this;
	}

	function value($value = '')
	{
		$this->data['value'] = $this->value = $value;

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

/*	function setModel($model)
	{
		if ($model instanceof Model) {
			$this->model = $model;
		} else {
			$this->model = new $model();
		}

		$this->type = 'reference';
		$this->template = 'field/select';

		return $this;
	}
	*/

	function set_model($model)
	{
		parent::set_model($model);

		//$this->type = 'reference';
		//$this->template = 'View/form_select';

		//$this->data = $this->get_data();

		return $this;
	}


	function get_data()
	{
		if ($this->type == 'reference') {
			if ($this->value)
				$this->model->where('id',$this->value);
			else
				$this->model->limit(10);

			$this->model->orderby('-id');
			//$array = array (
			$this->data = array (
				'name' => $this->name,
				'type' => $this->type,
				'caption' => $this->caption,
				'options' => $this->model->find_all(),
				'option_fields' => $this->option_fields,
				'option_separator' => $this->option_separator,
				'model' => $this->model
			);
			/*$this->data = $array;
			return $array;*/
		} else if ($this->type == 'hasmany') {
			$this->data['model'] = $this->model;
			$this->data['caption'] = $this->caption;
			//$this->data =
			/*
			Method 1

			$curr_rec_id = $_GET['client_id'];

			if ($curr_rec_id) {
			$link_table = 'link_clients_users';
			$table1 = 'mycrm_client';
			$table1_id = 'client_id';
			$table2 = 'mycrm_users';
			$table2_id = 'user_id';
			$query = "SELECT * FROM ".$table2." WHERE id IN (SELECT ".$table2_id." FROM ".$link_table." WHERE ".$table1_id."=".$curr_rec_id.")";
			$arr = Database::factory()->select($query);

			$this->data['linked_records'] = $arr;

			}*/

			// Method 2

			$curr_rec_id = $_GET['client_id'];

			if ($curr_rec_id) {
			/*$link_table = 'link_clients_users';
			$table1 = 'clients';
			$table1_id = 'clients_id';
			$table2 = 'users';
			$table2_id = 'users_id';*/
			$query = "SELECT * FROM ".$this->table2." WHERE id IN (SELECT ".$this->table2."_id FROM ".$this->link_table." WHERE ".$this->table1."_id=".$curr_rec_id.")";
			$arr = Database::factory()->select($query);


			foreach ($arr as $val) {
			if ($val['id'])
				$this->model->where('id',$val['id']);
			else
				$this->model->limit(10);

			$this->model->orderby('-id');
			$this->data['linked_records'][] = array (
				'name' => $this->name,
				'type' => $this->type,
				'caption' => $this->caption,
				'options' => $this->model->find_all(),
				'option_fields' => $this->option_fields,
				'option_separator' => $this->option_separator,
				'model' => $this->model
			);
			}

			//print_r($this->data);
			}

		} else {
			$this->data = array_merge(get_object_vars($this), $this->data);
			/*$array = get_object_vars($this);
			$this->data = $array;
			return $array;*/
		}
	}

	function hide()
	{
		$this->type('hidden');
		//$this->caption('');
	}

	function show_fields($array_of_field_names, $separator = ' ')
	{
		$this->option_fields = $array_of_field_names;
		$this->option_separator = $separator;

		return $this;
	}

	function link_table($table)
	{
		$this->link_table = $table;
		return $this;
	}

	function set_tables($table1, $table2)
	{
		$this->table1 = $table1;
		$this->table2 = $table2;
		return $this;
	}
}
