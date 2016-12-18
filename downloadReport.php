<!DOCTYPE html>
<?php
include_once ( dirname(__FILE__) . '/Classes/PHPExcel.php');
include_once ( dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php');

//値受取
if (empty($_REQUEST['dateLog01']) && empty($_REQUEST['dateLog02'])) {
    exit;
} else {
    $dateLog01 = $_REQUEST['dateLog01'];
    $dateLog02 = $_REQUEST['dateLog02'];
    $reportList = json_decode($_REQUEST['reportList']);
}

$book = PHPExcel_IOFactory::load('excel/template.xlsx');
$sheet = $book->getActiveSheet();

// セル番地で書いてみる
$sheet->setCellValue('B2', $dateLog01.' -' .$dateLog02);


$rowOffset = 5;
foreach ((array)$reportList as $row => $product) {
    foreach ($product as $col => $value) {
        $sheet->setCellValueByColumnAndRow($col, $row + $rowOffset, $value);
    }
}

//ローカルに保存
//$writer = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
//$writer->save('test.xlsx');


// Excel2007形式で出力する
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=PHPExcel.xlsx");
header("Cache-Control: max-age=0");
$writer = PHPExcel_IOFactory::createWriter($book, "Excel2007");
ob_end_clean();
$writer->save("php://output");
exit;