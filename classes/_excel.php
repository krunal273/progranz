<?php

include_once '../includes/config.php';
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once '../libraries/excel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator($_SESSION['uname'])
        ->setLastModifiedBy($_SESSION['uname'])
        ->setTitle(ucwords($file_data["title"]))
        ->setSubject(ucwords($file_data["title"]))
        ->setCompany(ucwords(APP_NAME));

// Add some data
$colum_count = count($file_data["header"]);
$last_col = chr(count($file_data["header"]) + 64);
$last_row = count($file_data["body"]) + 1;

for ($col = 0; $col < count($file_data["header"]); $col++) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr($col + 65) . "1", $file_data["header"][$col]);
}

$count = 2;
foreach ($file_data["body"] as $row) {
    for ($col = 0; $col < count($row); $col++) {
        $row[$col] = str_replace("<br />", "\n", $row[$col]);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue(chr($col + 65) . ($count), $row[$col]);
    }
    $count++;
}

//Format Heading row
//set font bold
//horizontal alignment center

$objPHPExcel->getActiveSheet()
        ->getStyle('A1:' . $last_col . '1')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$styleArray = [
    'font' => ['bold' => true]
];

$objPHPExcel->getActiveSheet()
        ->getStyle('A1:' . $last_col . '1')
        ->applyFromArray($styleArray);

//set vertical alignment center for all cell
//set border for all cells

for ($col = 65; $col < 65 + $colum_count; $col++) {
    $col_name = chr($col);
    $objPHPExcel->getActiveSheet()
            ->getStyle($col_name . '1:' . $col_name . $last_row)
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    $objPHPExcel->getActiveSheet()
            ->getStyle($col_name . '1:' . $col_name . $last_row)
            ->applyFromArray($styleArray);

    $objPHPExcel->getActiveSheet()
            ->getStyle($col_name . '1:' . $col_name . $last_row)
            ->getAlignment()
            ->setWrapText(true);


    switch ($file_data["config"][$col - 65]["align"]) {
        case "C":
            $objPHPExcel->getActiveSheet()
                    ->getStyle($col_name . '2:' . $col_name . $last_row)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            break;
        case "R":
            $objPHPExcel->getActiveSheet()
                    ->getStyle($col_name . '2:' . $col_name . $last_row)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            break;
        case "L":
        default :
            $objPHPExcel->getActiveSheet()
                    ->getStyle($col_name . '2:' . $col_name . $last_row)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            break;
    }
}

foreach (range('A', chr(count($file_data["header"]) + 64)) as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
            ->setAutoSize(true);
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle($file_data["title"]);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"{$file_data["title"]}_" . date('d_m_Y_H_i_s') . ".xlsx\"");
header("Cache-Control: max-age=0");


//$objWriter->save("01test_" . date('d_m_Y_H_i_s') . ".xlsx");

$objWriter->save("php://output");

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
