<?php

/**
 * Controla los Reportes
 * @author Diego Saavedra
 * @created 04/01/2017
 * @copyright DG Solutions sas
 */

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    require_once('../Utiles/MyPDF.php');
    switch ($action) {
        case 'obtenerReporte' :
            $header=array('Columna 1','Columna 2','Columna 3','Columna 4');
            $pdf = new MyPDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->TablaColores($header);
            $pdf->SetFont('Times', '', 12);
            for ($i = 1; $i <= 5; $i++)
                $pdf->Cell(0, 10, 'Jugador ' . $i, 0, 1);
            $pdfString = $pdf->Output('', 'S');
            $pdfBase64 = base64_encode($pdfString);
            echo 'data:application/pdf;base64,' . $pdfBase64;
            break;
    }
}
