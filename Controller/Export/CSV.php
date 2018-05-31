<?php
class Controller_Export_CSV extends Controller_Export {

	public function __construct()
	{
		parent::__construct();
	}

	public function render()
	{		$csv = '';
		foreach($this->headers as $header)
		{			$csv .=	$header->caption.';';
		}
		$csv .= "\n";

		foreach($this->rows as $row)
		{
			foreach ($row as $value)
			{
				$csv .= $value.';';
			}
			$csv .= "\n";
		}

		// Redirect output to a client’s web browser (PDF)
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename="export.csv"');
		header('Cache-Control: max-age=0');

		die($csv);
	}

}
