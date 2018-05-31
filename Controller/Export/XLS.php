<?php

class Controller_Export_XLS extends Controller_Export {

	public function __construct()
	{
		parent::__construct();
	}

	public function render()
	{		$objPHPExcel = $this->objPHPExcel;		// Set document properties
		$objPHPExcel->getProperties()
			->setCreator("MyCRM")
			->setLastModifiedBy("MyCRM")
			->setTitle("Office 2007 XLSX Document")
			->setSubject("Office 2007 XLSX Document")
			->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
			->setKeywords("office 2007 openxml php")
			->setCategory("Test result file");

		// set default font
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
		// set default font size
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);

		$styleArray =
		array
		(
            'style' => PHPExcel_Style_Border::BORDER_DASHDOT,
            'color' => array(
                'rgb' => '808080'
            )
        );


		$aSheet = $objPHPExcel->setActiveSheetIndex(0);

		// Add some data
		$colNum = 0;
		// headers
		foreach($this->headers as $header)
		{
			$cell = $aSheet->getCellByColumnAndRow($colNum,1);
			$style = $aSheet->getStyleByColumnAndRow($colNum, 1);			$cell->setValue($header->caption);
			$style->getFont()->setBold(true);
			$style->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$style->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		    $style->getFill()->getStartColor()->setARGB('FFD7E4BC');
		    $style->getAlignment()->setWrapText(true);
			$colNum++;		}
		// rows
		$colNum = 0;
		$rowNum = 2;
		foreach($this->rows as $row)
		{			foreach ($row as $value)
			{
				$cell = $aSheet->getCellByColumnAndRow($colNum,$rowNum);
				$style = $aSheet->getStyleByColumnAndRow($colNum, $rowNum);
				$cell->setValue($value);
			    $style->getAlignment()->setWrapText(true);
			    $style->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			    $colNum++;
			}
			$rowNum++;
			$colNum = 0;
		}


		// Rename worksheet
		$aSheet->setTitle('Лист 1');

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="export.xls"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;


	}

}
