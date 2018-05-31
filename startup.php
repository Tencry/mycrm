<?


/**
 * Init
 */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

function __autoload($class)
{
	$file = ROOT . 'kernel/' . $class . '.php';
	if (file_exists($file)) {
		include $file;
		return;
	}

	$file = ROOT . 'kernel/' . str_replace('_', '/', $class) . '.php';
	if (file_exists($file)) {
		include $file;
		return;
	}

	$file = ROOT . str_replace('_', '/', $class) . '.php';
	if (file_exists($file)) {
		include $file;
		return;
	}
}


/**
 * Config
 */
include 'config.php';

// �������� ������.
session_start();
