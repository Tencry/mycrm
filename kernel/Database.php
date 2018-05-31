<?php

abstract class Database {

	protected $host;
	protected $dbname;
	protected $user;
	protected $password;
	private static $instance = null;

	public static function factory()
	{
		if (self::$instance === null)
		{
			$driver = 'Database_'.$GLOBALS['DB_DRVR'];
			self::$instance = new $driver();
		}

		return self::$instance;
	}

	public function __construct()
	{
		$this->host = $GLOBALS['DB_HOST'];
		$this->dbname = $GLOBALS['DB_NAME'];
		$this->user = $GLOBALS['DB_USER'];
		$this->password = $GLOBALS['DB_PASS'];

		$this->connect();
	}

	public function __destruct()
	{
		$this->disconnect();
	}

	abstract public function connect();
	abstract public function disconnect();
	abstract public function query($query);
	abstract public function fetch_row();
	abstract public function fetch_assoc();
	abstract public function num_rows();
	abstract public function orderby($orderby);
	abstract public function limit($limit);
	abstract public function filter($fieldList, $sword);
}
