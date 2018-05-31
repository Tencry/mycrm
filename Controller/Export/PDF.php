<?php
class Controller_Export_PDF extends Controller_Export {

	public function __construct()
	{
		parent::__construct();
	}

	public function render()
	{		//	Change these values to select the Rendering library that you wish to use
		//		and its directory location on your server
		//$rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
		$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
		//$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
		//$rendererLibrary = 'tcPDF5.9';
		$rendererLibrary = 'MPDF54';
		//$rendererLibrary = 'domPDF0.6.0beta3';
		$rendererLibraryPath = ROOT.'libs/' . $rendererLibrary;

		$objPHPExcel = $this->objPHPExcel;
		// Set document properties
		$objPHPExcel->getProperties()
			->setCreator("MyCRM")
			->setLastModifiedBy("MyCRM")
			->setTitle("PDF Test Document")
			->setSubject("PDF Test Document")
			->setDescription("Test document for PDF, generated using PHP classes.")
			->setKeywords("pdf php")
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
			$style = $aSheet->getStyleByColumnAndRow($colNum, 1);
			$cell->setValue($header->caption);
			$style->getFont()->setBold(true);
			$style->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$style->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		    $style->getFill()->getStartColor()->setARGB('FFD7E4BC');
			$colNum++;
		}
		// rows
		$colNum = 0;
		$rowNum = 2;
		foreach($this->rows as $row)
		{
			foreach ($row as $value)
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
		$aSheet->setTitle('Ëèñò 1');
		$aSheet->setShowGridLines(false);


		if (!PHPExcel_Settings::setPdfRenderer(
		$rendererName,
		$rendererLibraryPath
			)) {
			die(
				'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
				'<br />' .
				'at the top of this script as appropriate for your directory structure'
			);
		}

		// Redirect output to a client’s web browser (PDF)
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment;filename="export.pdf"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		$objWriter->save('php://output');
		exit;


	}

}
