<?php

/**
 * Controla los Metodos de los Reportes
 * @author Diego Saavedra
 * @created 04/01/2017
 * @copyright DG Solutions sas
 */

require('fpdf.php');

class MyPDF extends FPDF {

// Cabecera de página
    function Header() {
        $this->Image('../img/Logo.jpg', 10, 8, 33);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        //$this->Cell(30, 23, 'Reporte Jugadores', 0, 0, 'C');
        $this->Ln(40);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    function TablaBasica($header)
   {
    //Cabecera
    foreach($header as $col)
    $this->Cell(40,7,$col,1);
    $this->Ln();
   
      $this->Cell(40,5,"hola",1);
      $this->Cell(40,5,"hola2",1);
      $this->Cell(40,5,"hola3",1);
      $this->Cell(40,5,"hola4",1);
      $this->Ln();
      $this->Cell(40,5,"linea ",1);
      $this->Cell(40,5,"linea 2",1);
      $this->Cell(40,5,"linea 3",1);
      $this->Cell(40,5,"linea 4",1);
   } 
   
   function TablaColores($header)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(20,143,20);
$this->SetTextColor(255);
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(.2);
$this->SetFont('Arial','I', 10);
//Cabecera

for($i=0;$i<count($header);$i++)
	$this->Cell(30,6,$header[$i],1,0,'C',true);
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');
//Datos
$fill=false;

$this->Cell(40,6,"hola",'LR',0,'L',$fill);
$this->Cell(40,6,"hola2",'LR',0,'L',$fill);
$this->Cell(40,6,"hola3",'LR',0,'R',$fill);
$this->Cell(40,6,"hola4",'LR',0,'R',$fill);
$this->Ln();
$fill=true;
$this->Cell(40,6,"col",'LR',0,'L',$fill);
$this->Cell(40,6,"col2",'LR',0,'L',$fill);
$this->Cell(40,6,"col3",'LR',0,'R',$fill);
$this->Cell(40,6,"col4",'LR',0,'R',$fill);
$fill=!$fill;
$this->Ln();
$this->Cell(160,0,'','T');
} 

}
