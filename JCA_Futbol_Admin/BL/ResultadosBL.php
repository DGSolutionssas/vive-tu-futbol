<?php

/**
 * Controla la logica de Negocio de los Campeonatos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    require_once('../DA/ResultadosDA.php');
    require_once('../DTO/ResultadosDTO.php');
    $db = new ResultadosDA();
    $dtoResultado = new ResultadosDTO();

    switch ($action) {
        case 'obtenerResultados':
            $resultados = $db->obtenerResultados();
            $arrayResultados = array();
            for ($i = 0; $i < count($resultados); $i++) {
                $arrayResultados[$i]['IdResultado'] = $resultados[$i]['IdResultado'];
                $arrayResultados[$i]['IdFecha'] = $resultados[$i]['Fecha'];
                $arrayResultados[$i]['IdCampeonato'] = $resultados[$i]['Campeonato'];
                $arrayResultados[$i]['IdEquipo1'] = $resultados[$i]['Equipo_1'];
                $arrayResultados[$i]['IdEquipo2'] = $resultados[$i]['Equipo_2'];
                $arrayResultados[$i]['Goles1'] = $resultados[$i]['GolesE1'];
                $arrayResultados[$i]['Goles2'] = $resultados[$i]['GolesE2'];
            }
            echo json_encode($arrayResultados);
            break;
        case 'registrarResultado':
            $file = fopen("archivo.txt", "a");
            fwrite($file, "IdFecha : " . $_POST['IdFecha'] . PHP_EOL);
            fclose($file);
            $resultado = $db->guardarResultado($_POST['IdFecha'],$_POST['IdCampeonato'],$_POST['IdEquipo1'],$_POST['IdEquipo2'],$_POST['Goles1'],$_POST['Goles2']);
            break;
        case 'eliminarResultado':
            $resultados = $db->eliminarResultado($_POST['IdResultado']);
            echo '{"error": "2", "descripcion": "Se elimino correctamente el Campeonato"}';
        break; 
        case 'obtenerResultadosJL':
            $resultadosJL = $db->obtenerResultadosJL($_POST['IdEquipo1']);
            $arrayResultadosJL = array();
            for ($i = 0; $i < count($resultadosJL); $i++) {
                $arrayResultadosJL[$i]['id'] = $resultadosJL[$i]['id'];
                $arrayResultadosJL[$i]['nombre'] = $resultadosJL[$i]['nombre'];
            }
            echo json_encode($arrayResultadosJL);
            break;
        case 'obtenerResultadosJL1':
            $resultadosJL = $db->obtenerResultadosJL($_POST['IdEquipo2']);
            $arrayResultadosJL = array();
            for ($i = 0; $i < count($resultadosJL); $i++) {
                $arrayResultadosJL[$i]['id'] = $resultadosJL[$i]['id'];
                $arrayResultadosJL[$i]['nombre'] = $resultadosJL[$i]['nombre'];
            }
            echo json_encode($arrayResultadosJL);
            break;
        case 'registrarDetalle':
            $resultado = $db->guardarDetalle($_POST['IdJugador'],$_POST['Amarilla'],$_POST['Azul'],$_POST['Roja'],$_POST['Goles']);
            break;
    }   
}
