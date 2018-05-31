<?


class SelectOptions extends Component {

	protected $template = 'view/select_options';

	public function __construct($name = null)
	{
		if (!is_null($name))
		{
			$this->name = $name;
		}
	}

	public function set_model($model)
	{
		parent::set_model($model);

		$this->model->where('id',$this->id);
		$this->rows = $this->model->find_all();
        $this->name = (string)$this->model;
//		print_r($arr_fields);

	}

	public function setId($id)
	{
		$this->id = $id;
	}

}
