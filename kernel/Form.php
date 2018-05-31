<?


class Form extends Component {

	protected $template = 'view/form';

	public function __construct($name = null)
	{
		//parent::__construct();

		if (!is_null($name))
		{
			$this->name = $name;
		}
/*
		if (isset($_POST['FORM_SUBMIT']) && ($_POST['FORM_SUBMIT']==$this->name)) {
			$m = new Model($_POST['TABLE_NAME']);
			$m->set_data($_POST); // validate();
			if (isset($_POST['update'])) {
				$m->save();
			} else if (isset($_POST['insert'])) {
				$m->save(true);
			} else if (isset($_POST['delete'])) {
				$m->delete();
			}
		}*/
	}

	// TODO: Переписать
	/*public function render()
	{
		$html = '';

		$this->elements = array_merge($this->model->get_fields(), $this->elements);

		$this->add_field('FORM_SUBMIT', 'hidden')
			->value($this->name)
			->caption('')
			;

		$this->add_field('TABLE_NAME', 'hidden')
			->value($this->model->get_table())
			->caption('')
			;

		$this->add_field('id', 'hidden')
			->value($this->model->id)
			->caption('')
			;

		foreach ($this->elements as $element)
		{
			$v_elem = View::factory($element->template);
			$v_elem->set_data($element->get_data());
			$html .= $v_elem->render();
		}

		$this->content = $html;

		return parent::render();
	}*/
/*
	public function render()
	{
		if ($this->model) {
			$arr_fields = $this->model->get_fields();
			foreach ($arr_fields as $field) {
				switch ($field['type']) {
					case 'text':
						$this->add_input($field['name'], $field['type'], $field['value'], $field['label']);
						break;
					case 'button':
						$this->add_button($field['name'], $field['caption']);
						break;
					default:
						break;
				}
			}
		}

		return parent::render();
	}*/

	// TODO: нужно ли это?
	public function add_field($name, $type='text')
	{
		//return $this->elements[] = new Field($name, $type);

		$field = $this->add_child($name, 'Field');
		$field->type($type);

		return $field;
	}

	public function add_submit($name, $caption=null)
	{
		if ($caption === null) {
			$caption = $name;
		}
		$this->add_input($name, 'submit', $caption);
	}
	public function add_button($name, $caption=null, $class='')//'btn-primary')
	{
		if ($caption === null) {
			$caption = $name;
		}

		$htm = new HTML();
		$htm->set_template('view/form_button');
		$htm->set_data(array('name'=>$name, 'caption'=>$caption, 'class'=>$class));
		$this->add_child($name, $htm);
	}

	public function set_model($model)
	{
		parent::set_model($model);

		if (isset($_POST['FORM_SUBMIT']) && ($_POST['FORM_SUBMIT']==$this->name)) {
			$this->model->set_data($_POST); // validate();
			if (isset($_POST['update'])) {
				$this->model->save();
				$this->model->delete_links();
				$this->model->save_links();
			} else if (isset($_POST['insert'])) {
				$this->model->save(true);
				$this->model->save_links();
			} else if (isset($_POST['delete'])) {
				echo "DELETE!!!";
				$this->model->delete();
				$this->model->delete_links();
			}

		}

		if (isset($_GET[$this->model.'_id']))
		$this->model->find_by_id(Input::get($this->model.'_id'));

		if ($this->model) {
			$this->add_input('FORM_SUBMIT', 'hidden', $this->name);
			$this->add_input('id', 'hidden', $this->model->id);

			$arr_fields = $this->model->get_fields();
			foreach ($arr_fields as $field) {
				$field->get_data();
				/*echo '<pre>';
				print_r($field->data);
				echo '</pre>';*/
				$this->add_child($field->name, $field);
				/*switch ($field['type']) {
					case 'text':
						$this->add_input($field['name'], $field['type'], $field['value'], $field['label']);
						break;
					case 'textarea':
					$this->add_textarea($field['name'], $field['value']);
						break;
					case 'button':
						$this->add_button($field['name'], $field['caption']);
						break;
					default:
						break;
				}*/
			}
		}
	}

	function add_input($name, $type, $value='', $label='',$placeholder='', $class='', $id='')
	{
		$htm = new HTML();
		$htm->set_template('view/form_input');
		$htm->set_data(array('name'=>$name,
			'type'=>$type,
			'value'=>$value,
			'label'=>$label,
			'placeholder'=>$placeholder,
			'class'=>$class,
			'id'=>$id
		));
		$this->add_child($name, $htm);
	}

	// TODO: Дописать методы
	function add_textarea($name, $text)
	{
		$htm = new HTML();
		$htm->set_template('view/form_textarea');
		$htm->set_data(array('text'=>$text));
		$this->add_child($name, $htm);
	}

	function add_select()
	{}
}
