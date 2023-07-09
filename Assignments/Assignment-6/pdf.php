<?php
session_start();
//require('fpdf185/fpdf.php');
require '../vendor/autoload.php';

class PDF extends FPDF
{
  function Header()
  {
    $this->SetFont('ZapfDingbats', 'B', 20);
    $this->SetTextColor(256, 256, 256);
    $this->SetFillColor(0, 0, 0);
    // Title.
    $this->Cell(0, 15, 'WelcometoYourresume.ThisisIT', 1, 1, 'C', true);
    $this->Ln(10);
  }

  // Page footer.
  function Footer()
  {
    // Position at 1.5 cm from bottom.
    $this->SetY(-15);
    // Arial italic 8.
    $this->SetFont('Arial', 'I', 8);
    // Page number.
    $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
  }
}


// Create new object.
$pdf = new PDF();
$pdf->AliasNbPages();
// Add new page.
$pdf->AddPage();
// Creating Header.
$pdf->Cell(140, 20, '', 0, 0);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(50, 50, '', 1, 0, 'R', true);

// Primary Details section.
$pdf->Image($_SESSION['img'], 151, 36, 48, 48);
$pdf->Cell(0, 0, '', 0, 1, '');
// Set font-family and font-size.
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(0, 10, '', 0, 1, '');
$pdf->Cell(60,10, 'Full Name: ', 0, 0, '');
$pdf->Cell(70,10,$_SESSION['fullname'],0,1);
$pdf->Cell(60,10, 'Email ID: ', 0, 0, '');
$pdf->Cell(70,10,$_SESSION['email'],0,1);
$pdf->Cell(60,10, 'Phone Number: ', 0, 0, '');
$pdf->Cell(70,10,$_SESSION['phone'],0,1);
$pdf->Cell(0, 20, '', 0, 1, '');

// Marks Section.
$pdf->SetTextColor(256, 256, 256);
$pdf->Cell(0, 10, 'Class X', 1,1,'C', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(63.3, 10, 'Subject', 1,0,'C');
$pdf->Cell(63.3, 10, 'Marks Obtained', 1,0,'C');
$pdf->Cell(63.3, 10, 'Total Marks', 1,1,'C');
// Adding the marks of the person. 
foreach($_SESSION['sub_info'] as $x => $value) {
  $pdf->Cell(63.3, 10, $x, 'L',0,'C');
  $pdf->Cell(63.3, 10, $value, '0',0,'C');
  $pdf->Cell(63.3, 10, '100', 'R',1,'C');
}
$pdf->Cell(0,1,'',1,0);
$pdf->Output();

?>
