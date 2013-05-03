<?php
App::import('Vendor', 'tcpdf/config/lang/ger');
App::import('Vendor', 'tcpdf/tcpdf');

$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

$pdf->AddPage();


$pdf->writeHTML($this->fetch('content'), true, false, false, false, '');
$pdf->Output();