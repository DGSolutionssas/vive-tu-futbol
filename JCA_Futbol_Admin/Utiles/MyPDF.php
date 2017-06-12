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
      if (isset($_SESSION['nombreCampeonato'])){
		        $tituloReporte = $_SESSION['nombreCampeonato'];
            $this->Image('../img/Logo.jpg', 10, 8, 33);
            $this->Cell(30, 23, $tituloReporte, 0, 0, 'C');
            $this->SetFont('Arial', 'B', 15);
          }
          else {
            $this->SetFont('Arial', 'B', 6);
          }
          $this->Cell(80);
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

   function TablaColoresCampeonatos($header, $data)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(20,143,20);
$this->SetTextColor(255);
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(.2);
$this->SetFont('Arial','I', 12);
//Cabecera

for($i=0;$i<count($header);$i++)
{
	if(strlen($header[$i])>5)
	{
		$this->Cell(65,6,$header[$i],1,0,'C',true);
	}
	else
	{
		$this->Cell(15,6,$header[$i],1,0,'C',true);
	}
}
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(182,255,188);
$this->SetTextColor(0);
$this->SetFont('');
//Datos
$fill = false;
foreach($data as $row)
{
	//'Campeonato', 'Grupo', 'Nombre', 'PJ', 'PG', 'PE', 'PP', 'GF', 'GC', 'DG', 'JL', 'PW', 'PTOS'
	//$this->Cell(40,6,$row['Campeonato'],1,0,'C',$fill);
	$this->Cell(15,6,$row['Grupo'],1,0,'C',$fill);
	$this->Cell(65,6,$row['Nombre'],1,0,'C',$fill);
	$this->Cell(15,6,$row['PJ'],1,0,'C',$fill);
	$this->Cell(15,6,$row['PG'],1,0,'C',$fill);
	$this->Cell(15,6,$row['PE'],1,0,'C',$fill);
	$this->Cell(15,6,$row['PP'],1,0,'C',$fill);
	$this->Cell(15,6,$row['GF'],1,0,'C',$fill);
	$this->Cell(15,6,$row['GC'],1,0,'C',$fill);
	$this->Cell(15,6,$row['DG'],1,0,'C',$fill);
	$this->Cell(15,6,$row['JL'],1,0,'C',$fill);
	$this->Cell(15,6,$row['PW'],1,0,'C',$fill);
	$this->Cell(15,6,$row['PTOS'],1,0,'C',$fill);
	$this->Ln();
	$fill = !$fill;
}
$this->Ln();

//$this->Cell(160,0,'','T');
}

   function TablaColoresFairPlayCampeonatos($header, $data)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(20,143,20);
$this->SetTextColor(255);
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(.2);
$this->SetFont('Arial','I', 12);
//Cabecera

for($i=0;$i<count($header);$i++)
{
	if(strlen($header[$i])>5)
	{
		$this->Cell(65,6,$header[$i],1,0,'C',true);
	}
	else
	{
		$this->Cell(15,6,$header[$i],1,0,'C',true);
	}
}
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(182,255,188);
$this->SetTextColor(0);
$this->SetFont('');
//Datos
$fill = false;
foreach($data as $row)
{
	//'Campeonato', 'Grupo', 'Nombre', 'PTOS'
	$this->Cell(15,6,$row['Grupo'],1,0,'C',$fill);
	$this->Cell(65,6,$row['Equipo'],1,0,'C',$fill);
	$this->Cell(15,6,$row['ptos'],1,0,'C',$fill);
	$this->Ln();
	$fill = !$fill;
}
$this->Ln();

//$this->Cell(160,0,'','T');
}

   function TablaColoresGoles($header, $data)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(20,143,20);
$this->SetTextColor(255);
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(.2);
$this->SetFont('Arial','I', 12);
//Cabecera

for($i=0;$i<count($header);$i++)
{
	if(strlen($header[$i])>5)
	{
		$this->Cell(65,6,$header[$i],1,0,'C',true);
	}
	else
	{
		$this->Cell(15,6,$header[$i],1,0,'C',true);
	}
}
$this->Ln();

//Restauración de colores y fuentes
$this->SetFillColor(182,255,188);
$this->SetTextColor(0);
$this->SetFont('');
//Datos
$fill = false;
foreach($data as $row)
{
	//'NombreJugador', 'Nombre', 'Goles'
	$this->Cell(65,6,$row['NombreJugador'],1,0,'C',$fill);
	$this->Cell(65,6,$row['nombreEquipo'],1,0,'C',$fill);
	$this->Cell(15,6,$row['Goles'],1,0,'C',$fill);
	$this->Ln();
	$fill = !$fill;
}
}

//$this->Cell(160,0,'','T');

function generarCarnetJugador($datos)
{
    $datosJugador = explode("|", $datos);
	$this->SetFont('Arial','',8);
    $this->Image('../img/Frontal.jpg', 70, 8, 95);
    $this->SetTextColor(0);
    $this->SetXY(102, 30.5);
    $this->Cell(0, 0, substr($datosJugador[0],0,15), 0, 0, 'L');
    $this->Ln();
    $this->SetXY(84, 42.5);
    $this->Cell(0, 0,substr($datosJugador[1],0,25), 0, 0, 'L');
    $this->Ln();
    $this->SetXY(84, 48.5);
    $this->Cell(0, 0, substr($datosJugador[2],0,25), 0, 0, 'L');
    $this->Ln();
    $this->SetXY(84, 54);
    $this->Cell(0, 0, $datosJugador[3], 0, 0, 'L');
    $this->Image('../img/Reverso.jpg', 70, 80, 95);
}

}
