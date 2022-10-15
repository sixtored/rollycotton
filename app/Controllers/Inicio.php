<?php

namespace App\Controllers;

use App\Models\ProductosModel ;
use App\Models\VentasModel ;
use PhpOffice\PhpSpreadsheet\Spreadsheet ;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//C:\laragon\www\pos\app\ThirdParty

class Inicio extends BaseController
{

	protected $productosModel, $ventasModel, $session ;
	
	public function __construct()
	{
		$this->productosModel = new ProductosModel() ;
		$this->ventasModel = new VentasModel() ;
		$this->session = session() ;
	}

	public function index()
	{
		if(!isset($this->session->id_usuario)) {
			return redirect()->to(base_url()) ;
		}
		$session = session() ;
        $id_usuario = $session->id_usuario ;
		$tproductos = $this->productosModel->total_productos() ;
		$ventasdia = $this->ventasModel->ventas_del_dia(date('Y-m-d'),$id_usuario) ;
		$pstock_min = $this->productosModel->productosSminimo() ;
		$datos = ['tproductos'=>$tproductos,'ventasdia'=>$ventasdia, 'pstock_min' => $pstock_min] ;
		echo view('header') ;
		echo view('inicio', $datos);
		echo view('footer') ;

	}


	public function excel()
	{

//use PhpOffice\PhpSpreadsheet\Spreadsheet;

// require __DIR__ . '/../Header.php';

$spreadsheet = new Spreadsheet() ;

// Set document properties
//$helper->log('Set document properties');
$spreadsheet->getProperties()
    ->setCreator('Maarten Balliauw')
    ->setLastModifiedBy('Maarten Balliauw')
    ->setTitle('PhpSpreadsheet Test Document')
    ->setSubject('PhpSpreadsheet Test Document')
    ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
    ->setKeywords('office PhpSpreadsheet php')
    ->setCategory('Test result file');

// Add some data
//$helper->log('Add some data');
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Hello')
    ->setCellValue('B2', 'world!')
    ->setCellValue('C1', 'Hello')
    ->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A4', 'Miscellaneous glyphs')
    ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

$spreadsheet->getActiveSheet()
    ->setCellValue('A8', "Hello\nWorld");
$spreadsheet->getActiveSheet()
    ->getRowDimension(8)
    ->setRowHeight(-1);
$spreadsheet->getActiveSheet()
    ->getStyle('A8')
    ->getAlignment()
    ->setWrapText(true);

$value = "-ValueA\n-Value B\n-Value C";
$spreadsheet->getActiveSheet()
    ->setCellValue('A10', $value);
$spreadsheet->getActiveSheet()
    ->getRowDimension(10)
    ->setRowHeight(-1);
$spreadsheet->getActiveSheet()
    ->getStyle('A10')
    ->getAlignment()
    ->setWrapText(true);
$spreadsheet->getActiveSheet()
    ->getStyle('A10')
    ->setQuotePrefix(true);

// Rename worksheet
//$helper->log('Rename worksheet');
$spreadsheet->getActiveSheet()
    ->setTitle('Simple');

// Save
//$helper->write($spreadsheet, __FILE__, ['Xlsx', 'Xls', 'Ods']);

    $writer = new Xlsx($spreadsheet);
    $writer->save('ejemplo.xlsx');

    // Aquí
$filename = 'test.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$objWriter->save('php://output');

	}
}
