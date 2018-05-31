<?php

class Database_MySQL extends Database {

	private $con_id;
	private $res;

	public function connect()
	{
		$this->con_id = mysql_connect($this->host, $this->user, $this->password);
		mysql_query('SET NAMES utf8');
		mysql_select_db($this->dbname);
	}

	public function disconnect()
	{
		mysql_close($this->con_id);
	}

	public function query($query)
	{
		return $this->res = mysql_query($query, $this->con_id);
	}

	public function fetch_row($result = null)
	{
		return mysql_fetch_row($result ? $result : $this->res);
	}

	public function fetch_assoc($result = null)
	{
		return mysql_fetch_assoc($result ? $result : $this->res);
	}

	public function insert_id()
	{
		return mysql_insert_id($this->con_id);
	}

	public function num_rows($result = null)
	{
		return mysql_num_rows($result ? $result : $this->res);
	}

	public function affected_rows()
	{
		return mysql_affected_rows($this->con_id);
	}

    //
	// Выборка строк
	// $query    	- полный текст SQL запроса
	// результат	- массив выбранных объектов
	//
	public function select($query)
	{
		$result = mysql_query($query);

		if (!$result)
			die(mysql_error());

		$n = mysql_num_rows($result);
		$arr = array();

		for($i = 0; $i < $n; $i++)
		{
			$row = mysql_fetch_assoc($result);
			$arr[] = $row;
		}

		return $arr;
	}

	//
	// Вставка строки
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// результат	- идентификатор новой строки
	//
	public function insert($table, $object)
	{
		$columns = array();
		$values = array();

		foreach ($object as $key => $value)
		{
			$key = mysql_real_escape_string($key . '');
			$columns[] = $key;

			if ($value === null)
			{
				$values[] = 'NULL';
			}
			else
			{
				$value = mysql_real_escape_string($value . '');
				$values[] = "'$value'";
			}
		}

		$columns_s = implode(',', $columns);
		$values_s = implode(',', $values);

		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = mysql_query($query);

		if (!$result)
			die(mysql_error());

		return mysql_insert_id();
	}

	//
	// Изменение строк
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// $where		- условие (часть SQL запроса)
	// результат	- число измененных строк
	//
	public function update($table, $object, $where)
	{
		$sets = array();

		foreach ($object as $key => $value)
		{
			$key = mysql_real_escape_string($key . '');

			if ($value === null)
			{
				$sets[] = "$key=NULL";
			}
			else
			{
				$value = mysql_real_escape_string($value . '');
				$sets[] = "$key='$value'";
			}
		}

		$sets_s = implode(',', $sets);
		$query = "UPDATE $table SET $sets_s WHERE $where";
		$result = mysql_query($query);

		if (!$result)
			die(mysql_error());

		return mysql_affected_rows();
	}

	//
	// Удаление строк
	// $table 		- имя таблицы
	// $where		- условие (часть SQL запроса)
	// результат	- число удаленных строк
	//
	public function delete($table, $where)
	{
		$query = "DELETE FROM $table WHERE $where";
		$result = mysql_query($query);

		if (!$result)
			die(mysql_error());

		return mysql_affected_rows();
	}

	public function groupby($groupby)
	{
		return 'group by ' . $groupby;
	}

	public function orderby($orderby,$type='asc')
	{
		return 'order by ' . $orderby . ' ' .$type;
	}

	public function limit($limit)
	{
		return 'limit ' . $limit;
	}

	public function filter($fieldList, $sword)
	{
		$sql = null;
		foreach ($fieldList as $field)
		{
			if ($sql) $sql .= ' or ';
			$sql .= 'a.' . $field . ' like \'%' . $sword . '%\'';
		}
		return 'where ' . $sql;
	}

	public function where($field, $value)
	{
		$sql = null;
		return 'where a.' . $field . '=\'' . $value . '\'';
	}
}
