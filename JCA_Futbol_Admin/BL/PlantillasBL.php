<?php

/**
 * Controla la generacion de Plantillas
 * @author Diego Saavedra
 * @created 04/01/2017
 * @copyright DG Solutions sas
 */
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    require_once '../Utiles/Classes/PHPExcel/IOFactory.php';
    require_once '../Utiles/Classes/PHPExcel.php';
    require_once('../DA/PlantillasDA.php');
    require_once('../DA/FechasDA.php');
	require_once('../DA/ReportesDA.php');
    $db = new PlantillasDA();
    $dbFechas=new FechasDA();
	$dbRep=new ReportesDA();

    switch ($action) {
        case 'generarPlantilla' :
            if ($_POST['idTipoPlantilla'] == "1") {
                $idCampeonato = $_POST['idCampeonato'];
                $idEquipo1 = $_POST['idEquipo1'];
                $idEquipo2 = $_POST['idEquipo2'];
                $campeonato = $_POST['campeonato'];
                $equipo1 = $_POST['equipo1'];
                $equipo2 = $_POST['equipo2'];

                $ruta = "../Utiles/PlanillaFutbol5.xlsx";
                $plantilla = PHPExcel_IOFactory::createReader('Excel2007');
                $plantilla = $plantilla->load($ruta); // Empty Sheet
                $plantilla->setActiveSheetIndex(0);

                $jugadores = $db->obtenerJugadores($idCampeonato, $idEquipo1, $idEquipo2);
                $arrayJugadores = array();
                $indicadorCeldaEquipo1 = 16;

                $plantilla->getActiveSheet()->setCellValue('K6', $equipo1)
                        ->setCellValue('B11', $equipo1)
                        ->setCellValue('BA6', $equipo2)
                        ->setCellValue('B36', $equipo2)
                        ->setCellValue('B7', 'CAMPEONATO.  ' . $campeonato);

                for ($i = 0; $i < count($jugadores); $i++) {
                    if ($jugadores[$i]['Equipo'] == $equipo1) {
                        $plantilla->getActiveSheet()->setCellValue('B' . $indicadorCeldaEquipo1, substr($jugadores[$i]['Cedula'], strlen($jugadores[$i]['Cedula']) - 4, 4))
                                //->setCellValue('G' . $indicadorCeldaEquipo1, $jugadores[$i]['Nombres'] . " " . $jugadores[$i]['Apellidos']);
                                ->setCellValue('G' . $indicadorCeldaEquipo1, $jugadores[$i]['Nombre']);
                        ++$indicadorCeldaEquipo1;
                    }
                }

                $indicadorCeldaEquipo2 = 41;

                for ($i = 0; $i < count($jugadores); $i++) {
                    if ($jugadores[$i]['Equipo'] == $equipo2) {
                        $plantilla->getActiveSheet()->setCellValue('B' . $indicadorCeldaEquipo2, substr($jugadores[$i]['Cedula'], strlen($jugadores[$i]['Cedula']) - 4, 4))
                                //->setCellValue('G' . $indicadorCeldaEquipo2, $jugadores[$i]['Nombres'] . " " . $jugadores[$i]['Apellidos']);
                                ->setCellValue('G' . $indicadorCeldaEquipo2, $jugadores[$i]['Nombre']);
                        ++$indicadorCeldaEquipo2;
                    }
                }
                $objWriter = PHPExcel_IOFactory::createWriter($plantilla, 'Excel2007');
                $objWriter->save('../Utiles/PlanillaFutbol5_Generada.xlsx');
                echo '{"error": "2", "url": "http://vivetufutboljca.com/AdminJCA/Utiles/PlanillaFutbol5_Generada.xlsx"}';
            }else if ($_POST['idTipoPlantilla'] == "2") {
                $idCampeonato = $_POST['idCampeonato'];
                $idEquipo1 = $_POST['idEquipo1'];
                $idEquipo2 = $_POST['idEquipo2'];
                $campeonato = $_POST['campeonato'];
                $equipo1 = $_POST['equipo1'];
                $equipo2 = $_POST['equipo2'];

                $ruta = "../Utiles/PlanillaFutbol8.xlsx";
                $plantilla = PHPExcel_IOFactory::createReader('Excel2007');
                $plantilla = $plantilla->load($ruta); // Empty Sheet
                $plantilla->setActiveSheetIndex(0);

                $jugadores = $db->obtenerJugadores($idCampeonato, $idEquipo1, $idEquipo2);
                $arrayJugadores = array();
                $indicadorCeldaEquipo1 = 14;

                $plantilla->getActiveSheet()->setCellValue('C12', $equipo1)
                        ->setCellValue('K12', $equipo2)
                        ->setCellValue('G10', 'CAMPEONATO.  ' . $campeonato);

                for ($i = 0; $i < count($jugadores); $i++) {
                    if ($jugadores[$i]['Equipo'] == $equipo1) {
                        $plantilla->getActiveSheet()->setCellValue('F' . $indicadorCeldaEquipo1, substr($jugadores[$i]['Cedula'], strlen($jugadores[$i]['Cedula']) - 4, 4))
                                //->setCellValue('G' . $indicadorCeldaEquipo1, $jugadores[$i]['Nombres'] . " " . $jugadores[$i]['Apellidos']);
                                ->setCellValue('D' . $indicadorCeldaEquipo1, $jugadores[$i]['Nombre']);
                        ++$indicadorCeldaEquipo1;
                    }
                }

                $indicadorCeldaEquipo2 = 14;

                for ($i = 0; $i < count($jugadores); $i++) {
                    if ($jugadores[$i]['Equipo'] == $equipo2) {
                        $plantilla->getActiveSheet()->setCellValue('M' . $indicadorCeldaEquipo2, substr($jugadores[$i]['Cedula'], strlen($jugadores[$i]['Cedula']) - 4, 4))
                                //->setCellValue('G' . $indicadorCeldaEquipo2, $jugadores[$i]['Nombres'] . " " . $jugadores[$i]['Apellidos']);
                                ->setCellValue('K' . $indicadorCeldaEquipo2, $jugadores[$i]['Nombre']);
                        ++$indicadorCeldaEquipo2;
                    }
                }
                $objWriter = PHPExcel_IOFactory::createWriter($plantilla, 'Excel2007');
                $objWriter->save('../Utiles/PlanillaFutbol8_Generada.xlsx');
                echo '{"error": "2", "url": "http://vivetufutboljca.com/AdminJCA/Utiles/PlanillaFutbol8_Generada.xlsx"}';
            }
			else if ($_POST['idTipoPlantilla'] == "3") {
                  $idCampeonato = $_POST['idCampeonato'];
                $idEquipo1 = $_POST['idEquipo1'];
                $idEquipo2 = $_POST['idEquipo2'];
                $campeonato = $_POST['campeonato'];
                $equipo1 = $_POST['equipo1'];
                $equipo2 = $_POST['equipo2'];

                $ruta = "../Utiles/PlanillaFutbol5Empresas.xlsx";
                $plantilla = PHPExcel_IOFactory::createReader('Excel2007');
                $plantilla = $plantilla->load($ruta); // Empty Sheet
                $plantilla->setActiveSheetIndex(0);

                $jugadores = $db->obtenerJugadores($idCampeonato, $idEquipo1, $idEquipo2);
                $arrayJugadores = array();
                $indicadorCeldaEquipo1 = 16;

                $plantilla->getActiveSheet()->setCellValue('K6', $equipo1)
                        ->setCellValue('B11', $equipo1)
                        ->setCellValue('BA6', $equipo2)
                        ->setCellValue('B36', $equipo2)
                        ->setCellValue('B7', 'CAMPEONATO.  ' . $campeonato);

                for ($i = 0; $i < count($jugadores); $i++) {
                    if ($jugadores[$i]['Equipo'] == $equipo1) {
                        $plantilla->getActiveSheet()->setCellValue('B' . $indicadorCeldaEquipo1, substr($jugadores[$i]['Cedula'], strlen($jugadores[$i]['Cedula']) - 4, 4))
                                //->setCellValue('G' . $indicadorCeldaEquipo1, $jugadores[$i]['Nombres'] . " " . $jugadores[$i]['Apellidos']);
                                ->setCellValue('G' . $indicadorCeldaEquipo1, $jugadores[$i]['Nombre']);
                        ++$indicadorCeldaEquipo1;
                    }
                }

                $indicadorCeldaEquipo2 = 41;

                for ($i = 0; $i < count($jugadores); $i++) {
                    if ($jugadores[$i]['Equipo'] == $equipo2) {
                        $plantilla->getActiveSheet()->setCellValue('B' . $indicadorCeldaEquipo2, substr($jugadores[$i]['Cedula'], strlen($jugadores[$i]['Cedula']) - 4, 4))
                                //->setCellValue('G' . $indicadorCeldaEquipo2, $jugadores[$i]['Nombres'] . " " . $jugadores[$i]['Apellidos']);
                                ->setCellValue('G' . $indicadorCeldaEquipo2, $jugadores[$i]['Nombre']);
                        ++$indicadorCeldaEquipo2;
                    }
                }
                $objWriter = PHPExcel_IOFactory::createWriter($plantilla, 'Excel2007');
                $objWriter->save('../Utiles/PlanillaFutbol5Empresas_Generada.xlsx');
                echo '{"error": "2", "url": "http://vivetufutboljca.com/AdminJCA/Utiles/PlanillaFutbol5Empresas_Generada.xlsx"}';
            }
            break;

            case 'generarReporteAmonestados':
            $idCampeonato = $_POST['idCampeonato'];
            $nombreCampeonato = $_POST['nombreCampeonato'];

            $ruta = "../Utiles/ReporteAmonestados.xlsx";
            $plantilla = PHPExcel_IOFactory::createReader('Excel2007');
            $plantilla = $plantilla->load($ruta); // Empty Sheet
            $plantilla->setActiveSheetIndex(0);

            $fechas = $dbFechas->obtenerFechasCampeonato($idCampeonato);
            $arrayFechas = array();
            $indicarCeldaFechas = 3;
            $indicadorLetra=68;//Letra D
            $plantilla->getActiveSheet();

            for ($i = 0; $i < count($fechas); $i++) {
              $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetra) . $indicarCeldaFechas, $fechas[$i]['nombrefecha']);
              $plantilla->getActiveSheet()->getStyle(chr($indicadorLetra) . $indicarCeldaFechas)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'002060')));
              $plantilla->getActiveSheet()->getStyle(chr($indicadorLetra) . $indicarCeldaFechas)->getFont()->setBold(true);
              $plantilla->getActiveSheet()->getStyle(chr($indicadorLetra) . $indicarCeldaFechas)->getFont()->getColor()->setRGB('FFFFFF');
              ++$indicadorLetra;
            }

            $juegolimpio = $dbRep->fairPlayReportPlayers($idCampeonato);

            $indicadorLetraJugador=65;//Letra A
            $indicadorCeldaJugador=4;
            $indicadorLetraFecha=68;//Letra D
            $numeroJugador=1;

            for ($i = 0; $i < count($fechas); $i++) {
              for ($j = 0; $j < count($juegolimpio); $j++) {
                if(intval($fechas[$i]['idfecha']) ==  intval($juegolimpio[$j]['IdFecha'])){
                  $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraJugador) . $indicadorCeldaJugador, $numeroJugador);
                  $numeroJugador=$numeroJugador+1;
                  $indicadorLetraJugador=$indicadorLetraJugador+1;
                  $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraJugador) . $indicadorCeldaJugador, $juegolimpio[$j]['Equipo']);
                  $indicadorLetraJugador=$indicadorLetraJugador+1;
                  $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraJugador) . $indicadorCeldaJugador, $juegolimpio[$j]['NombreJugador']);
                  $indicadorLetraJugador=$indicadorLetraJugador+1;
                  $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraFecha) . $indicadorCeldaJugador, ($juegolimpio[$j]['Amarilla']+$juegolimpio[$j]['Roja']+$juegolimpio[$j]['Azul']));
                  $indicadorLetraJugador=65;
                  $indicadorCeldaJugador++;
                }
              }
              $indicadorLetraFecha=$indicadorLetraFecha+1;
            }
            //echo('A1:'.chr($indicadorLetraFecha).'1');
            $letraInicioCampeonato='A';
            $celdaInicioCampeonato=1;
            $letraInicioAmonestado='A';
            $celdaInicioAmonestado=2;
            $titulo="AMONESTADOS";
            $plantilla->getActiveSheet()->mergeCells($letraInicioCampeonato.$celdaInicioCampeonato.':'.chr($indicadorLetraFecha-1).'1');
            $plantilla->getActiveSheet()->getStyle($letraInicioCampeonato. $celdaInicioCampeonato)->getFont()->getColor()->setRGB('FFFFFF');
            $plantilla->getActiveSheet()->mergeCells($letraInicioAmonestado.$celdaInicioAmonestado.':'.chr($indicadorLetraFecha-1).'2');
            $plantilla->getActiveSheet()->setCellValue('A1', $nombreCampeonato);
            $plantilla->getActiveSheet()->setCellValue('A2', $titulo);

            $objWriter = PHPExcel_IOFactory::createWriter($plantilla, 'Excel2007');
            $objWriter->save('../Utiles/ReporteAmonestados_Generada.xlsx');
            echo '{"error": "2", "url": "http://vivetufutboljca.com/AdminJCA/Utiles/ReporteAmonestados_Generada.xlsx"}';
            break;
            case 'generarReporteGoles':
                $idCampeonato = $_POST['idCampeonato'];
			    $nombreCampeonato = $_POST['nombreCampeonato'];
                $arrayGoles = $dbRep->goalsReportById($idCampeonato);
			    $ruta="../Utiles/ReporteGoles.xlsx";
                $plantilla = PHPExcel_IOFactory::createReader('Excel2007');
                $plantilla = $plantilla->load($ruta); // Empty Sheet
                $plantilla->setActiveSheetIndex(0);
                $plantilla->getActiveSheet();
                $indicadorCeldaGoleador=5;
                $indicadorLetraGoleador=66;
                $numeradorJugador=0;
                for ($i = 0; $i < count($arrayGoles); $i++) {
                    $numeradorJugador=$numeradorJugador+1;                  
                    $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraGoleador) . $indicadorCeldaGoleador, $numeradorJugador);
                    $indicadorLetraGoleador=$indicadorLetraGoleador+1;
                    $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraGoleador) . $indicadorCeldaGoleador, $arrayGoles[$i]['NombreJugador']);
                    $indicadorLetraGoleador=$indicadorLetraGoleador+1;
                    $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraGoleador) . $indicadorCeldaGoleador, $arrayGoles[$i]['nombreEquipo']);
                    $indicadorLetraGoleador=$indicadorLetraGoleador+1;
                    $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraGoleador) . $indicadorCeldaGoleador, $arrayGoles[$i]['Goles']);
                    $indicadorCeldaGoleador=$indicadorCeldaGoleador+1;
                    $indicadorLetraGoleador=66;
                }
                
                $plantilla->getActiveSheet()->setCellValue('B1', $nombreCampeonato);
                
                $objWriter = PHPExcel_IOFactory::createWriter($plantilla, 'Excel2007');
                $objWriter->save('../Utiles/ReporteGoles_Generado.xlsx');
                echo '{"error": "2", "url": "http://vivetufutboljca.com/AdminJCA/Utiles/ReporteGoles_Generado.xlsx"}';
            break;
            case 'generarReporteCampeonato':
                $idCampeonato = $_POST['idCampeonato'];
			    $nombreCampeonato = $_POST['nombreCampeonato'];
                $dbRep->championshipNameById($idCampeonato);
			    $grupos = $_SESSION['Grupos'];
                $ruta="../Utiles/ReporteCampeonato.xlsx";
                $plantilla = PHPExcel_IOFactory::createReader('Excel2007');
                $plantilla = $plantilla->load($ruta); // Empty Sheet
                $plantilla->setActiveSheetIndex(0);
                $plantilla->getActiveSheet();
                $indicadorCeldaPrueba=0;
                $indicadorCeldaCampeonato=5;
                $indicadorLetraCampeonato=66;
                $indicadorLetraCampeonatoPrueba=66;
                $indicadorLetraFin=77;
                
                $numeradorCampeonato=0;
                $letragrupo=65;

                for($j = 1; $j<=$grupos;$j++)
                {
                    $numeradorCampeonato=0;
                    $arrayEstadisticas = $dbRep->championshipReportById($idCampeonato, $j);
                    
                    $plantilla->getActiveSheet()->mergeCells(chr($indicadorLetraCampeonato).($indicadorCeldaCampeonato-2).':'.chr($indicadorLetraFin).($indicadorCeldaCampeonato-2));

                   
                    cargarHeader($plantilla, $indicadorLetraCampeonatoPrueba, $indicadorCeldaCampeonato-2,"GRUPO ".chr($letragrupo++),2);

                    $indicadorCeldaPrueba=$indicadorCeldaCampeonato-1;
                    
                    cargarHeader($plantilla, $indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"No.",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"EQUIPO",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"PJ",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"PG",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"PE",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"PP",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"GF",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"GC",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"DG",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"JL",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"PW",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"PTOS",1);
                    $indicadorLetraCampeonatoPrueba=66;

			        for ($i = 0; $i < count($arrayEstadisticas); $i++) {
                        $numeradorCampeonato=$numeradorCampeonato+1;             
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $numeradorCampeonato);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                      
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['Nombre']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['PJ']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['PG']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['PE']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['PP']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['GF']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['GC']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['DG']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['JL']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['PW']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['PTOS']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        
                        $indicadorCeldaCampeonato=$indicadorCeldaCampeonato+1;
                        $indicadorLetraCampeonato=66;
                    }
                    $indicadorCeldaCampeonato=$indicadorCeldaCampeonato+3;
                }

                $plantilla->getActiveSheet()->setCellValue('B1', $nombreCampeonato);
                
                $objWriter = PHPExcel_IOFactory::createWriter($plantilla, 'Excel2007');
                $objWriter->save('../Utiles/ReporteCampeonato_Generado.xlsx');
                echo '{"error": "2", "url": "http://vivetufutboljca.com/AdminJCA/Utiles/ReporteCampeonato_Generado.xlsx"}';
            break;
              case 'generarReporteJuegoLimpioCampeonato':
                $idCampeonato = $_POST['idCampeonato'];
			    $nombreCampeonato = $_POST['nombreCampeonato'];
                $dbRep->championshipNameById($idCampeonato);
			    $grupos = $_SESSION['Grupos'];
                $ruta="../Utiles/ReporteJuegoLimpio.xlsx";
                $plantilla = PHPExcel_IOFactory::createReader('Excel2007');
                $plantilla = $plantilla->load($ruta); // Empty Sheet
                $plantilla->setActiveSheetIndex(0);
                $plantilla->getActiveSheet();
                $indicadorCeldaPrueba=0;
                $indicadorCeldaCampeonato=5;
                $indicadorLetraCampeonato=66;
                $indicadorLetraCampeonatoPrueba=66;
                $indicadorLetraFin=68;
                
                $numeradorCampeonato=0;
                $letragrupo=65;

                for($j = 1; $j<=$grupos;$j++)
                {
                    $numeradorCampeonato=0;
                    $arrayEstadisticas = $dbRep->championshipFairPlayReportById($idCampeonato, $j);
                    
                    $plantilla->getActiveSheet()->mergeCells(chr($indicadorLetraCampeonato).($indicadorCeldaCampeonato-2).':'.chr($indicadorLetraFin).($indicadorCeldaCampeonato-2));
                   
                    cargarHeader($plantilla, $indicadorLetraCampeonatoPrueba, $indicadorCeldaCampeonato-2,"GRUPO ".chr($letragrupo++),2);

                    $indicadorCeldaPrueba=$indicadorCeldaCampeonato-1;
                    
                    cargarHeader($plantilla, $indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"No.",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"EQUIPO",1);
                    cargarHeader($plantilla, ++$indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,"PTOS",1);
                    $indicadorLetraCampeonatoPrueba=66;

			        for ($i = 0; $i < count($arrayEstadisticas); $i++) {
                        $numeradorCampeonato=$numeradorCampeonato+1;             
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $numeradorCampeonato);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                      
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['Equipo']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonato) . $indicadorCeldaCampeonato, $arrayEstadisticas[$i]['ptos']);
                        $indicadorLetraCampeonato=$indicadorLetraCampeonato+1;
                        
                        $indicadorCeldaCampeonato=$indicadorCeldaCampeonato+1;
                        $indicadorLetraCampeonato=66;
                    }
                    $indicadorCeldaCampeonato=$indicadorCeldaCampeonato+3;
                }

                $plantilla->getActiveSheet()->setCellValue('B1', $nombreCampeonato);
                
                $objWriter = PHPExcel_IOFactory::createWriter($plantilla, 'Excel2007');
                $objWriter->save('../Utiles/ReporteJuegoLimpio_Generado.xlsx');
                echo '{"error": "2", "url": "http://vivetufutboljca.com/AdminJCA/Utiles/ReporteJuegoLimpio_Generado.xlsx"}';
            break;
    }
}

    function cargarHeader($plantilla, $indicadorLetraCampeonatoPrueba, $indicadorCeldaPrueba,$texto, $tipo)
    {
        $plantilla->getActiveSheet()->getStyle(chr($indicadorLetraCampeonatoPrueba) . $indicadorCeldaPrueba)->getFont()->setBold(true);
        if($tipo==1)
        {
            $plantilla->getActiveSheet()->getStyle(chr($indicadorLetraCampeonatoPrueba) . $indicadorCeldaPrueba)->getFont()->getColor()->setRGB('FFFFFF');
            $plantilla->getActiveSheet()->getStyle(chr($indicadorLetraCampeonatoPrueba) . $indicadorCeldaPrueba)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'002060')));
        }else{
            $plantilla->getActiveSheet()->getStyle(chr($indicadorLetraCampeonatoPrueba) . $indicadorCeldaPrueba)->getFont()->getColor()->setRGB('000000');
            $plantilla->getActiveSheet()->getStyle(chr($indicadorLetraCampeonatoPrueba) . $indicadorCeldaPrueba)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'92D050')));
        }
        $plantilla->getActiveSheet()->getStyle(chr($indicadorLetraCampeonatoPrueba) . $indicadorCeldaPrueba)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $plantilla->getActiveSheet()->setCellValue(chr($indicadorLetraCampeonatoPrueba) . $indicadorCeldaPrueba, $texto);
    }