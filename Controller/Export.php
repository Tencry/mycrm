<?php

class Controller_Export {	//private $objPHPExcel;
	public function __construct()
	{		include(ROOT . 'libs/PHPExcel.php');
		$this->objPHPExcel = new PHPExcel();
	}

	public function render()
	{	}

	public function setRows($rows)
	{		$this->rows = $rows;	}

	public function setHeaders($headers)
	{
		$this->headers = $headers;
	}

}
