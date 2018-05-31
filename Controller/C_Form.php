<?php

class C_Form extends C_View {

	protected $template = 'form';

	protected $model;

	protected $elements = array();

	public function __construct($name = null)
	{
		parent::__construct();

		if (!is_null($name))
		{
			$this->name = $name;
		}

		if (Input::post('FORM_SUBMIT')==$this->name) {
			$m = new Model(Input::post('TABLE_NAME'));
			$m->set_data($_POST); // validate();
			if (isset($_POST['update'])) {
				$m->save();
			} else if (isset($_POST['insert'])) {
				$m->save(true);
			} else if (isset($_POST['delete'])) {
				$m->delete();
			}
		}
	}

	public function render()
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
	}

	public function add_field($name, $type='text')
	{
		return $this->elements[] = new Field($name, $type);
	}

	public function add_button($name, $caption=null)
	{
		if ($caption === null) {
			$caption = $name;
		}
		$this->add_field($name)
			->type('submit')
			->value($caption)
			->caption('')
			;
	}

	public function setModel($model)
	{
		parent::setModel($model);

		$this->model->find_by_id(Input::get($this->model.'_id'));
	}
}
