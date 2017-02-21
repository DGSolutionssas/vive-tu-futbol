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
	//require_once('../Utiles/PDF_MySQL_Table.php');
	require_once('../DA/ReportesDA.php');
	$db = new ReportesDA();
	
    switch ($action) {
        case 'generarReporteCampeonato' :
			$idCampeonato = $_POST['idCampeonato'];
			$db->championshipNameById($idCampeonato);
			$grupos = $_SESSION['Grupos'];
			//$header=array('Campeonato', 'Grupo', 'Nombre', 'PJ', 'PG', 'PE', 'PP', 'GF', 'GC', 'DG', 'JL', 'PW', 'PTOS');
            $pdf = new MyPDF('L', 'mm', 'A4');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
			for($i = 1; $i<=$grupos;$i++){
				$estadisticas = $db->championshipReportById($idCampeonato, $i);
				$header=array('Grupo', 'Nombre', 'PJ', 'PG', 'PE', 'PP', 'GF', 'GC', 'DG', 'JL', 'PW', 'PTOS');
				$pdf->TablaColoresCampeonatos($header, $estadisticas);
			}
            $pdfString = $pdf->Output('', 'S');
            $pdfBase64 = base64_encode($pdfString);			
            echo 'data:application/pdf;base64, ' . $pdfBase64;
            break;
		case 'generarReporteGoles' :
			$idCampeonato = $_POST['idCampeonato'];
			$estadisticas = $db->goalsReportById($idCampeonato);
			$db->championshipNameById($idCampeonato);
			$header=array('NombreJugador', 'nombreEquipo', 'Goles');
            $pdf = new MyPDF('P', 'mm', 'A4');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->TablaColoresGoles($header, $estadisticas);
            $pdf->SetFont('Arial', '', 10);
            $pdfString = $pdf->Output('', 'S');
            $pdfBase64 = base64_encode($pdfString);			
            echo 'data:application/pdf;base64, ' . $pdfBase64;
            break;
    }
}
