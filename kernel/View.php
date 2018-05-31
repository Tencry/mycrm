<?


class View {
	static function render($file, $data)
	{
		foreach ($data as $v_key=>$v_value) {
			$$v_key = $v_value;
		}
		
		ob_start();
		include ROOT . $file . '.php';
		$ret = ob_get_contents();
		ob_end_clean();
		
		return $ret;
	}
}
