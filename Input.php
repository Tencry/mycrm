<?

class Input {


	static function get($key)
	{
		if (isset($_GET[$key])) {
			return $_GET[$key];
		}

		return null;
	}

	static function post($key)
	{
		if (isset($_POST[$key])) {
			return $_POST[$key];
		}

		return null;
	}

	static function memorize($key, $value)
	{

	static function remember($key)
	{
			return $_SESSION[$key];
		}

		return null;

	static function forget($key)
	{
		unset($_SESSION[$key]);
		//session_unregister($key);

}