
<?php

require_once '../includes/config.php';
require_once '../libraries/fpdf/fpdf.php';

class PDF extends FPDF {

    private $header, $data, $col_width, $config, $title;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);
        $this->SetFont('Arial', '', 10);
    }

    function prepareData($pdf_data) {
        $this->title = $pdf_data["title"];
        $this->header = $pdf_data["header"];
        $this->data = $pdf_data["body"];
        $this->col_width = [];
        $this->config = $pdf_data["config"];
        foreach ($this->header as $header) {
            $this->col_width[] = 0;
        }

        for ($i = 0; $i < count($this->header); $i++) {
            if ($this->GetStringWidth($this->header[$i]) > $this->col_width[$i]) {
                $this->col_width[$i] = $this->GetStringWidth($this->header[$i]);
            }
        }

        // Read row data
        foreach ($this->data as $row) {
            for ($i = 0; $i < count($row); $i++) {
                if ($this->GetStringWidth($row[$i]) > $this->col_width[$i]) {
                    $this->col_width[$i] = $this->GetStringWidth($row[$i]);
                }
            }
        }
    }

    function printPDF() {
        $this->printTable();
    }

    function Header() {
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('', 'B');

        for ($i = 0; $i < count($this->header); $i++) {
            $this->Cell($this->col_width[$i] + 6, 7, $this->header[$i], 1, 0, 'C', true);
        }

        $this->Ln();
    }

    function printTable() {
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('Arial', '', 10);
        $count = 0;
        foreach ($this->data as $row) {
            for ($i = 0; $i < count($row); $i++) {
                $this->Cell($this->col_width[$i] + 6, 6, $row[$i], 1, 0, $this->config[$i]["align"]);
            }
            $this->Ln();
            $count++;
        }
        // Closing line
        $this->Cell(array_sum($this->col_width), 0, '', 'T');
    }

    function Footer() {
        $generated_by = ucwords(strtolower($_SESSION['uname']));
        $generated_time = date('d-m-Y H:i:s A');
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print centered page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'L');
        $this->SetX($this->lMargin);
        $this->Cell(0, 10, ucwords($this->title), 0, 0, 'C');
        $this->SetX($this->lMargin);
        $this->Cell(0, 10, $generated_by . " (" . $generated_time . ")", 0, 0, 'R');
    }

}

$pdf = new PDF($file_data["settings"]["orientation"]);
$pdf->SetLineWidth(0.1);
$pdf->prepareData($file_data);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->printPDF();
$pdf->Output('D', $file_data["settings"]["filename"] . ".pdf");
//echo json_encode(setMessage("success"));
