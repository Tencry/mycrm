<?php

class Model_Usr extends Ext_Model {

	public static $instance = null;

	protected $_table_name = 'users';

	protected $_model_name = 'usr';

	private $sid;				// идентификатор текущей сессии
	private $uid;				// идентификатор текущего пользователя
	private $onlineMap;			// карта пользователей online

	public static function instance()
	{
		if (self::$instance == null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct()
	{
		parent::__construct();

		$this->sid = null;
		$this->uid = null;
		$this->onlineMap = null;
	}

	public function define_fields()
	{
		$this->add_field('id', 'text')->sortable(true)->hide();
		$this->add_field('name', 'text')
			->caption('ФИО')
  			//->set_model('Model_Client')
  			;

  		$this->add_field('login', 'text')
			->caption('Логин')
  			;

  		$this->add_field('groups_id', 'hasone')
  			//->type('reference')
			->show_fields(array('name'), '-')
			->caption('Группа')
			->sortable(true)
			->set_model('Model_Grps')
  			;
	}

	//
	// Очистка неиспользуемых сессий
	//
	public function clear_sessions()
	{
		$min = date('Y-m-d H:i:s', time() - 60 * 20);
		$t = "time_last < '%s'";
		$where = sprintf($t, $min);
		$this->Database->delete('sessions', $where);
	}

	public function login($login, $password, $remember = true)
	{
		if ($this->find_by('login', $login) == false)
			return false;

		if ($this->password != $password)
			return false;

		// запоминаем имя и md5(пароль)
		if ($remember)
		{
			$expire = time() + 3600 * 24 * 100;
			setcookie('login', $login, $expire);
			setcookie('password', $password, $expire);
		}

		// открываем сессию и запоминаем SID
		$this->sid = $this->open_session($this->id);

		return true;
	}

	//
	// Выход
	//
	public function logout()
	{
		setcookie('login', '', time() - 1);
		setcookie('password', '', time() - 1);
		unset($_COOKIE['login']);
		unset($_COOKIE['password']);
		unset($_SESSION['sid']);
		$this->sid = null;
		$this->uid = null;
		
		return true;
	}

	public function get($user_id = null)
	{
		if ($user_id == null)
			$user_id = $this->get_uid();

		if ($user_id == null)
			return null;

		$this->find_by_id($user_id);
		/*if (count($this->get_data()));
			return $this;*/

		return $this;
	}

	public function can($perm, $user_id)
	{}

	public function is_online()
	{}

	public function get_uid()
	{
		if ($this->uid)
			return $this->uid;

		$sid = $this->get_sid();

		if ($sid == null)
			return null;

		// Method 1
		$t = "SELECT user_id FROM sessions WHERE sid = '%s'";
		$query = sprintf($t, mysql_real_escape_string($sid));
		$result = $this->Database->select($query);

		// Если сессию не нашли - значит пользователь не авторизован.
		if (count($result) == 0)
			return null;

		// Если нашли - запоминм ее.
		$this->uid = $result[0]['user_id'];
		return $this->uid;

		// Method 2
		$mSession = new Model('sessions');
		$mSession->find_by('sid', $sid);
		return $mSession->user_id;
	}

	private function get_sid()
	{
		if ($this->sid)
			return $this->sid;

		// Ищем SID в сессии.
		$sid = isset($_SESSION['sid']) ? $_SESSION['sid'] : null;

		// Если нашли, попробуем обновить time_last в базе.
		// Заодно и проверим, есть ли сессия там.
		if ($sid != null)
		{
			$session = array();
			$session['time_last'] = date('Y-m-d H:i:s');
			$t = "sid = '%s'";
			$where = sprintf($t, mysql_real_escape_string($sid));
			$affected_rows = $this->Database->update('sessions', $session, $where);

			if ($affected_rows == 0)
			{
				$t = "SELECT count(*) FROM sessions WHERE sid = '%s'";
				$query = sprintf($t, mysql_real_escape_string($sid));
				$result = $this->Database->select($query);

				if ($result[0]['count(*)'] == 0)
					$sid = null;
			}
		}

		// Нет сессии? Ищем логин и md5(пароль) в куках.
		// Т.е. пробуем переподключиться.
		if ($sid == null && isset($_COOKIE['login']))
		{
			//$user = $this->GetByLogin($_COOKIE['login']);
			$this->find_by('login', $_COOKIE['login']);

			if ($this->login != null && $this->password == $_COOKIE['password'])
				$sid = $this->open_session($this->id);
		}

		// Запоминаем в кеш.
		if ($sid != null)
			$this->sid = $sid;

		// Возвращаем, наконец, SID.
		return $sid;
	}

	//
	// Открытие новой сессии
	// результат	- SID
	//
	private function open_session($user_id)
	{
		// генерируем SID
		$sid = $this->generate_string(10);

		// вставляем SID в БД
		$now = date('Y-m-d H:i:s');
		$session = array();
		$session['user_id'] = $user_id;
		$session['sid'] = $sid;
		$session['time_start'] = $now;
		$session['time_last'] = $now;

		//$this->Database->insert('sessions', $session);			// method 1
		$mSession = new Model('sessions');						// method 2
		//$mSession->set_table('sessions');
		$mSession->set_data($session);
		$mSession->save(true);

		// регистрируем сессию в PHP сессии
		$_SESSION['sid'] = $sid;

		// возвращаем SID
		return $sid;
	}

	//
	// Генерация случайной последовательности
	// $length 		- ее длина
	// результат	- случайная строка
	//
	private function generate_string($length = 10)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;

		while (strlen($code) < $length)
            $code .= $chars[mt_rand(0, $clen)];

		return $code;
	}
	
	public function logged_id()
	{
		return ($this->login($_COOKIE['login'], $_COOKIE['password']));
	}
}
