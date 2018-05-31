<?


class Model
{

	/**
	 * Name of the current table
	 * @var string
	 */
	protected $table_name;


	protected $model_name;

	/**
	 * Name of the field that references the active record
	 * @var string
	 */
	protected $ref_field;

	/**
	 * Value of the field that references the active record
	 * @var mixed
	 */
	protected $ref_id;

	/**
	 * Database result
	 * @var Database_Result
	 */
	protected $res;

	/**
	 * Data array
	 * @var array
	 */
	protected $data = null;

	/**
	 * Indicate whether the current record exists
	 * @var boolean
	 */
	protected $record_exists = false;

	protected $Database;

	protected $fields = null;

	protected $num_rows;

	protected $orderby;

	protected $groupby;

	protected $limit;

	protected $filter;

	protected $where;


	/**
	 * Import the database object
	 */
	public function __construct($table_name = null)
	{
		$this->Database = Database::factory();

		if ($table_name)
			$this->table_name = $table_name;

		$this->define_fields();
	}

	protected function define_fields(){}//;

	/**
	 * Set an object property
	 * @param string
	 * @param mixed
	 */
	public function __set($key, $value)
	{
		$this->data[$key] = $value;
	}


	/**
	 * Return an object property
	 * @param string
	 * @return mixed
	 */
	public function & __get($key)
	{
		return $this->data[$key];
	}


	/**
	 * Check whether a property is set
	 * @param string
	 * @return boolean
	 */
	public function __isset($key)
	{
		return isset($this->data[$key]);
	}


	/**
	 * Set the current record from an object or array
	 * @param array
	 * @throws Exception
	 */
	public function set_data($data)
	{
		//print_r($data);
		if (is_object($data))
		{
			$data = get_object_vars($data);
		}

		if (!is_array($data))
		{
			throw new Exception('Array required to set data');
		}

		// Получаем поля таблицы
		$fields = mysql_list_fields('mycrm', $this->table_name);
		$columns = mysql_num_fields($fields);

		for ($i = 0; $i < $columns; $i++) {
			$arr[] = mysql_field_name($fields, $i);
		}


		$ar_fields = $this->fields();
		//print_r($ar_fields);

		// Удаляем из массива поля которых нет в таблице
		foreach($data as $key=>$val) {
			if (!in_array($key, $arr) && !in_array($key, $ar_fields)) {
				unset($data[$key]);
			}
		}

		// Устанавливаем ссылку на текущую запись
		$this->ref_field = 'id';
		$this->ref_id = $data['id'];
		$this->record_exists = true;

		$this->data = $data;
	}


	/**
	 * Return the current record as associative array
	 * @return array
	 */
	public function get_data()
	{
		return $this->data;
	}


	/**
	 * Return the database result object
	 * @return Database_Result
	 */
	public function get_db_result()
	{
		return $this->res;
	}


	/**
	 * Find a record by its reference field and return true if it has been found
	 * @param string
	 * @param integer
	 * @return boolean
	 */
	public function find_by($ref_field, $ref_id)
	{
		$this->record_exists = false;
		$this->ref_field = $ref_field;
		$this->ref_id = $ref_id;

		$query = sprintf("SELECT * FROM %s WHERE %s='%s'",$this->table_name, $ref_field, $ref_id);
		$result = $this->Database->query($query);

		if ($this->Database->num_rows() == 1)
		{
			$this->res = $result;
			$this->data = $this->Database->fetch_assoc();
			$this->record_exists = true;

			return true;
		}

		return false;
	}

	public function find_by_id($id)
	{
		$this->find_by('id', $id);

		return $this;
	}

	public function find_all()
	{
		$fieldset = '';
		$join = '';
		if ($this->fields) {
			//$fieldset = 'a.id';
			foreach ($this->fields as $field)
			{
				//if ($field->type == 'hasmany') continue;
				if ($fieldset) $fieldset .= ',';
				if ($field->model)
				{
					if ($field->type == 'hasmany')
					{
						$fieldset .= 'group_concat(b.name SEPARATOR \'\n\') ' . $field->name;

						$join .= sprintf(' left join %s link_ab on a.id = link_ab.%s_id left join %s b on link_ab.%s_id = b.id',
						$field->link_table,$this->table_name,$field->model->table_name,$field->model->table_name);

						$this->groupby('a.id');
					}
					else {
						$fieldset .= $field->model->table_name . '.name ' . $field->name;
						$join .= sprintf(' left join %s on a.%s = %s.id',
						$field->model->table_name,$field->name,$field->model->table_name);
					}
				}
				else
					$fieldset .= 'a.' . $field->name;
			}
		}
		else
			$fieldset = '*';


		$query = sprintf("SELECT SQL_CALC_FOUND_ROWS %s FROM %s a %s %s %s %s %s %s",
		$fieldset, $this->table_name, $join, $this->filter, $this->where, $this->groupby, $this->orderby, $this->limit);
		//echo ($query);
		//echo "<br/>";

		//return $this->Database->select($query);
		$result = $this->Database->query($query);

		$arr_result = array();
		if ($this->Database->num_rows())
		{
			while ($row = $this->Database->fetch_assoc())
			{
				$arr_result[] = $row;
			}
			//$this->res = $result;
			//$this->record_exists = true;
			return $arr_result;
		}

		return false;
	}

	public function get_num_rows()
	{
		$query = 'SELECT FOUND_ROWS()';
		$result = $this->Database->query($query);
		$row = $this->Database->fetch_row();

		return $row[0];
	}


	/**
	 * Save the current record and return the number of affected rows or the last insert ID
	 * @param boolean
	 * @return integer
	 */
	public function save($insert=false)
	{

		$set_data = array();
		unset($this->data['id']);
		//print_r($this->data);
		foreach($this->data as $key=>$value)
		{
			if (!is_array($value))
			{
				$set_data[] = sprintf("%s='%s'", $key, $value);
			}
		}
		$set_string = "SET " . implode(', ', $set_data);

		if ($this->record_exists && !$insert)
		{
			$query = sprintf("UPDATE %s %s WHERE %s=%s", $this->table_name, $set_string, $this->ref_field, $this->ref_id);
			$this->Database->query($query);

			return $this->Database->affected_rows();
		}
		else
		{
			$query = sprintf("INSERT INTO %s %s", $this->table_name, $set_string);
			$this->Database->query($query);
			$this->last_id = $this->Database->insert_id();

			return $this->last_id;
		}
	}

	public function save_links()
	{
		if ($this->last_id)
		{
			$id = $this->last_id;
		}
		else
		{
			$id = $this->ref_id;
		}

		$set_data = array();
		unset($this->data['id']);
		foreach($this->data as $key=>$value)
		{
			$field = $this->field_by_name($key);
			if ($field->type == 'hasmany')
			{
				foreach($value as $val)
				{
					$query = sprintf("INSERT INTO %s(%s_id,%s_id) VALUES(%d,%d) on DUPLICATE key UPDATE %s_id=%d",
					$field->link_table,$this->table_name,$field->model->table_name,$id,$val,$this->table_name,$id);
					$this->Database->query($query);
				}
			}
		}
	}

	public function delete_links()
	{
		if ($this->ref_id) {
			foreach ($this->fields as $field)
			{
				if ($field->type == 'hasmany')
				{
					$query = sprintf("DELETE FROM %s WHERE %s_id=%d",$field->link_table,$this->table_name,$this->ref_id);
					$this->Database->query($query);
				}
			}
		}
	}



	/**
	 * Delete the current record and return the number of affected rows
	 * @return integer
	 */
	public function delete()
	{
		$query = sprintf("DELETE FROM %s WHERE %s=%s", $this->table_name, $this->ref_field, $this->ref_id);
		$this->Database->query($query);
		return $this->Database->affected_rows();
	}

	public function set_table($table_name)
	{
		$this->table_name = $table_name;
	}

	public function get_table()
	{
		return $this->table_name;
	}

	public function get_all()
	{
		$result = $this->Database->select("SELECT * FROM {$this->table_name}");

		return $result;
	}

	public function add_field($name, $type='text')
	{
		$field = new Field($name, $type);

		return $this->fields[$name] = $field;
	}


/*	public function add_field($name, $type='text', $param=array())
	{
		$field = array_merge(
			array('name'=>$name, 'type'=>$type, 'value'=>'', 'label'=>''),
			$param
		);

		$this->fields[] = $field;
	}*/

	public function get_fields()
	{
		foreach ($this->fields as $field) {
			//echo $field->name . ' = ' . $this->gett($field->name).' | ';
			$field->value(isset($this->data[$field->name]) ? $this->data[$field->name] : null);
			/*if ($field->model)
				$field->set_data($field->get_data());*/
		}

		return $this->fields;
	}

	public function groupby($groupby)
	{
		$this->groupby = $this->Database->groupby($groupby);
	}

	public function orderby($orderby)
	{
		if (substr($orderby,0,1) == '-')
		{
			$type = 'desc';
			$orderby = str_replace('-','',$orderby);
		}
		else
			$type = 'asc';

		foreach ($this->fields as $field)
		{
			if ($field->name == $orderby)
			{
				$this->orderby = $this->Database->orderby($orderby,$type);
				return true;
			}
		}
		return false;
	}

	public function limit($limit)
	{
		$this->limit = $this->Database->limit($limit);
	}

	public function filter($fieldList, $sword)
	{
		$this->filter = $this->Database->filter($fieldList, $sword);
	}

	public function where($field, $value)
	{
		$this->where = $this->Database->where($field, $value);
	}

	function __toString()
	{
		return $this->model_name;
	}

	function fields()
	{
		if (is_array($this->fields))
		foreach ($this->fields as $field)
		{
			$arr[] = $field->name;
		}

		return $arr;
	}

	function field_by_name($name)
	{
		foreach ($this->fields as $field)
		{
			if ($name == $field->name)
			{
				return $field;
			}
		}
	}

}
