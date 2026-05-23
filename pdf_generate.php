<?php

//include 'auth.php';
include 'connection_db.php';
include 'fpdf186/fpdf.php';

$row_data = $_GET['search_val'];
$col_data = $_GET['search_col'];

$pdf = new FPDF();
$pdf->SetFont('Arial', 'B', 18);
$pdf->AddPage();

$pdf->Cell(190, 10, 'Student List', 1, 1, 'C');
//width height text border ln align

$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(40, 10, 'Student ID', 1, 0, 'C');
$pdf->Cell(30, 10, 'Last Name', 1, 0, 'C');
$pdf->Cell(30, 10, 'First Name', 1, 0, 'C');
$pdf->Cell(30, 10, 'Middle Name', 1, 0, 'C');
$pdf->Cell(30, 10, 'Section', 1, 0, 'C');
$pdf->Cell(30, 10, 'Year', 1, 0, 'C');

$pdf->Ln();


$query = "SELECT * FROM students";

if(!empty($row_data) && !empty($col_data)){
    $query = "SELECT * FROM students WHERE $col_data LIKE '%$row_data%'";
}
$query1 = mysqli_query($conn, $query);

$pdf->SetFont('Arial', '', 12);

while ($row = $query1->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['student_id_number'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['last_name'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['first_name'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['middle_name'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['section'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['year'], 1, 0, 'C');

    $pdf->Ln();
}

$pdf->Output();
