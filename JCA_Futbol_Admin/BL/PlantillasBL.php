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
    $db = new PlantillasDA();

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
                echo '{"error": "2", "url": "http://127.0.0.1:8082/JCA_Futbol_Admin/Utiles/PlanillaFutbol5_Generada.xlsx"}';
            }
            if ($_POST['idTipoPlantilla'] == "2") {
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
                $objWriter->save('../Utiles/PlanillaFutbol8_Generada.xlsx');
                echo '{"error": "2", "url": "http://127.0.0.1:8082/JCA_Futbol_Admin/Utiles/PlanillaFutbol8_Generada.xlsx"}';
            }
            if ($_POST['idTipoPlantilla'] == "3") {
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
                echo '{"error": "2", "url": "http://127.0.0.1:8082/JCA_Futbol_Admin/Utiles/PlanillaFutbol5Empresas_Generada.xlsx"}';
            }
            break;
    }
}