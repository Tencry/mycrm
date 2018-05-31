<?


class Ext_Model extends Ext_Object
{

	/**
	 * Name of the current table
	 * @var string
	 */
	protected $_table_name;


	protected $_model_name;

	/**
	 * Name of the field that references the active record
	 * @var string
	 */
	protected $_ref_field;

	/**
	 * Value of the field that references the active record
	 * @var mixed
	 */
	protected $_ref_id;

	/**
	 * Database result
	 * @var Database_Result
	 */
	protected $_res;

	/**
	 * Data array
	 * @var array
	 */
	//protected $_data = null;

	/**
	 * Indicate whether the current record exists
	 * @var boolean
	 */
	protected $_record_exists = false;

	protected $_db;

	protected $_fields = null;

	protected $_num_rows;

	protected $_orderby;

	protected $_groupby;

	protected $_limit;

	protected $_filter;

	protected $_where;


	/**
	 * Import the database object
	 */
	public function __construct($table_name = null)
	{
		$this->_db = Database::factory();

		if ($table_name)
			$this->_table_name = $table_name;

		$this->define_fields();
	}

	protected function define_fields(){}//;


	/**
	 * Set the current record from an object or array
	 * @param array
	 * @throws Exception
	 */
	public function set_data($data)
	{
		// Заменить на parent::set_data($data);
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
		$fields = mysql_list_fields('mycrm', $this->_table_name);
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

		$this->_data = $data;
	}


	/**
	 * Return the database result object
	 * @return Database_Result
	 */
	public function get_db_result()
	{
		return $this->_res;
	}


	/**
	 * Find a record by its reference field and return true if it has been found
	 * @param string
	 * @param integer
	 * @return boolean
	 */
	public function find_by($ref_field, $ref_id)
	{
		$this->_record_exists = false;
		$this->_ref_field = $ref_field;
		$this->_ref_id = $ref_id;

		$query = sprintf("SELECT * FROM %s WHERE %s='%s'",$this->_table_name, $ref_field, $ref_id);
		$result = $this->_db->query($query);

		if ($this->_db->num_rows() == 1)
		{
			$this->_res = $result;
			$this->_data = $this->_db->fetch_assoc();
			$this->_record_exists = true;

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
		if ($this->_fields) {
			//$fieldset = 'a.id';
			foreach ($this->_fields as $field)
			{
				//if ($field->type == 'hasmany') continue;
				if ($fieldset) $fieldset .= ',';
				
				$m = $field->get_model();
				if ($m)
				{
					$f_table = $m->get_table();
					if ($field->type == 'hasmany')
					{
						$fieldset .= 'group_concat(b.name SEPARATOR \'\n\') ' . $field->name;

						$join .= sprintf(' left join %s link_ab on a.id = link_ab.%s_id left join %s b on link_ab.%s_id = b.id',
						$field->link_table,$this->_table_name,$f_table,$f_table);

						$this->groupby('a.id');
					}
					else {
						$fieldset .= $f_table . '.name ' . $field->name;
						$join .= sprintf(' left join %s on a.%s = %s.id',
						$f_table,$field->name,$f_table);
					}
				}
				else
					$fieldset .= 'a.' . $field->name;
			}
		}
		else
			$fieldset = '*';


		$query = sprintf("SELECT SQL_CALC_FOUND_ROWS %s FROM %s a %s %s %s %s %s %s",
		$fieldset, $this->_table_name, $join, $this->filter, $this->where, $this->groupby, $this->orderby, $this->limit);
		//echo ($query);
		//echo "<br/>";

		//return $this->Database->select($query);
		$result = $this->_db->query($query);

		$arr_result = array();
		if ($this->_db->num_rows())
		{
			while ($row = $this->_db->fetch_assoc())
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
		$result = $this->_db->query($query);
		$row = $this->_db->fetch_row();

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
		//unset($this->_data['id']);
		if (isset($this->_data['id'])) {
			$this->_ref_field = 'id';
			$this->_ref_id = $this->_data['id'];
			$this->_record_exists = true;
		}
		/*echo '<pre>';
		print_r($this->_data);
		echo '</pre>';*/
		foreach($this->_data as $key=>$value)
		{
			if (!is_array($value))
			{
				$set_data[] = sprintf("%s='%s'", $key, $value);
			}
		}
		$set_string = "SET " . implode(', ', $set_data);

		if ($this->_record_exists && !$insert)
		{
			$query = sprintf("UPDATE %s %s WHERE %s=%s", $this->_table_name, $set_string, $this->_ref_field, $this->_ref_id);
			$this->_db->query($query);

			return $this->_db->affected_rows();
		}
		else
		{
			$query = sprintf("INSERT INTO %s %s", $this->_table_name, $set_string);
			$this->_db->query($query);
			$this->last_id = $this->_db->insert_id();

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
			$id = $this->_ref_id;
		}

		//echo $id. 'Это ИД';

		$set_data = array();
		unset($this->_data['id']);
		foreach($this->_data as $key=>$value)
		{
			$field = $this->field_by_name($key);
			if ($field->type == 'hasmany')
			{
				foreach($value as $val)
				{
					$query = sprintf("INSERT INTO %s(%s_id,%s_id) VALUES(%d,%d) on DUPLICATE key UPDATE %s_id=%d",
					$field->link_table,$this->_table_name,$field->get_model()->get_table(),$id,$val,$this->_table_name,$id);
					$this->_db->query($query);
				}
			}
		}
	}

	public function delete_links()
	{
		if ($this->_ref_id) {
			foreach ($this->_fields as $field)
			{
				if ($field->type == 'hasmany')
				{
					$query = sprintf("DELETE FROM %s WHERE %s_id=%d",$field->link_table,$this->_table_name,$this->_ref_id);
					$this->_db->query($query);
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
		$query = sprintf("DELETE FROM %s WHERE %s=%s", $this->_table_name, $this->_ref_field, $this->_ref_id);
		$this->_db->query($query);
		return $this->_db->affected_rows();
	}

	public function set_table($table_name)
	{
		$this->_table_name = $table_name;
	}

	public function get_table()
	{
		return $this->_table_name;
	}

	public function get_all()
	{
		$result = $this->_db->select("SELECT * FROM {$this->_table_name}");

		return $result;
	}

	public function add_field($name, $type='text')
	{
		$fieldtype = 'Ext_Field' . $type;
		$field = new $fieldtype($name);
		$field->type = $type;

		return $this->_fields[$name] = $field;
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
		foreach ($this->_fields as $field) {
			//echo $field->name . ' = ' . $this->gett($field->name).' | ';
			$field->value(isset($this->_data[$field->name]) ? $this->_data[$field->name] : null);
			/*if ($field->model)
				$field->set_data($field->get_data());*/
		}

		return $this->_fields;
	}

	public function groupby($groupby)
	{
		$this->groupby = $this->_db->groupby($groupby);
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

		foreach ($this->_fields as $field)
		{
			if ($field->name == $orderby)
			{
				$this->orderby = $this->_db->orderby($orderby,$type);
				return true;
			}
		}
		return false;
	}

	public function limit($limit)
	{
		$this->limit = $this->_db->limit($limit);
	}

	public function filter($fieldList, $sword)
	{
		$this->filter = $this->_db->filter($fieldList, $sword);
	}

	public function where($field, $value)
	{
		$this->where = $this->_db->where($field, $value);
	}

	function __toString()
	{
		return $this->_model_name;
	}

	function fields()
	{
		foreach ($this->_fields as $field)
		{
			$arr[] = $field->name;
		}

		return $arr;
	}

	function field_by_name($name)
	{
		foreach ($this->_fields as $field)
		{
			if ($name == $field->name)
			{
				return $field;
			}
		}
	}

}
