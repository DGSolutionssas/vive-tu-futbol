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
                $arrayResultados[$i]['EquipoGanador'] = $resultados[$i]['EquipoW'];              
            }
            echo json_encode($arrayResultados);
            break;
        case 'registrarResultado':
            $file = fopen("archivo.txt", "a");
            fwrite($file, "IdFecha : " . $_POST['IdFecha'] . PHP_EOL);
            fclose($file);
            $resultado = $db->guardarResultado($_POST['IdFecha'],$_POST['IdCampeonato'],$_POST['IdEquipo1'],$_POST['IdEquipo2'],$_POST['Goles1'],$_POST['Goles2'],$_POST['EquipoGanador'],$_POST['PW']);
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
            $resultado = $db->guardarDetalle($_POST['IdJugador'],$_POST['Amarilla'],$_POST['Azul'],$_POST['Roja'],$_POST['Goles'],$_POST['IdEquipo']);
            break;
        case 'registrarResultadoeditado':
            $file = fopen("archivo.txt", "a");
            fwrite($file, "IdFecha : " . $_POST['IdFecha'] . PHP_EOL);
            fclose($file);
            $resultado = $db->guardarResultadoEditado($_POST['IdResultado'],$_POST['IdFecha'],$_POST['IdCampeonato'],$_POST['IdEquipo1'],$_POST['IdEquipo2'],$_POST['Goles1'],$_POST['Goles2'],$_POST['EquipoGanador'],$_POST['PW']);
            break;
        case 'obtenerResultadosEditarJL':
            $resultadosJLeditados = $db->obtenerResultadoseditadosJL($_POST['IdResultado'], $_POST['IdEquipo']);
            $arrayResultadosJLeditados = array();
            for ($i = 0; $i < count($resultadosJLeditados); $i++) {
                $arrayResultadosJLeditados[$i]['id'] = $resultadosJLeditados[$i]['id'];
                $arrayResultadosJLeditados[$i]['nombre'] = $resultadosJLeditados[$i]['nombre'];
                $arrayResultadosJLeditados[$i]['Goles'] = $resultadosJLeditados[$i]['Goles'];
                $arrayResultadosJLeditados[$i]['amarilla'] = $resultadosJLeditados[$i]['amarilla'];
                $arrayResultadosJLeditados[$i]['azul'] = $resultadosJLeditados[$i]['azul'];
                $arrayResultadosJLeditados[$i]['roja'] = $resultadosJLeditados[$i]['roja'];                
            }
            echo json_encode($arrayResultadosJLeditados);
            break;
        case 'obtenerresultadosdetallese1':
            $resultadosgolese1 = $db->obtenerResultadosdetallee1($_POST['IdResultado'], $_POST['IdEquipo']);
            $arrayResultadosgolese1 = array();
            for ($i = 0; $i < count($resultadosgolese1); $i++) {
                $arrayResultadosgolese1[$i]['Name'] = $resultadosgolese1[$i]['Name'];
                $arrayResultadosgolese1[$i]['Goals'] = $resultadosgolese1[$i]['Goals'];
                $arrayResultadosgolese1[$i]['amarilla'] = $resultadosgolese1[$i]['amarilla'];
                $arrayResultadosgolese1[$i]['azul'] = $resultadosgolese1[$i]['azul'];
                $arrayResultadosgolese1[$i]['roja'] = $resultadosgolese1[$i]['roja'];
            }
            echo json_encode($arrayResultadosgolese1);
            break;
        case 'obtenerresultadosdetallese2':
            $resultadosgolese1 = $db->obtenerResultadosdetallee2($_POST['IdResultado'], $_POST['IdEquipo']);
            $arrayResultadosgolese1 = array();
            for ($i = 0; $i < count($resultadosgolese1); $i++) {
                $arrayResultadosgolese1[$i]['Name'] = $resultadosgolese1[$i]['Name'];
                $arrayResultadosgolese1[$i]['Goals'] = $resultadosgolese1[$i]['Goals'];
                $arrayResultadosgolese1[$i]['amarilla'] = $resultadosgolese1[$i]['amarilla'];
                $arrayResultadosgolese1[$i]['azul'] = $resultadosgolese1[$i]['azul'];
                $arrayResultadosgolese1[$i]['roja'] = $resultadosgolese1[$i]['roja'];
            }
            echo json_encode($arrayResultadosgolese1);
            break;
        case 'EliminarJugadorDetalle':
            $eliminarjd = $db->eliminarJD($_POST['IdResultado'], $_POST['IdJugador']);
            echo '{"error": "2", "descripcion": "Se elimino correctamente el Campeonato"}';
            break;
        case 'registrarDetalleEditado':
            $registrardetallee1 = $db->registrardetallee1($_POST['IdResultado'], $_POST['IdJugador'], $_POST['Amarilla'], $_POST['Azul'], $_POST['Roja'], $_POST['Goles'], $_POST['IdEquipo']);
            break;
    }   

}
