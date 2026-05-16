<?php

include("../fpdf186/fpdf.php");

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Cell();
?>