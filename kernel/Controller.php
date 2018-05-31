<?


class Controller {

	protected $model = null;

	public function set_model($model)
	{
		if ($model instanceof Model) {
			$this->model = $model;
		} else {
			$this->model = new $model();
		}
	}
}
