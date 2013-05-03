<?php
App::import('Vendor', 'tcpdf/config/lang/ger');
App::import('Vendor', 'tcpdf/tcpdf');

header('Content-Type: application/pdf');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->SetFont('helvetica', 'B', 20);
$pdf->AddPage();

$pdf->writeHTML($this->fetch('content'), true, false, false, false, '');

echo $pdf->Output();